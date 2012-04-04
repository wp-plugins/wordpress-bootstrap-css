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
	
	protected $m_aAllBootstrapLessOptions;
	
	public function __construct() {
		
		$this->m_aAllBootstrapLessOptions = array (
		
				array( 'less_textColor',				'', '#333',						'color',		'Text Colour' ), //@grayDark
				array( 'less_primaryButtonBackground',	'', '#08c',						'color',		'Primary Button Colour' ), //@linkColor
				array( 'less_linkColor',				'', '#08c',						'color',		'Link Colour' ),
				array( 'less_linkColorHover',			'', '#08c',						'color',		'Link Hover Colour' ), //darken(@linkColor, 15%)
				array( 'less_blue',						'', '#049cdb',					'color',		'Blue' ),
				array( 'less_blueDark',					'', '#0064cd',					'color',		'Dark Blue' ),
				array( 'less_green',					'', '#46a546',					'color',		'Green' ),
				array( 'less_red',						'', '#9d261d',					'color',		'Red' ),
				array( 'less_yellow',					'', '#ffc40d',					'color',		'Yellow' ),
				array( 'less_orange',					'', '#f89406',					'color',		'Orange' ),
				array( 'less_pink',						'', '#c3325f',					'color',		'Pink' ),
				array( 'less_purple',					'', '#7a43b6',					'color',		'Purple' ),
				array( 'less_baseFontSize',				'', '13px',						'size',			'Font Size' ),
				array( 'less_baseLineHeight',			'', '18px',						'size',			'Base Line Height' ),
				array( 'less_baseFontFamily',			'', '"Helvetica Neue", Helvetica, Arial, sans-serif',	'font',		'Font Family' )
		);
		
	}//__construct
	
	public function getAllBootstrapLessOptions() {
		return $this->m_aAllBootstrapLessOptions;
	}//getAllBootstrapLessOptions
	
}//HLT_BootstrapLess