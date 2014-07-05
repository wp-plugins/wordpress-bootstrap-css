<?php

/**
 * Copyright (c) 2013 iControlWP <support@icontrolwp.com>
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
 */

require_once( dirname(__FILE__).'/src/icwp-pure-base.php' );

if ( !function_exists( '_wptb_e' ) ) {
	function _wptb_e( $insStr ) {
		_e( $insStr, ICWP_Wordpress_Twitter_Bootstrap_Plugin::GetTextDomain() );
	}
}
if ( !function_exists( '_wptb__' ) ) {
	function _wptb__( $insStr ) {
		return __( $insStr, ICWP_Wordpress_Twitter_Bootstrap_Plugin::GetTextDomain() );
	}
}

if ( !class_exists('HLT_BootstrapCss') ):

class HLT_BootstrapCss extends ICWP_WPTB_Pure_Base_V1 {
	/**
	 * @var string
	 */
	const OptionPrefix				= 'hlt_bootstrapcss_'; //ALL database options use this as the prefix.

	public function __construct( ICWP_Wordpress_Twitter_Bootstrap_Plugin $oPluginVo ) {
		parent::__construct( $oPluginVo );
		$this->loadAllFeatures();
	}

	/**
	 * @param bool $fRecreate
	 * @param bool $fFullBuild
	 * @return bool
	 */
	protected function loadAllFeatures( $fRecreate = false, $fFullBuild = false ) {
		foreach( $this->oPluginVo->getFeatures() as $sFeature ) {
			$fSuccess = $this->loadFeatureHandler( $sFeature, $fRecreate, $fFullBuild );
		}
		return $fSuccess;
	}

	protected function loadFeatureHandler( $sFeatureSlug = 'plugin', $infRecreate = false, $infFullBuild = false ) {
		if ( !$this->getIsFeature( $sFeatureSlug ) ) {
			return false;
		}

		$sFeatureName = str_replace( ' ', '', ucwords( str_replace( '_', ' ', $sFeatureSlug ) ) );
		$sOptionsVarName = 'o'.$sFeatureName.'Options'; // e.g. oPluginOptions

		if ( isset( $this->{$sOptionsVarName} ) ) {
			return $this->{$sOptionsVarName};
		}
		$sSourceFile = $this->oPluginVo->getSourceDir().'icwp-optionshandler-'.$sFeatureSlug.'.php'; // e.g. icwp-optionshandler-plugin.php
		$sClassName = 'ICWP_WPTB_FeatureHandler_'.$sFeatureName;

		require_once( $sSourceFile );
		if ( $infRecreate || !isset( $this->{$sOptionsVarName} ) ) {
			$this->{$sOptionsVarName} = new $sClassName( $this->oPluginVo );
		}
		if ( $infFullBuild ) {
			$this->{$sOptionsVarName}->buildOptions();
		}
		return $this->{$sOptionsVarName};
	}

	/**
	 * Given a certain feature 'slug' will return true if this is a particular supported feature of this plugin.
	 *
	 * @param string $sFeature
	 * @return boolean
	 */
	public function getIsFeature( $sFeature ) {
		return in_array( $sFeature, $this->oPluginVo->getFeatures() );
	}

	public function onWpAdminInit() {
		parent::onWpAdminInit();

		// If it's a plugin admin page, we do certain things we don't do anywhere else.
		if ( $this->getIsPage_PluginAdmin() ) {

			//JS color picker for the Bootstrap LESS
			if ( $_GET['page'] == $this->getSubmenuId( 'bootstrap-less' ) ) {
				wp_register_style( 'miniColors', $this->m_sPluginUrl.'inc/miniColors/jquery.miniColors.css', false, $this->m_sVersion );
				wp_enqueue_style( 'miniColors' );
	
				wp_register_script( 'miniColors', $this->m_sPluginUrl.'inc/miniColors/jquery.miniColors.min.js', false, $this->m_sVersion, true );
				wp_enqueue_script( 'miniColors' );
			}
		}
	}

	/**
	 * @param $inaLinks
	 * @param $insFile
	 * @return mixed
	 */
	public function onWpPluginActionLinks( $inaLinks, $insFile ) {
		if ( $insFile == $this->m_sPluginFile ) {
			$sSettingsLink = '<a href="'.admin_url( "admin.php" ).'?page='.$this->getSubmenuId('bootstrap-css').'">' . _hlt__( 'Settings' ) . '</a>';
			array_unshift( $inaLinks, $sSettingsLink );
		}
		return $inaLinks;
	}
}

endif;