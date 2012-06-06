<?php

/*
Plugin Name: WordPress Twitter Bootstrap CSS
Plugin URI: http://worpit.com/wordpress-twitter-bootstrap-css-plugin-home/
Description: Allows you to install Twitter Bootstrap CSS and Javascript files for your site, before all others.
Version: 2.0.4
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
require_once( dirname(__FILE__).'/src/worpit-plugins-base.php' );
include_once( dirname(__FILE__).'/hlt-bootstrap-shortcodes.php' );
include_once( dirname(__FILE__).'/hlt-bootstrap-less.php' );
include_once( dirname(__FILE__).'/hlt-rssfeed-widget.php' );

define( 'DS', DIRECTORY_SEPARATOR );

function _hlt_e( $insStr ) {
	_e( $insStr, 'hlt-wordpress-bootstrap-css' );
}
function _hlt__( $insStr ) {
	return __( $insStr, 'hlt-wordpress-bootstrap-css' );
}

class HLT_BootstrapCss extends HLT_Plugin {
	
	const InputPrefix			= 'hlt_bootstrap_';
	const OptionPrefix			= 'hlt_bootstrapcss_'; //ALL database options use this as the prefix.
	
	const TwitterVersion		= '2.0.4';
	const TwitterVersionLegacy	= '1.4.0';
	const YUI3Version			= '3.4.1';
	
	const GoogleCdnJqueryVersion	= '1.7.2';
	
	static public $BOOSTRAP_DIR;
	static public $BOOSTRAP_URL;
	
	protected $m_aAllPluginOptions;
	protected $m_aAllBootstrapLessOptions;
	
	public function __construct() {
		parent::__construct();

		register_activation_hook( __FILE__, array( &$this, 'onWpActivatePlugin' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'onWpDeactivatePlugin' ) );
		register_uninstall_hook( __FILE__, array( &$this, 'onWpUninstallPlugin' ) );
		
		/**
		 * We make the assumption that all settings updates are successful until told otherwise
		 * by an actual failing update_option call.
		 */
		$this->m_fUpdateSuccessTracker = true;
		$this->m_aFailedUpdateOptions = array();

		self::$VERSION		= '2.0.4'; //SHOULD BE UPDATED UPON EACH NEW RELEASE
		
		self::$PLUGIN_NAME	= basename(__FILE__);
		self::$PLUGIN_PATH	= plugin_basename( dirname(__FILE__) );
		self::$PLUGIN_DIR	= WP_PLUGIN_DIR.DS.self::$PLUGIN_PATH.DS;
		self::$PLUGIN_URL	= WP_PLUGIN_URL.'/'.self::$PLUGIN_PATH.'/';
		self::$OPTION_PREFIX = self::BaseOptionPrefix . self::OptionPrefix;
		self::$OPTION_PREFIX = self::OptionPrefix;

		self::$BOOSTRAP_DIR = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-'.self::TwitterVersion.DS;
		self::$BOOSTRAP_URL = self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersion.'/';
		
		$this->m_sParentMenuIdSuffix = 'wtb';
		
	}
	
	protected function initPluginOptions() {
		
		/* v2.0.4.1
		$this->m_aAllPluginOptions = array(
				'Choose Bootstrap CSS Options' => array(
						array( 'option', 					'',		'none', 	'select' ),
						array( 'inc_responsive_css',		'',		'N',		'checkbox' ),
						array( 'customcss',					'',		'N',		'checkbox' ),
						array( 'customcss_url',				'',		'http://',	'text' )
				),
				'Twitter Bootstrap Javascript Library Options' => array(
						array( 'all_js', 					'',		'N',	'checkbox' ),
						array( 'js_head',					'',		'N',	'checkbox' )
				),
				'Extra Twitter Bootstrap Options' => array(
						array( 'useshortcodes', 			'',		'N',	'checkbox' ),
						array( 'use_minified_css',			'',		'N',	'checkbox' ),
						array( 'use_compiled_css',			'',		'N',	'checkbox' ),
						array( 'replace_jquery_cdn',		'',		'Y',	'checkbox' )
				),
				'Miscellaneous Plugin Options' => array(
						array( 'inc_bootstrap_css_wpadmin', '',		'N',	'checkbox' ),
						array( 'hide_dashboard_rss_feed',	'',		'N',	'checkbox' ),
						array( 'delete_on_deactivate',		'',		'N',	'checkbox' ),
						array( 'prettify',					'',		'Y',	'checkbox' )
				)
		);
		*/	
				
		$this->m_aAllPluginOptions = array(
			array( 'option',					'none',	'select' ), 	//the main option of the plugin - which reset CSS to use
			array( 'inc_responsive_css',		'N',	'checkbox' ),	// Bootstrap v2.0+
			
			array( 'customcss',					'N',	'checkbox' ),
			array( 'customcss_url',				'http://',	'text' ),
			
			//Twitter Javascript preferences
			array( 'all_js',					'N', 'checkbox' ),	// Bootstrap v2.0+
			array( 'js_head',					'N', 'checkbox' ),
			
			//Twitter Bootstrap Extra Options
			array( 'useshortcodes',				'N', 'checkbox' ),
			array( 'use_minified_css',			'N', 'checkbox' ),
			array( 'use_compiled_css',			'N', 'checkbox' ),
			array( 'replace_jquery_cdn',		'N', 'checkbox' ),
			
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
		
	}//initPluginOptions
	
	public function onWpAdminNotices() {
		
		//Do we have admin priviledges?
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$this->adminNoticeVersionUpgrade();
		$this->adminNoticeOptionsUpdated();
	}
	
	private function adminNoticeVersionUpgrade() {

		global $current_user;
		$user_id = $current_user->ID;

		$sCurrentVersion = get_user_meta( $user_id, self::$OPTION_PREFIX.'current_version', true );

		if ( $sCurrentVersion !== self::$VERSION ) {
			$sNotice = '
					<form method="post" action="admin.php?page='.$this->getSubmenuId('bootstrap-css').'">
						<p><strong>WordPress Twitter Bootstrap</strong> plugin has been updated. Worth checking out the latest docs.
						<input type="hidden" value="1" name="hlt_hide_update_notice" id="hlt_hide_update_notice">
						<input type="hidden" value="'.$user_id.'" name="hlt_user_id" id="hlt_user_id">
						<input type="submit" value="Okay, show me and hide this notice" name="submit" class="button-primary">
						</p>
					</form>
			';
			
			$this->getAdminNotice( $sNotice, 'updated', true );
		}
		
	}//adminNoticeVersionUpgrade
	
	private function adminNoticeOptionsUpdated() {
		
		$sAdminFeedbackNotice = $this->getOption( 'feedback_admin_notice' );
		if ( !empty( $sAdminFeedbackNotice ) ) {
			$sNotice = '<p>'.$sAdminFeedbackNotice.'</p>';
			$this->getAdminNotice( $sNotice, 'updated', true );
			$this->updateOption( 'feedback_admin_notice', '' );
		}
		
	}//adminNoticeOptionsUpdated

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
			'twitter_responsive'		=> self::$BOOSTRAP_URL.'css/bootstrap-responsive'.$sfiedCssOption,
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
			$oShortCodes = new HLT_BootstrapShortcodes();
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
		
		if ( $this->isWorpitPluginAdminPage()) {
			
			//JS color picker for the Bootstrap LESS
			if ( $_GET['page'] == $this->getSubmenuId( 'bootstrap-less' ) ) {
				wp_register_style( 'miniColors', self::$PLUGIN_URL.'inc/miniColors/jquery.miniColors.css', false, self::$VERSION );
				wp_enqueue_style( 'miniColors' );
	
				wp_register_script( 'miniColors', self::$PLUGIN_URL.'inc/miniColors/jquery.miniColors.min.js', false, self::$VERSION, true );
				wp_enqueue_script( 'miniColors' );
			}
			
		}
		//Adds the WP Admin Twitter Bootstrap files if the option is set
		if ( is_admin() && self::getOption( 'inc_bootstrap_css_wpadmin' ) == 'Y' ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueueBootstrapAdminCss' ), 99 );
		}
		
		//Multilingual support.
		load_plugin_textdomain( 'hlt-wordpress-bootstrap-css', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	protected function createPluginSubMenuItems(){
		$this->m_aPluginMenu = array(
				//Menu Page Title => Menu Item name, page ID (slug), callback function for this page - i.e. what to do/load.
				$this->getSubmenuPageTitle( 'Bootstrap CSS' ) => array( 'Bootstrap CSS', $this->getSubmenuId('bootstrap-css'), 'onDisplayWtbCss' ),
				$this->getSubmenuPageTitle( 'Bootstrap LESS' ) => array( 'Bootstrap LESS', $this->getSubmenuId('bootstrap-less'), 'onDisplayWtbLess' ),
			);
	}//createPluginSubMenuItems
	
	/**
	 * Handles the upgrade from version 1 to version 2 of Twitter Bootstrap as well as any other plugin upgrade
	 */
	protected function handlePluginUpgrade() {
		
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
			
			//Recompile LESS CSS if applicable
			if ( self::getOption('use_compiled_css') == 'Y' ) {
				$oBoostrapLess = new HLT_BootstrapLess();				
				if ( $oBoostrapLess->reWriteVariablesLess( self::$BOOSTRAP_DIR ) ) {
					$oBoostrapLess->compileLess( self::$BOOSTRAP_DIR );
				}
			}
		
			//Set the flag so that this update handler isn't run again for this version.
			self::updateOption( 'current_plugin_version', self::$VERSION );
		}//if

		//Someone clicked the button to acknowledge the update
		if ( isset( $_POST['hlt_hide_update_notice'] ) && isset( $_POST['hlt_user_id'] ) ) {
			$result = update_user_meta( $_POST['hlt_user_id'], 'hlt_bootstrapcss_current_version', self::$VERSION );
			header( "Location: admin.php?page=".$this->getFullParentMenuId() );
		}
		
	}//handlePluginUpgrade
	
	public function onDisplayWtbCss() {
	
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
			'option_replace_jquery_cdn'			=> self::getOption( 'replace_jquery_cdn' ),

			'option_inc_bootstrap_css_wpadmin'	=> self::getOption( 'inc_bootstrap_css_wpadmin' ),
			'option_hide_dashboard_rss_feed'	=> self::getOption( 'hide_dashboard_rss_feed' ),
			'option_delete_on_deactivate'		=> self::getOption( 'delete_on_deactivate' ),
			'option_prettify'					=> self::getOption( 'prettify' ),
			
		//	'form_action'						=> 'admin.php?page=hlt-directory-bootstrap-css',
			'form_action'						=> 'admin.php?page='.$this->getSubmenuId('bootstrap-css') //$this->getSubmenuId('bootstrap-css')
		);
		$this->display( 'bootstrapcss_index', $aData );
	}//onDisplayWtbCss
	
	public function onDisplayWtbLess() {
		
		$oBoostrapLess = new HLT_BootstrapLess();

		$aData = array(
			'plugin_url'				=> self::$PLUGIN_URL,
			'compiler_enabled'			=> self::getOption( 'use_compiled_css' ) === 'Y',
			'less_prefix'				=> HLT_BootstrapLess::LessOptionsPrefix,
			'less_options'				=> $oBoostrapLess->getAllBootstrapLessOptions(true),
			'less_file_location'		=> array( self::$BOOSTRAP_DIR.'css'.DS.'bootstrap.less.css', self::$BOOSTRAP_URL.'css/bootstrap.less.css' ),
			'page_link_options'			=> $this->getSubmenuId('bootstrap-css'),
				
		//	'form_action'				=> 'admin.php?page=hlt-directory-bootstrap-less',
			'form_action'				=> 'admin.php?page='.$this->getSubmenuId('bootstrap-less')
		);
		
		$this->display( 'bootstrapcss_less', $aData );
		
	}//onDisplayLess
	
	public function onOutputBufferFlush( $insContent ) {
		return $this->rewriteHead( $insContent );
	}
	
	protected function handlePluginFormSubmit() {
	
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
	}//handlePluginFormSubmit
	
	protected function handleSubmit_BootstrapIndex() {
		
		if ( !isset( $_POST['hlt_bootstrap_option'] ) ) {
			return;
		}
	
		self::updateOption( 'option',			$_POST['hlt_bootstrap_option'] );
		
		//DEBUG error problem reported: http://wordpress.org/support/topic/plugin-wordpress-twitter-bootstrap-css-noticeswarningsdb-option-usage
		$sCustomUrl = (isset( $_POST[self::InputPrefix.'text_customcss_url'] ))? $_POST[self::InputPrefix.'text_customcss_url'] : '';
		$fCustomCss = ($this->getAnswerFromPost( 'option_customcss' ) === 'Y');
		if ( $fCustomCss && !empty( $sCustomUrl ) ) {
			if ( $this->checkUrlValid( $sCustomUrl ) ) {
				self::updateOption( 'customcss_url', $sCustomUrl );
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
		self::updateOption( 'replace_jquery_cdn',			$this->getAnswerFromPost( 'option_replace_jquery_cdn' ) );
		
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
			
			$sExtension = ( self::getOption( 'use_minified_css' ) == 'Y' )? '.min.js' : '.js';
			if ( self::getOption( 'replace_jquery_cdn' ) == 'Y' ) {
				wp_deregister_script('jquery');
				
				$sGoogleJqueryUri = 'https://ajax.googleapis.com/ajax/libs/jquery/'.self::GoogleCdnJqueryVersion.'/jquery';
				$sGoogleJqueryUri .= $sExtension;
				
				wp_register_script( 'jquery', $sGoogleJqueryUri, '', self::GoogleCdnJqueryVersion, false );
			}
			
			wp_enqueue_script( 'jquery' );
			
			wp_register_script( 'bootstrap-all-min', $sUrlPrefix.$sExtension, array('jquery'), self::$VERSION, $fJsInFooter );
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
	
	public function onWpPluginActionLinks( $inaLinks, $insFile ) {
		if ( $insFile == plugin_basename( __FILE__ ) ) {
			$sSettingsLink = '<a href="'.admin_url( "admin.php" ).'?page='.$this->getSubmenuId('bootstrap-css').'">' . _hlt__( 'Settings' ) . '</a>';
			array_unshift( $inaLinks, $sSettingsLink );
		}
		return $inaLinks;
	}
	
	protected function deleteAllPluginDbOptions() {
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		if (empty($this->m_aAllPluginOptions)) {
			$this->initPluginOptions();
		}
		
		foreach ( $this->m_aAllPluginOptions as $aOptionParams ) {
			if ( isset( $aOptionParams[0] ) ) {
				$this->deleteOption($aOptionParams[0]);
			}
		}
		
		$this->deleteOption( 'upgraded1to2' );
		
		$oBoostrapLess = new HLT_BootstrapLess();
		$oBoostrapLess->deleteAllLessOptions();
		
	}//deleteAllPluginDbOptions
	
	public function onWpDeactivatePlugin() {
		
		if ( $this->getOption('delete_on_deactivate') == 'Y' ) {
			$this->deleteAllPluginDbOptions();
		}
		$this->deleteOption( 'upgraded1to2' );
		
		/* v2.0.4.1
		$this->initPluginOptions();

// 		if ( $this->getOption('delete_on_deactivate') == 'Y' ) {
			foreach ( $this->m_aAllPluginOptions as &$aOptionsSection ) {
				foreach ( $aOptionsSection['section_options'] as &$aOptionParams ) {
					$this->deleteOption( $aOptionParams[0] );
				}
			}
			$this->deleteOption( self::Ip2NationDbVersionKey );
// 		}
 		*/
	}//onWpDeactivatePlugin
	
	public function onWpActivatePlugin() { }

}//HLT_BootstrapCss


$oHLT_BootstrapCss = new HLT_BootstrapCss();
