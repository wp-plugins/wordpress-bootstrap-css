<style type="text/css">
	.inside p.desc {
		margin-left: 20px;
		font-style: italic;
		margin-top: 4px;
	}
	.submit span {
		font-size: smaller;
		font-style: italic;
	}
	.option_section {
		border: 1px solid transparent;
		border-radius: 5px 5px 5px 5px;
		margin-bottom: 8px;
		padding: 12px 10px 0px;
	}
	.option_section:hover {
	    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
	}
	.selected_item {
	    background-color: rgba(128, 255, 128, 0.2);
	    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
	}
	.selected_item label {
		font-weight: bold;
	}
	.nonselected_item {
		background-color: transparent;
	}
	.nonselected_item label {
		font-weight: normal;
	}
</style>

<div class="wrap">
	<a href="http://hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
	<h2>Host Like Toast: Wordpress/Twitter Bootstrap CSS Options</h2>
	
	<div style="width:60%;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<form method="post" action="<?php echo $hlt_form_action; ?>">
					<div class="postbox" id="ResetCssBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap CSS Option</span></h3>
						<div class="inside">
							<p><strong>Choose which type of bootstrap CSS you would like installed.</strong></p>

							<div class="option_section  <?php if ( $hlt_option == 'none' ): ?>selected_item<?php endif;?>" id="section-hlt-none">
								<input type="radio" name="hlt_bootstrap_option" value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>checked="checked"<?php endif;?> />
								<label for="hlt-none">None</label>
								<br class="clear">
								<p class="desc" style="display: block;">Nothing will be applied. Effectively the same as deactivating the plugin.</p>
							</div>
							
							<div class="option_section <?php if ( $hlt_option == 'yahoo-reset' ): ?>selected_item<?php endif;?>" id="section-hlt-yahoo-reset">
								<input type="radio" name="hlt_bootstrap_option" value="yahoo-reset" id="hlt-yahoo-reset" <?php if ( $hlt_option == 'yahoo-reset' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-yahoo-reset">Yahoo UI Reset CSS</label>
								<br class="clear">
								<p class="desc" style="display: block;">YahooUI Reset CSS is a basic reset for all browsers.</p>
							</div>
							
							<div class="option_section <?php if ( $hlt_option == 'normalize' ): ?>selected_item<?php endif;?>" id="section-hlt-normalize">
								<input type="radio" name="hlt_bootstrap_option" value="normalize" id="hlt-normalize" <?php if ( $hlt_option == 'normalize' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-normalize">Normalize CSS</label>
								<br class="clear">
								<p class="desc" style="display: block;">Normalize CSS description and link.</p>
							</div>
							
							<div class="option_section <?php if ( $hlt_option == 'twitter' ): ?>selected_item<?php endif;?>" id="section-hlt-twitter">
								<input type="radio" name="hlt_bootstrap_option" value="twitter" id="hlt-twitter" <?php if ( $hlt_option == 'twitter' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-twitter">Twitter Bootstrap CSS</label>
								<br class="clear">
								<p class="desc" style="display: block;">Bootstrap, from Twitter. [<a href="http://twitter.github.com/bootstrap/" target="_blank">more info</a>]</p>
							</div>
						</div>
					</div>

					<div class="postbox" id="BootstrapJavascript">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap Javascript Include Options</span></h3>
						<div class="inside">
							<p><strong>Choose which of the following Twitter Bootstrap Javascript libraries you would like included on your site.</strong></p>

							<div class="option_section <?php if ( $hlt_option_alerts_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-alerts-js">
								<input type="checkbox" name="hlt_bootstrap_option_alerts_js" value="Y" id="hlt-alerts-js" <?php if ( $hlt_option_alerts_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-alerts-js">alerts.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Alerts' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#alerts" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section <?php if ( $hlt_option_dropdown_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-dropdown-js">
								<input type="checkbox" name="hlt_bootstrap_option_dropdown_js" value="Y" id="hlt-dropdown-js" <?php if ( $hlt_option_dropdown_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-dropdown-js">dropdown.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Dropdown' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#dropdown" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section <?php if ( $hlt_option_modal_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-modal-js">
								<input type="checkbox" name="hlt_bootstrap_option_modal_js" value="Y" id="hlt-modal-js" <?php if ( $hlt_option_modal_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-modal-js">modal.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Modal' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#modal" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section <?php if ( $hlt_option_popover_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-popover-js">
								<input type="checkbox" name="hlt_bootstrap_option_popover_js" value="Y" id="hlt-popover-js" <?php if ( $hlt_option_popover_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-popover-js">popover.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Popover' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#popover" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section <?php if ( $hlt_option_scrollspy_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-scrollspy-js">
								<input type="checkbox" name="hlt_bootstrap_option_scrollspy_js" value="Y" id="hlt-scrollspy-js" <?php if ( $hlt_option_scrollspy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-scrollspy-js">scrollspy.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Scrollspy' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#scrollspy" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section <?php if ( $hlt_option_tabs_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-tabs-js">
								<input type="checkbox" name="hlt_bootstrap_option_tabs_js" value="Y" id="hlt-tabs-js" <?php if ( $hlt_option_tabs_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-tabs-js">tabs.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Tabs' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#tabs" target="_blank">more info</a>]</p>
							</div>

							<div class="option_section  <?php if ( $hlt_option_twipsy_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-twipsy-js">
								<input type="checkbox" name="hlt_bootstrap_option_twipsy_js" value="Y" id="hlt-twipsy-js" <?php if ( $hlt_option_twipsy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-twipsy-js">twipsy.js</label>
								<br class="clear">
								<p class="desc" style="display: block;">Include the 'Bootstrap Twipsy' Javascript library. [<a href="http://twitter.github.com/bootstrap/javascript.html#twipsy" target="_blank">more info</a>]</p>
							</div>
							
							<h4><strong>Extra</strong></h4>
							<div class="option_section <?php if ( $hlt_option_js_head == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-js-head">
								<input type="checkbox" name="hlt_bootstrap_option_js_head" value="Y" id="hlt-js-head" <?php if ( $hlt_option_js_head == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-js-head">Place Javascript in the &lt;HEAD&gt; section.</label>
								<br class="clear">
								<p class="desc" style="display: block;">By default, Javascript libraries should be placed at the end of the &lt;BODY&gt; section.
								If you have a need to put them in the &lt;HEAD&gt; check this box.  Not recommended.</p>
							</div>
						</div>
					</div>

					<div class="postbox" id="CustomCssOptionBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Add your own custom CSS</span></h3>
						<div class="inside">
							<p><strong>Enter the URL to a CSS file you would like included before all others (and immediately after the Bootstrap CSS above if selected).</strong></p>

							<div class="option_section <?php if ( $hlt_option_customcss == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-customcss">
								<input type="checkbox" name="hlt_bootstrap_option_customcss" value="Y" id="hlt-option-customcss" <?php if ( $hlt_option_customcss == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-option-customcss">Enable custom CSS link</label>
								<br class="clear">
								<p class="desc" style="display: block;">If you choose to link to your own custom CSS be sure to put the full URL path to the CSS file.
								If you're hotlinking to another site, ensure you have permission to do so.
								<br />This CSS link will be inserted immediately after the reset, normalize or Twitter Bootstrap CSS if any of these are selected.</p>
							</div>

							<label for="hlt-text-customcss-url">Custom CSS URL:</label><input id="customcss-url-input" type="text" name="hlt_bootstrap_text_customcss_url" id="hlt-text-customcss-url" size="100" value="<?php echo $hlt_text_customcss_url; ?>" style="margin-left:20px;"/>
							<br /><br class="clear">
						</div>
					</div>
					
					<div class="postbox" id="HotlinkOptionBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Resource Linking Option</span></h3>
						<div class="inside">
							<p><strong>Choose the method of linking to the CSS and Javascript. Note: Javascript is only applicable when you have selected Twitter Bootstrap.</strong></p>

							<div class="option_section <?php if ( $hlt_hotlink == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-hotlink">
								<input type="checkbox" name="hlt_bootstrap_hotlink" value="Y" id="hlt-hotlink" <?php if ( $hlt_hotlink == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-hotlink">Enable CSS and JS Hotlinking.</label>
								<br class="clear">
								<p class="desc" style="display: block;">If you choose to hotlink, your site will be relying on external servers to deliver both the CSS and JS files.
								If that server goes down or the file becomes unavailable for any reason, your site will be affected visually. This option is not recommended.</p>
							</div>
						</div>
					</div>

					<div class="submit"><input type="submit" value="Save Settings" name="submit" class="button-primary"><?php echo ( class_exists( 'W3_Plugin_TotalCacheAdmin' )? '<span> and flush W3 Total Cache</span>' : '' ); ?></div>
				</form>
			</div>
		</div>
	</div>
	
	<script>
	( function($) {
		$(document).ready(function(){
			
			$("input:radio[name='hlt_bootstrap_option']").click(function(){
				var radio_value = $(this).val();

				/* Show/Hide Bootstrap Javascript section on Twitter CSS selection */
				if(radio_value=='twitter') {
					$("#BootstrapJavascript").slideDown(150);
				} else {
					$("#BootstrapJavascript").slideUp(150);
				}

				/* Show/Hide Hotlink section on none/CSS selection */
				if(radio_value=='none') {
					$("#HotlinkOptionBox").slideUp(150);
				} else {
					$("#HotlinkOptionBox").slideDown(150);
				}
			});

			if ( $("#hlt-twitter").is(':checked') === false ) {
				$("#BootstrapJavascript").hide();
			}

			if ( $("#hlt-none").is(':checked') === false ) {
				$("#HotlinkOptionBox").show();
			} else {
				$("#HotlinkOptionBox").hide();
			}

			/* Enables/Disables the custom CSS text field depending on checkbox*/
			$("input[type=checkbox][name='hlt_bootstrap_option_customcss']").click(function(){
				$("#customcss-url-input").attr('disabled', !$(this).attr('checked'));
			});

			if ( $("#hlt_bootstrap_option_customcss").is(':checked') === false ) {
				$("#customcss-url-input").attr('disabled', false);
			}

			$("div#ResetCssBox .option_section").click(function(){

				$("div#ResetCssBox div.option_section").removeClass('selected_item');
				
				$(this).addClass('selected_item');

			    var checkbox = $(this).find('input');
			    checkbox.attr('checked', !checkbox.attr('checked'));				
			});
			
			$("div#BootstrapJavascript .option_section").click(function(){

			    var checkbox = $(this).find('input');
			    checkbox.attr('checked', !checkbox.attr('checked'));
				if ( $(this).find('input').is(':checked') ) {
					$(this).addClass('selected_item');
					$(this).removeClass('nonselected_item');
				} else {
					$(this).removeClass('selected_item');
					$(this).addClass('nonselected_item');
				}
			});

		});
	} ) ( jQuery );
	</script>

	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>