<?php

/*
Plugin Name: WordPress Twitter Bootstrap CSS
Plugin URI: http://worpit.com/wordpress-twitter-bootstrap-css-plugin-home/
Description: Allows you to install Twitter Bootstrap CSS and Javascript files for your site, before all others.
Version: 2.0.3
Author: Worpit
Author URI: http://worpit.com/
*/

/**
 * Copyright (c) 2012 Worpit <support@worpit.com>
 * All rights reserved.
 *
 * "WordPress Twitter Bootstrap CSS" (formerly "WordPress Bootstrap CSS") is
 * distributed under the GNU General Public License, Version 2,
 * June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
 * St, Fifth Floor, Boston, MA 02110, USA
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
include_once( dirname(__FILE__).'/hlt-bootstrap-shortcodes.php' );
include_once( dirname(__FILE__).'/hlt-bootstrap-less.php' );
include_once( dirname(__FILE__).'/hlt-rssfeed-widget.php' );

define( 'DS', DIRECTORY_SEPARATOR );

//global $wp_version;
//global $doc_db_version;
//global $wpdb;

//$exit_msg = "The WordPress installation must be version 3 or above.";
//if (version_compare($wp_version, "3.0", "<")) {
 //   exit($exit_msg);
//}

function _hlt_e( $insStr ) {
	_e( $insStr, 'hlt-wordpress-bootstrap-css' );
}
function _hlt__( $insStr ) {
	return __( $insStr, 'hlt-wordpress-bootstrap-css' );
}

class HLT_BootstrapCss extends HLT_Plugin {
	
	const InputPrefix			= 'hlt_bootstrap_';
	const OptionPrefix			= 'hlt_bootstrapcss_';
	
	// possibly configurable in the UI, we'll determine this as new releases occur.
	const TwitterVersion		= '2.0.3';
	const TwitterVersionLegacy	= '1.4.0';
	const YUI3Version			= '3.4.1';
	
	static public $BOOSTRAP_DIR;
	static public $BOOSTRAP_URL;
	
	protected $m_fUpdateSuccessTracker;
	protected $m_aFailedUpdateOptions;
	
	protected $m_aAllPluginOptions;
	protected $m_aAllBootstrapLessOptions;
	
	public function __construct() {
		parent::__construct();
		
		/**
		 * We make the assumption that all settings updates are successful until told otherwise
		 * by an actual failing update_option call.
		 */
		$this->m_fUpdateSuccessTracker = true;
		$this->m_aFailedUpdateOptions = array();

		self::$VERSION		= '2.0.3'; //SHOULD BE UPDATED UPON EACH NEW RELEASE
		
		self::$PLUGIN_NAME	= basename(__FILE__);
		self::$PLUGIN_PATH	= plugin_basename( dirname(__FILE__) );
		self::$PLUGIN_DIR	= WP_PLUGIN_DIR.DS.self::$PLUGIN_PATH.DS;
		self::$PLUGIN_URL	= WP_PLUGIN_URL.'/'.self::$PLUGIN_PATH.'/';
		
		self::$BOOSTRAP_DIR = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-'.self::TwitterVersion.DS;
		self::$BOOSTRAP_URL = self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersion.'/';
		
		$this->defineAllPluginOptions();

		if ( is_admin() ) {
			$oInstall = new HLT_BootstrapCss_Install( &$this->m_aAllPluginOptions );
			$oUninstall = new HLT_BootstrapCss_Uninstall( &$this->m_aAllPluginOptions );
		}
	}
	
	private function defineAllPluginOptions() {
		
		$this->m_aAllPluginOptions = array(
			array( 'option',					'none',	'select' ), //the main option of the plugin - which reset CSS to use
			array( 'inc_responsive_css',		'N',	'checkbox' ),	// Bootstrap v2.0+
			
			array( 'customcss',					'N',	'checkbox' ),
			array( 'customcss_url',				'http://',	'text' ),
			
			//Twitter Javascript preferences
			array( 'all_js',					'N', 'checkbox' ),	// Bootstrap v2.0+
			
			array( 'js_head',					'N', 'checkbox' ),
			
			//Twitter Bootstrap Extra Options
			array( 'useshortcodes',				'N', 'checkbox' ),
			array( 'use_minified_css',			'Y', 'checkbox' ),	//Defaults to Minified
			array( 'use_compiled_css',			'N', 'checkbox' ),
			
			//Miscellaneous
			array( 'prettify',					'N', 'checkbox' ),
			array( 'hide_dashboard_rss_feed',	'N', 'checkbox' ),
			array( 'inc_bootstrap_css_wpadmin',	'N', 'checkbox' ),
			array( 'delete_on_deactivate',		'N', 'checkbox' ),
			
			//Plugin admin flags
			array( 'feedback_admin_notice',		'', '' ), //set to empty to not display anything
			array( 'current_plugin_version',	'', '' ), //for managing upgrades and calling the upgrade handler
		);
		
		//$this->m_aAllPluginOptions = array_merge($this->m_aAllPluginOptions, $this->m_aAllBootstrapLessOptions );
		
	}//defineAllPluginOptions
	
	public function printAdminNotices() {

		// (1) check for plugin upgrade
		global $current_user;
		$user_id = $current_user->ID;

		$sCurrentVersion = get_user_meta( $user_id, self::OptionPrefix.'current_version', true );

		if ( current_user_can( 'manage_options' ) && $sCurrentVersion !== self::$VERSION ) {
			echo '
				<div id="message" class="updated">
					<style>
						#message form {
							margin: 0px;
						}
					</style>
					<form method="post" action="admin.php?page=hlt-directory-bootstrap-css">
						<p><strong>WordPress Twitter Bootstrap</strong> plugin has been updated. Worth checking out the latest docs.
						<input type="hidden" value="1" name="hlt_hide_update_notice" id="hlt_hide_update_notice">
						<input type="hidden" value="'.$user_id.'" name="hlt_user_id" id="hlt_user_id">
						<input type="submit" value="Okay, show me and hide this notice" name="submit" class="button-primary">
						</p>
					</form>
				</div>
			';
		}

		// (2) check for plugin settings upgrade
		$sAdminFeedbackNotice = self::getOption( 'feedback_admin_notice' );
		if ( !empty( $sAdminFeedbackNotice ) ) {
			echo '
				<div id="message" class="updated">
					<p>'.$sAdminFeedbackNotice.'</p>
				</div>
			';
			self::updateOption( 'feedback_admin_notice', '' );
		}
		
	}//printAdminNotice

	/**
	 * Performs the actual rewrite of the <HEAD> to include the reset file(s)
	 *
	 * @param $insContents
	 */
	public function rewriteHead( $insContents ) {
		
		$aPossibleOptions = array( 'twitter', 'yahoo-reset', 'yahoo-reset-3', 'normalize' );
		
		$sBoostrapOption = self::getOption( 'option' );
		$fResponsive = ( self::getOption( 'inc_responsive_css' ) == 'Y' );
		$fCustomCss = ( self::getOption( 'customcss' ) == 'Y' );
		
		$sMinifiedCssOption = ( self::getOption( 'use_minified_css' ) == 'Y' )? '.min.css' : '.css';
		
		if ( !in_array( $sBoostrapOption, $aPossibleOptions ) && !$fCustomCss ) {
			return $insContents;
		}
		
		$aLocalCss = array(
			'twitter'					=> self::$BOOSTRAP_URL.'css/bootstrap'.$sMinifiedCssOption,
			'twitter_less'				=> self::$BOOSTRAP_URL.'css/bootstrap.less'.$sMinifiedCssOption,
			'twitter_responsive'		=> self::$BOOSTRAP_URL.'css/bootstrap-responsive'.$sMinifiedCssOption,
			'yahoo-reset'				=> self::$PLUGIN_URL.'resources/misc/css/yahoo-2.9.0.min.css',
			'yahoo-reset-3'				=> self::$PLUGIN_URL.'resources/misc/css/yahoo-'.self::YUI3Version.'.min.css',
			'normalize'					=> self::$PLUGIN_URL.'resources/misc/css/normalize.css'
		);
		
		$sCssLink = $aLocalCss[$sBoostrapOption];
		
		//Add the CSS link
		$sRegExp = "/(<\bhead\b([^>]*)>)/i";
		$sReplace = '${1}';
		$sReplace .= "\n<!-- This site uses WordPress Twitter Bootstrap CSS plugin v".self::$VERSION." from http://worpit.com/ -->";
		
		if ( in_array( $sBoostrapOption, $aPossibleOptions ) ) {
			//link to the Twitter LESS-compiled CSS (only if the file exists)
			if ( $sBoostrapOption == 'twitter'
					&& self::getOption( 'use_compiled_css' ) == 'Y'
					&& file_exists( self::$BOOSTRAP_DIR.'css'.DS.'bootstrap.less'.$sMinifiedCssOption )
					) {
				$sCssLink = $aLocalCss['twitter_less'];
			}
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$sCssLink.'">';
		}
		
		//Add the Responsive CSS link
		if ( $fResponsive && $sBoostrapOption == 'twitter' ) {
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$aLocalCss['twitter_responsive'].'">';
		}

		//Custom/Reset CSS
		if ( $fCustomCss ) {
			$sCustomCssUrl = self::getOption( 'customcss_url' );
			if ( !empty($sCustomCssUrl) ) {
				$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$sCustomCssUrl.'">';
			}
		}
		$sReplace .= "\n<!-- / WordPress Twitter Bootstrap CSS Plugin from Worpit. -->";
		
		return preg_replace( $sRegExp, $sReplace, $insContents );
	}
	
	/**
	 * Links up the Twitter Bootstrap CSS into the WordPress Admin.
	 *
	 * Also includes a separate CSS fixes file.
	 */
	public function includeTwitterCssWpAdmin() {
		wp_register_style( 'bootstrap_wpadmin_css', self::$PLUGIN_URL.'resources/misc/css/bootstrap-wpadmin-'.self::TwitterVersion.'.css', false, self::$VERSION );
		wp_enqueue_style( 'bootstrap_wpadmin_css' );
		wp_register_style( 'bootstrap_wpadmin_css_fixes', self::$PLUGIN_URL.'resources/misc/css/bootstrap-wpadmin-fixes.css', array('bootstrap_wpadmin_css'), self::$VERSION );
		wp_enqueue_style( 'bootstrap_wpadmin_css_fixes' );
	}//includeTwitterCssWpAdmin

	public function onWpInit() {
		parent::onWpInit();
		
		if ( !is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) ) {
			ob_start( array( &$this, 'onOutputBufferFlush' ) );
		}

		add_action( 'wp_enqueue_scripts', array( &$this, 'onWpPrintStyles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'onWpEnqueueScripts' ) );
		
		//if shortcodes are enabled, instantiate
		$sBootstrapOption = self::getOption( 'option' );
		if ( self::getOption( 'option' ) == 'twitter' && self::getOption( 'useshortcodes' ) == 'Y' ) {
			$oShortCodes = new HLT_BootstrapShortcodes( '2' );
		}
	}//onWpInit
	
	public function onWpAdminInit() {
		parent::onWpAdminInit();
		
		global $pagenow;
		//Loads the news widget on the Dashboard (if it hasn't been disabled)
		if ( $pagenow == 'index.php' ) {
			$sDashboardRssOption = self::getOption( 'hide_dashboard_rss_feed' );
			if ( empty( $sDashboardRssOption ) || self::getOption( 'hide_dashboard_rss_feed' ) == 'N' ) {
				$oHLT_DashboardRssWidget = new HLT_DashboardRssWidget();
			}
		}
		
		$sSubPageNow = isset( $_GET['page'] )? $_GET['page']: '';
		$aAllowedPages = array(
			'hlt-directory',
			'hlt-directory-bootstrap-css',
			'hlt-directory-bootstrap-less'
		);
		
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->getSubmenuId( 'bootstrap-less' ) ) {
			wp_register_style( 'miniColors', self::$PLUGIN_URL.'inc/miniColors/jquery.miniColors.css', array(), self::$VERSION );
			wp_enqueue_style( 'miniColors' );
		}
		
		$fAddAdminBootstrap = false;
		if ( ($pagenow == 'admin.php') && in_array( $sSubPageNow, $aAllowedPages ) ) {
			//Links up CSS styles for the plugin itself (set the admin bootstrap CSS as a dependency also)
			wp_register_style( 'wtb_css', self::$PLUGIN_URL.'resources/misc/css/bootstrap-admin.css', array( 'bootstrap_wpadmin_css_fixes' ), self::$VERSION );
			wp_enqueue_style( 'wtb_css' );
			
			$fAddAdminBootstrap = true; //for use in the next step
		}
		
		//Adds the WP Admin Twitter Bootstrap files if the option is set
		if ( $fAddAdminBootstrap || self::getOption( 'inc_bootstrap_css_wpadmin' ) == 'Y' ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'includeTwitterCssWpAdmin' ), 99 );
		}

		//Multilingual support.
		load_plugin_textdomain( 'hlt-wordpress-bootstrap-css', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	public function onWpPluginsLoaded() {
		parent::onWpPluginsLoaded();
		
		if ( is_admin() ) {
		
			$this->handlePluginUpgrade();
			$this->handleSubmit();

			//Display the admin notices where applicable.
			add_action( 'admin_notices', array( &$this, 'printAdminNotices' ) );
		}
	}
	
	public function onWpAdminMenu() {
		parent::onWpAdminMenu();
		
		add_submenu_page( self::ParentMenuId, $this->getSubmenuPageTitle( 'Bootstrap CSS' ), 'Bootstrap CSS', self::ParentPermissions, $this->getSubmenuId( 'bootstrap-css' ), array( &$this, 'onDisplayIndex' ) );
		add_submenu_page( self::ParentMenuId, $this->getSubmenuPageTitle( 'Bootstrap LESS' ), 'Bootstrap LESS', self::ParentPermissions, $this->getSubmenuId( 'bootstrap-less' ), array( &$this, 'onDisplayLess' ) );
		$this->fixSubmenu();
	}
	
	/**
	 * Handles the upgrade from version 1 to version 2 of Twitter Bootstrap.
	 */
	public function handlePluginUpgrade() {
		
		//current_user_can( 'manage_options' ) ensure only valid users attempt this.
		if ( self::getOption( 'current_plugin_version' ) !== self::$VERSION && current_user_can( 'manage_options' ) ) {

			//Manages those users who are coming from a version pre-Twitter 2.0+
			if ( self::getOption( 'upgraded1to2' ) !== 'Y' ) {
				if ( self::getOption( 'alerts_js' ) === 'Y' || self::getOption( 'tabs_js' ) === 'Y'	|| self::getOption( 'twipsy_js' ) === 'Y' ) {
					self::updateOption( 'all_js', 'Y' );
				}
				self::addOption( 'upgraded1to2', 'Y' );
			}
			
			//Manages migration to version 2.0.3 where legacy twitter and individual Javascript libraries are removed
			if ( self::getOption( 'alert_js' ) == 'Y'
					|| self::getOption( 'button_js' ) == 'Y'
					|| self::getOption( 'dropdown_js' ) == 'Y'
					|| self::getOption( 'modal_js' ) == 'Y'
					|| self::getOption( 'tooltip_js' ) == 'Y'
					|| self::getOption( 'popover_js' ) == 'Y'
					|| self::getOption( 'scrollspy_js' ) == 'Y'
					|| self::getOption( 'tab_js' ) == 'Y'
					|| self::getOption( 'transition_js' ) == 'Y'
					|| self::getOption( 'collapse_js' ) == 'Y'
					|| self::getOption( 'carousel_js' ) == 'Y'
					|| self::getOption( 'typeahead_js' ) == 'Y'
					) {
				self::updateOption( 'all_js', 'Y' );
			}
			
			//Delete all old plugin options from all previous versions if they exist.
			$m_aAllOldPluginOptions = array(
				'hotlink',
				'alert_js',
				'button_js',
				'dropdown_js',
				'modal_js',
				'tooltip_js',
				'popover_js',
				'scrollspy_js',
				'tab_js',
				'transition_js',
				'collapse_js',
				'carousel_js',
				'typeahead_js',
				'alerts_js',	//upgrade from 1~2
				'tabs_js',		//upgrade from 1~2
				'twipsy_js'		//upgrade from 1~2
			);
			
			foreach ( $m_aAllOldPluginOptions as $sOldOptions ) {
				self::deleteOption( $sOldOptions );
			}
		
			//Set the flag so that this update handler isn't run again for this version.
			self::updateOption( 'current_plugin_version', self::$VERSION );
		}//if

		//Someone clicked the button to acknowledge the update
		if ( isset( $_POST['hlt_hide_update_notice'] ) && isset( $_POST['hlt_user_id'] ) ) {
			$result = update_user_meta( $_POST['hlt_user_id'], 'hlt_bootstrapcss_current_version', self::$VERSION );
			header( "Location: admin.php?page=hlt-directory" );
		}
		
	}//handlePluginUpgrade
	
	public function onDisplayIndex() {
	
		$aData = array(
			'plugin_url'						=> self::$PLUGIN_URL,
			'option'							=> self::getOption( 'option' ),
			'option_inc_responsive_css'			=> self::getOption( 'inc_responsive_css' ),	// Bootstrap v2.0+

			'option_customcss'					=> self::getOption( 'customcss' ),
			'text_customcss_url'				=> self::getOption( 'customcss_url' ),

			'option_all_js'						=> self::getOption( 'all_js' ),			// Bootstrap v2.0+
			'option_js_head'					=> self::getOption( 'js_head' ),
			
			'option_useshortcodes'				=> self::getOption( 'useshortcodes' ),
			'option_use_minified_css'			=> self::getOption( 'use_minified_css' ),
			'option_use_compiled_css'			=> self::getOption( 'use_compiled_css' ),

			'option_inc_bootstrap_css_wpadmin'	=> self::getOption( 'inc_bootstrap_css_wpadmin' ),
			'option_hide_dashboard_rss_feed'	=> self::getOption( 'hide_dashboard_rss_feed' ),
			'option_delete_on_deactivate'		=> self::getOption( 'delete_on_deactivate' ),
			'option_prettify'					=> self::getOption( 'prettify' ),
			
			'form_action'						=> 'admin.php?page=hlt-directory-bootstrap-css'
		);
		$this->display( 'bootstrapcss_index', $aData );
	}//onDisplayIndex
	
	public function onDisplayLess() {
		
		$oBoostrapLess = new HLT_BootstrapLess();

		$aData = array(
			'plugin_url'				=> self::$PLUGIN_URL,
			'compiler_enabled'			=> self::getOption( 'use_compiled_css' ) === 'Y',
			'form_action'				=> 'admin.php?page=hlt-directory-bootstrap-less',
			'less_prefix'				=> HLT_BootstrapLess::LessOptionsPrefix,
			'less_options'				=> $oBoostrapLess->getAllBootstrapLessOptions(true),
			'less_file_location'		=> array( self::$BOOSTRAP_DIR.'css'.DS.'bootstrap.less.css', self::$BOOSTRAP_URL.'css/bootstrap.less.css' )
		);
		
		//enqueue JS color scripts
		//wp_register_script( 'jscolor-picker', self::$PLUGIN_URL.'inc/jscolor/jscolor.js', '', self::$VERSION, true );
		//wp_enqueue_script( 'jscolor-picker' );
	
		wp_register_script( 'miniColors', self::$PLUGIN_URL.'inc/miniColors/jquery.miniColors.min.js', '', self::$VERSION, true );
		wp_enqueue_script( 'miniColors' );
		
		$this->display( 'bootstrapcss_less', $aData );
		
	}//onDisplayLess
	
	public function onOutputBufferFlush( $insContent ) {
		return $this->rewriteHead( $insContent );
	}
	
	protected function handleSubmit_BootstrapIndex() {
		
		if ( !isset( $_POST['hlt_bootstrap_option'] ) ) {
			return;
		}
	
		self::updateOption( 'option',			$_POST['hlt_bootstrap_option'] );
	
		$sCustomUrl = $_POST[self::InputPrefix.'text_customcss_url'];
		$fCustomCss = ($this->getAnswerFromPost( 'option_customcss' ) === 'Y');
		if ( $fCustomCss && !empty( $sCustomUrl ) ) {
			if ( $this->checkUrlValid( $sCustomUrl ) ) {
				self::updateOption( 'customcss_url', $_POST[self::InputPrefix.'text_customcss_url'] );
			}
			else {
				self::updateOption( 'customcss_url', '' );
			}
		}
		
		self::updateOption( 'inc_responsive_css',			$this->getAnswerFromPost( 'option_inc_responsive_css' ) );	// Bootstrap v2.0+
		self::updateOption( 'customcss',					$this->getAnswerFromPost( 'option_customcss' ) );
	
		self::updateOption( 'all_js',						$this->getAnswerFromPost( 'option_all_js' ) );	// Bootstrap v2.0+
		self::updateOption( 'js_head',						$this->getAnswerFromPost( 'option_js_head' ) );
		
		self::updateOption( 'useshortcodes',				$this->getAnswerFromPost( 'option_useshortcodes' ) );
		self::updateOption( 'use_minified_css',				$this->getAnswerFromPost( 'option_use_minified_css' ) );
		self::updateOption( 'use_compiled_css',				$this->getAnswerFromPost( 'option_use_compiled_css' ) );
		
		self::updateOption( 'inc_bootstrap_css_wpadmin',	$this->getAnswerFromPost( 'option_inc_bootstrap_css_wpadmin' ) );	// Bootstrap v2.0+
		self::updateOption( 'hide_dashboard_rss_feed',		$this->getAnswerFromPost( 'option_hide_dashboard_rss_feed' ) );
		self::updateOption( 'delete_on_deactivate',			$this->getAnswerFromPost( 'option_delete_on_deactivate' ) );
		self::updateOption( 'prettify',						$this->getAnswerFromPost( 'option_prettify' ) );
		
		if ( !$this->m_fUpdateSuccessTracker ) {
			self::updateOption( 'feedback_admin_notice', 'Updating Twitter Bootstrap Settings <strong>Failed</strong>.' );
		}
		else {
			self::updateOption( 'feedback_admin_notice', 'Updating Twitter Bootstrap Settings <strong>Succeeded</strong>.' );
		}
		
		// Flush W3 Total Cache (compatible up to version 0.9.2.4)
		if ( class_exists( 'W3_Plugin_TotalCacheAdmin' ) ) {
			$oW3TotalCache =& w3_instance( 'W3_Plugin_TotalCacheAdmin' );
			$oW3TotalCache->flush_all();
		}
		
		// TODO:
		// header( "Location:admin.php?page=hlt-directory-bootstrap-css" ); //breaks admin notices
	}
	
	protected function handleSubmit_BootstrapLess() {
		
		if ( !isset( $_POST['hlt_less_option'] ) ) {
			return;
		}
	
		$oBoostrapLess = new HLT_BootstrapLess();

		if ( isset( $_POST['submit_reset'] ) ) {
			$oBoostrapLess->resetToDefaultAllLessOptions( self::$BOOSTRAP_DIR );
			return;
		}
		
		$aAllLessOptions = $oBoostrapLess->getAllBootstrapLessOptions();
		
		// TODO: Make as const
		$sLessPrefix = 'less_';
		
		$oBoostrapLess->processNewLessOptions( $_POST, 'hlt_', self::$BOOSTRAP_DIR );

		
		
	}//handleSubmit_BootstrapLess
	
	protected function handleSubmit() {
	
		if ( isset( $_GET['page'] ) ) {
			switch ( $_GET['page'] ) {
				case $this->getSubmenuId( 'bootstrap-css' ):
					$this->handleSubmit_BootstrapIndex();
					return;
					
				case $this->getSubmenuId( 'bootstrap-less' ):
					$this->handleSubmit_BootstrapLess();
					return;
			}
		}
	}//handleSubmit

	public function onWpPrintStyles() {
		if ( self::getOption( 'prettify' ) == 'Y' ) {
			$sUrlPrefix = self::$PLUGIN_URL.'resources/misc/js/google-code-prettify/';
			wp_register_style( 'prettify_style', $sUrlPrefix.'prettify.css' );
			wp_enqueue_style( 'prettify_style' );
		}
	}

	public function onWpEnqueueScripts() {
		
		$fJsInFooter = (self::getOption( 'js_head' ) == 'Y'? false : true);
		$sBootstrapOption = self::getOption( 'option' );
		
		if ( $sBootstrapOption == 'twitter' && self::getOption( 'all_js' ) == 'Y' ) {
			$sUrlPrefix = self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersion.'/js/bootstrap';
			wp_enqueue_script( 'jquery' );
			
			wp_register_script( 'bootstrap-all-min', $sUrlPrefix.'.min.js', 'jquery', self::$VERSION, $fJsInFooter );
			wp_enqueue_script( 'bootstrap-all-min' );
		}
		
		if ( self::getOption( 'prettify' ) == 'Y' ) {
			$sUrlPrefix = self::$PLUGIN_URL.'js/google-code-prettify/';
			wp_register_script( 'prettify_script', $sUrlPrefix.'prettify.js', '', self::$VERSION, $fJsInFooter );
			wp_enqueue_script( 'prettify_script' );
		}
	}//onWpEnqueueScripts
	
	protected function checkUrlValid( $insUrl ) {
		$oCurl = curl_init();
		curl_setopt( $oCurl, CURLOPT_URL, $insUrl );
		curl_setopt( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $oCurl, CURLOPT_CONNECTTIMEOUT, 10 );
		
		$sContent = curl_exec( $oCurl );
		$sHttpCode = curl_getinfo( $oCurl, CURLINFO_HTTP_CODE );
		curl_close( $oCurl );
		
		return ( intval( $sHttpCode ) === 200 );
	}
	
	protected function getAnswerFromPost( $insKey, $insPrefix = null ) {
		if ( is_null( $insPrefix ) ) {
			$insKey = self::InputPrefix.$insKey;
		}
		return ( isset( $_POST[$insKey] )? 'Y': 'N' );
	}
	
	/**
	 * Not currently used, but could be useful once we work out what way the JS should be included.
	 * @param $insHandle	For example: 'prettify/prettify.css'
	 */
	protected function isRegistered( $insHandle ) {
		return (
			wp_script_is( $insHandle, 'registered' ) ||
			wp_script_is( $insHandle, 'queue' ) ||
			wp_script_is( $insHandle, 'done' ) ||
			wp_script_is( $insHandle, 'to_do' )
		);
	}
	
	static public function getOption( $insKey ) {
		return get_option( self::OptionPrefix.$insKey );
	}
	
	static public function addOption( $insKey, $insValue ) {
		return add_option( self::OptionPrefix.$insKey, $insValue );
	}
	
	static public function updateOption( $insKey, $insValue ) {
		if ( self::getOption( $insKey ) == $insValue ) {
			return true;
		}
		$fResult = update_option( self::OptionPrefix.$insKey, $insValue );
		if ( !$fResult ) {
			$this->m_fUpdateSuccessTracker = false;
			$this->m_aFailedUpdateOptions[] = self::OptionPrefix.$insKey;
		}
	}
	
	static public function deleteOption( $insKey ) {
		return delete_option( self::OptionPrefix.$insKey );
	}
	
	public function onWpPluginActionLinks( $inaLinks, $insFile ) {
		if ( $insFile == plugin_basename( __FILE__ ) ) {
		//	$sSettingsLink = '<a href="'.admin_url( "admin.php" ).'?page=hlt-directory-bootstrap-less">' . _hlt__( 'LESS' ) . '</a>';
		//	array_unshift( $inaLinks, $sSettingsLink );
			$sSettingsLink = '<a href="'.admin_url( "admin.php" ).'?page=hlt-directory-bootstrap-css">' . _hlt__( 'Settings' ) . '</a>';
			array_unshift( $inaLinks, $sSettingsLink );
		}
		return $inaLinks;
	}

}//HLT_BootstrapCss

