<?php

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

class HLT_BootstrapLess {
	
	const LessOptionsPrefix = 'less_';
	
	protected $m_aAllBootstrapLessOptions;
	
	public function __construct() {
		
		$this->m_aAllBootstrapLessOptions = array(
			'The Grays' => array(
				array( self::LessOptionsPrefix.'black', 		'', '#000',	'color',	'Black' ),
				array( self::LessOptionsPrefix.'grayDarker',	'', '#222',	'color',	'Darker Gray' ),
				array( self::LessOptionsPrefix.'grayDark',		'', '#333',	'color',	'Dark Gray' ),
				array( self::LessOptionsPrefix.'gray',			'', '#555',	'color',	'Gray' ),
				array( self::LessOptionsPrefix.'grayLight',		'', '#999',	'color',	'Light Gray' ),
				array( self::LessOptionsPrefix.'grayLighter',	'', '#eee',	'color',	'Lighter Gray' ),
				array( self::LessOptionsPrefix.'white',			'', '#fff',	'color',	'White' )
			),
			'Fonts, Colours & Lights' => array(
				array( self::LessOptionsPrefix.'textColor',					'', '#333',				'color',		'Text Colour' ), //@grayDark
				array( self::LessOptionsPrefix.'primaryButtonBackground',	'', '#08c',				'color',		'Primary Button Colour' ), //@linkColor
				array( self::LessOptionsPrefix.'linkColor',					'', '#08c',				'color',		'Link Colour' ),
				array( self::LessOptionsPrefix.'linkColorHover', 			'', '#08c',				'color',		'Link Hover Colour' ), //darken(@linkColor, 15%)
				array( self::LessOptionsPrefix.'blue', 						'', '#049cdb',			'color',		'Blue' ),
				array( self::LessOptionsPrefix.'blueDark',					'', '#0064cd',			'color',		'Dark Blue' ),
				array( self::LessOptionsPrefix.'green',						'', '#46a546',			'color',		'Green' ),
				array( self::LessOptionsPrefix.'red',						'', '#9d261d',			'color',		'Red' ),
				array( self::LessOptionsPrefix.'yellow',					'', '#ffc40d',			'color',		'Yellow' ),
				array( self::LessOptionsPrefix.'orange',					'', '#f89406',			'color',		'Orange' ),
				array( self::LessOptionsPrefix.'pink', 						'', '#c3325f',			'color',		'Pink' ),
				array( self::LessOptionsPrefix.'purple', 					'', '#7a43b6',			'color',		'Purple' ),
				array( self::LessOptionsPrefix.'baseFontSize',				'', '13px',				'size',			'Font Size' ),
				array( self::LessOptionsPrefix.'baseLineHeight', 			'', '18px',				'size',			'Base Line Height' ),
				array( self::LessOptionsPrefix.'baseFontFamily',			'', '"Helvetica Neue", Helvetica, Arial, sans-serif',	'font',		'Font Family' ),
			)		
		);

	}//__construct
	
	public function getAllBootstrapLessOptions( $fPopulate = false ) {
		if ($fPopulate) {
			$this->populateAllLessOptions();
		}
		return $this->m_aAllBootstrapLessOptions;
	}//getAllBootstrapLessOptions

	public function populateAllLessOptions() {

		foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
			
			foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => &$aOptionParams ) {
				$sCurrentOptionVal = HLT_BootstrapCss::getOption( $aOptionParams[0] );
				$aOptionParams[1] = ($sCurrentOptionVal == '' )? $aOptionParams[2] : $sCurrentOptionVal;
			}
		}
		
	}//populateAllOptions
	
	public function resetToDefaultAllLessOptions( $insBootstrapDir ) {

		foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
			
			foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => $aOptionParams ) {
				HLT_BootstrapCss::updateOption( $aOptionParams[0], $aOptionParams[2] );
			}
		}
		$this->reWriteVariablesLess($insBootstrapDir);
		$this->compileLess($insBootstrapDir);

	}//resetToDefaultAllLessOptions
	
	public function processNewLessOptions( $inaPostOptions, $sOptionsPrefix = '', $insBootstrapDir ) {
		
		// Read in variables.less contents
		foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
			
			foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => $aOptionParams ) {
				list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $aOptionParams;
				
				$sPostValue = $inaPostOptions[$sOptionsPrefix.$sLessKey];
				if ( $sLessOptionType == 'color' ) {
					
					if ( !preg_match( '/^[a-fA-F0-9]{3,6}$/', $sPostValue ) ) {
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
				HLT_BootstrapCss::updateOption( $sLessKey, $sPostValue );
			}
		}
		
		$this->reWriteVariablesLess($insBootstrapDir);
		$this->compileLess($insBootstrapDir);
		
	}//processNewLessOptions
	
	public function reWriteVariablesLess( $insBootstrapDir ) {
		
		$sFilePathVariablesLess = $insBootstrapDir.'less'.DS.'variables.less';
		$sFilePathVariablesLess = HLT_BootstrapCss::$PLUGIN_DIR.'resources'.DS.'bootstrap-2.0.1'.DS.'less'.DS.'variables.less';
		$sContents = file_get_contents( $sFilePathVariablesLess );
		
		$this->populateAllLessOptions();
	
		foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
			
			foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => $aOptionParams ) {
				list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $aOptionParams;
				
				$sBootstrapLessVar = str_replace( self::LessOptionsPrefix, '', $sLessKey );
				$sContents = preg_replace( '/^\s*(@'.$sBootstrapLessVar.':\s*)([^;]+)(;)\s*$/im', '${1}'.$sLessSaved.'${3}', $sContents );
			}
		}
		
		file_put_contents( $sFilePathVariablesLess, $sContents );
	
	}//reWriteVariablesLess
	
	public function compileLess( $insBootstrapDir ) {
		
		$sFilePathBootstrapLess = $insBootstrapDir.'less'.DS.'bootstrap.less';
		$sFilePathBootstrapLess = HLT_BootstrapCss::$PLUGIN_DIR.'resources'.DS.'bootstrap-2.0.1'.DS.'less'.DS.'bootstrap.less';
		
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
		$sMinFile = $insBootstrapDir.'css'.DS.'bootstrap.less';
		file_put_contents( $sMinFile.'.css', $sCompiledCss );
		
		//Basic Minify
		$sCompiledCss = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $sCompiledCss);
		file_put_contents( $sMinFile.'.min.css', $sCompiledCss );
	}//compileLess
	
}//HLT_BootstrapLess