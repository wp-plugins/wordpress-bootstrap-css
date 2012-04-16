<?php
include_once( dirname(__FILE__).'/widgets/bootstrapcss_widgets.php' );

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
			<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon">&nbsp;</div></a>
			<h2><?php _hlt_e( 'Host Like Toast: WordPress Twitter Bootstrap LESS Compiler' ); ?></h2>
		</div>

		<div class="row">
			<div class="span12">
				<?php
				if ( !$hlt_compiler_enabled ) {
					?><div class="alert alert-error">You need to <a href="admin.php?page=hlt-directory-bootstrap-css">enable the LESS compiler option</a> before using this section.</div><?php
				}
				else {
					?><div class="alert alert-info">Customize the options below to tweak the appearance of your website.</div><?php
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
						<button type="submit" class="btn btn-danger" name="submit_reset"  <?php echo ($hlt_compiler_enabled ? '':' disabled'); ?>><?php _hlt_e( 'Reset all values to original defaults' ); ?></button>
					</div>
				</form>
			</div><!-- / span9 -->
			<div class="span3" id="side_widgets">
	  			<?php echo getWidgetIframeHtml( 'side-widgets' ); ?>
			</div>
		</div>
	</div><!-- / bootstrap-wpadmin -->
</div><!-- / wrap -->