class HLT_BootstrapCss_Install {

	private $m_aAllPluginOptions;

	public function __construct( $inaAllPluginOptions ) {
		$this->m_aAllPluginOptions = $inaAllPluginOptions;
		register_activation_hook( __FILE__, array( &$this, 'onWpActivatePlugin' ) );
	}
	
	public function onWpActivatePlugin() {
		
		foreach ( $this->m_aAllPluginOptions as $aPluginOption ) {
			HLT_BootstrapCss::addOption( $aPluginOption[0], $aPluginOption[1] );
		}
	}
}//HLT_BootstrapCss_Install

class HLT_BootstrapCss_Uninstall {
	
	// TODO: when uninstalling, maybe have a WPversion save settings offsite-like setting

	private $m_aAllPluginOptions;
	
	public function __construct($inaAllPluginOptions) {
		$this->m_aAllPluginOptions = $inaAllPluginOptions;
		register_deactivation_hook( __FILE__, array( &$this, 'onWpDeactivatePlugin' ) );
	}
	
	public function onWpDeactivatePlugin() {
		
		if ( HLT_BootstrapCss::getOption('delete_on_deactivate') == 'Y' ) {
			foreach ( $this->m_aAllPluginOptions as $aPluginOption ) {
				HLT_BootstrapCss::deleteOption( $aPluginOption[0] );
			}
			$oBoostrapLess = new HLT_BootstrapLess();
			$oBoostrapLess->deleteAllLessOptions();
		}
		HLT_BootstrapCss::deleteOption( 'upgraded1to2' );
	}
}//HLT_BootstrapCss_Uninstall

