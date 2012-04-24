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

include_once( dirname(__FILE__).'/widgets/bootstrapcss_widgets.php' );

function getLessDownloadLink() {
	
}//getLessDownloadLink

function getIsHexColour($insColour) {
	return preg_match( '/^#[a-fA-F0-9]{3,6}$/', $insColour );
}

function getBootstrapOptionSpan( $inaBootstrapOption, $iSpanSize, $fEnabled ) {
	
	list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName, $sLessHelpText ) = $inaBootstrapOption;
	
	if ( $sLessKey == 'spacer' ) {
		$sHtml = '
			<div class="span'.$iSpanSize.'">
			</div>
		';
	} else {
	
		$sHtml = '
			<div class="span'.$iSpanSize.'">
				<div class="control-group">
					<label class="control-label" for="hlt_'.$sLessKey.'">'.$sLessHumanName.'<br /></label>
					<div class="controls">
						<label>
		';
		$sAdditionalClass = '';
		$sToggleTextInput = '';
		$sChecked = '';
		if ( $sLessOptionType == 'color' ) {
			if ( !getIsHexColour( $sLessSaved ) ) {
				$sChecked = ' checked';
			}
			$sToggleTextInput = ' <span class="toggle_checkbox"><label><input type="checkbox" name="hlt_toggle_'.$sLessKey.'" id="hlt_toggle_'.$sLessKey.'"'.$sChecked.' style="vertical-align: -2px;" '.($fEnabled ? '':' disabled').'/> edit as text</label></span>';
		}
	
		$sHtml .= '
							<input class="span2'.$sAdditionalClass.'" type="text" placeholder="'.esc_attr( $sLessSaved ).'" name="hlt_'.$sLessKey.'" value="'.esc_attr( $sLessSaved ).'" id="hlt_'.$sLessKey.'"'.($fEnabled ? '':' disabled').' />
						</label>
							 
						<p class="help-block"></p>
					</div><!-- controls -->
					<div class="help_section">
						<span class="label label-less-name">@'.str_replace( HLT_BootstrapLess::$LESS_PREFIX, '', $sLessKey ).'</span>
						'.$sToggleTextInput.'
						<span class="label label-less-name">'.$sLessDefault.'</span> 
					</div>
				</div><!-- control-group -->
			</div>
		';
	}
	
	echo $sHtml;
}

