
<?php

function getIsHexColour($insColour) {
	
	return preg_match( '/^#[a-fA-F0-9]{3,6}$/', $insColour );
}

function getBootstrapOptionSpan( $inaBootstrapOption, $iSpanSize, $fEnabled ) {
	
	list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName, $sLessHelpText ) = $inaBootstrapOption;
	
	$sHtml = '
		<div class="span'.$iSpanSize.'">
			<div class="control-group">
				<label class="control-label" for="hlt_'.$sLessKey.'">'.$sLessHumanName.'</label>
				<div class="controls">
						<label>
		';
	$sAdditionalClass = '';
	$sToggleTextInput = '';
	if ( $sLessOptionType == 'color' && getIsHexColour($sLessSaved) ) {
		$sAdditionalClass = ' color';
		$sToggleTextInput = ' <input type="checkbox" name="hlt_toggle_'.$sLessKey.'" id="hlt_toggle_'.$sLessKey.'" style="vertical-align: -2px;"/> Text?';
	}

	$sHtml .=
	'						<input class="span2'.$sAdditionalClass.
							'" type="text" name="hlt_'.$sLessKey.'" value="'.esc_attr($sLessSaved).'" id="hlt_'.$sLessKey.'"'.($fEnabled ? '':' disabled').' />'
							.$sToggleTextInput.'
						</label>
						 
						<p class="help-block">'._hlt__( sprintf( "LESS name: @%s", str_replace( HLT_BootstrapLess::$LESS_PREFIX, '', $sLessKey ) ) ).'</p>
				</div>
			</div>
		</div>
	';
	
	echo $sHtml;
}

?>

<div class="wrap">

	<style>
		.row.row_number_1 {
			padding-top: 18px;
		}
		.control-group {
			border: 1px solid #eeeeee;
			border-radius: 8px;
			padding: 10px;
		}
		.control-group:hover {
			background-color: #f8f8f8;
		}
		.control-group .control-label {
			font-weight: bold;
		}
		.control-group .option_section {
			border: 1px solid transparent;
		}
	</style>

	<div class="page-header">
		<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
		<h2><?php _hlt_e( 'Host Like Toast: WordPress Twitter Bootstrap LESS Compiler' ); ?></h2>
	</div>
	
	<div class="bootstrap-wpadmin">
		<form class="form-horizontal" method="post" action="<?php echo $hlt_form_action; ?>">
			<div class="row">
				<div class="span10">
<?php
	if (!$hlt_compiler_enabled) {
		echo '
			<div class="alert alert-error" style="margin-top: 18px;">You need to <a href="admin.php?page=hlt-directory-bootstrap-css">enable the LESS compiler option</a> before using this section.</div>
		';
	} else {
		echo '
			<div class="alert alert-info" style="margin-top: 18px;">Customize the options below to tweak the appearance of your website.</div>
		';
	}

?>
				</div>
			</div>
<?php
	$sOptionValue;
	foreach ($hlt_less_options as $sLessOptionSectionName => $aLessSectionOptions) {
		
		$rowCount = 1;
		echo '
			<div class="row">
				<div class="span10">
					<fieldset>
						<legend>'.$sLessOptionSectionName.'</legend>
		';
		
		$iFieldCount = 0;
		foreach ($aLessSectionOptions as $aLessOption) {
			
			if ( $iFieldCount == 0 ) {
				echo '
				<div class="row row_number_'.$rowCount.'">';
			}
			echo getBootstrapOptionSpan( $aLessOption, 5, $hlt_compiler_enabled );

			if ( $iFieldCount == 1 ) {
				echo '
				</div> <!-- / options row -->';
				$rowCount++;
			}
			$iFieldCount = ($iFieldCount + 1) % 2;

		}//foreach option

		if ( $iFieldCount == 1 ) {
			echo '
			</div> <!-- / options row -->	';
		}
		
		echo '
					</fieldset>
				</div>
			</div>
		';

	}//foreach section

?>

			<div class="form-actions">
				<input type="hidden" name="hlt_less_option" value="Y" />
				<button type="submit" class="btn btn-primary" name="submit" <?php echo ($hlt_compiler_enabled ? '':' disabled'); ?>><?php _hlt_e( 'Save all changes' ); ?></button>
				<button type="submit" class="btn btn-danger" name="submit_reset"><?php _hlt_e( 'Reset all values to original defaults' ); ?></button>
			</div>
		</form>
	</div><!-- / bootstrap-wpadmin -->
</div><!-- / wrap -->