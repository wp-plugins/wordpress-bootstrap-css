<?php

/* 
Plugin Name: Wordpress Bootstrap CSS
Plugin URI: http://www.hostliketoast.com/wp-plugins/bootstrapcss/
Description: Allows you to install a base CSS file for your site, which is included before all others. 
Version: 0.2
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
	
	public function __construct() {
		parent::__construct();
		
		self::$VERSION		= '0.2';
		
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
		$sOption = get_option( 'hlt_bootstrapcss_option' );
		$fHotlink = (get_option( 'hlt_bootstrapcss_hotlink' ) == 'Y');
		
		if ( !in_array( $sOption, array( 'yahoo-reset', 'normalize', 'twitter' ) ) ) {
			return $insContents;
		}
		
		$aLocalCss = array(
			'yahoo-reset'	=> self::$PLUGIN_URL.'css/yahoo-2.9.0.min.css',
			'normalize'		=> self::$PLUGIN_URL.'css/normalize.css',
			'twitter'		=> self::$PLUGIN_URL.'css/bootstrap-1.3.0.min.css'
		);
		
		$aHotlinkCss = array(
			'yahoo-reset'	=> 'http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css',
			'normalize'		=> 'https://raw.github.com/necolas/normalize.css/master/normalize.css',
			'twitter'		=> 'http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css'
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
		return preg_replace( $sRegExp, $sReplace, $insContents );
	}
	
	public function linkBootstrapJavascript() {

		$sBootstrapVersion = '1.3.0';
		
		$aBootstrapJsOptions = array (
			'alerts'	=> get_option( 'hlt_bootstrapcss_alerts_js' ),
			'dropdown'	=> get_option( 'hlt_bootstrapcss_dropdown_js' ),
			'modal'		=> get_option( 'hlt_bootstrapcss_modal_js' ),
			'popover'	=> get_option( 'hlt_bootstrapcss_popover_js' ),
			'scrollspy'	=> get_option( 'hlt_bootstrapcss_scrollspy_js' ),
			'tabs'		=> get_option( 'hlt_bootstrapcss_tabs_js' ),
			'twipsy'	=> get_option( 'hlt_bootstrapcss_twipsy_js' ),
		);

		$aHotlinkJs = array(
			'alerts'	=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-alerts.js',
			'dropdown'	=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-dropdown.js',
			'modal'		=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-modal.js',
			'popover'	=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-popover.js',
			'scrollspy'	=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-scrollspy.js',
			'tabs'		=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-tabs.js',
			'twipsy'	=> 'http://twitter.github.com/bootstrap/' . $sBootstrapVersion . '/bootstrap-twipsy.js'
		);

		foreach ($aBootstrapJsOptions as $sJsLib => $display) {

			if ($display == 'Y') {
				echo '<script type="text/javascript" src="' . $aHotlinkJs[$sJsLib] . '" /></script>';
			}
		}
		
	}

	public function onWpInit() {
		parent::onWpInit();
		
		if ( !is_admin() ) {
			ob_start( array( &$this, 'onOutputBufferFlush' ) );
			
			if ( get_option( 'hlt_bootstrapcss_option' ) == 'twitter' ) {
				if ( get_option( 'hlt_bootstrapcss_js_head' ) == 'Y' ) {
					add_action('wp_head','HLT_BootstrapCss::linkBootstrapJavascript');
				} else {
					add_action('wp_footer','HLT_BootstrapCss::linkBootstrapJavascript');
				}
			} 
		}
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
		
		$aBootstrapJsOptions = array (
		);
	
		$aData = array(
			'plugin_url'	=> self::$PLUGIN_URL,
			'option'		=> get_option( 'hlt_bootstrapcss_option' ),
			'hotlink'		=> get_option( 'hlt_bootstrapcss_hotlink' ),

			'option_alerts_js'		=> get_option( 'hlt_bootstrapcss_alerts_js' ),
			'option_dropdown_js'	=> get_option( 'hlt_bootstrapcss_dropdown_js' ),
			'option_modal_js'		=> get_option( 'hlt_bootstrapcss_modal_js' ),
			'option_popover_js'		=> get_option( 'hlt_bootstrapcss_popover_js' ),
			'option_scrollspy_js'	=> get_option( 'hlt_bootstrapcss_scrollspy_js' ),
			'option_tabs_js'		=> get_option( 'hlt_bootstrapcss_tabs_js' ),
			'option_twipsy_js'		=> get_option( 'hlt_bootstrapcss_twipsy_js' ),
			'option_js_head'		=> get_option( 'hlt_bootstrapcss_js_head' ),

			'form_action'	=> 'admin.php?page=hlt-directory-bootstrap-css'
		);
		$this->display( 'bootstrapcss_index', $aData );
	}
	
	public function onOutputBufferFlush( $insContent ) {
		return $this->rewriteHead( $insContent );
	}
	
	protected function handleSubmit() {
		if ( isset( $_POST['hlt_bootstrap_option'] ) ) {
			if ( update_option( 'hlt_bootstrapcss_option', $_POST['hlt_bootstrap_option'] ) === false ) {
				// TODO: need to say it hasn't worked
			}
			update_option( 'hlt_bootstrapcss_hotlink', isset( $_POST['hlt_bootstrap_hotlink'] )? 'Y': 'N' );
		
			update_option( 'hlt_bootstrapcss_alerts_js', isset( $_POST['hlt_bootstrap_option_alerts_js'] )? 'Y': 'N');
			update_option( 'hlt_bootstrapcss_dropdown_js', isset( $_POST['hlt_bootstrap_option_dropdown_js'] )? 'Y': 'N');
			update_option( 'hlt_bootstrapcss_modal_js', isset( $_POST['hlt_bootstrap_option_modal_js'] )? 'Y': 'N' );
			update_option( 'hlt_bootstrapcss_popover_js', isset( $_POST['hlt_bootstrap_option_popover_js'] )? 'Y': 'N' );
			update_option( 'hlt_bootstrapcss_scrollspy_js', isset( $_POST['hlt_bootstrap_option_scrollspy_js'] )? 'Y': 'N' );
			update_option( 'hlt_bootstrapcss_tabs_js', isset( $_POST['hlt_bootstrap_option_tabs_js'] )? 'Y': 'N' );
			update_option( 'hlt_bootstrapcss_twipsy_js', isset( $_POST['hlt_bootstrap_option_twipsy_js'] )? 'Y': 'N' );
				
			update_option( 'hlt_bootstrapcss_js_head', isset( $_POST['hlt_bootstrap_option_js_head'] )? 'Y': 'N' );
		}

/*			
			if ( class_exists( 'W3_Plugin_TotalCache' ) ) {
				$oW3TotalCache =& W3_Plugin_TotalCache::instance();
				$oW3TotalCache->flush_all();
			}
*/
	}
}

