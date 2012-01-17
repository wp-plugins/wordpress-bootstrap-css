<?php
	function js_option_block( $hlt_option_value, $sOptionName, $sExplanation = '' ) {
?>
			<td>
				<div class="option_section  <?php if ( $hlt_option_value == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-<?php echo $sOptionName; ?>-js">
					<input type="checkbox" name="hlt_bootstrap_option_<?php echo $sOptionName; ?>_js" value="Y" id="hlt-<?php echo $sOptionName; ?>-js" <?php if ( $hlt_option_value == 'Y' ): ?>checked="checked"<?php endif; ?> />
					<label for="hlt-<?php echo $sOptionName; ?>-js"><?php echo $sOptionName; ?>.js</label>
					<br class="clear" />
<?php
		echo '					<p class="desc" style="display: block;">';
		echo 'Include Bootstrap '. ucfirst($sOptionName).' library. [<a href="http://twitter.github.com/bootstrap/javascript.html#'.$sOptionName.'" target="_blank">more info</a>]';
		echo $sExplanation;
		echo '</p></div></td>';

	}//js_option_block
?>

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
						<div class="inside" style="">
							<p><strong>Choose which type of bootstrap CSS you would like installed.</strong></p>

							<select id="hlt_bootstrap_option" name="hlt_bootstrap_option" style="">
								<option value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>selected="selected"<?php endif; ?> >None</option>
								<option value="twitter" id="hlt-twitter" <?php if ( $hlt_option == 'twitter' ): ?>selected="selected"<?php endif; ?>>Twitter Bootstrap CSS</option>
								<option value="twitter-legacy" id="hlt-twitter-legacy" <?php if ( $hlt_option == 'twitter-legacy' ): ?>selected="selected"<?php endif; ?>>Twitter Bootstrap CSS (v1.4.0)</option>
								<option value="yahoo-reset" id="hlt-yahoo-reset" <?php if ( $hlt_option == 'yahoo-reset' ): ?>selected="selected"<?php endif;?>>Yahoo UI Reset CSS</option>
								<option value="normalize" id="hlt-normalize" <?php if ( $hlt_option == 'normalize' ): ?>selected="selected"<?php endif; ?>>Normalize CSS</option>
							</select>
							
							<div id="desc_block">
								<div id="desc_none" class="desc <?php if ( $hlt_option != 'none' ): ?>hidden<?php endif; ?>">
									<p>No reset CSS will be applied.</p>
								</div>
								<div id="desc_twitter" class="desc <?php if ( $hlt_option != 'twitter' ): ?>hidden<?php endif; ?>">
									<p>Bootstrap, from Twitter (latest release). [<a href="http://twitter.github.com/bootstrap/" target="_blank">more info</a>]</p>
								</div>
								<div id="desc_twitter-legacy" class="desc <?php if ( $hlt_option != 'twitter-legacy' ): ?>hidden<?php endif; ?>">
									<p>Bootstrap version 1.4.0, from Twitter (provided for sites that need the previous major release). [<a href="http://twitter.github.com/bootstrap/" target="_blank">more info</a>]</p>
								</div>
								<div id="desc_yahoo-reset" class="desc <?php if ( $hlt_option != 'yahoo-reset' ): ?>hidden<?php endif; ?>">
									<p>YahooUI Reset CSS is a basic reset for all browsers.</p>
								</div>
								<div id="desc_normalize" class="desc <?php if ( $hlt_option != 'normalize' ): ?>hidden<?php endif; ?>">
									<p>Normalize CSS.</p>
								</div>
							</div>
							<div style="clear:both"></div>
						</div>
					</div>

					<div class="postbox" id="BootstrapJavascript">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Select Extra Twitter Bootstrap Options</span></h3>
						<div class="inside">
							<p><strong>Choose which of the following Twitter Bootstrap Javascript libraries you would like included on your site.</strong></p>

							<table id="tbl_tbs_options_javascript" class="tbl_tbs_options">
								<tr>
									<?php
										js_option_block( $hlt_option_modal_js, "modal" );
										js_option_block( $hlt_option_alerts_js, "alerts" ); 
									?>
								</tr>
								<tr>
									<?php
										js_option_block( $hlt_option_dropdown_js, "dropdown" );
										js_option_block( $hlt_option_scrollspy_js, "scrollspy" ); 
									?>
								</tr>
								<tr>
									<?php
										js_option_block( $hlt_option_popover_js, "popover",
										' (<em>Note: requires Twipsy library</em>)' );
									
										js_option_block( $hlt_option_twipsy_js, "twipsy");
									?>
								</tr>
								<tr>
									<?php
										js_option_block( $hlt_option_tabs_js, "tabs" );
										js_option_block( $hlt_option_transition_js, "transition", ' (<em>Note: not available in Twitter v1.x</em>)' );
									?>
								</tr>
								<tr>
									<?php
										js_option_block( $hlt_option_collapse_js, "collapse", ' (<em>Note: not available in Twitter v1.x</em>)' );
										js_option_block( $hlt_option_carousel_js, "carousel", ' (<em>Note: not available in Twitter v1.x</em>)' );
									?>
								</tr>
							</table>

							<p><strong>Some Further Bootstrap Options:</strong></p>
						
							<table id="tbl_tbs_options_javascript" class="tbl_tbs_options">
								<tr>
									<td>
										<div class="option_section <?php if ( $hlt_option_js_head == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-js-head">
											<input type="checkbox" name="hlt_bootstrap_option_js_head" value="Y" id="hlt-js-head" <?php if ( $hlt_option_js_head == 'Y' ): ?>checked="checked"<?php endif; ?> />
											<label for="hlt-js-head">Place Javascript libraries in the &lt;HEAD&gt; section.</label>
											<br class="clear" />
											<p class="desc" style="display: block;">
												By default, Javascript libraries should be placed at the end of the &lt;BODY&gt; section.
												If you have a need to put them in the &lt;HEAD&gt; check this box.  Not recommended.
											</p>
										</div>
									</td>
									<td>
										<div class="option_section <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-useshortcodes">
											<input type="checkbox" name="hlt_bootstrap_option_useshortcodes" value="Y" id="hlt-option-useshortcodes" <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>checked="checked"<?php endif; ?> />
											<label for="hlt-option-useshortcodes">Enable Twitter Bootstrap Shortcodes</label>
											<br class="clear" />
											<p class="desc" style="display: block;">
												WordPress shortcodes for fast application of the Twitter Bootstrap library.
												<br />
												Click here for a complete guide on WordPress shortcode for Twitter Bootstrap.
											</p>
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
								<br class="clear" />
								<p class="desc" style="display: block;">
									If you choose to link to your own custom CSS be sure to put the full URL path to the CSS file.
									If you're hotlinking to another site, ensure you have permission to do so.
									<br />
									This CSS link will be inserted immediately after the reset, normalize or Twitter Bootstrap CSS if any of these are selected.
								</p>
							</div>

							<label for="hlt-text-customcss-url">Custom CSS URL:</label>
							<input id="customcss-url-input" type="text" name="hlt_bootstrap_text_customcss_url" id="hlt-text-customcss-url" size="100" value="<?php echo $hlt_text_customcss_url; ?>" style="margin-left:20px;" />
							<br class="clear" />
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
								<br class="clear" />
								<p class="desc" style="display: block;">
									If you choose to hotlink, your site will be relying on external servers to deliver both the CSS and JS files.
									If that server goes down or the file becomes unavailable for any reason, your site will be affected visually. This option is not recommended.
								</p>
							</div>
						</div>
					</div>

					<div class="postbox" id="MiscOptionBox">
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Enable or Disable any of the following options as desired</span></h3>
						<div class="inside">
							<p><strong>If you need to display code snippets on your site, this is useful in conjunction with some Twitter Bootstrap elements.</strong></p>

							<div class="option_section <?php if ( $hlt_option_prettify == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-prettify">
								<input type="checkbox" name="hlt_bootstrap_option_prettify" value="Y" id="hlt-option-prettify" <?php if ( $hlt_option_prettify == 'Y' ): ?>checked="checked"<?php endif; ?> />
								<label for="hlt-option-prettify">Include Google Prettify/Pretty Links Javascript</label>
								<br class="clear" />
								<p class="desc" style="display: block;">
									If you display code snippets or similar on your site, enabling this option will include the
									Google Prettify Javascript library for use with these code blocks.
								</p>
							</div>

						</div>
					</div>

					<div class="submit">
						<input type="submit" value="Save Settings" name="submit" class="button-primary">
						<?php echo ( class_exists( 'W3_Plugin_TotalCacheAdmin' )? '<span> and flush W3 Total Cache</span>' : '' ); ?>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready(
			function () {
	
				jQuery( "select[name='hlt_bootstrap_option']" ).click( onChangeCssBootstrapOption );
	
				if ( jQuery( "#hlt-twitter" ).is( ':checked' ) === false ) {
					jQuery( "#BootstrapJavascript" ).hide();
				}
	
				if ( jQuery( "#hlt-none" ).is( ':checked' ) === false ) {
					jQuery( "#HotlinkOptionBox" ).show();
				}
				else {
					jQuery( "#HotlinkOptionBox" ).hide();
				}
				/* Enables/Disables the custom CSS text field depending on checkbox*/
				jQuery( "input[type=checkbox][name='hlt_bootstrap_option_customcss']" ).click( onClickCustomCss );
	
				if ( jQuery( "#hlt_bootstrap_option_customcss" ).is( ':checked' ) === false ) {
					jQuery( "#customcss-url-input" ).attr( 'disabled', false );
				}
	
				jQuery( 'input:checked' ).parents( 'div.option_section' ).addClass( 'active' );
				
				jQuery( '.option_section' ).bind( 'click', onSectionClick );
				jQuery( '.option_section input[type=checkbox],.option_section label' ).bind( 'click',
					function ( inoEvent ) {
						var $this = jQuery( this );
						var oParent = $this.parents( 'div.option_section' );

						var oInput = jQuery( 'input[type=checkbox]', oParent );
						if ( oInput.is( ':checked' ) ) {
							oParent.addClass( 'active' );
						}
						else {
							oParent.removeClass( 'active' );
						}
					}
				);
	
				jQuery( 'input[name=hlt_bootstrap_option_popover_js]' ).bind( 'click', onChangePopoverJs );
				
				jQuery( "select[name='hlt_bootstrap_option']" ).trigger( 'click' );
			}
		);
	
		function onSectionClick( inoEvent ) {
			var oDiv = jQuery( inoEvent.currentTarget );
			if ( inoEvent.target.tagName && inoEvent.target.tagName.match( /input|label/i ) ) {
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
			if ( sValue == 'twitter' || sValue == 'twitter-legacy' ) {
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

			jQuery( '#desc_block .desc' ).addClass( 'hidden' );
			jQuery( '#desc_'+sValue ).removeClass( 'hidden' );
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