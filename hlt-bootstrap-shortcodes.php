<?php

/**
 * Copyright (c) 2012 Worpit <support@worpit.com>
 * All rights reserved.
 * 
 * "WordPress Bootstrap CSS" is distributed under the GNU General Public License, Version 2,
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

class HLT_BootstrapShortcodes {
	
	protected $sTwitterBootstrapVersion;
	
	protected $m_sCollapseParentId;

	public function __construct( $sVersion = '2' ) {
		$aMethods = get_class_methods( $this );
		$aExclude = array( 'idHtml',
							'def',
							'filterTheContent',
							'filterTheContentToFixNamedAnchors',
							'noEmptyHtml',
							'noEmptyElement',
							'PrintJavascriptForTooltips',
							'PrintJavascriptForPopovers' );
		
		foreach ( $aMethods as $sMethod ) {
			if ( !in_array( $sMethod, $aExclude ) ) {
				add_shortcode( 'TBS_'.strtoupper( $sMethod ), array( &$this, $sMethod ) );
			}
		}
		
		$this->sTwitterBootstrapVersion = $sVersion;

		add_filter( 'the_content', array( &$this, 'filterTheContent' ), 10 );		
		add_filter( 'the_content', array( &$this, 'filterTheContentToFixNamedAnchors' ), 99 );
		
		/**
		 * Move the wpautop until after the shortcodes have been run!
		 * remove_filter( 'the_content', 'wpautop' );
		 * add_filter( 'the_content', 'wpautop' , 99 );
		 * add_filter( 'the_content', 'shortcode_unautop', 100 );
		 */
		
		/**
		 * Disable wpautop globally!
		 * remove_filter( 'the_content',  'wpautop' );
		 * remove_filter( 'comment_text', 'wpautop' );
		 */
	}
	/**
	 * Prints the necessary HTML for Twitter Bootstrap Icons.
	 * 
	 * Defaults to: "icon-star-empty" icon
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function icon( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'class'	=>	'icon-star-empty',
		);
		
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp($aOptions);
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//strip empty parameters
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		$sReturn = '<i class="'.$inaAtts['class'].'"'.$inaAtts['style'].$inaAtts['id'].'></i>';
		
		return $sReturn;
	}//icon
	
	/**
	 * Prints the necessary HTML for Twitter Bootstrap Labels
	 * 
	 * Class may be one of: Primary Info Success Danger Warning Inverse
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function button( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'style'			=>	'',
				'id'			=>	'',
				'class'			=>	'',
				'link_title'	=>	'',
				'title'			=>	'',
				'value'			=>	'0',
				'text'			=>	'',
				'disabled'		=>	'N',
				'toggle'		=>	'N',
				'type'			=>	($sElementType == 'a')? '' : 'button',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp($aOptions);
		}
		
//		$this->processOptions( $inaAtts, $aOptions );
		
		$sElementType = 'a';
		if ( isset( $inaAtts['element'] ) ) {
			$sElementType = $inaAtts['element'];
		} else {
			if ( !isset( $inaAtts['link'] ) ) { //i.e. there's no link defined, set as button
				$sElementType = 'button';
			}
		}
		
		$this->def( $inaAtts, 'style' );
		$this->def( $inaAtts, 'id' );
		$this->def( $inaAtts, 'class' );
		$this->def( $inaAtts, 'link_title' );
		$this->def( $inaAtts, 'title' );
		if (empty($inaAtts['title'])) {
			$inaAtts['title'] = $inaAtts['link_title']; // backwards compatibility - originally only "link_title"
		}
		$this->def( $inaAtts, 'value', '0' );
		$this->def( $inaAtts, 'text' );
		$this->def( $inaAtts, 'disabled', 'N' );
		$this->def( $inaAtts, 'toggle', 'N' );
		$this->def( $inaAtts, 'type', ($sElementType == 'a')? '' : 'button' );
		
		//strip empty parameters
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'title' );
		$this->noEmptyElement( $inaAtts, 'type' );
		
		$sClassString = 'btn';
		
		//Prefix first class with "btn-" to ensure correct class name for Twitter Bootstrap
		if ( !preg_match( '/^btn-/', $inaAtts['class'] ) ) {
			$sClassString .= ( empty($inaAtts['class']) ) ? '' : ' btn-'.$inaAtts['class'];
		} else if ( !empty($inaAtts['class']) ) {
			$sClassString .= ' '.$inaAtts['class'];
		}
		
		//Add disabled class
		$sClassString .= ( strtolower($inaAtts['disabled']) == 'y' ) ? ' disabled' : '';

		$sReturn = '<'.$sElementType
					.$inaAtts['style']
					.$inaAtts['id']
					.$inaAtts['type']
					.' class="'.$sClassString.'"'
		;

		if ( $sElementType == 'a' ) {
			$sReturn .= ' href="'.$inaAtts['link'].'"'.$inaAtts['title'];
		}
		else {
			$sReturn .= ' value="'.$inaAtts['value'].'"';
		}
		
		//Creates a toggle button
		if ( strtolower($inaAtts['toggle']) == 'y' )
			$sReturn .= ' data-toggle="button"';
		
		//Add disabled field in the case of buttons
		if ( $sElementType == 'button' AND strtolower($inaAtts['disabled']) == 'y' ) {
			$sReturn .= ' disabled="disabled"';
		}
		
		//Final close and insert content
		if ( strtolower($sElementType) == 'input') {
		//special case for INPUT elements

			$sReturn .= ' />';

		} else {
			//Priority for button text is given to the text parameter
			if ( !empty($inaAtts['text']) ) {
				$insContent = $inaAtts['text'];
			} else if ( empty($insContent) ) {
				$insContent = 'button';
			}
			$sReturn .= '>'.$this->doShortcode( $insContent ).'</'.$sElementType.'>';
		}
	
		return $sReturn;
	}//button
	
	/**
	 * Toggle button options are "buttons-checkbox" and "buttons-radio"
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function buttonGroup( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'toggle'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp($aOptions);
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		$inaAtts['toggle'] = $this->noEmptyHtml( $inaAtts['toggle'], 'data-toggle' );
		
		$sReturn = '<div class="btn-group '.$inaAtts['class']. '"'
					.$inaAtts['id']
					.$inaAtts['style']
					.$inaAtts['toggle']
					.'>'.$this->doShortcode( $insContent ).'</div>'
		;
		
		return $sReturn;
		
	}//buttonGroup
	
	/**
	 * Prints the necessary HTML for Twitter Bootstrap Badges
	 * 
	 * class may be one of: success, warning, error, info, inverse
	 * 
	 * only supported in Twitter Bootstrap version 2.0+
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 * @return string
	 */
	public function badge( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array();
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		//prefix the first class with "badge-" to ensure correct class name for Twitter
		if ( !empty($inaAtts['class']) && !preg_match( '/^badge-/', $inaAtts['class'] ) ) {
			$inaAtts['class'] = 'badge-'.$inaAtts['class'];
		}

		$sReturn = '<span class="badge '.$inaAtts['class'].'"'
					.$inaAtts['style']
					.$inaAtts['id']
					.'>'.$this->doShortcode( $insContent ).'</span>'
		;

		return $sReturn;
	}
	
	/**
	 * Prints the necessary HTML for Twitter Bootstrap Labels
	 * 
	 * class may be one of: success, warning, important, notice
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 * @return string
	 */
	public function label( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array();
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		//prefix the first class with "label-" to ensure correctly class name for Twitter
		if ( !empty($inaAtts['class']) && !preg_match( '/^label-/', $inaAtts['class'] ) ) {
			$inaAtts['class'] = 'label-'.$inaAtts['class'];
		}

		$sReturn = '<span class="label '.$inaAtts['class'].'"'
					.$inaAtts['style']
					.$inaAtts['id']
					.'>'.$this->doShortcode( $insContent ).'</span>'
		;

		return $sReturn;
	}//label

	/**
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 * @return string
	 */
	public function blockquote( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'source'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'class' );

		$sReturn = '<blockquote '.$inaAtts['style']
					.$inaAtts['id']
					.$inaAtts['class']
					.'><p>'.$this->doShortcode( $insContent ).'</p><small>'.$inaAtts['source'].'</small></blockquote>'
		;
		
		return $sReturn;
	}//blockquote

	/**
	 * Returns a DIV with appropriate classes for Twitter Bootstrap Alerts.
	 * 
	 * Support for Twitter Bootstrap 1.4.x was removed with version 2.0.3 of the plugin.
	 * 
	 * Class may be one of: error, warning, success, info
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function alert( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'type'		=>	'alert',
				'heading'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );

		//Ensures class starts with "alert-"
		if ( !empty($inaAtts['class']) && !preg_match( '/^alert-/', $inaAtts['class'] ) ) {
			$inaAtts['class'] = 'alert-'.$inaAtts['class'];
		}
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		$sReturn = '<div class="alert '.$inaAtts['class'].'"'
					.$inaAtts['style']
					.$inaAtts['id']
					.'>';
		
		if ( !empty($inaAtts['heading']) ) {
			$sReturn .= '<h4 class="alert-heading">'.$inaAtts['heading'].'</h4>';
		}
		
		$sReturn .= $this->doShortcode( $insContent ).'</div>';

		return  $sReturn ;
	}
	
	public function code( $inaAtts = array(), $insContent = '' ) {
		
		$this->def( $inaAtts, 'style' );
		$this->def( $inaAtts, 'id' );

		$sReturn = '<pre class="prettyprint linenums" '.$this->idHtml( $inaAtts['id'] ).' '.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>'.$insContent.'</pre>';

		return $sReturn;
	}

	/**
	 * Options for 'placement' are top | bottom | left | right
	 */
	public function tooltip( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'placement'	=>	'top',
				'title'		=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );

		if ( $inaAtts['placement'] == 'above' ) {
			$inaAtts['placement'] = 'top';
		}
		if ( $inaAtts['placement'] == 'below' ) {
			$inaAtts['placement'] = 'bottom';
		}
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'class' );

		$sReturn = $insContent;
		if ( $inaAtts['title'] != '' ) {
			$sReturn = '<span'
					.' rel="tooltip" data-placement="'.$inaAtts['placement'].'" data-original-title="'.$inaAtts['title'].'"'
					.$inaAtts['style']
					.$inaAtts['id']
					.$inaAtts['class']
					.'>'.$this->doShortcode($insContent).'</span>';
		}
		
		remove_action( 'wp_footer', array(__CLASS__, 'PrintJavascriptForTooltips' ) );
		add_action( 'wp_footer', array(__CLASS__, 'PrintJavascriptForTooltips' ) );
		return $sReturn;
	}

	/**
	 * Options for 'placement' are top | bottom | left | right
	 */
	public function popover( $inaAtts = array(), $insContent = '' ) {
		
		$aOptions = array(
				'placement'	=>	'right',
				'title'		=>	'',
				'content'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'class' );

		$sReturn = '<span'
					.' rel="popover" data-placement="'.$inaAtts['placement'].'" title="'.$inaAtts['title'].'"'
					.' data-content="'.$inaAtts['content'].'"'
					.$inaAtts['style']
					.$inaAtts['id']
					.$inaAtts['class'].'>'.$this->doShortcode( $insContent ).'</span>';
		
		remove_action( 'wp_footer', array(__CLASS__, 'PrintJavascriptForPopovers' ) );
		add_action( 'wp_footer', array(__CLASS__, 'PrintJavascriptForPopovers' ) );
		return $sReturn;
	}
	
	public function dropdown( $inaAtts = array(), $insContent = '' ) {
		$this->def( $inaAtts, 'name', 'Undefined' );
		
		$insContent = '
			<ul class="tabs">
				<li class="dropdown" data-dropdown="dropdown">
					<a class="dropdown-toggle" href="#">'.$inaAtts['name'].'</a>
					<ul class="dropdown-menu">
						'.$insContent.'
					</ul>
				</li>
			</ul>
		';

		return $this->doShortcode( $insContent );
	}
	
	/**
	 * This is used by both dropdown and tabgroup/tab
	 */
	public function dropdown_option( $inaAtts = array(), $insContent = '' ) {
		$this->def( $inaAtts, 'name', 'Undefined' );
		$this->def( $inaAtts, 'link', '#' );
		
		$insContent = '<li><a href="'.$inaAtts['link'].'">'.$inaAtts['name'].'</a></li>';
		
		return $this->doShortcode( $insContent );
	}

	public function tabgroup( $inaAtts = array(), $insContent ) {
		
		$aTabs = array();
		$aMatches = array();
		$nOffsetAdjustment = 0;
		$i = 0;
		
		/**
		 * Because there are 2 separate sections of HTML for the tabs to work, we need to
		 * look for the TBS_TAB shortcodes now, to create the buttons. The $insContent is
		 * passed onwards and will be used to create the tab content panes.
		 * 
		 * PREG_OFFSET_CAPTURE requires PHP 4.3.0
		 */
		if ( preg_match_all( '/\[TBS_TAB([^\]]*)\]/', $insContent, $aMatches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
			foreach ( $aMatches as $aMatch ) {
				//aMatch = Array ( [0] => Array ( [0] => [TBS_TAB page_id="53" name="test1"] [1] => 1 ) [1] => Array ( [0] => page_id="53" name="test1" [1] => 9 ) )
				 
				if ( !isset( $aMatch[1] ) ) {
					continue;
				}
				
				$sName = "Undefined";
				if ( preg_match( '/name\s*=\s*("|\')(.+)\g{-2}+/i', $aMatch[1][0], $aSubMatches ) ) {
					$sName = $aSubMatches[2];
				}
				
				$sType = "page";
				if ( preg_match( '/type\s*=\s*("|\')(page|dropdown)\g{-2}+/i', $aMatch[1][0], $aSubMatches ) ) {
					$sType = $aSubMatches[2];
				}
				
				if ( $sType == "page" ) {
					$aTabs[] = '<li class="'.($i == 0? 'active': '').'"><a href="#TbsTabId'.$i.'">'.$sName.'</a></li>';
				}
				else {
					/**
					 * Handle the dropdowns as the tab() shortcode handles the tab contents only
					 */
					$nOffsetTemp = $aMatch[0][1] + $nOffsetAdjustment;

					$sRemainder = substr( $insContent, $nOffsetTemp + strlen( $aMatch[0][0] ) );					
					$nPos = strpos( $sRemainder, '[/TBS_TAB]' );
					$sRemainder = substr( $sRemainder, 0, $nPos );

					// match all dropdowns until [/TBS_TAB]
					if ( !preg_match_all( '/\[TBS_DROPDOWN_OPTION([^\]]*)\]/', $sRemainder, $aSubMatches, PREG_SET_ORDER ) ) {
						continue;
					}

					$aOptions = array();
					foreach ( $aSubMatches as $aSubMatch ) {
						$sLink = '#';
						if ( preg_match( '/link\s*=\s*("|\')(.*)\g{-2}+/i', $aSubMatch[1][0], $aSubMatches ) ) {
							$sLink = $aSubMatches[2];
						}

						$sName = 'Undefined';
						if ( preg_match( '/name\s*=\s*("|\')(.*)\g{-2}+/i', $aSubMatch[1][0], $aSubMatches ) ) {
							$sName = $aSubMatches[2];
						}
						
						$aOptions[] = '<li><a href="'.$sLink.'">'.$sName.'</a></li>';
					}

					$aTabs[] = '
						<li class="dropdown" data-dropdown="dropdown">
							<a class="dropdown-toggle" href=" #">'.$sName.'</a>
							<ul class="dropdown-menu">
								'.implode( '', $aOptions ).'
							</ul>
						</li>
					';
				}
				
				$nOffset = $aMatch[0][1] + $nOffsetAdjustment;
				$nLength = strlen( $aMatch[0][0] );
				$sAddition = ' id="TbsTabId'.$i.'"';
				$insContent = substr_replace( $insContent, '[TBS_TAB'.($aMatch[1][0]).$sAddition.']', $nOffset, $nLength );
				
				$nOffsetAdjustment += strlen( $sAddition );
				
				$i++;
			}
		}
		
		$insContent = '
			<ul class="nav nav-tabs" data-tabs="tabs">
				'.implode( "\n", $aTabs ).'
			</ul>
			<div id="my-tab-content" class="tab-content">
				'.$insContent.'
			</div>
		';
		
		return $this->doShortcode( $insContent );
	}
	
	/**
	 * Reference: http://codex.wordpress.org/Function_Reference/get_page
	 */
	public function tab( $inaAtts = array(), $insContent = '' ) {
		$this->def( $inaAtts, 'page_id', 0 );
		$this->def( $inaAtts, 'type', 'page' ); // can be either page or dropdown
		
		// If this value is never not set, then the tabgroup method didn't do it's job!
		$this->def( $inaAtts, 'id', 'TbsTabId_' );
		
		// Actually not used as the tab name is used by the TabGroup
		$this->def( $inaAtts, 'name', 'Undefined' );
		
		if ( $inaAtts['page_id'] > 0 ) {
			$oPage = get_page( $inaAtts['page_id'] );
			if ( !is_null( $oPage ) ) {
				$insContent = $oPage->post_content;
			}
		}
		
		$nIndex = intval( str_replace( 'TbsTabId', '', $inaAtts['id'] ) );
		
		$insContent = '<div id="'.$inaAtts['id'].'" class="tab-pane'.($nIndex == 0?' active':'').'">'.$insContent.'</div>';
		
		return $this->doShortcode( $insContent );
	}
	
	/**
	 * Prints the HTML necessary for Bootstrap Rows. Will also create a container DIV but it has the option
	 * to not print it with: container=n
	 * 
	 * There is also the option to make it fluid layout with: fluid=y
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function row( $inaAtts = array(), $insContent = '' ) {

		$aOptions = array(
				'fluid'		=>	'n',
				'container'	=>	'n',
				'cstyle'	=>	'',
				'cid'		=>	'',
				'cclass'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		$sFluid = ( strtolower($inaAtts['fluid']) == 'y' ) ? '-fluid' : '';
		
		$sReturn = '<div class="row'.$sFluid.' '.$inaAtts['class'].'" '
					.$inaAtts['style']
					.$inaAtts['id'].'>';
		$sReturn .= $this->doShortcode( $insContent ) .'</div>';
		
		if ( strtolower($inaAtts['container']) == 'y' ) {
			
			$this->noEmptyElement( $inaAtts, 'cid', 'id' );
			$this->noEmptyElement( $inaAtts, 'cstyle', 'style' );
			
			$sReturn = '<div class="container'.$sFluid.' '.$inaAtts['cclass'].'"'
						.$inaAtts['cstyle']
						.$inaAtts['cid']
						.'>'.$sReturn.'</div>';
		}
		
		return $sReturn;
	}//row
	
	public function column( $inaAtts = array(), $insContent = '' ) {

		$aOptions = array(
				'size'		=>	'1',
				'offset'	=>	'',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//filters out empty elements
		$this->noEmptyElement( $inaAtts, 'id' );
		$this->noEmptyElement( $inaAtts, 'style' );
		
		$sReturn = '<div class="span'.$inaAtts['size'].' '.$inaAtts['offset'].' '.$inaAtts['class']. '"'
					.$inaAtts['style']
					.$inaAtts['id'].'>';
		$sReturn .= $this->doShortcode( $insContent ) .'</div>';
		
		return $sReturn;
	}//row
	
	public function span( $inaAtts = array(), $insContent = '' ) {
		return $this->column( $inaAtts, $insContent );
	}
	
	public function collapse( $inaAtts = array(), $insContent = '' ) {

		$aOptions = array(
				'accordion'	=>	'n',
				'id'		=>	'randomly generated'
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$aOptions['id'] = 'TbsCollapseId-'.rand();
		
		$this->processOptions( $inaAtts, $aOptions );
		
		//if accordian is set, set the Parent ID so we can use it later.
		$this->m_sCollapseParentId = ( strtolower($inaAtts['accordion']) == 'y' )? '#'.$inaAtts['id'] : '';
		
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'id' );
		
		ob_start();
		?>
		<div class="accordion <?php echo $inaAtts['class']; ?>" <?php echo $inaAtts['id']; ?> <?php echo $inaAtts['style']; ?>>
			<?php echo $this->doShortcode( $insContent ); ?>
		</div>
		<?php
		
		$sContent = ob_get_contents();
		ob_end_clean();
		
		return $sContent;
	
	}
	
	public function collapse_group( $inaAtts = array(), $insContent = '' ) {

		$aOptions = array(
				'group-id'	=>	'randomly generated',
				'title'		=>	'"title" Not Set',
				'open'		=>	'n',
		);
		
		//Print Help if asked for and return
		if ( isset($inaAtts['help']) && strtolower($inaAtts['help']) == 'y' ) {
			return $this->getHelp( $aOptions );
		}
		
		$aOptions['parent'] = $this->m_sCollapseParentId; //this will add the accordion effect, or not.
		$sCollapseGroupId = 'TbsCollapseGroupId-'.rand();
		$aOptions['group-id'] = $sCollapseGroupId;
		
		$this->processOptions( $inaAtts, $aOptions );
		
		$this->noEmptyElement( $inaAtts, 'parent', 'data-parent' ); //this should only be printed if accordion=y was set in the parent Shortcode
		$this->noEmptyElement( $inaAtts, 'style' );
		$this->noEmptyElement( $inaAtts, 'id' );
		
		ob_start();
		?>
			<div class="accordion-group <?php echo $inaAtts['class']; ?>" <?php echo $inaAtts['id']; ?> <?php echo $inaAtts['style']; ?>>
			  <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" <?php echo $inaAtts['parent']; ?> href="#<?php echo $inaAtts['group-id']; ?>">
				  <?php echo $inaAtts['title']; ?>
				</a>
			  </div>
			  <div id="<?php echo $inaAtts['group-id']; ?>" class="accordion-body collapse <?php echo (strtolower($inaAtts['open']) == 'y') ? 'in' : '';?>">
				<div class="accordion-inner">
					<?php echo $insContent; ?>
				</div>
			  </div>
			</div>
		<?php
		
		$sContent = ob_get_contents();
		ob_end_clean();
		
		return $sContent;
	}
	
	/**
	 * Given the array of parameters/attributes and array of options and their defaults, sets them all up.
	 * 
	 * @param $inaAtts
	 * @param $inaOptions
	 */
	protected function processOptions( &$inaAtts, &$inaOptions ) {
		
		$aDefaults = array(
				'style'	=>	'',
				'id'	=>	'',
				'class'	=>	''
		);
		if ( empty($inaOptions) ) {
			$inaOptions = $aDefaults;
		} else {
			$inaOptions = array_merge( $aDefaults, $inaOptions );
		}
		
		foreach ($inaOptions as $sOption => $sDefault) {
			$this->def( $inaAtts, $sOption, $sDefault );
		}
	}
	
	protected function getHelp( &$inaOptions ) {
		
		$aDefaults = array(
				'style'	=>	'',
				'id'	=>	'',
				'class'	=>	''
		);
		if ( empty($inaOptions) ) {
			$inaOptions = $aDefaults;
		} else {
			$inaOptions = array_merge( $aDefaults, $inaOptions );
		}
		
		$sHelp = '
		Options are as follows (default values in brackets): 
		<ul>
		';
		
		foreach ($inaOptions as $sOption => $sDefault) {
			$sHelp .= '<li>'.$sOption.' ( ';
			$sHelp .= (empty($sDefault))? 'none' : '"'.$sDefault.'"';
			$sHelp .= ' )</li>';
		}
		$sHelp .= '
			</ul>
		';
		return $sHelp;
	}
	
	public static function PrintJavascriptForPopovers() {
		
		$sJavascript = "
		<!-- BEGIN: WordPress Twitter Bootstrap CSS from http://worpit.com/ : Popover-enabling Javascript -->
		<script type='text/javascript'>
			jQuery( document ).ready(
				function () {
					jQuery( '*[rel=popover]')
						.popover(); 
					
					jQuery( '*[data-popover=popover]')
						.popover();
				}
			);
		</script>
		<!-- END: Popovers-enabling Javascript -->
		";
		
		echo $sJavascript;
		
	}//PrintJavascriptForPopovers
	
	public static function PrintJavascriptForTooltips() {
		
		$sJavascript = "
			<!-- BEGIN: WordPress Twitter Bootstrap CSS from http://worpit.com/ : Tooltip-enabling Javascript -->
			<script type=\"text/javascript\">
				jQuery( document ).ready(
					function () {
						jQuery( '*[rel=tooltip],*[data-tooltip=tooltip]' ).tooltip();
					}
				);
			</script>
			<!-- END: Tooltip-enabling Javascript -->
		";
		
		echo $sJavascript;
		
	}//PrintJavascriptForTooltips

	/**
	 * Public, but should never be directly accessed other than by the WP add_filter method. 
	 * @param $insContent
	 */
	public function filterTheContent( $insContent = "" ) {		
		// Remove <p>'s that get added to [TBS...] by wpautop.
		$insContent = preg_replace( '|(<p>\s*)?(\[/?TBS[^\]]+\])(\s*</p>)?|', "$2", $insContent );
		$insContent = preg_replace( '|(<br />\s*)?(\[/?TBS[^\]]+\])(\s*</p>)?|', "$2", $insContent );
		
		return $insContent;
	}
	
	public function filterTheContentToFixNamedAnchors( $insContent = "" ) {		
		$sPattern = '/(<a\s+href=")(.*)(#TbsTabId[0-9]+">(.*)<\/a>)/';
		$insContent = preg_replace( $sPattern, '$1$3', $insContent );
		
		return $insContent;
	}
	
	/**
	 * name collision on "default"
	 */
	protected function def( &$aSrc, $insKey, $insValue = '' ) {
		if ( !isset( $aSrc[$insKey] ) ) {
			$aSrc[$insKey] = $insValue;
		}
	}

	protected function idHtml( $insId ) {
		return (($insId != '')? ' id="'.$insId.'" ' : '' );	
	}
	protected function noEmptyHtml( $insContent, $insAttr ) {
		return (($insContent != '')? ' '.$insAttr.'="'.$insContent.'" ' : '' );	
	}
	protected function noEmptyElement( &$inaArgs, $insAttrKey, $insElement = '' ) {
		$sAttrValue = $inaArgs[$insAttrKey];
		$insElement = ( $insElement == '' )? $insAttrKey : $insElement;
		$inaArgs[$insAttrKey] = ( empty($sAttrValue) ) ? '' : ' '.$insElement.'="'.$sAttrValue.'"';
	}
	
	/**
	 * Only implemented for possible future customisation
	 * @param unknown_type $insContent
	 */
	protected function doShortcode( $insContent ) {
		return do_shortcode( $insContent );
	}

	/**
	 * DEPRECATED: To BE EVENTUALLY REMOVED AS UNSUPPORTED IN Twitter Bootstrap 2+
	 * 
	 * Uses alert() function but just adds the class "block-message"
	 * 
	 * class may be one of: error, warning, success, info
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function block( $inaAtts = array(), $insContent = '' ) {
		return '<strong>Warning: You are using a deprecated shortcode. Please replace your [TBS_BLOCK] with [TBS_ALERT class="alert-block"]</strong>';
	}

	/**
	 * DEPRECATED: To BE EVENTUALLY REMOVED AS UNSUPPORTED IN Twitter Bootstrap 2+
	 * 
	 * Options for 'placement' are above | below | left | right
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function twipsy( $inaAtts = array(), $insContent = '' ) {
		/* return $this->tooltip($inaAtts, $insContent); */
		return '<strong>Warning: You are using a deprecated shortcode. Please replace your [TBS_TWIPSY] with [TBS_TOOLTIP]</strong>';
	}
	
}//class HLT_BootstrapShortcodes
