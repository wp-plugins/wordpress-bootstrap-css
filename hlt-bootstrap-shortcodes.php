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
		$aExclude = array( 'idHtml', 'def' );
		foreach ( $aMethods as $sMethod ) {
			if ( !in_array( $sMethod, $aExclude ) ) {
				add_shortcode( 'TBS_'.strtoupper( $sMethod ), array( &$this, $sMethod ) );
			}
		}
	}
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function button( $inaAtts = array(), $insContent = '' ) {
		
		$sElementType = 'a';  
		if ( !isset( $inaAtts['link'] ) ) {
			$sElementType = 'button';
		}
		
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class', 'default' );
		$this->def( &$inaAtts, 'link_title' );
		$this->def( &$inaAtts, 'value', '0' );
		
		$sReturn = '<div class="hlt_bs_button"><'.$sElementType.' class="btn '.$inaAtts['class']. '"'.$this->idHtml( $inaAtts['id'] );
		
		if ( $sElementType == 'a' ) {
			$sReturn .= ' href="'.$inaAtts['link'].'" title="' .$inaAtts['link_title']. '">'.$insContent.'</a>';
		}
		else {
			$sReturn .= ' type="button" value="'.$inaAtts['value']. '">'.$insContent.'</a>';
		}
		
		$sReturn .= '</div>';
		
		return $sReturn;
	}//button
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function label( $inaAtts = array(), $insContent = '' ) {
	
		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
	
		$sReturn = '<span class="label '.$inaAtts['class'].'"'.$this->idHtml( $inaAtts['id'] ).'>'.$insContent.'</span>';
		
		return $sReturn;
	}//label
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function block( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
	
		$sReturn = '<div class="alert-message block-message '.$inaAtts['class'].'"'.$this->idHtml( $inaAtts['id'] ).'>'.$insContent.'</div>';
		
		return $sReturn;
	}//blockmessage
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function code( $inaAtts = array(), $insContent = '' ) {
		
		$this->def( &$inaAtts, 'id' );

		$sReturn = '<pre class="prettyprint linenums"'.$this->idHtml( $inaAtts['id'] ).'>'.$insContent.'</pre>';

		return $sReturn;
	}//code
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function twipsy( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'placement', 'top' );
		$this->def( &$inaAtts, 'title' );
	
		$sReturn = '<a href="#" rel="twipsy" placement="'.$inaAtts['placement'].'" title="'.$inaAtts['title'].'"'.$this->idHtml( $inaAtts['id'] ).'>'.$insContent.'</a>';
		
		return $sReturn;
	}//twipsy
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	public function popover( $inaAtts = array(), $insContent = '' ) {

		$this->def( &$inaAtts, 'id' );
		$this->def( &$inaAtts, 'class' );
		$this->def( &$inaAtts, 'placement', 'above' );
		$this->def( &$inaAtts, 'title' );
		$this->def( &$inaAtts, 'content' );
		
		$sReturn = trim( '
			<a href="#" rel="popover" class="'.$inaAtts['class']. '" '.$this->idHtml( $inaAtts['id'] )
				.'placement="'.$inaAtts['placement'].'" title="'.$inaAtts['title'].'" content="'.$inAtts['content'].'">'.$insContent.'</a>'
		);
	
		return $sReturn;
	}//popover

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
	
}//class