class HLT_Plugin {
	
	static public $VERSION;
	
	static public $PLUGIN_NAME;
	static public $PLUGIN_PATH;
	static public $PLUGIN_DIR;
	static public $PLUGIN_URL;
	
	const ParentTitle		= 'Worpit Plugins';
	const ParentName		= 'Twitter Bootstrap';
	const ParentPermissions	= 'manage_options';
	const ParentMenuId		= 'hlt-directory';
	
	const ViewExt			= '.php';
	const ViewDir			= 'views';
	
	public function __construct() {
		add_action( 'init', array( &$this, 'onWpInit' ), 1 );
		add_action( 'admin_init', array( &$this, 'onWpAdminInit' ) );
		add_action( 'plugins_loaded', array( &$this, 'onWpPluginsLoaded' ) );
	}
	
	protected function fixSubmenu() {
		global $submenu;
		if ( isset( $submenu[self::ParentMenuId] ) ) {
			$submenu[self::ParentMenuId][0][0] = 'Dashboard';
		}
	}
	
	/**
	 *
	 * @param $insUrl
	 * @param $innTimeout
	 */
	protected function redirect( $insUrl, $innTimeout = 1 ) {
		echo '
			<script type="text/javascript">
				function redirect() {
					window.location = "'.$insUrl.'";
				}
				var oTimer = setTimeout( "redirect()", "'.($innTimeout * 1000).'" );
			</script>';
	}
	
