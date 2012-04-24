<?php

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

class HLT_BootstrapLess {
	
	const LessOptionsPrefix = 'less_';
	
	static public $LESS_PREFIX;
	
	protected $m_aAllBootstrapLessOptions;
	
	public function __construct() {
		
		self::$LESS_PREFIX = self::LessOptionsPrefix;
		
		$this->m_aAllBootstrapLessOptions = array(
			'The Grays' => array(
				array( self::LessOptionsPrefix.'black', 		'', '#000',	'color',	'Black',		'@black' ),
				array( self::LessOptionsPrefix.'grayDarker',	'', '#222',	'color',	'Darker Gray',	'@grayDarker' ),
				array( self::LessOptionsPrefix.'grayDark',		'', '#333',	'color',	'Dark Gray',	'@grayDark' ),
				array( self::LessOptionsPrefix.'gray',			'', '#555',	'color',	'Gray',			'@gray' ),
				array( self::LessOptionsPrefix.'grayLight',		'', '#999',	'color',	'Light Gray',	'@grayLight' ),
				array( self::LessOptionsPrefix.'grayLighter',	'', '#eee',	'color',	'Lighter Gray',	'@grayLighter' ),
				array( self::LessOptionsPrefix.'white',			'', '#fff',	'color',	'White',		'@white' )
			),
			'Fonts, Colours & Links' => array(
				array( self::LessOptionsPrefix.'bodyBackground',	'', '@white',			'color',		'Body Background Colour',			'@bodyBackground' ), //@white
				array( self::LessOptionsPrefix.'textColor',			'', '@grayDark',		'color',		'Text Colour',						'@textColor' ),
				array( self::LessOptionsPrefix.'linkColor',			'', '#08c',				'color',		'Link Colour',						'@linkColor' ),
				array( self::LessOptionsPrefix.'linkColorHover', 	'', 'darken(@linkColor, 15%)',			'color',	'Link Hover Colour',	'@linkColorHover' ), //darken(@linkColor, 15%)
				array( self::LessOptionsPrefix.'blue', 				'', '#049cdb',			'color',		'Blue',								'@blue' ),
				array( self::LessOptionsPrefix.'blueDark',			'', '#0064cd',			'color',		'Dark Blue',						'@blueDark' ),
				array( self::LessOptionsPrefix.'green',				'', '#46a546',			'color',		'Green',							'@green' ),
				array( self::LessOptionsPrefix.'red',				'', '#9d261d',			'color',		'Red',								'@red' ),
				array( self::LessOptionsPrefix.'yellow',			'', '#ffc40d',			'color',		'Yellow',							'@yellow' ),
				array( self::LessOptionsPrefix.'orange',			'', '#f89406',			'color',		'Orange',							'@orange' ),
				array( self::LessOptionsPrefix.'pink', 				'', '#c3325f',			'color',		'Pink',								'@pink' ),
				array( self::LessOptionsPrefix.'purple', 			'', '#7a43b6',			'color',		'Purple',							'@purple' ),
				array( self::LessOptionsPrefix.'baseFontSize',		'', '13px',				'size',			'Font Size',						'@baseFontSize' ),
				array( self::LessOptionsPrefix.'baseLineHeight', 	'', '18px',				'size',			'Base Line Height',					'@baseLineHeight' ),
				array( self::LessOptionsPrefix.'baseFontFamily',	'', '"Helvetica Neue", Helvetica, Arial, sans-serif',	'font',	'Fonts',	'@baseFontFamily' ),
				array( self::LessOptionsPrefix.'altFontFamily',		'', 'Georgia, "Times New Roman", Times, serif',	'font',	'Alternative Fonts',	'@altFontFamily' ),
			),
			'Button Styling' => array(
				array( self::LessOptionsPrefix.'btnBackground', 				'', '@white',							'color',	'Background' ),				//@white
				array( self::LessOptionsPrefix.'btnBackgroundHighlight',		'', 'darken(@white, 10%)',				'color',	'Background Highlight' ),	//darken(@white, 10%);
				array( self::LessOptionsPrefix.'btnPrimaryBackground',			'', '@linkColor',						'color',	'Primary Btn Background' ),	//@linkColor
				array( self::LessOptionsPrefix.'btnPrimaryBackgroundHighlight',	'', 'spin(@btnPrimaryBackground, 15%)',	'color',	'Primary Btn Highlight' ),	//spin(@btnPrimaryBackground, 15%)
				array( self::LessOptionsPrefix.'btnInfoBackground',				'', '#5bc0de',							'color',	'Info Btn Background' ),
				array( self::LessOptionsPrefix.'btnInfoBackgroundHighlight',	'', '#2f96b4',							'color',	'Info Btn Highlight' ),
				array( self::LessOptionsPrefix.'btnSuccessBackground',			'', '#62c462',							'color',	'Success Btn Background' ),
				array( self::LessOptionsPrefix.'btnSuccessBackgroundHighlight',	'', '#51a351',							'color',	'Success Btn Highlight' ),
				array( self::LessOptionsPrefix.'btnWarningBackground',			'', 'lighten(@orange, 15%)',			'color',	'Warning Btn Background' ),	//lighten(@orange, 15%)
				array( self::LessOptionsPrefix.'btnWarningBackgroundHighlight',	'', '@orange',							'color',	'Warning Btn Highlight' ),	//@orange
				array( self::LessOptionsPrefix.'btnDangerBackground',			'', '#ee5f5b',							'color',	'Danger Btn Background' ),
				array( self::LessOptionsPrefix.'btnDangerBackgroundHighlight',	'', '#bd362f',							'color',	'Danger Btn Highlight' ),
				array( self::LessOptionsPrefix.'btnInverseBackground',			'', '@gray',							'color',	'Inverse Btn Background' ),	//@gray
				array( self::LessOptionsPrefix.'btnInverseBackgroundHighlight',	'', '@grayDarker',						'color',	'Inverse Btn Highlight' ),	//@grayDarker
				array( self::LessOptionsPrefix.'btnBorder',						'', 'darken(@white, 20%)',				'color',	'Button Border' ),			//darken(@white, 20%)
			),
			'Alerts and Form States' => array(
				array( self::LessOptionsPrefix.'warningText', 		'', '#c09853',			'color',	'Warning Text Colour' ),
				array( self::LessOptionsPrefix.'warningBackground',	'', '#fcf8e3',			'color',	'Warning Background Colour' ),
				array( self::LessOptionsPrefix.'warningBorder',		'', 'darken(spin(@warningBackground, -10), 3%)',			'color',	'Warning Border Colour' ),
				array( 'spacer' ),
				array( self::LessOptionsPrefix.'errorText', 		'', '#b94a48',			'color',	'Error Text Colour' ),
				array( self::LessOptionsPrefix.'errorBackground',	'', '#f2dede',			'color',	'Error Background Colour' ),
				array( self::LessOptionsPrefix.'errorBorder',		'', 'darken(spin(@errorBackground, -10), 3%)',			'color',	'Error Border Colour' ),
				array( 'spacer' ),
				array( self::LessOptionsPrefix.'successText', 		'', '#468847',			'color',	'Success Text Colour' ),
				array( self::LessOptionsPrefix.'successBackground',	'', '#dff0d8',			'color',	'Success Background Colour' ),
				array( self::LessOptionsPrefix.'successBorder',		'', 'darken(spin(@successBackground, -10), 5%)',			'color',	'Success Border Colour' ),
				array( 'spacer' ),
				array( self::LessOptionsPrefix.'infoText', 			'', '#3a87ad',			'color',	'Info Text Colour' ),
				array( self::LessOptionsPrefix.'infoBackground',	'', '#d9edf7',			'color',	'Info Background Colour' ),
				array( self::LessOptionsPrefix.'infoBorder',		'', 'darken(spin(@infoBackground, -10), 7%)',			'color',	'Info Border Colour' ),
				array( 'spacer' )
			),
			'The Grid' => array(
				array( self::LessOptionsPrefix.'gridColumns', 		'', '12',			'',	'Grid Columns' ),
				array( self::LessOptionsPrefix.'gridColumnWidth',	'', '60px',			'',	'Grid Column Width' ),
				array( self::LessOptionsPrefix.'gridGutterWidth',	'', '20px',			'',	'Grid Gutter Width' ),
				array( self::LessOptionsPrefix.'gridRowWidth',		'', '(@gridColumns * @gridColumnWidth) + (@gridGutterWidth * (@gridColumns - 1))',	'',	'Grid Row Width' )
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

	public function deleteAllLessOptions() {

		foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
			
			foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => &$aOptionParams ) {
				HLT_BootstrapCss::deleteOption( $aOptionParams[0] );
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
					
					if ( preg_match( '/^[a-fA-F0-9]{3,6}$/', $sPostValue ) ) {

						$sPostValue = '#'.$sPostValue;
					
					} else {
						//validate LESS?
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
		
		if ( $this->reWriteVariablesLess($insBootstrapDir) ) {
			$this->compileLess($insBootstrapDir);
		}
		
	}//processNewLessOptions
	
	public function reWriteVariablesLess( $insBootstrapDir ) {

		$fSuccess = true;
		
		$sFilePathVariablesLess = $insBootstrapDir.'less'.DS.'variables.less';
		$sContents = file_get_contents( $sFilePathVariablesLess );
		
		if ( !$sContents ) {
			//The Variable.less file couldn't be read: bail!
			$fSuccess = false;
		} else {
			$this->populateAllLessOptions();
		
			foreach ( $this->m_aAllBootstrapLessOptions as $aKeySectionTitle => $aLessSection ) {
				
				foreach ( $this->m_aAllBootstrapLessOptions[$aKeySectionTitle] as $sKey => $aOptionParams ) {
					list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $aOptionParams;
					
					$sBootstrapLessVar = str_replace( self::LessOptionsPrefix, '', $sLessKey );
					$sContents = preg_replace( '/^\s*(@'.$sBootstrapLessVar.':\s*)([^;]+)(;)\s*$/im', '${1}'.$sLessSaved.'${3}', $sContents );
				}
			}
			
			file_put_contents( $sFilePathVariablesLess, $sContents );
		}
		return $fSuccess;
	
	}//reWriteVariablesLess
	
	public function compileLess( $insBootstrapDir ) {

		$sFilePathBootstrapLess = $insBootstrapDir.'less'.DS.'bootstrap.less';
		
		//parse LESS
		include_once( dirname(__FILE__).'/inc/lessc/lessc.inc.php' );
		$oLessCompiler = new lessc( $sFilePathBootstrapLess );
		$sCompiledCss = '';
		try {
			$sCompiledCss = $oLessCompiler->parse();
			
			$sLessFile = $insBootstrapDir.'css'.DS.'bootstrap.less';
			file_put_contents( $sLessFile.'.css', $sCompiledCss );
		
			//Basic Minify
			$sCompiledCss = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $sCompiledCss);
			file_put_contents( $sLessFile.'.min.css', $sCompiledCss );
		}
		catch ( Exception $oE ) {
			echo "lessphp fatal error: ".$oE->getMessage();
		}
	}//compileLess
	
}//HLT_BootstrapLess