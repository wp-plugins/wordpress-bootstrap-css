<div class="wrap">

	<div class="page-header">
		<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
		<h2><?php _hlt_e( 'Host Like Toast: WordPress Twitter Bootstrap LESS Compiler' ); ?></h2>
	</div>
	
	<div class="bootstrap-wpadmin">
		<form class="form-horizontal" method="post" action="<?php echo $hlt_form_action; ?>">
			<div class="row">
				<div class="span10">
					<fieldset>
						<legend><?php _hlt_e( 'Choose LESS options' ); ?></legend>
<?php 

	$sOptionName;
	$sOptionValue;
	$sOptionDefaultValue;
	$iFieldCount = 0;
	foreach ($hlt_less_options as $aLessOption) {
		$sOptionName = $aLessOption[0];
		$sOptionDefaultValue = $aLessOption[2];
		$sOptionValue = (empty($aLessOption[1]))? $sOptionDefaultValue : $aLessOption[1];
		
		if ( $iFieldCount == 0 ) {
			echo '<div class="row">';
		}

		echo '
				<div class="span5">
						<div class="control-group">
							<label class="control-label" for="hlt_'.$sOptionName.'">'.$aLessOption[4].'</label>
							<div class="controls">
								<div>
									<label class="checkbox">
										<input class="span2'.
										($aLessOption[3] == 'color'? ' color' : '')
										.'" type="text" name="hlt_'.$sOptionName.'" value="'.esc_attr($sOptionValue).'" id="hlt_'.$sOptionName.'" />
									</label>
									<p class="help-block">
										Some help
									</p>
								</div>
							</div>
						</div>
				</div>
		';
		if ( $iFieldCount == 1 ) {
			echo '</div> <!-- / row -->';
		}
		$iFieldCount = ($iFieldCount + 1) % 2;
	}
	if ( $iFieldCount == 1 ) {
		echo '</div>';
	}

?>

						<div class="form-actions">
							<input type="hidden" name="hlt_less_option" value="Y" />
							<button type="submit" class="btn btn-primary" name="submit"><?php _hlt_e( 'Save all changes' ); ?></button>
							<button type="submit" class="btn btn-danger" name="submit_reset"><?php _hlt_e( 'Reset all values to original defaults' ); ?></button>
						</div>
					</fieldset>
				</div>
			</div>
		</form>
	</div>
</div>