	protected function display( $insView, $inaData = array() ) {
		$sFile = dirname(__FILE__).DS.self::ViewDir.DS.$insView.self::ViewExt;
		
		if ( !is_file( $sFile ) ) {
			echo "View not found: ".$sFile;
			return false;
		}
		
		if ( count( $inaData ) > 0 ) {
			extract( $inaData, EXTR_PREFIX_ALL, 'hlt' );
		}
		
		ob_start();
			include( $sFile );
			$sContents = ob_get_contents();
		ob_end_clean();
		
		echo $sContents;
		return true;
	}
	
	protected function getImageUrl( $insImage ) {
		return self::$PLUGIN_URL.'resources/misc/images/'.$insImage;
	}
	
	protected function getSubmenuPageTitle( $insTitle ) {
		return self::ParentTitle.' - '.$insTitle;
	}
	
	protected function getSubmenuId( $insId ) {
		return self::ParentMenuId.'-'.$insId;
	}
	
	public function onWpInit() {
		add_action( 'admin_menu', array( &$this, 'onWpAdminMenu' ) );
		add_action( 'plugin_action_links', array( &$this, 'onWpPluginActionLinks' ), 10, 4 );
	}
	public function onWpAdminInit() {
	}
	
	public function onWpPluginsLoaded() {
	}
	
	public function onWpAdminMenu() {
		add_menu_page( self::ParentTitle, self::ParentName, self::ParentPermissions, self::ParentMenuId, array( $this, 'onDisplayMainMenu' ), $this->getImageUrl( 'worpit_16x16.png' ) );
	}
	
	public function onDisplayMainMenu() {
		//$this->redirect( 'admin.php?page=hlt-directory-bootstrap-css' );

		$aData = array(
			'plugin_url'	=> self::$PLUGIN_URL
		);
		$this->display( 'worpit_index', $aData );
	}
	
	public function onWpPluginActionLinks( $inaLinks, $insFile ) {
	}
	
}

$oHLT_BootstrapCss = new HLT_BootstrapCss();
