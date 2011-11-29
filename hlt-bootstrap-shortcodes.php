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

	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_button( $atts=array(), $content = '' ) {
		
		$sElementType = 'a';
	
		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		if ( !isset( $atts['class'] ) ) {
			$atts['class'] = 'default';
		}
		if ( !isset( $atts['link'] ) ) {
			$sElementType = 'button';
		}
		if ( !isset( $atts['link_title'] ) ) {
			$atts['link_title'] = '';
		}
		if ( !isset( $atts['value'] ) ) {
			$atts['value'] = '0';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );
		
		$sReturn ='<div class="hlt_bs_button"><' .$sElementType. ' class="btn ' .$atts['class']. '"'. $atts['id'];
		
		if ($sElementType == 'a') {
			$sReturn.= ' href="' .$atts['link']. '" title="' .$atts['link_title']. '>' .$content. '</a>';
		} else {
			$sReturn.= ' type="button" value="' .$atts['value']. '>' .$content. '</a>';
		}
		
		$sReturn .= '</div>';
		
		return $sReturn;
	}//print_bootstrap_button
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_label( $atts=array(), $content = '' ) {
	
		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		if ( !isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );
	
		$sReturn = '<span class="label ' .$atts['class']. '"'. $atts['id'] .'>' .$content. '</span>';
		
		return $sReturn;
	}//print_bootstrap_label
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_blockmessage( $atts=array(), $content = '' ) {

		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		if ( !isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );
	
		$sReturn = '<div class="alert-message block-message ' .$atts['class']. '"'.
					$atts['id'] .'>' .$content. '</div>';
		
		return $sReturn;
	}//print_bootstrap_blockmessage
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_code( $atts=array(), $content = '' ) {
	
		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );

		$sReturn = '<pre class="prettyprint linenums"'. $atts['id'] .'>' .$content. '</pre>';

		return $sReturn;
	}//print_bootstrap_code
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_tooltips( $atts=array(), $content = '' ) {

		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		if ( !isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}
		if ( !isset( $atts['placement'] ) ) {
			$atts['placement'] = 'top';
		}
		if ( !isset( $atts['title'] ) ) {
			$atts['title'] = '';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );
	
		$sReturn = '<a href="#" rel="twipsy" placement="' .$atts['placement']. '" title="' .$atts['title']. '"'.
					 $atts['id'] .'>' .$content. '</a>';
		
		return $sReturn;
	}//print_bootstrap_tooltips
	
	/**
	 * 
	 * @param $atts
	 * @param $content
	 */
	function print_bootstrap_popover( $atts=array(), $content = '' ) {

		if ( !isset( $atts['id'] ) ) {
			$atts['id'] = '';
		}
		if ( !isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}
		if ( !isset( $atts['placement'] ) ) {
			$atts['placement'] = 'above';
		}
		if ( !isset( $atts['title'] ) ) {
			$atts['title'] = '';
		}
		if ( !isset( $atts['content'] ) ) {
			$atts['content'] = '';
		}
		$atts['id'] = (($atts['id'] != '')? ' id="' .$atts['id']. '"' : '' );
	
		$sReturn = '<a href="#" rel="popover" class="' .$atts['class']. '"'. $atts['id'] .
					' placement="' .$atts['placement']. '" title="' .$atts['title']. '" content="' .$atts['content']. '">' .$content. '</a>';
	
		return $sReturn;
	}//print_bootstrap_popover

}//class