<style type="text/css">

	#desc_block {
		float: right;
		width: 60%;
	}
	.inside p.desc {
		font-size: smaller;
		font-style: italic;
		margin-top: 4px 0 4px 20px;
	}
	.submit span {
		font-size: smaller;
		font-style: italic;
	}
	.option_section {
		border: 1px solid transparent;
		border-radius: 8px 8px 8px 8px;
		margin-bottom: 8px;
		padding: 8px 10px 0px;
	}
/*
	.option_section:hover {
	    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
	}
	.selected_item {
	    background-color: rgba(128, 255, 128, 0.2);
	    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
	}
*/
	.selected_item label {
		font-weight: bold;
	}
	.nonselected_item {
		background-color: transparent;
	}
	.nonselected_item label {
		font-weight: normal;
	}
	
	.option_section:hover {
		background-color: #ffffff;
		cursor: pointer;
	}
	
	.option_section.active {
		background-color: #DDDDDD;
	}
	
	table.tbl_tbs_options {
		width: 100%;
		border: 1px solid transparent;
	}
	table.tbl_tbs_options tr td {
		width: 49%;
		border: 1px solid transparent;
	}
	
</style>

<div class="wrap">
	<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
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

							<select name="hlt_bootstrap_option">
								<option value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>selected<?php endif;?> >None</option>
								<option value="twitter" id="hlt-twitter" <?php if ( $hlt_option == 'twitter' ): ?>selected<?php endif;?>>Twitter Bootstrap CSS</option>
								<option value="yahoo-reset" id="hlt-yahoo-reset" <?php if ( $hlt_option == 'yahoo-reset' ): ?>selected<?php endif;?>>Yahoo UI Reset CSS</option>
								<option value="normalize" id="hlt-normalize" <?php if ( $hlt_option == 'normalize' ): ?>selected<?php endif;?>>Normalize CSS</option>
							</select>
							
							<div id="desc_block">
								<div id="desc_none" class="desc"><p style="display: block;">No reset CSS will be applied.</p></div>
								<div id="desc_tbs" class="desc"><p style="display: block;">Bootstrap, from Twitter. [<a href="http://twitter.github.com/bootstrap/" target="_blank">more info</a>]</p></div>
								<div id="desc_yahoo" class="desc"><p style="display: block;">YahooUI Reset CSS is a basic reset for all browsers.</p></div>
								<div id="desc_normalise" class="desc"><p style="display: block;">Normalize CSS.</p></div>
							</div>
							<div style="clear:both"></div>
