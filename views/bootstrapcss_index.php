<style type="text/css">
	.inside p.desc {
		margin-left: 20px;
		font-style: italic;
		margin-top: 4px;
	}
</style>

<div class="wrap">
	<a href="http://hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br></div></a>
	<h2>Host Like Toast: Bootstrap CSS</h2>
	
	<div style="width:70%;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<form method="post" action="<?php echo $hlt_form_action; ?>">
					<div class="postbox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap Option</span></h3>
						<div class="inside">
							<p><strong>Choose which type of bootstrap CSS you would like installed.</strong></p>
							
							<input type="radio" name="hlt_bootstrap_option" value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>checked="checked"<?php endif;?> />
							<label for="hlt-none">None</label>
							<br class="clear">
							<p class="desc" style="display: block;">Nothing will be applied. Effectively the same as deactivating the plugin.</p>
							
							<input type="radio" name="hlt_bootstrap_option" value="yahoo-reset" id="hlt-yahoo-reset" <?php if ( $hlt_option == 'yahoo-reset' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-yahoo-reset">Yahoo UI Reset CSS</label>
							<br class="clear">
							<p class="desc" style="display: block;">YahooUI Reset CSS is a basic reset for all browsers.</p>
							
							<input type="radio" name="hlt_bootstrap_option" value="normalize" id="hlt-normalize" <?php if ( $hlt_option == 'normalize' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-normalize">Normalize CSS</label>
							<br class="clear">
							<p class="desc" style="display: block;">Normalize CSS description and link.</p>
							
							<input type="radio" name="hlt_bootstrap_option" value="twitter" id="hlt-twitter" <?php if ( $hlt_option == 'twitter' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-twitter">Twitter Bootstrap CSS</label>
							<br class="clear">
							<p class="desc" style="display: block;">Twitter bootsrap description with links etc.</p>
							
							<p><strong>Extra</strong></p>
							<input type="checkbox" name="hlt_bootstrap_hotlink" value="Y" id="hlt-hotlink" <?php if ( $hlt_hotlink == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-hotlink">Enable CSS Hotlinking.</label>
							<br class="clear">
							<p class="desc" style="display: block;">If you choose to hotlink your site will be relying on an external server. If that server goes down or the file becomes
							unavailable for any reason, your site will be affected -and may have a serious impact visually for your users. This option is not recommended.</p>
						</div>
					</div>
					
					<div class="submit"><input type="submit" value="Save Settings" name="submit" class="button-primary"></div>
				</form>
			</div>
		</div>
	</div>
	
	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>