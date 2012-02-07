<?php

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

class HLT_BootstrapShortcodes {

	public function __construct() {
		$aMethods = get_class_methods( $this );
		$aExclude = array( 'idHtml', 'def', 'noEmptyHtml' );
		foreach ( $aMethods as $sMethod ) {
			if ( !in_array( $sMethod, $aExclude ) ) {
				add_shortcode( 'TBS_'.strtoupper( $sMethod ), array( &$this, $sMethod ) );
			}
		}

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
	 * Prints the necessary HTML for Twitter Bootstrap Labels
	 * 
	 * Class may be one of: Primary Default Info Success Danger
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function button( $inaAtts = array(), $insContent = '' ) {
		
		$sElementType = 'a';  
		if ( !isset( $inaAtts['link'] ) ) {
			$sElementType = 'button';
		}

		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class', 'default' );
		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'link_title' );
		$this->def( &$inaAtts, 'value', '0' );

		$sReturn = '<'.$sElementType.' '.$this->noEmptyHtml( $inaAtts['style'], 'style' ).' class="btn '.$inaAtts['class']. '"'.$this->idHtml( $inaAtts['id'] );

		if ( $sElementType == 'a' ) {
			$sReturn .= ' href="'.$inaAtts['link'].'" title="' .$inaAtts['link_title']. '"';
		}
		else {
			$sReturn .= ' type="button" value="'.$inaAtts['value']. '"';
		}
		
		$sReturn .= '>'.$insContent.'</'.$sElementType.'>';
		
		return $this->doShortcode( $sReturn );
	}
	
	/**
	 * Prints the necessary HTML for Twitter Bootstrap Labels
	 * 
	 * class may be one of: default, success, warning, important, notice
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function label( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );

		$sReturn = '<span '.$this->noEmptyHtml( $inaAtts['style'], 'style' ).' class="label '.$inaAtts['class'].'"'.$this->idHtml( $inaAtts['id'] ).'>'.$insContent.'</span>';

		return $this->doShortcode( $sReturn );
	}

	public function blockquote( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'source' );
		
		if ($inaAtts['source'] != '') {
			$inaAtts['source'] = '<small>'.$inaAtts['source'].'</small>';
		}
	
		$sReturn = '<blockquote '.$this->noEmptyHtml( $inaAtts['style'], 'style' ).' '.$this->noEmptyHtml( $inaAtts['class'], 'class' ).' '.$this->idHtml( $inaAtts['id'] ).'><p>'.$insContent.'</p>'.$inaAtts['source'].'</blockquote>';
		
		return $this->doShortcode( $sReturn );
	}

	/**
	 * class may be one of: error, warning, success, info
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function alert( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
	
		$sReturn = '<div '.$this->noEmptyHtml( $inaAtts['style'], 'style' )
					.' class="alert-message '.$inaAtts['class'].'" '
					.$this->noEmptyHtml( $inaAtts['id'], 'id' ).'>'.$insContent.'</div>';
		
		return $this->doShortcode( $sReturn );
	}

	/**
	 * Uses alert() function but just adds the class "block-message"
	 * 
	 * class may be one of: error, warning, success, info
	 * 
	 * @param $inaAtts
	 * @param $insContent
	 */
	public function block( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		
		return $this->doShortcode( '[TBS_ALERT '.'class="block-message '
									.$inaAtts['class'].'" '
									.$this->noEmptyHtml( $inaAtts['id'], 'id' ).' '
									.$this->noEmptyHtml( $inaAtts['style'], 'style' ).']'.$insContent.'[/TBS_ALERT]' );
	}
	
	public function code( $inaAtts = array(), $insContent = '' ) {
		
		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );

		$sReturn = '<pre class="prettyprint linenums" '.$this->idHtml( $inaAtts['id'] ).' '.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>'.$insContent.'</pre>';

