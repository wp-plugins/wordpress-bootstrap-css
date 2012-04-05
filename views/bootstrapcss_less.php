
<?php 

function getBootstrapOptionSpan( $inaBootstrapOption, $iSpanSize, $fEnabled ) {
	
	list( $sLessKey, $sLessSaved, $sLessDefault, $sLessOptionType, $sLessHumanName ) = $inaBootstrapOption;
	
	echo '
		<div class="span'.$iSpanSize.'">
			<div class="control-group">
				<label class="control-label" for="hlt_'.$sLessKey.'">'.$sLessHumanName.'</label>
				<div class="controls">
					<div>
						<label class="checkbox">
							<input class="span2'
							.($sLessOptionType == 'color'? ' color' : '').
							'" type="text" name="hlt_'.$sLessKey.'" value="'.esc_attr($sLessSaved).'" id="hlt_'.$sLessKey.'"'.($fEnabled ? '':' disabled').' />
						</label>
						<p class="help-block">
							Some help
						</p>
					</div>
				</div>
			</div>
		</div>
	';	
}

?>

<div class="wrap">

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
				<div class="row">';
			}
			echo getBootstrapOptionSpan( $aLessOption, 5, $hlt_compiler_enabled );

			if ( $iFieldCount == 1 ) {
				echo '
				</div> <!-- / options row -->';
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