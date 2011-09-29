<style type="text/css">
	.inside p.desc {
		margin-left: 20px;
		font-style: italic;
		margin-top: 4px;
	}
</style>

<div class="wrap">
	<a href="http://hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
	<h2>Host Like Toast: Wordpress/Twitter Bootstrap CSS Options</h2>
	
	<div style="width:70%;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<form method="post" action="<?php echo $hlt_form_action; ?>">
					<div class="postbox" width>
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap CSS Option</span></h3>
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
							<p class="desc" style="display: block;">If you choose to hotlink, your site will be relying on external servers to deliver the files. If that server goes down
							or the file becomes	unavailable for any reason, your site will be affected visually. This option is not recommended.</p>
						</div>
					</div>
					<!-- <div class="submit"><input type="submit" value="Save Settings" name="submit" class="button-primary"></div> -->

					<div class="postbox" id="BootstrapJavascript">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap Javascript Include Options</span></h3>
						<div class="inside">
							<p><strong>Choose which of the following Twitter Bootstrap Javascript libraries you would like included on your site. Note: they are all (currently) hotlinked to the Github repository.</strong></p>
							
							<input type="checkbox" name="hlt_bootstrap_option_alerts_js" value="Y" id="hlt-alerts-js" <?php if ( $hlt_option_alerts_js == 'Y' ): ?>checked="checked"<?php endif;?> />
							<label for="hlt-alerts-js">alerts.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Alerts' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#alerts" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_dropdown_js" value="Y" id="hlt-dropdown-js" <?php if ( $hlt_option_dropdown_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-dropdown-js">dropdown.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Dropdown' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#dropdown" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_modal_js" value="Y" id="hlt-modal-js" <?php if ( $hlt_option_modal_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-modal-js">modal.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Modal' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#modal" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_popover_js" value="Y" id="hlt-popover-js" <?php if ( $hlt_option_popover_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-popover-js">popover.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Popover' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#popover" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_scrollspy_js" value="Y" id="hlt-scrollspy-js" <?php if ( $hlt_option_scrollspy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-scrollspy-js">scrollspy.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Scrollspy' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#scrollspy" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_tabs_js" value="Y" id="hlt-tabs-js" <?php if ( $hlt_option_tabs_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-tabs-js">tabs.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Tabs' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#tabs" target="_blank">more info</a>]</p>
							
							<input type="checkbox" name="hlt_bootstrap_option_twipsy_js" value="Y" id="hlt-twipsy-js" <?php if ( $hlt_option_twipsy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-twipsy-js">twipsy.js</label>
							<br class="clear">
							<p class="desc" style="display: block;">Include the 'Bootstrap Twipsy' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#twipsy" target="_blank">more info</a>]</p>

							<p><strong>Extra</strong></p>
							<input type="checkbox" name="hlt_bootstrap_option_js_head" value="Y" id="hlt-js-head" <?php if ( $hlt_option_js_head == 'Y' ): ?>checked="checked"<?php endif; ?> />
							<label for="hlt-js-head">Place Javascript in the &lt;HEAD&gt; section.</label>
							<br class="clear">
							<p class="desc" style="display: block;">By default, Javascript libraries should be placed at the end of the &lt;BODY&gt; section.
							If you have a need to put them in the &lt;HEAD&gt; check this box.  Not recommended.</p>
						</div>
					</div>
					<div class="submit"><input type="submit" value="Save Settings" name="submit" class="button-primary"></div>
				</form>
			</div>
		</div>
	</div>
	
	<script>
	( function($) {
		$(document).ready(function(){
			$("input:radio[name='hlt_bootstrap_option']").click(function(){
				var radio_value = $(this).val();

				if(radio_value=='twitter') {
					$("#BootstrapJavascript").slideDown(150);
				} else {
					$("#BootstrapJavascript").slideUp(150);
				}
			});

			if ( $("#hlt-twitter").is(':checked') === false ) {
				$("#BootstrapJavascript").hide();
			}
			 
		});
	} ) ( jQuery );
	</script>

	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>