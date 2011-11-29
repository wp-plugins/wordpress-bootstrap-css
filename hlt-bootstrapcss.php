<?php

/* 
Plugin Name: Wordpress Bootstrap CSS
Plugin URI: http://www.hostliketoast.com/wp-plugins/bootstrapcss/
Description: Allows you to install a base CSS file for your site, which is included before all others. 
Version: 0.7
Author: Host Like Toast
Author URI: http://www.hostliketoast.com 
*/

/**
 * Copyright (c) 2011 Host Like Toast <helpdesk@hostliketoast.com>
 * All rights reserved.
 * 
 * "Wordpress Bootstrap CSS" is distributed under the GNU General Public License, Version 2,
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

define( 'DS', DIRECTORY_SEPARATOR );

//global $wp_version;
//global $doc_db_version;
//global $wpdb;

//$exit_msg = "The Wordpress installation must be version 3 or above.";
//if (version_compare($wp_version, "3.0", "<")) {
 //   exit($exit_msg);
//}

class HLT_BootstrapCss extends HLT_Plugin {
	
	const InputPrefix = 'hlt_bootstrap_';
	const OptionPrefix = 'hlt_bootstrapcss_';
	
	// possibly configurable in the UI, we'll determine this as new releases occur.
	const TwitterVersion = '1.4.0';
	
	public function __construct() {
		parent::__construct();
		
		self::$VERSION		= '0.7';
		
		self::$PLUGIN_NAME	= basename(__FILE__);
		self::$PLUGIN_PATH	= plugin_basename( dirname(__FILE__) );
		self::$PLUGIN_DIR	= WP_PLUGIN_DIR.DS.self::$PLUGIN_PATH.DS;
		self::$PLUGIN_URL	= WP_PLUGIN_URL.'/'.self::$PLUGIN_PATH.'/';
		
		if ( is_admin() ) {
			$oInstall = new HLT_BootstrapCss_Install();
			$oUninstall = new HLT_BootstrapCss_Uninstall();
		}
	}
	
	public function rewriteHead( $insContents ) {
		$sOption = self::getOption( 'option' );
		$fHotlink = ( self::getOption( 'hotlink' ) == 'Y' );
		
		$fCustomCss = ( self::getOption( 'customcss' ) == 'Y' );
		
		if ( !in_array( $sOption, array( 'yahoo-reset', 'normalize', 'twitter' ) ) ) {
			return $insContents;
		}
		
		$aLocalCss = array(
			'yahoo-reset'	=> self::$PLUGIN_URL.'css/yahoo-2.9.0.min.css',
			'normalize'		=> self::$PLUGIN_URL.'css/normalize.css',
			'twitter'		=> self::$PLUGIN_URL.'css/bootstrap-'.self::TwitterVersion.'.min.css'
		);
		
		$aHotlinkCss = array(
			'yahoo-reset'	=> 'http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css',
			'normalize'		=> 'https://raw.github.com/necolas/normalize.css/master/normalize.css',
			'twitter'		=> 'http://twitter.github.com/bootstrap/'.self::TwitterVersion.'/bootstrap.min.css'
		);
		
		$sCssLink = '';
		if ( $fHotlink ) {
			$sCssLink = $aHotlinkCss[$sOption];
		}
		else {
			$sCssLink = $aLocalCss[$sOption];
		}
		
		$sRegExp = "/(<head([^>]*)>)/i";
		$sReplace = '${1}'."\n".'<link rel="stylesheet" type="text/css" href="'.$sCssLink.'">';

		if ( $fCustomCss ) {
			$sCustomCssUrl = self::getOption( 'customcss_url' );
			$sReplace .= "\n".'<link rel="stylesheet" type="text/css" href="'.$sCustomCssUrl.'">';
		}
		
		return preg_replace( $sRegExp, $sReplace, $insContents );
	}
	
	public function linkBootstrapJavascript() {
		$aBootstrapJsOptions = array (
			'alerts'	=> self::getOption( 'alerts_js' ),
			'dropdown'	=> self::getOption( 'dropdown_js' ),
			'modal'		=> self::getOption( 'modal_js' ),
			'twipsy'	=> self::getOption( 'twipsy_js' ),
			'popover'	=> self::getOption( 'popover_js' ),
			'scrollspy'	=> self::getOption( 'scrollspy_js' ),
			'tabs'		=> self::getOption( 'tabs_js' ),
		);
		
		$sUrlPrefix = self::$PLUGIN_URL.'js/twitter-'.self::TwitterVersion.'/bootstrap-';
		if ( self::getOption( 'hotlink' ) == 'Y' ) {
			$sUrlPrefix = 'http://twitter.github.com/bootstrap/'.self::TwitterVersion.'/bootstrap-';
		}
		
		foreach ( $aBootstrapJsOptions as $sJsLib => $sDisplay ) {
			if ( $sDisplay == 'Y' ) {
				$sUrl = $sUrlPrefix.$sJsLib.'.js';
				echo "\n".'<script type="text/javascript" src="'.$sUrl.'" /></script>';
			}
		}
	}
	
	public function onWpInit() {
		parent::onWpInit();
		
		if ( !is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) ) {
			ob_start( array( &$this, 'onOutputBufferFlush' ) );
			
			if ( self::getOption( 'option' ) == 'twitter' ) {
				add_action( 'wp_'.(self::getOption( 'js_head' ) == 'Y'? 'head': 'footer'), array( &$this, 'linkBootstrapJavascript' ) );
			}
		}
		
		// if shortcodes are enabled!
		$oShortCodes = new HLT_BootstrapShortcodes();
	}
	
	public function onWpAdminInit() {
		parent::onWpAdminInit();
	}
	
	public function onWpPluginsLoaded() {
		parent::onWpPluginsLoaded();
		
		if ( is_admin() ) {
			$this->handleSubmit();			
		}
	}
	
	public function onWpAdminMenu() {
		parent::onWpAdminMenu();
		
		add_submenu_page( self::ParentMenuId, $this->getSubmenuPageTitle( 'Bootstrap CSS' ), 'Bootstrap CSS', self::ParentPermissions, $this->getSubmenuId( 'bootstrap-css' ), array( &$this, 'onDisplayPlugin' ) );

		$this->fixSubmenu();
	}
	
	public function onDisplayPlugin() {
	
		$aData = array(
			'plugin_url'			=> self::$PLUGIN_URL,
			'option'				=> self::getOption( 'option' ),
			'hotlink'				=> self::getOption( 'hotlink' ),

			'option_alerts_js'		=> self::getOption( 'alerts_js' ),
			'option_dropdown_js'	=> self::getOption( 'dropdown_js' ),
			'option_modal_js'		=> self::getOption( 'modal_js' ),
			'option_twipsy_js'		=> self::getOption( 'twipsy_js' ),
			'option_popover_js'		=> self::getOption( 'popover_js' ),
			'option_scrollspy_js'	=> self::getOption( 'scrollspy_js' ),
			'option_tabs_js'		=> self::getOption( 'tabs_js' ),
			'option_js_head'		=> self::getOption( 'js_head' ),

			'option_customcss'		=> self::getOption( 'customcss' ),
			'text_customcss_url'	=> self::getOption( 'customcss_url' ),
		
			'form_action'			=> 'admin.php?page=hlt-directory-bootstrap-css'
		);
		$this->display( 'bootstrapcss_index', $aData );
	}
	
	public function onOutputBufferFlush( $insContent ) {
		return $this->rewriteHead( $insContent );
	}
	
	protected function handleSubmit() {
		if ( isset( $_POST['hlt_bootstrap_option'] ) ) {
			if ( self::updateOption( 'option', $_POST['hlt_bootstrap_option'] ) === false ) {
				// TODO: need to say it hasn't worked
			}
			$sCustomUrl = $_POST[self::InputPrefix.'text_customcss_url'];
			$fCustomCss = ($this->getAnswerFromPost( 'option_customcss' ) === 'Y');
			
			self::updateOption( 'hotlink',			$this->getAnswerFromPost( 'hotlink' ) );
		
			self::updateOption( 'alerts_js',		$this->getAnswerFromPost( 'option_alerts_js' ) );
			self::updateOption( 'dropdown_js',		$this->getAnswerFromPost( 'option_dropdown_js' ) );
			self::updateOption( 'modal_js',			$this->getAnswerFromPost( 'option_modal_js' ) );
			self::updateOption( 'twipsy_js',		$this->getAnswerFromPost( 'option_twipsy_js' ) );
			self::updateOption( 'popover_js',		$this->getAnswerFromPost( 'option_popover_js' ) );
			self::updateOption( 'scrollspy_js',		$this->getAnswerFromPost( 'option_scrollspy_js' ) );
			self::updateOption( 'tabs_js',			$this->getAnswerFromPost( 'option_tabs_js' ) );

			self::updateOption( 'js_head',			$this->getAnswerFromPost( 'option_js_head' ) );

			self::updateOption( 'customcss',		$this->getAnswerFromPost( 'option_customcss' ) );

			if ( $fCustomCss && !empty( $sCustomUrl ) ) {
				if ( $this->checkUrlValid( $sCustomUrl ) ) {
					self::updateOption( 'customcss_url', $_POST[self::InputPrefix.'text_customcss_url'] );
				}
				else {
					self::updateOption( 'customcss_url', '' );
				}
			}
			
			// Flush W3 Total Cache (compatible up to version 0.9.2.4)
			if ( class_exists( 'W3_Plugin_TotalCacheAdmin' ) ) {
				$oW3TotalCache =& w3_instance('W3_Plugin_TotalCacheAdmin');
				$oW3TotalCache->flush_all();
			}
		}
	}
	
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
	
	static public function getOption( $insKey ) {
		return get_option( self::OptionPrefix.$insKey );
	}
	
	static public function addOption( $insKey, $insValue ) {
		return add_option( self::OptionPrefix.$insKey, $insValue );
	}
	
	static public function updateOption( $insKey, $insValue ) {
		return update_option( self::OptionPrefix.$insKey, $insValue );
	}
	
	static public function deleteOption( $insKey ) {
		return delete_option( $insKey );
	}
}

class HLT_BootstrapCss_Install {
	
	public function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'onWpActivatePlugin' ) );
	}
	
	public function onWpActivatePlugin() {
		HLT_BootstrapCss::addOption( 'option',			'none' );
		HLT_BootstrapCss::addOption( 'hotlink',			'N' );
		
		HLT_BootstrapCss::addOption( 'alerts_js',		'N' );
		HLT_BootstrapCss::addOption( 'dropdown_js',		'N' );
		HLT_BootstrapCss::addOption( 'modal_js',		'N' );
		HLT_BootstrapCss::addOption( 'twipsy_js',		'N' );
		HLT_BootstrapCss::addOption( 'popover_js',		'N' );
		HLT_BootstrapCss::addOption( 'scrollspy_js',	'N' );
		HLT_BootstrapCss::addOption( 'tabs_js',			'N' );
		HLT_BootstrapCss::addOption( 'js_head',			'N' );

		HLT_BootstrapCss::addOption( 'customcss',		'N' );
		HLT_BootstrapCss::addOption( 'customcss_url',	'http://' );
	}
}

class HLT_BootstrapCss_Uninstall {
	
	// TODO: when uninstalling, maybe have a WPversion save settings offsite-like setting
	
	public function __construct() {
		register_deactivation_hook( __FILE__, array( &$this, 'onWpDeactivatePlugin' ) );
	}
	
	public function onWpDeactivatePlugin() {
		HLT_BootstrapCss::deleteOption( 'option' );
		HLT_BootstrapCss::deleteOption( 'hotlink' );
		
		HLT_BootstrapCss::deleteOption( 'alerts_js' );
		HLT_BootstrapCss::deleteOption( 'dropdown_js' );
		HLT_BootstrapCss::deleteOption( 'modal_js' );
		HLT_BootstrapCss::deleteOption( 'twipsy_js' );
		HLT_BootstrapCss::deleteOption( 'popover_js' );
		HLT_BootstrapCss::deleteOption( 'scrollspy_js' );
		HLT_BootstrapCss::deleteOption( 'tabs_js' );
		HLT_BootstrapCss::deleteOption( 'js_head' );

		HLT_BootstrapCss::deleteOption( 'customcss'  );
		HLT_BootstrapCss::deleteOption( 'customcss_url' );
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
		$this->redirect( 'admin.php?page=hlt-directory-bootstrap-css' );

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