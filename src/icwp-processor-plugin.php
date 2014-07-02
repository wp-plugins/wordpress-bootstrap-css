<?php
/**
 * Copyright (c) 2014 iControlWP <support@icontrolwp.com>
 * All rights reserved.
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

require_once( dirname(__FILE__).'/icwp-base-processor.php' );

if ( !class_exists('ICWP_WPTB_PluginProcessor') ):

class ICWP_WPTB_PluginProcessor extends ICWP_WPTB_BaseProcessor {

	/**
	 * @param ICWP_WPTB_FeatureHandler_Plugin $oFeatureOptions
	 */
	public function __construct( ICWP_WPTB_FeatureHandler_Plugin $oFeatureOptions ) {
		parent::__construct( $oFeatureOptions );
	}

	/**
	 *
	 */
	public function run() {
		add_filter( $this->oFeatureOptions->doPluginPrefix( 'show_marketing' ), array( $this, 'getIsShowMarketing' ) );
	}

	/**
	 * @param $fShow
	 * @return bool
	 */
	public function getIsShowMarketing( $fShow ) {
		if ( !$fShow ) {
			return $fShow;
		}

		$oWpFunctions = $this->loadWpFunctionsProcessor();
		if ( class_exists( 'Worpit_Plugin' ) ) {
			if ( method_exists( 'Worpit_Plugin', 'IsLinked' ) ) {
				$fShow = !Worpit_Plugin::IsLinked();
			}
			else if ( $oWpFunctions->getOption( Worpit_Plugin::$VariablePrefix.'assigned' ) == 'Y'
				&& $oWpFunctions->getOption( Worpit_Plugin::$VariablePrefix.'assigned_to' ) != '' ) {

				$fShow = false;
			}
		}

		if ( $this->getInstallationDays() < 1 ) {
			$fShow = false;
		}

		return $fShow;
	}

	/**
	 * @return int
	 */
	protected function getInstallationDays() {
		$nTimeInstalled = $this->oFeatureOptions->getOpt( 'installation_time' );
		if ( empty($nTimeInstalled) ) {
			return 0;
		}
		return round( ( time() - $nTimeInstalled ) / DAY_IN_SECONDS );
	}
}

endif;
