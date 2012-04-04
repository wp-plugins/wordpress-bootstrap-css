<?php

/*
Plugin Name: WordPress Twitter Bootstrap CSS
Plugin URI: http://www.hostliketoast.com/wordpress-resource-centre/wordpress-plugins/
Description: Allows you to install Twitter Bootstrap CSS and Javascript files for your site, before all others.
Version: 2.0.2.1
Author: Host Like Toast
Author URI: http://www.hostliketoast.com/
*/

/**
 * Copyright (c) 2011 Host Like Toast <helpdesk@hostliketoast.com>
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

class HLT_BootstrapCss extends HLT_Plugin {
	
	const InputPrefix = 'hlt_bootstrap_';
	const OptionPrefix = 'hlt_bootstrapcss_';
	
	// possibly configurable in the UI, we'll determine this as new releases occur.
	const TwitterVersion = '2.0.2';
	const TwitterVersionLegacy = '1.4.0';
	
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

		self::$VERSION		= '2.0.2.1'; //SHOULD BE UPDATED UPON EACH NEW RELEASE
		
		self::$PLUGIN_NAME	= basename(__FILE__);
		self::$PLUGIN_PATH	= plugin_basename( dirname(__FILE__) );
		self::$PLUGIN_DIR	= WP_PLUGIN_DIR.DS.self::$PLUGIN_PATH.DS;
		self::$PLUGIN_URL	= WP_PLUGIN_URL.'/'.self::$PLUGIN_PATH.'/';
		
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
				array( 'alert_js',					'N', 'checkbox' ),
				array( 'button_js',					'N', 'checkbox' ),
				array( 'dropdown_js',				'N', 'checkbox' ),
				array( 'modal_js',					'N', 'checkbox' ),
				array( 'tooltip_js',				'N', 'checkbox' ),
				array( 'popover_js',				'N', 'checkbox' ),
				array( 'scrollspy_js',				'N', 'checkbox' ),
				array( 'tab_js',					'N', 'checkbox' ),
				array( 'transition_js',				'N', 'checkbox' ),	// Bootstrap v2.0+
				array( 'collapse_js',				'N', 'checkbox' ),	// Bootstrap v2.0+
				array( 'carousel_js',				'N', 'checkbox' ),	// Bootstrap v2.0+
				array( 'typeahead_js',				'N', 'checkbox' ),	// Bootstrap v2.0+
				
				array( 'js_head',					'N', 'checkbox' ),
				
				//Miscellaneous
				array( 'prettify',					'N', 'checkbox' ),
				array( 'hide_dashboard_rss_feed',	'N', 'checkbox' ),
				array( 'inc_bootstrap_css_wpadmin',	'N', 'checkbox' ),
				array( 'useshortcodes',				'N', 'checkbox' ),
				
				//Plugin admin flags
				array( 'feedback_admin_notice',		'', '' ), //set to empty to not display anything
			);
		
		$this->m_aAllBootstrapLessOptions = array (
				
				array( 'less_textColor',				'', '#333',						'color',		'Text Colour' ), //@grayDark
				array( 'less_primaryButtonBackground',	'', '#08c',						'color',		'Primary Button Colour' ), //@linkColor
				array( 'less_linkColor',				'', '#08c',						'color',		'Link Colour' ),
				array( 'less_linkColorHover',			'', '#08c',						'color',		'Link Hover Colour' ), //darken(@linkColor, 15%)
				array( 'less_blue',						'', '#049cdb',					'color',		'Blue' ),
				array( 'less_blueDark',					'', '#0064cd',					'color',		'Dark Blue' ),
				array( 'less_green',					'', '#46a546',					'color',		'Green' ),
				array( 'less_red',						'', '#9d261d',					'color',		'Red' ),
				array( 'less_yellow',					'', '#ffc40d',					'color',		'Yellow' ),
				array( 'less_orange',					'', '#f89406',					'color',		'Orange' ),
				array( 'less_pink',						'', '#c3325f',					'color',		'Pink' ),
				array( 'less_purple',					'', '#7a43b6',					'color',		'Purple' ),
				array( 'less_baseFontSize',				'', '13px',						'size',			'Font Size' ),
				array( 'less_baseLineHeight',			'', '18px',						'size',			'Base Line Height' ),
				array( 'less_baseFontFamily',			'', '"Helvetica Neue", Helvetica, Arial, sans-serif',	'',		'Font Family' )
			);
		
		$this->m_aAllPluginOptions = array_merge($this->m_aAllPluginOptions, $this->m_aAllBootstrapLessOptions );
		
	}//defineAllPluginOptions
	
	public function printAdminNotices() {

		// (1) check for plugin upgrade
		global $current_user;
		$user_id = $current_user->ID;

		$sCurrentVersion = get_user_meta( $user_id, 'hlt_bootstrapcss_current_version', true );

		if ( empty( $sCurrentVersion ) || ( $sCurrentVersion != self::$VERSION ) ) {
	        echo '
	        <div id="message" class="updated">
				<form method="post" action="admin.php?page=hlt-directory-bootstrap-css">
	        		<p><strong>WordPress Twitter Bootstrap</strong> plugin has been updated. Worth checking out the latest docs.
					<input type="hidden" value="1" name="hlt_hide_update_notice" id="hlt_hide_update_notice">
					<input type="hidden" value="'.$user_id.'" name="hlt_user_id" id="hlt_user_id">
					<input type="submit" value="Okay, show me and hide this notice" name="submit" class="button-primary">
					</p>
				</form>
	        </div>';
		}

		// (2) check for plugin settings upgrade
		$sAdminFeedbackNotice = self::getOption( 'feedback_admin_notice' );
		if ( !empty( $sAdminFeedbackNotice ) && $sAdminFeedbackNotice != '' ) {
	        echo '
	        <div id="message" class="updated">
	        		<p>'.$sAdminFeedbackNotice.'</p>
	        </div>';
	        self::updateOption( 'feedback_admin_notice', '' );
		}
		
	}//printAdminNotice

	/**
	 * Performs the actual rewrite of the <HEAD> to include the reset file(s)
	 *
	 * @param $insContents
	 */
	public function rewriteHead( $insContents ) {
		
		$aPossibleOptions = array( 'twitter', 'twitter-legacy', 'yahoo-reset', 'normalize' );
		
		$sOption = self::getOption( 'option' );
		$fHotlink = ( self::getOption( 'hotlink' ) == 'Y' );
		$fResponsive = ( self::getOption( 'inc_responsive_css' ) == 'Y' );

		$fCustomCss = ( self::getOption( 'customcss' ) == 'Y' );
		
		if ( !in_array( $sOption, $aPossibleOptions ) && !$fCustomCss ) {
			return $insContents;
		}
		
		$aLocalCss = array(
			'twitter'				=> self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersion.'/css/bootstrap.min.css',
			'twitter_responsive'	=> self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersion.'/css/bootstrap-responsive.min.css',
			'twitter-legacy'		=> self::$PLUGIN_URL.'resources/bootstrap-'.self::TwitterVersionLegacy.'/css/bootstrap.min.css',
			'yahoo-reset'			=> self::$PLUGIN_URL.'resources/misc/css/yahoo-2.9.0.min.css',
			'normalize'				=> self::$PLUGIN_URL.'resources/misc/css/normalize.css'
		);
		
		$sCssLink = $aLocalCss[$sOption];
		
		//Add the CSS link
		$sRegExp = "/(<\bhead\b([^>]*)>)/i";
		$sReplace = '${1}';
		$sReplace .= "\n<!-- This site uses WordPress Twitter Bootstrap CSS plugin v".self::$VERSION." from http://worpit.com/ -->";
		
		if ( in_array( $sOption, $aPossibleOptions ) ) {
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$sCssLink.'">';
		}
		
		//Add the Responsive CSS link
		if ( $fResponsive && $sOption == 'twitter' ) {
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$aLocalCss['twitter_responsive'].'">';
		}

		if ( $fCustomCss ) {
			$sCustomCssUrl = self::getOption( 'customcss_url' );
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$sCustomCssUrl.'">';
		}
		$sReplace .= "\n<!-- / WordPress Twitter Bootstrap CSS Plugin from Host Like Toast. -->";
		
		return preg_replace( $sRegExp, $sReplace, $insContents );
	}
	
	/**
	 * Links up the Twitter Bootstrap CSS into the WordPress Admin.
	 *
	 * Also includes a separate CSS fixes file.
	 */
	public function includeTwitterCssWpAdmin() {
		wp_register_style( 'bootstrap_wpadmin_css', self::$PLUGIN_URL.'resources/misc/css/bootstrap-wpadmin-2.0.2.css', false, self::$VERSION );
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
		if ( preg_match( "/^twitter/", $sBootstrapOption ) && self::getOption( 'useshortcodes' ) == 'Y' ) {
			$sVersion = ($sBootstrapOption == 'twitter') ? '2' : '1';
			$oShortCodes = new HLT_BootstrapShortcodes( $sVersion );
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
		
		$sSubPageNow = $_GET['page'];
		$aAllowedPages = array(
			'hlt-directory',
			'hlt-directory-bootstrap-css',
			'hlt-directory-bootstrap-less'
		);
		
		$fAddAdminBootstrap = false;
		if ( ($pagenow == 'admin.php') && in_array( $sSubPageNow, $aAllowedPages ) ) {
			//Links up CSS styles for the plugin itself (set the admin bootstrap CSS as a dependency also)
			wp_register_style( 'wtb_css', self::$PLUGIN_URL.'css/bootstrap-admin.css', array( 'bootstrap_wpadmin_css_fixes' ), self::$VERSION );
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
	//	if ( self::getOption( 'option' ) == 'twitter' ) {
		add_submenu_page( self::ParentMenuId, $this->getSubmenuPageTitle( 'Bootstrap LESS' ), 'Bootstrap LESS', self::ParentPermissions, $this->getSubmenuId( 'bootstrap-less' ), array( &$this, 'onDisplayLess' ) );
	//	}
		$this->fixSubmenu();
	}
	
	/**
	 * Handles the upgrade from version 1 to version 2 of Twitter Bootstrap.
	 */
	public function handlePluginUpgrade() {

		//Manages those users who are coming from a version pre-Twitter 2.0+
		if ( self::getOption( 'upgraded1to2' ) != 'Y' ) {
			
			if ( self::getOption( 'option' ) == 'twitter' ) {
				self::updateOption( 'option', 'twitter-legacy' );
			}
			if ( self::getOption( 'alerts_js' ) == 'Y' ) {
				self::addOption( 'alert_js', 'Y' );
			}
			self::deleteOption( 'alerts_js'  );

			if ( self::getOption( 'tabs_js' ) == 'Y' ) {
				self::addOption( 'tab_js', 'Y' );
			}
			self::deleteOption( 'tabs_js' );

			if ( self::getOption( 'twipsy_js' ) == 'Y' ) {
				self::addOption( 'tooltip_js', 'Y' );
			}
			self::deleteOption( 'twipsy_js' );

			self::addOption( 'upgraded1to2', 'Y' );
			self::updateOption( 'upgraded1to2', 'Y' );
		}
			
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
		//	'hotlink'							=> self::getOption( 'hotlink' ),

			'option_alert_js'					=> self::getOption( 'alert_js' ),
			'option_button_js'					=> self::getOption( 'button_js' ),
			'option_dropdown_js'				=> self::getOption( 'dropdown_js' ),
			'option_modal_js'					=> self::getOption( 'modal_js' ),
			'option_tooltip_js'					=> self::getOption( 'tooltip_js' ),
			'option_popover_js'					=> self::getOption( 'popover_js' ),
			'option_scrollspy_js'				=> self::getOption( 'scrollspy_js' ),
			'option_tab_js'						=> self::getOption( 'tab_js' ),
			'option_transition_js'				=> self::getOption( 'transition_js' ),	// Bootstrap v2.0+
			'option_collapse_js'				=> self::getOption( 'collapse_js' ),	// Bootstrap v2.0+
			'option_carousel_js'				=> self::getOption( 'carousel_js' ),	// Bootstrap v2.0+
			'option_typeahead_js'				=> self::getOption( 'typeahead_js' ),	// Bootstrap v2.0+
			'option_all_js'						=> self::getOption( 'all_js' ),			// Bootstrap v2.0+
			
			'option_js_head'					=> self::getOption( 'js_head' ),
			'option_useshortcodes'				=> self::getOption( 'useshortcodes' ),
			
			'option_inc_bootstrap_css_wpadmin'	=> self::getOption( 'inc_bootstrap_css_wpadmin' ),
			'option_hide_dashboard_rss_feed'	=> self::getOption( 'hide_dashboard_rss_feed' ),
			'option_prettify'					=> self::getOption( 'prettify' ),
		
			'form_action'						=> 'admin.php?page=hlt-directory-bootstrap-css'
		);
		$this->display( 'bootstrapcss_index', $aData );
	}
	
	public function onDisplayLess() {
		
		foreach ($this->m_aAllBootstrapLessOptions as &$aOption) {
		
			$sOptionValue = self::getOption( $aOption[0] );
			$aOption[1] = ($sOptionValue == '') ? $aOption[2] : $sOptionValue;
		}
		$aData = array(
			'plugin_url'		=> self::$PLUGIN_URL,
			'form_action'		=> 'admin.php?page=hlt-directory-bootstrap-less',
			'less_options'		=> $this->m_aAllBootstrapLessOptions
		);
		
		//enqueue JS color
		$bInFooter = true;
		wp_register_script( 'jscolor-picker', self::$PLUGIN_URL.'inc/jscolor/jscolor.js', '', self::$VERSION, $bInFooter );
		wp_enqueue_script( 'jscolor-picker' );
		
		$this->display( 'bootstrapcss_less', $aData );
		
	}
	
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
		$fIncludeTooltip = ($this->getAnswerFromPost( 'option_popover_js' ) === 'Y' || $this->getAnswerFromPost( 'option_tooltip_js' ) === 'Y' );
	
		//	self::updateOption( 'hotlink',			$this->getAnswerFromPost( 'hotlink' ) );
	
		self::updateOption( 'alert_js',			$this->getAnswerFromPost( 'option_alert_js' ) );
		self::updateOption( 'button_js',		$this->getAnswerFromPost( 'option_button_js' ) );
		self::updateOption( 'dropdown_js',		$this->getAnswerFromPost( 'option_dropdown_js' ) );
		self::updateOption( 'modal_js',			$this->getAnswerFromPost( 'option_modal_js' ) );
		self::updateOption( 'tooltip_js',		$fIncludeTooltip? 'Y': 'N' );
		self::updateOption( 'popover_js',		$this->getAnswerFromPost( 'option_popover_js' ) );
		self::updateOption( 'scrollspy_js',		$this->getAnswerFromPost( 'option_scrollspy_js' ) );
		self::updateOption( 'tab_js',			$this->getAnswerFromPost( 'option_tab_js' ) );
		self::updateOption( 'transition_js',	$this->getAnswerFromPost( 'option_transition_js' ) );	// Bootstrap v2.0+
		self::updateOption( 'collapse_js',		$this->getAnswerFromPost( 'option_collapse_js' ) );		// Bootstrap v2.0+
		self::updateOption( 'carousel_js',		$this->getAnswerFromPost( 'option_carousel_js' ) );		// Bootstrap v2.0+
		self::updateOption( 'typeahead_js',		$this->getAnswerFromPost( 'option_typeahead_js' ) );	// Bootstrap v2.0+
		self::updateOption( 'all_js',			$this->getAnswerFromPost( 'option_all_js' ) );	// Bootstrap v2.0+
	
		self::updateOption( 'inc_responsive_css',			$this->getAnswerFromPost( 'option_inc_responsive_css' ) );	// Bootstrap v2.0+
		self::updateOption( 'inc_bootstrap_css_wpadmin',	$this->getAnswerFromPost( 'option_inc_bootstrap_css_wpadmin' ) );	// Bootstrap v2.0+
	
		self::updateOption( 'js_head',			$this->getAnswerFromPost( 'option_js_head' ) );
		self::updateOption( 'useshortcodes',	$this->getAnswerFromPost( 'option_useshortcodes' ) );
		self::updateOption( 'prettify',			$this->getAnswerFromPost( 'option_prettify' ) );
	
		self::updateOption( 'customcss',		$this->getAnswerFromPost( 'option_customcss' ) );
	
		if ( $fCustomCss && !empty( $sCustomUrl ) ) {
			if ( $this->checkUrlValid( $sCustomUrl ) ) {
				self::updateOption( 'customcss_url', $_POST[self::InputPrefix.'text_customcss_url'] );
			}
			else {
				self::updateOption( 'customcss_url', '' );
			}
		}
	
		// Show Dashboard RSS Feed?
		self::updateOption( 'hide_dashboard_rss_feed',	$this->getAnswerFromPost( 'option_hide_dashboard_rss_feed' ) );
	
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
		if ( isset( $_POST['submit_reset'] ) ) {
			
			//Set DEFAULTS
			foreach ( $this->m_aAllBootstrapLessOptions as $aOption ) {
				list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $aOption;
				self::updateOption( $sLessKey, $sLessDefault );
			}
			return;
		}
		
		$sBootstrapImportLine = "@import \"bootstrap-2.0.1/less/bootstrap.less\";";
		$sCustomLessContents = $sBootstrapImportLine;
		
		// TODO: Make as const
		$sLessPrefix = 'less_';
		
		// Read in variables.less contents
		$sFilePathVariablesLess = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-'.self::TwitterVersion.DS.'less'.DS.'variables.less';
		$sFilePathVariablesLess = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-2.0.1'.DS.'less'.DS.'variables.less';
		$sContents = file_get_contents( $sFilePathVariablesLess );
		
		foreach ( $this->m_aAllBootstrapLessOptions as $aOption ) {
			list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $aOption;
			
			$sPostValue = $_POST['hlt_'.$sLessKey];
			if ( $sLessOptionType == 'color' ) {
				
				if ( !preg_match( '/^[a-fA-F0-9]{3,6}$/', $sPostValue ) && !preg_match( '/^[a-fA-F0-9]{3}$/', $sPostValue ) ) {
					$sPostValue = $sLessDefault;
				}
				if ( !preg_match( '/^#/', $sPostValue ) ) {
					$sPostValue = '#'.$sPostValue;
				}
			} else if ( $sLessOptionType == 'size' ) {
				if ( preg_match( '/^\d+$/', $sPostValue ) ) {
					$sPostValue = $sPostValue.'px';
				}
				if ( !preg_match( '/^\d+(px|em|pt)$/', $sPostValue ) ) {
					$sPostValue = $sLessDefault;
				}
			}
			self::updateOption( $sLessKey, $sPostValue );
			$sBootstrapLessVar = str_replace( $sLessPrefix, '', $sLessKey );
		
			$sContents = preg_replace( '/^\s*(@'.$sBootstrapLessVar.':\s*)([^;]+)(;)\s*$/im', '${1}'.$sPostValue.'${3}', $sContents );
		}
		
		file_put_contents( $sFilePathVariablesLess, $sContents );		
		
		$sFilePathBootstrapLess = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-'.self::TwitterVersion.DS.'less'.DS.'bootstrap.less';
		$sFilePathBootstrapLess = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-2.0.1'.DS.'less'.DS.'bootstrap.less';
		
		//parse LESS
		include_once( dirname(__FILE__).'/inc/lessc/lessc.inc.php' );
		$oLessCompiler = new lessc( $sFilePathBootstrapLess );
		$sCompiledCss = '';
		try {
			$sCompiledCss = $oLessCompiler->parse();
		}
		catch ( Exception $oE ) {
			echo "lessphp fatal error: ".$oE->getMessage();
		}
		$sMinFile = self::$PLUGIN_DIR.'resources'.DS.'bootstrap-2.0.1'.DS.'css'.DS.'bootstrap.css';
		file_put_contents( $sMinFile, $sCompiledCss );
	}
	
	protected function handleSubmit() {
		
		switch ( $_GET['page'] ) {
			case $this->getSubmenuId( 'bootstrap-css' ):
				$this->handleSubmit_BootstrapIndex();
				return;
				
			case $this->getSubmenuId( 'bootstrap-less' ):
				$this->handleSubmit_BootstrapLess();
				return;
		}
	}

	public function onWpPrintStyles() {
		if ( self::getOption( 'prettify' ) == 'Y' ) {
			$sUrlPrefix = self::$PLUGIN_URL.'resources/misc/js/google-code-prettify/';
			wp_register_style( 'prettify_style', $sUrlPrefix.'prettify.css' );
			wp_enqueue_style( 'prettify_style' );
		}
	}

	public function onWpEnqueueScripts() {
		
		$bInFooter = (self::getOption( 'js_head' ) == 'Y'? false : true);
		$sBootstrapOption = self::getOption( 'option' );
		
		if ( self::getOption( 'prettify' ) == 'Y' ) {
			$sUrlPrefix = self::$PLUGIN_URL.'js/google-code-prettify/';
			wp_register_script( 'prettify_script', $sUrlPrefix.'prettify.js', '', self::$VERSION, $bInFooter );
			wp_enqueue_script( 'prettify_script' );
		}
		

		if ( preg_match ( '/^twitter/', $sBootstrapOption ) ) {
			
			$sTwitterVersion = self::TwitterVersionLegacy;
			
			$aBootstrapJsOptions = array (
				'alert'			=> self::getOption( 'alert_js' ),
				'button'		=> self::getOption( 'button_js' ),
				'dropdown'		=> self::getOption( 'dropdown_js' ),
				'modal'			=> self::getOption( 'modal_js' ),
				'tooltip'		=> self::getOption( 'tooltip_js' ),
				'popover'		=> self::getOption( 'popover_js' ),
				'scrollspy'		=> self::getOption( 'scrollspy_js' ),
				'tab'			=> self::getOption( 'tab_js' )
				//'name of TBS lib with .js'		=> self::getOption( 'carousel_js' )
			);

			if ( $sBootstrapOption == 'twitter' ) {
				$aBootstrapJsOptions['transition']	= self::getOption( 'transition_js' );	// Bootstrap v2.0+
				$aBootstrapJsOptions['collapse']		= self::getOption( 'collapse_js' );		// Bootstrap v2.0+
				$aBootstrapJsOptions['carousel']		= self::getOption( 'carousel_js' );		// Bootstrap v2.0+
				$aBootstrapJsOptions['typeahed']		= self::getOption( 'typeahed_js' );		// Bootstrap v2.0+
				
				$sTwitterVersion = self::TwitterVersion;
			}
		
			$sUrlPrefix = self::$PLUGIN_URL.'resources/bootstrap-'.$sTwitterVersion.'/js/bootstrap';

			if ( self::getOption( 'all_js' ) == 'Y' && $sTwitterVersion == self::TwitterVersion ) {
				wp_register_script( 'bootstrap-all-min', $sUrlPrefix.'.min.js', '', self::$VERSION, $bInFooter );
				wp_enqueue_script( 'bootstrap-all-min' );
			}
			else {
				foreach ( $aBootstrapJsOptions as $sJsLib => $sDisplay ) {
					if ( $sDisplay == 'Y' ) {
						$sUrl = $sUrlPrefix.'-'.$sJsLib.'.js';
						wp_register_script( 'bootstrap'.$sJsLib, $sUrl, '', self::$VERSION, $bInFooter );
						wp_enqueue_script( 'bootstrap'.$sJsLib );
					}
				}
			}
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
}

class HLT_BootstrapCss_Uninstall {
	
	// TODO: when uninstalling, maybe have a WPversion save settings offsite-like setting

	private $m_aAllPluginOptions;
	
	public function __construct($inaAllPluginOptions) {
		$this->m_aAllPluginOptions = $inaAllPluginOptions;
		register_deactivation_hook( __FILE__, array( &$this, 'onWpDeactivatePlugin' ) );
	}
	
	public function onWpDeactivatePlugin() {
		
		foreach ( $this->m_aAllPluginOptions as $aPluginOption ) {
			//HLT_BootstrapCss::deleteOption( $aPluginOption[0] );
		}
		
		HLT_BootstrapCss::deleteOption( 'upgraded1to2' );
		
		/* Clean-up from previous versions -pre-version 2.0 */
		HLT_BootstrapCss::deleteOption( 'alerts_js'  );
		HLT_BootstrapCss::deleteOption( 'tabs_js'  );
		HLT_BootstrapCss::deleteOption( 'twipsy_js'  );
		HLT_BootstrapCss::deleteOption( 'hotlink' );
	}
}

class HLT_Plugin {
	
	static public $VERSION;
	
	static public $PLUGIN_NAME;
	static public $PLUGIN_PATH;
	static public $PLUGIN_DIR;
	static public $PLUGIN_URL;
	
	const ParentTitle		= 'Host Like Toast Plugins';
	const ParentName		= 'Host Like Toast';
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
		return self::$PLUGIN_URL.'images/'.$insImage;
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
		add_menu_page( self::ParentTitle, self::ParentName, self::ParentPermissions, self::ParentMenuId, array( $this, 'onDisplayMainMenu' ), $this->getImageUrl( 'toaster_16x16.png' ) );
	}
	
	public function onDisplayMainMenu() {
		//$this->redirect( 'admin.php?page=hlt-directory-bootstrap-css' );

		$aData = array(
			'plugin_url'	=> self::$PLUGIN_URL
		);
		$this->display( 'hostliketoast_index', $aData );
	}
	
	public function onWpPluginActionLinks( $inaLinks, $insFile ) {
		if ( $insFile == plugin_basename( __FILE__ ) ) {
			$sSettingsLink = '<a href="'.admin_url( "admin.php" ).'?page=hlt-directory-bootstrap-css">' . __( 'Settings', 'hostliketoast' ) . '</a>';
			array_unshift( $inaLinks, $sSettingsLink );
		}
		return $inaLinks;
	}
	
}

$oHLT_BootstrapCss = new HLT_BootstrapCss();