?>
<div class="wrap">
	<style type="text/css">
		.bootstrap-wpadmin .row.row_number_1 {
			padding-top: 18px;
		}
		.bootstrap-wpadmin .span4 {
			width: 325px;
		}
		.bootstrap-wpadmin .control-group {
			border: 1px dashed #DDDDDD;
			border-radius: 8px;
			padding: 10px;
		}
		.bootstrap-wpadmin .control-group:hover {
			background-color: #f8f8f8;
		}
		.bootstrap-wpadmin .control-group .control-label {
			font-weight: bold;
			font-size: 12px;
			width: 150px;
		}
		.bootstrap-wpadmin .control-group span.label-less-name {
			font-weight: normal;
			font-size: 11px;
			display: block;
			margin-bottom: 2px;
			clear: both;
			float: left;
		}
		.bootstrap-wpadmin .control-group .controls {
		}
		.bootstrap-wpadmin .control-group .option_section {
			border: 1px solid transparent;
		}
		.help_section  {
			padding-top: 8px;
			border-top: 1px solid #DDDDDD;
			margin-top: 15px;
		}
		.toggle_checkbox {
			float:right;
		}
	</style>
	<script type="text/javascript">
		function triggerColor( inoEl ) {
			var $ = jQuery;
			
			var $oThis = $( inoEl );
			var aParts = $oThis.attr( 'id' ).split( '_' );
			
			var $oColorInput = $( '#hlt_less_'+ aParts[3] );
			
			if ( $oThis.is( ':checked' ) ) {
				$oColorInput.miniColors( 'destroy' );
				$oColorInput.css( 'width', '130px' );
			}
			else {
				$oColorInput.miniColors();
				$oColorInput.css( 'width', '100px' );
			}
		}
	
		jQuery( document ).ready(
			function() {
				var $ = jQuery;

				$( 'input[name^=hlt_toggle_less]' ).on( 'click',
					function() {
						triggerColor( this );
					}
				);

				$( 'input[name^=hlt_toggle_less]' ).each(
					function( index, el ) {
						triggerColor( this );
					}
				);

				//.miniColors().css( 'width', '100px' );
			}
		);
	</script>
	
	<div class="bootstrap-wpadmin">
		<div class="page-header">
			<a href="http://worpit.com/"><div class="icon32" id="worpit-icon">&nbsp;</div></a>
			<h2><?php _hlt_e( 'LESS Compiler :: Twitter Bootstrap Plugin from Worpit' ); ?></h2>
		</div>

		<div class="row">
			<div class="span12">
				<?php
				if ( !$hlt_compiler_enabled ) {
					?><div class="alert alert-error">You need to <a href="admin.php?page=hlt-directory-bootstrap-css">enable the LESS compiler option</a> before using this section.</div><?php
				}
				else {
					?><div class="alert alert-info">Customize the twitter bootstrap options below to tweak the appearance of your website.</div><?php
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="span9 <?php echo ( $hlt_compiler_enabled? 'enabled_section': 'disabled_section' ); ?>">
				<form method="post" action="<?php echo $hlt_form_action; ?>" class="form-horizontal">
					<?php
					$sOptionValue;
					foreach ( $hlt_less_options as $sLessOptionSectionName => $aLessSectionOptions ) {
						
						$rowCount = 1;
						echo '
							<div class="row">
								<div class="span9" style="margin-left:0px">
									<fieldset>
										<legend>'.$sLessOptionSectionName.'</legend>
						';
						
						$iFieldCount = 0;
						foreach ( $aLessSectionOptions as $aLessOption ) {
							
							if ( $iFieldCount == 0 ) {
								echo '
								<div class="row row_number_'.$rowCount.'">';
							}
							echo getBootstrapOptionSpan( $aLessOption, 4, $hlt_compiler_enabled );
				
							if ( $iFieldCount == 1 ) {
								echo '
								</div> <!-- / options row -->';
								$rowCount++;
							}
							$iFieldCount = ($iFieldCount + 1) % 2;
				
						}//foreach option
				
						if ( $iFieldCount == 1 ) {
							echo '
							</div> <!-- / options row -->';
						}
						
						echo '
									</fieldset>
								</div>
							</div>
						';
					
						//ensure the intermediate save button is not printed at the end.
						end($hlt_less_options);
						$skey = key($hlt_less_options);
						if ( $sLessOptionSectionName != $skey ) {
							echo '
								<div class="form-actions">
									<button type="submit" class="btn btn-primary" name="submit" '.($hlt_compiler_enabled ? '':' disabled').'>'. _hlt__( 'Save All Settings' ).'</button>
								</div>
							';
						}
				
					}//foreach section
					?>
					<div class="form-actions">
						<input type="hidden" name="hlt_less_option" value="Y" />
						<button type="submit" class="btn btn-primary" name="submit" <?php echo ($hlt_compiler_enabled ? '':' disabled'); ?>><?php _hlt_e( 'Save All Settings' ); ?></button>
						<button type="submit" class="btn btn-danger" name="submit_reset"  <?php echo ($hlt_compiler_enabled ? '':' disabled'); ?>><?php _hlt_e( 'Reset All To Defaults' ); ?></button>
						<a class="btn btn-inverse" name="download_less_css" <?php echo ( file_exists( $hlt_less_file_location[0] ) ? 'href="'.$hlt_less_file_location[1].'"' :' disabled'); ?>><?php _hlt_e( 'Download Compiled CSS' ); ?></a>	
					</div>
				</form>
			</div><!-- / span9 -->
			<div class="span3" id="side_widgets">
	  			<?php echo getWidgetIframeHtml( 'side-widgets' ); ?>
			</div>
		</div>
	</div><!-- / bootstrap-wpadmin -->
</div><!-- / wrap -->