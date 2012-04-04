<?php

function js_option_block_bootstrap( $hlt_option_value, $sOptionName, $sLabel, $sInfo, $sExplanation = '' ) {
	?>
		<div class="span4" id="section-hlt-<?php echo $sOptionName; ?>-js">
			<div class="option_section  <?php if ( $hlt_option_value == 'Y' ): ?>selected_item<?php endif; ?>">
				<label class="checkbox" for="hlt-<?php echo $sOptionName; ?>-js">
					<input type="checkbox" name="hlt_bootstrap_option_<?php echo $sOptionName; ?>_js" value="Y" id="hlt-<?php echo $sOptionName; ?>-js" <?php if ( $hlt_option_value == 'Y' ): ?>checked="checked"<?php endif; ?> />
					<?php echo $sLabel; ?>
				</label>
				<p class="help-block"><?php echo '<a href="http://twitter.github.com/bootstrap/javascript.html#'.$sInfo.'" target="_blank"><span class="label label-info more_info">'. __('more info', 'hlt-wordpress-bootstrap-css') .'</span></a> '.$sExplanation; ?></p>
			</div>
		</div>
	<?php
}//js_option_block_bootstrap
?>
<div class="wrap">

	<div class="page-header">
		<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br /></div></a>
		<h2><?php _hlt_e( 'Host Like Toast: WordPress Twitter Bootstrap CSS Options' ); ?></h2><?php _hlt_e( '' ); ?>
	</div>
	
	<div class="bootstrap-wpadmin">
		<form class="form-horizontal" method="post" action="<?php echo $hlt_form_action; ?>">
			<div class="row">
				<div class="span10">
					<fieldset>
						<legend><?php _hlt_e( 'Choose which type of bootstrap CSS you would like installed' ); ?></legend>
					
						<div class="control-group">
							<label class="control-label" for="hlt_bootstrap_option"><?php _hlt_e( 'Desired Bootstrap CSS' ); ?></label>
							<div class="controls">
								<label class="select">
									<select id="hlt_bootstrap_option" name="hlt_bootstrap_option" style="width:250px">
										<option value="none" id="hlt-none" <?php if ( $hlt_option == 'none' ): ?>selected="selected"<?php endif; ?> >
											<?php _hlt_e( 'None' ); ?>
										</option>
										<option value="twitter" id="hlt-twitter" <?php if ( $hlt_option == 'twitter' ): ?>selected="selected"<?php endif; ?>>
											<?php _hlt_e( 'Twitter Bootstrap CSS' ); ?>
										</option>
										<option value="twitter-legacy" id="hlt-twitter-legacy" <?php if ( $hlt_option == 'twitter-legacy' ): ?>selected="selected"<?php endif; ?>>
											<?php _hlt_e( 'Twitter Bootstrap CSS Legacy v1.4.0' ); ?>
										</option>
										<option value="yahoo-reset" id="hlt-yahoo-reset" <?php if ( $hlt_option == 'yahoo-reset' ): ?>selected="selected"<?php endif;?>>
											<?php _hlt_e( 'Yahoo UI Reset CSS' ); ?>
										</option>
										<option value="normalize" id="hlt-normalize" <?php if ( $hlt_option == 'normalize' ): ?>selected="selected"<?php endif; ?>>
											<?php _hlt_e( 'Normalize CSS' ); ?>
										</option>
									</select>
								</label>
								<div id="desc_block">
									<div id="desc_none" class="desc <?php if ( $hlt_option != 'none' ): ?>hidden<?php endif; ?>">
										<p class="help-block"><?php _hlt_e('No reset CSS will be applied'); ?></p>
									</div>
									<div id="desc_twitter" class="desc <?php if ( $hlt_option != 'twitter' ): ?>hidden<?php endif; ?>">
										<p class="help-block"><?php _hlt_e('Bootstrap, from Twitter (latest release:'); ?>  v2.0.2) <a href="http://twitter.github.com/bootstrap/index.html" target="_blank"><span class="label label-info">more info</span></a></p>
									</div>
									<div id="desc_twitter-legacy" class="desc <?php if ( $hlt_option != 'twitter-legacy' ): ?>hidden<?php endif; ?>">
										<p class="help-block">Bootstrap version 1.4.0, from Twitter (provided for sites that need the previous major release). <a href="http://twitter.github.com/bootstrap/upgrading.html" target="_blank"><span class="label label-info">more info</span></a></p>
									</div>
									<div id="desc_yahoo-reset" class="desc <?php if ( $hlt_option != 'yahoo-reset' ): ?>hidden<?php endif; ?>">
										<p class="help-block"><?php _hlt_e('YahooUI Reset CSS is a basic reset for all browsers'); ?></p>
									</div>
									<div id="desc_normalize" class="desc <?php if ( $hlt_option != 'normalize' ): ?>hidden<?php endif; ?>">
										<p class="help-block"><?php _hlt_e('Normalize CSS.'); ?></p>
									</div>
								</div>
							</div>
						</div>

						<div id="IncludeResponsiveCss" class="control-group">
							<label class="control-label" for="hlt-option-incresponsivecss"><?php _hlt_e('Responsive CSS'); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_inc_responsive_css == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-incresponsivecss">
									<label class="checkbox">
										<input type="checkbox" name="hlt_bootstrap_option_inc_responsive_css" value="Y" id="hlt-option-incresponsivecss" <?php if ( $hlt_option_inc_responsive_css == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Include the Responsive CSS file immediately following the standard Bootstrap file.' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e( "This doesn't make your WordPress site 'responsive', but includes the extra CSS stylesheet." ); ?>
										<br />
										<?php _hlt_e( 'This link will be inserted immediately after the Twitter Bootstrap CSS.' ); ?>
									</p>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="hlt-option-customcss"><?php _hlt_e( 'Custom Reset CSS' ); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_customcss == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-customcss">
									<label class="checkbox">
										<input type="checkbox" name="hlt_bootstrap_option_customcss" value="Y" id="hlt-option-customcss" <?php if ( $hlt_option_customcss == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Enable custom CSS link' ); ?>
									</label>
									<p class="help-block"><?php _hlt_e('Add your own reset CSS with its full URL.' ); ?>
									<br/><?php _hlt_e( '(note: included after any bootstrap/reset CSS selected above)' ); ?></p>
									
									<br class="clear" />
									<label for="hlt-text-customcss-url">
										<?php _hlt_e( 'Custom CSS URL', 'hlt-wordpress-bootstrap-css' ); ?>:
										<input class="span5" type="text" name="hlt_bootstrap_text_customcss_url" id="hlt-text-customcss-url" size="100" value="<?php echo $hlt_text_customcss_url; ?>" style="margin-left:20px;" />
									</label>
									<p class="help-block">
										<?php _hlt_e( "If you're hotlinking to another site, ensure you have permission to do so." ); ?>
									</p>
								</div>
							</div>
						</div>
					
					</fieldset>
				</div>
				<div class="span4"></div>
			</div><!-- / row -->

			<div class="row" id="BootstrapJavascript">
				<div class="span10">
					<fieldset>
					  <legend><?php _hlt_e( 'Select Twitter Bootstrap Javascript Libraries' ); ?></legend>
					  <div class="row" style="height:20px"></div>
			
						<div class="twitter_extra">
							<div class="control-group" id="controlAllJavascriptLibraries">
								<label class="control-label" for="hlt-all-js"><?php _hlt_e( 'All Javascript Libraries' ); ?></label>
								<div class="controls">
									<div class="option_section <?php if ( $hlt_option_all_js == 'Y' ): ?>selected_item<?php endif; ?>">
										<label class="checkbox" for="hlt-all-js">
											<input type="checkbox" name="hlt_bootstrap_option_all_js" value="Y" id="hlt-all-js" <?php if ( $hlt_option_all_js == 'Y' ): ?>checked="checked"<?php endif; ?> />
											<?php _hlt_e('Include ALL Bootstrap Javascript libraries.' ); ?>
										</label>
										<p class="help-block">
											<?php _hlt_e( 'Selecting this negates the need for selecting individual libraries below.' ); ?>
											<br /><?php _hlt_e( '(Note: not available in Twitter Legacy)' ); ?>
										</p>
									</div>
								</div>
							</div>

							<div id="controlIndividualLibrariesList" class="hidden">
								<div class="row">
									<div class="span2"><label class="control-label"><?php _hlt_e( 'Individual Libraries' ); ?></label></div>
									<?php
										js_option_block_bootstrap( $hlt_option_alert_js, "alert", "Alert Javascript Library", "alerts" );
										js_option_block_bootstrap( $hlt_option_button_js, "button", "Button Javascript Library", "buttons" );
									?>
								</div>
								<div class="row">
									<div class="span2">&nbsp;</div>
									<?php
										js_option_block_bootstrap( $hlt_option_modal_js, "modal", "Modal Javascript Library", "modals" );
										js_option_block_bootstrap( $hlt_option_dropdown_js, "dropdown", "Dropdown Javascript Library", "dropdowns" );
									?>
								</div>
								<div class="row">
									<div class="span2">&nbsp;</div>
									<?php
										js_option_block_bootstrap( $hlt_option_popover_js, "popover", "Popover Javascript Library", "popovers",
										' (<em>Note: requires Tooltip library</em>)' );
									
										js_option_block_bootstrap( $hlt_option_tooltip_js, "tooltip", "Tooltip Javascript Library", "tooltips");
									?>
								</div>
								<div class="row">
									<div class="span2">&nbsp;</div>
									<?php
										js_option_block_bootstrap( $hlt_option_scrollspy_js, "scrollspy", "Scrollspy Javascript Library", "scrollspy" );
										js_option_block_bootstrap( $hlt_option_tab_js, "tab", "Tab Javascript Library", "tabs" );
									?>
								</div>
								<div class="row">
									<div class="span2">&nbsp;</div>
									<?php
										js_option_block_bootstrap( $hlt_option_collapse_js, "collapse", "Collapse Javascript Library", "collapse", ' (<em>Note: not available in Twitter v1.x</em>)' );
										js_option_block_bootstrap( $hlt_option_carousel_js, "carousel", "Carousel Javascript Library", "carousel", ' (<em>Note: not available in Twitter v1.x</em>)' );
									?>
								</div>
								<div class="row">
									<div class="span2">&nbsp;</div>
									<?php
										js_option_block_bootstrap( $hlt_option_typeahead_js, "typeahead", "Typeahead Javascript Library", "typeahead", ' (<em>Note: not available in Twitter v1.x</em>)' );
										js_option_block_bootstrap( $hlt_option_transition_js, "transition", "Transition Javascript Library", "transition", ' (<em>Note: not available in Twitter v1.x</em>)' );
									?>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend><?php _hlt_e( 'Select Other Twitter Bootstrap Options' ); ?></legend>

						<div class="control-group">
							<label class="control-label" for="hlt-js-head"><?php _hlt_e('Javascript Placement'); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_js_head == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-js-head">
									<label class="checkbox" for="hlt-js-head">
										<input type="checkbox" name="hlt_bootstrap_option_js_head" value="Y" id="hlt-js-head" <?php if ( $hlt_option_js_head == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Place Javascript in &lt;HEAD&gt;' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e( 'By default, Javascript libraries should be placed at the end of the &lt;BODY&gt; section.
										If you have a need to put them in the &lt;HEAD&gt; check this box.  Not recommended.' ); ?>
									</p>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="hlt-option-useshortcodes"><?php _hlt_e( 'Bootstrap Shortcodes' ); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-useshortcodes">
									<label class="checkbox" for="hlt-option-useshortcodes">
										<input type="checkbox" name="hlt_bootstrap_option_useshortcodes" value="Y" id="hlt-option-useshortcodes" <?php if ( $hlt_option_useshortcodes == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e('Enable Twitter Bootstrap Shortcodes' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e('WordPress shortcodes for fast application of the Twitter Bootstrap library.' ); ?>
									</p>
								</div>
							</div>
						</div>

					</fieldset>
				</div><!-- / span8 -->
			</div><!-- / row -->

			<div class="row" id="MiscOptionBox">
				<div class="span10">
					<fieldset>
						<legend><?php _hlt_e( 'Enable or Disable any of the following options as desired' ); ?></legend>
					
						<div class="control-group">
							<label class="control-label" for="hlt-option-inc_bootstrap_css_wpadmin"><?php _hlt_e( 'Admin Bootstrap CSS' ); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_inc_bootstrap_css_wpadmin == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-inc_bootstrap_css_wpadmin">
									<label class="checkbox" for="hlt-option-inc_bootstrap_css_wpadmin">
										<input type="checkbox" name="hlt_bootstrap_option_inc_bootstrap_css_wpadmin" value="Y" id="hlt-option-inc_bootstrap_css_wpadmin" <?php if ( $hlt_option_inc_bootstrap_css_wpadmin == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Include Twitter Bootstrap CSS in the WordPress Admin' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e( 'This is not the standard Twitter Bootstrap CSS and is not minified. To use Twitter Bootstrap styles within the WordPress Admin area, you must
										include all your WordPress Admin pages within a DIV with class "bootstrap-wpadmin".' ); ?>
									</p>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="hlt-option-hide_dashboard_rss_feed"><?php _hlt_e('Hide HLT News Feed'); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_hide_dashboard_rss_feed == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-dashboard_rss_feed">
									<label class="checkbox" for="hlt-option-hide_dashboard_rss_feed">
										<input type="checkbox" name="hlt_bootstrap_option_hide_dashboard_rss_feed" value="Y" id="hlt-option-hide_dashboard_rss_feed" <?php if ( $hlt_option_hide_dashboard_rss_feed == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Hide the Host Like Toast news feed from the Dashboard' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e( 'We added this feature so you could easily see the latest news and updates from our site that includes Web Hosting, WordPress and Twitter Bootstrap news and guides.' ); ?>
									</p>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="hlt-option-prettify"><?php _hlt_e( 'Display Code Snippets' ); ?></label>
							<div class="controls">
								<div class="option_section <?php if ( $hlt_option_prettify == 'Y' ): ?>selected_item<?php endif; ?>" id="section-hlt-option-prettify">
									<label class="checkbox" for="hlt-option-prettify">
										<input type="checkbox" name="hlt_bootstrap_option_prettify" value="Y" id="hlt-option-prettify" <?php if ( $hlt_option_prettify == 'Y' ): ?>checked="checked"<?php endif; ?> />
										<?php _hlt_e( 'Include Google Prettify/Pretty Links Javascript' ); ?>
									</label>
									<p class="help-block">
										<?php _hlt_e( 'If you display code snippets or similar on your site, enabling this option will include the
										Google Prettify Javascript library for use with these code blocks.' ); ?>
									</p>
								</div>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="submit"><?php _hlt_e( 'Save all changes' ); ?></button>
							<?php echo ( class_exists( 'W3_Plugin_TotalCacheAdmin' )? '<span> and flush W3 Total Cache</span>' : '' ); ?>
						</div>
					</fieldset>
				</div><!-- / span10 -->
			</div><!-- / row -->
	
		</form>
	
	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
	</div><!-- / bootstrap-wpadmin -->

	<?php include_once( dirname(__FILE__).'/bootstrapcss_js.php' ); ?>
</div>