class HLT_BootstrapCss_Install {
	
	public function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'onWpActivatePlugin' ) );
	}
	
	public function onWpActivatePlugin() {
		add_option( 'hlt_bootstrapcss_option', 'none' );
		add_option( 'hlt_bootstrapcss_hotlink', 'N' );
		
		add_option( 'hlt_bootstrapcss_alerts_js', 'N' );
		add_option( 'hlt_bootstrapcss_dropdown_js', 'N' );
		add_option( 'hlt_bootstrapcss_modal_js', 'N' );
		add_option( 'hlt_bootstrapcss_popover_js', 'N' );
		add_option( 'hlt_bootstrapcss_scrollspy_js', 'N' );
		add_option( 'hlt_bootstrapcss_tabs_js', 'N' );
		add_option( 'hlt_bootstrapcss_twipsy_js', 'N' );
		add_option( 'hlt_bootstrapcss_js_head', 'N' );
	}
}

class HLT_BootstrapCss_Uninstall {
	
	// TODO: when uninstalling, maybe have a WPversion save settings offsite-like setting
	
	public function __construct() {
		register_deactivation_hook( __FILE__, array( &$this, 'onWpDeactivatePlugin' ) );
	}
	
	public function onWpDeactivatePlugin() {
		delete_option( 'hlt_bootstrapcss_option' );
		delete_option( 'hlt_bootstrapcss_hotlink' );
		
		delete_option( 'hlt_bootstrapcss_alerts_js' );
		delete_option( 'hlt_bootstrapcss_dropdown_js' );
		delete_option( 'hlt_bootstrapcss_modal_js' );
		delete_option( 'hlt_bootstrapcss_popover_js' );
		delete_option( 'hlt_bootstrapcss_scrollspy_js' );
		delete_option( 'hlt_bootstrapcss_tabs_js' );
		delete_option( 'hlt_bootstrapcss_twipsy_js' );
		delete_option( 'hlt_bootstrapcss_js_head' );
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