		return $sReturn;
	}
	
	public function twipsy( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'placement', 'above' );
		$this->def( &$inaAtts, 'title' );

		$sReturn = $insContent;
		if ( $inaAtts['title'] != '' ) {
			$sReturn = '<span'
					.' rel="twipsy" data-placement="'.$inaAtts['placement'].'" data-original-title="'.$inaAtts['title'].'"'
					.$this->noEmptyHtml( $inaAtts['id'], 'id' )
					.$this->noEmptyHtml( $inaAtts['class'], 'class' )
					.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>'.$insContent.'</span>';
		}
		
		return $this->doShortcode( $sReturn );
	}
	
	public function tooltip( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'placement', 'top' );
		$this->def( &$inaAtts, 'title' );

		$sReturn = $insContent;
		if ( $inaAtts['title'] != '' ) {
			$sReturn = '<span'
					.' rel="tooltip" data-animation="true" data-placement="'.$inaAtts['placement'].'" data-original-title="'.$inaAtts['title'].'"'
					.$this->noEmptyHtml( $inaAtts['id'], 'id' )
					.$this->noEmptyHtml( $inaAtts['class'], 'class' )
					.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>'.$insContent.'</span>';
		}
		
		return $this->doShortcode( $sReturn );
	}
	
	public function popover( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'placement', 'right' );
		$this->def( &$inaAtts, 'title' );
		$this->def( &$inaAtts, 'content' );

		$sReturn = '<span'
					.' data-popover="popover" data-placement="'.$inaAtts['placement'].'" title="'.$inaAtts['title'].'"'
					.' data-content="'.$inaAtts['content'].'"'
					.$this->noEmptyHtml( $inaAtts['id'], 'id' )
					.$this->noEmptyHtml( $inaAtts['class'], 'class' )
					.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>'.$this->doShortcode( $insContent ).'</span>';

		return $sReturn;
	}
	
	public function dropdown( $inaAtts = array(), $insContent = '' ) {
		$this->def( &$inaAtts, 'name', 'Undefined' );
		
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
		$this->def( &$inaAtts, 'name', 'Undefined' );
		$this->def( &$inaAtts, 'link', '#' );
		
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
		if ( preg_match_all( '/\[TBS_TAB([^\]]*)\]/', $insContent, &$aMatches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
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
					if ( !preg_match_all( '/\[TBS_DROPDOWN_OPTION([^\]]*)\]/', $sRemainder, &$aSubMatches, PREG_SET_ORDER ) ) {
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
			<ul class="tabs" data-tabs="tabs">
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
		$this->def( &$inaAtts, 'page_id', 0 );
		$this->def( &$inaAtts, 'type', 'page' ); // can be either page or dropdown
		
		// If this value is never not set, then the tabgroup method didn't do it's job!
		$this->def( &$inaAtts, 'id', 'TbsTabId_' );
		
		// Actually not used as the tab name is used by the TabGroup
		$this->def( &$inaAtts, 'name', 'Undefined' );
		
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
	
	public function row( $inaAtts = array(), $insContent = '' ) {
	
		$sReturn = '<div class="container">	<div class="row">';
		$sReturn .= $this->doShortcode( $insContent );
		$sReturn .= '</div></div>';
		
		return $sReturn;
	}//row
	
	public function column( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'size', 1 );
		$this->def( &$inaAtts, 'style' );
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		
		$sReturn = '<div class="span'.$inaAtts['size'].' '.$inaAtts['class']. '"'
					.$this->noEmptyHtml( $inaAtts['id'], 'id' )
					.$this->noEmptyHtml( $inaAtts['style'], 'style' ).'>';
		$sReturn .= $this->doShortcode( $insContent );
		$sReturn .= '</div>';
		
		return $sReturn;
	}//row

	/**
	 * Public, but should never be directly accessed other than by the WP add_filter method. 
	 * @param $insContent
	 */
	public function filterTheContent( $insContent = "" ) {		
		// Remove <p>'s that get added to [TBS...] by wpautop.
		$insContent = preg_replace( '|(<p>\s*)?(\[/?TBS[^\]]+\])(\s*</p>)?|', "$2", $insContent );
		
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
	
	/**
	 * Only implemented for possible future customisation
	 * @param unknown_type $insContent
	 */
	protected function doShortcode( $insContent ) {
		return do_shortcode( $insContent );
	}
	
}