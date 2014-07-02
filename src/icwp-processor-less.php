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

if ( !class_exists('ICWP_WPTB_LessProcessor_V1') ):

class ICWP_WPTB_LessProcessor_V1 extends ICWP_WPTB_BaseProcessor {

	/**
	 * @param ICWP_WPTB_FeatureHandler_Less $oFeatureOptions
	 */
	public function __construct( ICWP_WPTB_FeatureHandler_Less $oFeatureOptions ) {
		parent::__construct( $oFeatureOptions );
	}

	/**
	 */
	public function run() {
		$this->writeVariableOrig();
		//check for existence of LESS file
		$oWpFs = $this->loadFileSystemProcessor();

		if ( $oWpFs->exists( $this->oFeatureOptions->getPath_TargetLessFileStem().'.css' ) ) {
			return;
		}
		// compile as necessary
		$this->compileLess();
	}

	public function compileLess() {
		$oWpFs = $this->loadFileSystemProcessor();

		$this->includeLessLibrary();
		$sFilePathToLess = $this->getPath_BootstrapDir().'less'.ICWP_DS.'bootstrap.less';
		$sTargetCssFileStem = $this->oFeatureOptions->getPath_TargetLessFileStem();

		// Write normal CSS
		$oLessCompiler = new Less_Parser();
		$oLessCompiler->parseFile( $sFilePathToLess );
		$sCompiledCss = $oLessCompiler->getCss();
		$oWpFs->putFileContent( $sTargetCssFileStem.'.css', $sCompiledCss );

		// Write compressed CSS - it doesn't work to use the SetOption and recompile
		$aCompileOptions = array( 'compress' => true );
		$oLessCompiler = new Less_Parser( $aCompileOptions );
		$oLessCompiler->parseFile( $sFilePathToLess );
		$sCompiledCss = $oLessCompiler->getCss();
		return $oWpFs->putFileContent( $sTargetCssFileStem.'.min.css', $sCompiledCss );
	}

	/**
	 */
	protected function writeVariableOrig() {
		$oWpFs = $this->loadFileSystemProcessor();
		if ( is_admin() ) {
			$sVariablesLessFile = $this->getPath_VariablesLessFile();
			if ( !$oWpFs->exists( $sVariablesLessFile.'.orig' ) ) {
				copy( $sVariablesLessFile, $sVariablesLessFile.'.orig' );
			}
		}
	}

	protected function includeLessLibrary() {
		$sPathToLessCompiler = $this->oFeatureOptions->getPathToInc( 'Less.php/Autoloader.php' );
		require_once ( $sPathToLessCompiler );
		Less_Autoloader::register();
	}

	/**
	 * @return string
	 */
	protected function getPath_BootstrapDir() {
		return $this->oFeatureOptions->getResourcesDir( 'bootstrap-'.$this->oFeatureOptions->getTwitterBootstrapVersion().ICWP_DS );
	}

	protected function getPath_VariablesLessFile() {
		return $this->getPath_BootstrapDir().'less'.ICWP_DS.'variables.less';
	}

}

endif;

if ( !class_exists('ICWP_WPTB_LessProcessor') ):
	class ICWP_WPTB_LessProcessor extends ICWP_WPTB_LessProcessor_V1 { }
endif;