<!--
							<div class="option_section  <?php if ( $hlt_option == 'none' ): ?>selected_item<?php endif;?>" id="section-hlt-none">
								<input type="radio" name="hlt_bootstrap_option" value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>checked="checked"<?php endif;?> />
								<label for="hlt-none">None</label>
								<br class="clear">
								<p class="desc" style="display: block;">No reset CSS will be applied.</p>
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
							
  -->
						</div>
					</div>

					<div class="postbox" id="BootstrapJavascript">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Bootstrap Javascript Include Options</span></h3>
						<div class="inside">
							<p><strong>Choose which of the following Twitter Bootstrap Javascript libraries you would like included on your site.</strong></p>

							<table id="tbl_tbs_options_javascript" class="tbl_tbs_options">
							<tr>
								<td>
								<div class="option_section <?php if ( $hlt_option_modal_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-modal-js">
									<input type="checkbox" name="hlt_bootstrap_option_modal_js" value="Y" id="hlt-modal-js" <?php if ( $hlt_option_modal_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-modal-js">modal.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Modal' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#modal" target="_blank">more info</a>]</p>
								</div>
								</td>
								<td>
								<div class="option_section <?php if ( $hlt_option_alerts_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-alerts-js">
									<input type="checkbox" name="hlt_bootstrap_option_alerts_js" value="Y" id="hlt-alerts-js" <?php if ( $hlt_option_alerts_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-alerts-js">alerts.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Alerts' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#alerts" target="_blank">more info</a>]</p>
								</div>
								</td>
							</tr>
							<tr>
								<td>
								<div class="option_section <?php if ( $hlt_option_dropdown_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-dropdown-js">
									<input type="checkbox" name="hlt_bootstrap_option_dropdown_js" value="Y" id="hlt-dropdown-js" <?php if ( $hlt_option_dropdown_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-dropdown-js">dropdown.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Dropdown' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#dropdown" target="_blank">more info</a>]</p>
								</div>
								</td>
								<td>
								<div class="option_section <?php if ( $hlt_option_scrollspy_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-scrollspy-js">
									<input type="checkbox" name="hlt_bootstrap_option_scrollspy_js" value="Y" id="hlt-scrollspy-js" <?php if ( $hlt_option_scrollspy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-scrollspy-js">scrollspy.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Scrollspy' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#scrollspy" target="_blank">more info</a>]</p>
								</div>
								</td>
							</tr>
							<tr>
								<td>
								<div class="option_section <?php if ( $hlt_option_popover_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-popover-js">
									<input type="checkbox" name="hlt_bootstrap_option_popover_js" value="Y" id="hlt-popover-js" <?php if ( $hlt_option_popover_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-popover-js">popover.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Popover' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#popover" target="_blank">more info</a>] (<em>Note: requires Twipsy library</em>)</p>
								</div>
								</td>
								<td>
								<div class="option_section  <?php if ( $hlt_option_twipsy_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-twipsy-js">
									<input type="checkbox" name="hlt_bootstrap_option_twipsy_js" value="Y" id="hlt-twipsy-js" <?php if ( $hlt_option_twipsy_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-twipsy-js">twipsy.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Twipsy' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#twipsy" target="_blank">more info</a>]</p>
								</div>
								</td>
							</tr>
							<tr>
								<td>
								<div class="option_section <?php if ( $hlt_option_tabs_js == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-tabs-js">
									<input type="checkbox" name="hlt_bootstrap_option_tabs_js" value="Y" id="hlt-tabs-js" <?php if ( $hlt_option_tabs_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-tabs-js">tabs.js</label>
									<br class="clear">
									<p class="desc" style="display: block;">Include 'Bootstrap Tabs' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#tabs" target="_blank">more info</a>]</p>
								</div>
								</td>
								<td></td>
							</tr>
						</table>
						<table id="tbl_tbs_options_javascript" class="tbl_tbs_options">
							<tr>
								<td>
								<div class="option_section <?php if ( $hlt_option_js_head == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-js-head">
									<input type="checkbox" name="hlt_bootstrap_option_js_head" value="Y" id="hlt-js-head" <?php if ( $hlt_option_js_head == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-js-head">Place Javascript in the &lt;HEAD&gt; section.</label>
									<br class="clear">
									<p class="desc" style="display: block;">By default, Javascript libraries should be placed at the end of the &lt;BODY&gt; section.
									If you have a need to put them in the &lt;HEAD&gt; check this box.  Not recommended.</p>
								</div>
								</td>
								<td>
								<div class="option_section <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-useshortcodes">
									<input type="checkbox" name="hlt_bootstrap_option_useshortcodes" value="Y" id="hlt-option-useshortcodes" <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>checked="checked"<?php endif; ?> />
									<label for="hlt-option-useshortcodes">Enable Twitter Bootstrap Shortcodes</label>
									<br class="clear">
									<p class="desc" style="display: block;">We have created a number of WordPress shortcodes for fast application of the Twitter Bootstrap
									library. There is no need to enable this unless you wish to use the shortcodes.
									<br />Click here for a complete guide on our current WordPress shortcode implementation for Twitter Bootstrap.</p>
								</div>
								</td>
							</tr>
						</table>
						</div>
					</div>

					<div class="postbox" id="CustomCssOptionBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Add your own custom CSS</span></h3>
						<div class="inside">
							<p><strong>Enter the URL of a CSS file you would like included before all others (and immediately after the Bootstrap CSS if selected).</strong></p>

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

					<div class="postbox" id="MiscOptionBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Enable or Disable any of the following options as desired</span></h3>
						<div class="inside">
							<p><strong>Enter the URL of a CSS file you would like included before all others (and immediately after the Bootstrap CSS if selected).</strong></p>

							<div class="option_section <?php if ( $hlt_option_googleprettify == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-googleprettify">
								<input type="checkbox" name="hlt_bootstrap_option_googleprettify" value="Y" id="hlt-option-googleprettify" <?php if ( $hlt_option_googleprettify == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-option-googleprettify">Include Google Prettify/Pretty Links Javascript</label>
								<br class="clear">
								<p class="desc" style="display: block;">If you display code snippets or similar on your site, enabling this option will include the
								Google Prettify Javascript library for use with these code blocks.
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
		$( document ).ready( function() {
			
			$( "select[name='hlt_bootstrap_option']" ).click( onChangeCssBootstrapOption );

			if ( $( "#hlt-twitter" ).is( ':checked' ) === false ) {
				$( "#BootstrapJavascript" ).hide();
			}

			if ( $( "#hlt-none" ).is( ':checked' ) === false ) {
				$( "#HotlinkOptionBox" ).show();
			}
			else {
				$( "#HotlinkOptionBox" ).hide();
			}

			/* Enables/Disables the custom CSS text field depending on checkbox*/
			$( "input[type=checkbox][name='hlt_bootstrap_option_customcss']" ).click(	onClickCustomCss );

			if ( $( "#hlt_bootstrap_option_customcss" ).is( ':checked' ) === false ) {
				$( "#customcss-url-input" ).attr( 'disabled', false );
			}
		});
	} ) ( jQuery );
	</script>

<script>

	jQuery( document ).ready(
		function () {

			jQuery( 'input:checked' ).parents( 'div.option_section' ).addClass( 'active' );
			
			jQuery( '.option_section' ).bind( 'click', onSectionClick );

			jQuery( 'input[name=hlt_bootstrap_option_popover_js]' ).bind( 'click', onChangePopoverJs() );
			
		}
	);

	function onSectionClick( inoEvent ) {
		var oDiv = jQuery( inoEvent.currentTarget );
		if ( inoEvent.target.tagName && inoEvent.target.tagName.match( /input/i ) ) {
			return true;
		}

		var oEl = oDiv.find( 'input[name=hlt_bootstrap_option_popover_js]' );
		if ( oEl.length > 0 ) {
			onChangePopoverJs.call( oEl.get( 0 ) );
		}
		
		var oEl = oDiv.find( "select[name='hlt_bootstrap_option']" );
		if ( oEl.length > 0 ) {
			onChangeCssBootstrapOption.call( oEl.get( 0 ) );
		}
		
		var oEl = oDiv.find( 'input[type=checkbox]' );
		if ( oEl.length > 0 ) {
			if ( oEl.is( ':checked' ) ) {
				oEl.removeAttr( 'checked' );
				oDiv.removeClass( 'active' );
			}
			else {
				oEl.attr( 'checked', 'checked' );
				oDiv.addClass( 'active' );
			}
		}

		var oEl = oDiv.find( 'input[type=radio]' );
		if ( oEl.length > 0 && !oEl.is( ':checked' ) ) {
			oEl.attr( 'checked', 'checked' );
			oDiv.addClass( 'active' ).siblings().removeClass( 'active' );
		}
	}

	function onChangeCssBootstrapOption() {
		var sValue = jQuery( this ).val();

		/* Show/Hide Bootstrap Javascript section on Twitter CSS selection */
		if ( sValue == 'twitter' ) {
			jQuery( "#BootstrapJavascript" ).slideDown( 150 );
		}
		else {
			jQuery( "#BootstrapJavascript" ).slideUp( 150 );
		}

		/* Show/Hide Hotlink section on none/CSS selection */
		if ( sValue == 'none' ) {
			jQuery( "#HotlinkOptionBox" ).slideUp( 150 );
		}
		else {
			jQuery( "#HotlinkOptionBox" ).slideDown( 150 );
		}
	}

	function onClickCustomCss() {
		jQuery( '#customcss-url-input' ).attr( 'disabled', !jQuery( this ).attr( 'checked' ) );
	}

	function onChangePopoverJs() {
		if ( !jQuery( this ).is( ':checked' ) ) {
			jQuery( 'input[name=hlt_bootstrap_option_twipsy_js]' ).attr( 'checked', 'checked' ).parents( 'div.option_section' ).addClass( 'active' );
		}
	}

</script>

	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>