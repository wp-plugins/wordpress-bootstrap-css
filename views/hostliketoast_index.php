<?php
?>
<div class="wrap">
	<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br></div></a>
	<h2>Host Like Toast: Plugins Dashboard</h2>

<div class="bootstrap-wpadmin">

	<div class="row">
	  <div class="span12">
		<div class="alert alert-error">
 		 <h4 class="alert-heading">Important Notice</h4>
 		 Support for Twitter Bootstrap Legacy CSS will be removed from <strong>version 2.0.3</strong> onwards. Now is the time to update your plugin settings to use the latest version.</div>
	  </div><!-- / span12 -->
	</div><!-- / row -->

	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>

	<div class="row" id="worpit_promo">
	  <div class="span6" id="worpit_button">
		<a href="http://bit.ly/H3GXyK"><img src="<?php echo $inaData['plugin_url']; ?>images/worpit_wordpress_plugin.png" /></a>
	  </div><!-- / span6 -->
	  <div class="span6" id="worpit_description">
	  <div class="well">
	  	<h3>Worpit :: Faster, Centralized WordPress Admin</h3>
			<p>Coming soon:</p>
			<ul>
				<li>Revolutionary <a href="http://bit.ly/H3tiAu" target="_blank">Backup and Recovery System for WordPress: WorpDrive</a></li>
				<li>Bulk WordPress.org Plugin and Theme installation and updates</li>
				<li>Integrated WordPress Web Hosting</li>
				<li>Centralized control panel for all WordPress hosting administrators</li>
			</ul>
	  </div>
	  </div><!-- / span6 -->
	</div><!-- / row -->
	
	<div class="row" id="tbs_docs">
	  <div class="span6" id="tbs_docs_shortcodes">
	  <div class="well">
		<h3>Wordpress Twitter Bootstrap CSS Plugin Shortcodes</h3>
		<p>To learn more about what shortcodes are, <a href="http://www.hostliketoast.com/2011/12/how-extend-wordpress-powerful-shortcodes/">check this link</a></p>
		<p>The following shortcodes are available:</p>
		<ol>
			<li>[ <a href="http://bit.ly/HOt01C" title="Twitter Bootstrap Badge Shortcode">TBS_BADGE</a> ] <span class="label label-success">new</span></li>
			<li>[ <a href="http://bit.ly/zmGUeD" title="Twitter Bootstrap Glyph Icon WordPress Shortcode">TBS_ICON</a> ]</li>
			<li>[ <a href="http://bit.ly/AlETMx" title="Twitter Bootstrap Button WordPress Shortcode">TBS_BUTTON</a> ]</li>
			<li>[ <a href="http://bit.ly/wIUa7U" title="Twitter Bootstrap Button WordPress Shortcode">TBS_BUTTONGROUP</a> ]</li>
			<li>[ <a href="http://bit.ly/wJqEhk" title="Twitter Bootstrap Label WordPress Shortcode">TBS_LABEL</a> ]</li>
			<li>[ <a href="http://bit.ly/zGgnOl" title="Twitter Bootstrap Blockquotes WordPress Shortcode">TBS_BLOCKQUOTE</a> ]</li>
			<li>[ <a href="http://bit.ly/uiipiY" title="Twitter Bootstrap Block Alerts WordPress Shortcode">TBS_BLOCK</a>] * Not fully supported in v2.0+</li>
			<li>[ <a href="http://bit.ly/uiipiY" title="Twitter Bootstrap Block Alerts WordPress Shortcode">TBS_ALERT</a> ]</li>
			<li>[TBS_CODE]</li>
			<li>[ <a href="http://bit.ly/xMn0AZ" title="Twitter Bootstrap Button WordPress Shortcode">TBS_TWIPSY</a>] * Not fully supported in v2.0+</li>
			<li>[ <a href="http://bit.ly/xMn0AZ" title="Twitter Bootstrap Button WordPress Shortcode">TBS_TOOLTIP</a> ]</li>
			<li>[ <a href="http://bit.ly/AC5JW5" title="Twitter Bootstrap Button WordPress Shortcode">TBS_POPOVER</a> ]</li>
			<li>[TBS_DROPDOWN] + [TBS_DROPDOWN_OPTION].</li> * Not YET fully supported in plugin version v2.0+
			<li>[TBS_TABGROUP] + [TBS_TAB].</li> * Not YET fully supported in plugin version v2.0+
		</ol>
	  </div>
	  </div><!-- / span6 -->
	  <div class="span6" id="tbs_docs_examples">
	  <div class="well">
		<h3>Shortcode Usage Examples</h3>
		<div class="shortcode-usage">
			<p>The following are just some examples of how you can use the shortcodes with the associated HTML output</p>
			<ul>
				<li><span class="code">[TBS_BUTTON id="mySpecialButton" link="http://www.hostliketoast.com"]Click Me[/TBS_BUTTON]</span>
				<p>will give the following HTML:</p>
				<p class="code">&lt;a href="http://www.hostliketoast.com/" class="btn"&gt;Click Me&lt;/a&gt;</p>
				<p class="code-description">This will produce a full-featured button with modern gradient, hover and click styles.</p>
				</li>
			</ul>
		</div>
		<div class="shortcode-usage">
			<ul>
				<li><span class="code">[TBS_LABEL class="important"]highlighted text[/TBS_LABEL]</span>
				<p>will give the following HTML:</p>
				<p class="code">&lt;span class="label label-important"&gt;highlighted text&lt;/span&gt;</p>
				<p class="code-description">This will highlight the text. You can optionally add a class to change the highlight colour: new, warning, important, notice</p>
				</li>
			</ul>
		</div>
		<div class="shortcode-usage">
			<p>There will be much more <a href="http://www.hostliketoast.com/wordpress-resource-centre/wordpress-plugins/">documentation forthcoming on the Host Like Toast website</a>.</a></p>
		</div>
	  </div>
	  </div><!-- / span6 -->
	</div><!-- / row -->
	
	<div class="row" id="developer_channel_promo">
	  <div class="span6" id="developer_channel_form">
		<h3>Get more Free Stuff from the Host Like Toast Developer Channel</h3>
		<!-- Begin MailChimp Signup Form -->
		<div class="dap_signup_box" id="dap_signup_box_widget" style=none >
			<div>
				<form name="dap_direct_signup" method="post" action="http://www.hostliketoast.com/dap/signup_submit.php">
					<div class="input-container">
						<div class="signup_line">
							<div class="signup_field">Name:</div><div class="signup_input"><input id="dap_first_name" type="text" name="first_name" value="Your Name" onclick="clickclear(this, 'Your Name')" onblur="clickrecall(this,'Your Name')" onchange="processDapNameField(this)" /></div>
						</div>
						<div class="signup_line">
							<div class="signup_field">Email:</div><div class="signup_input"><input id="dap_email" type="text" name="email" value="Your Email Address"  onclick="clickclear(this, 'Your Email Address')" onblur="clickrecall(this,'Your Email Address')" /></div>
						</div>
					</div>
			<p id='tac_p_836840886' style='clear:both;margin-top:20px;'></p>
			<script type='text/javascript'>
	
				var tac_p=document.getElementById('tac_p_836840886');
			
				var tac_cb_836840886			= document.createElement('input');
				tac_cb_836840886.type			= 'checkbox';
				tac_cb_836840886.id			= 'tac_checkbox_836840886';
				tac_cb_836840886.name			= 'tac_checkbox_836840886';
				tac_cb_836840886.style.width	= '25px';
				tac_cb_836840886.onclick		= cb_click_836840886;
			
				var tac_label				= document.createElement('label');
				tac_label.htmlFor			= 'tac_checkbox_836840886';
				tac_label.style.cssFloat	= 'none';
				tac_label.style.styleFloat	= 'none';
				tac_label.style.display		= 'inline';
				tac_label.innerHTML			= ' Agree to the <a href="http://www.hostliketoast.com/developer-channel/developer-channel-terms-and-conditions/" target="_blank">Developer Channel Terms and Conditions</a>';
			
				var tac_cb_name_836840886	= document.createElement('input');
				tac_cb_name_836840886.type	= 'hidden';
				tac_cb_name_836840886.name	= 'cb_field_name';
	
				tac_p.appendChild( tac_cb_836840886 );
				tac_p.appendChild( tac_label );
				tac_p.appendChild( tac_cb_name_836840886 );
	
				var frm_836840886		= tac_cb_836840886.form;
				frm_836840886.onsubmit	= tac_check_836840886;
				
				function cb_click_836840886() {
					tac_cb_name_836840886.value=tac_cb_836840886.name;
					frm_836840886.elements['dapass_use'].value='true';
				}
	
				function tac_check_836840886() {
					if(tac_cb_836840886.checked!=true){
						alert('You must agree to the Terms & Conditions');
						return false;
					}
					return true;
				}
			</script>
			<input type='hidden' id='dapass_use' name='dapass_use' value='false' />
			<input type='hidden' id='dapass_email' name='dapass_email' value='' />
				<div class="submit_button"><input id="dap_submit" class="btn" type="submit" name="Submit" value="Sign Up" /></div>
				<input type="hidden" name="last_name" value="">
				<input type="hidden" name="productId" value="3">
				<input type="hidden" name="redirect" value="http://www.hostliketoast.com/developer-channel/thank-you-developer-channel/">
				<input type="hidden" name="custom_signup_form_location" value="WBC plugin">		</form>
			<div class="clear"></div>
	
				<script type="text/javascript">
					function clickclear(thisfield, defaulttext) {
						if (thisfield.value == defaulttext) {
							thisfield.value = "";
						}
					}
					function clickrecall(thisfield, defaulttext) {
						if (thisfield.value == "") {
						thisfield.value = defaulttext;
						}
					}
	
					function processDapNameField(thisfield) {
						var sName = thisfield.value;
						var iSpaceIndex = sName.indexOf(' ');
						var vLastNameField = thisfield.form.elements["last_name"]; //assuming the input field is thus called.
						if ( iSpaceIndex != -1 ) {
							vLastNameField.value = sName.substr(iSpaceIndex+1);
							thisfield.value = sName.substr(0, iSpaceIndex);
						}
	
						thisfield.value=capitaliseAllFirstLetters(thisfield.value);
						vLastNameField.value=capitaliseAllFirstLetters(vLastNameField.value);
					}//processDapNameField
	
					/**
					 * Will capitalise the first letter of a string
					 * @return String with first Character capitalised
					 */
					function capitaliseFirstLetter( someText ) {
						return someText.charAt(0).toUpperCase() + someText.slice(1);
					}
	
					/**
					 * Will (recursively) capitalise all the first letters of a string
					 * @return String with all the first Characters capitalised
					 */
					function capitaliseAllFirstLetters( someText ) {
		
						someText = capitaliseFirstLetter( someText );
						var iSpaceIndex = someText.indexOf(' ');
	
						if ( iSpaceIndex != -1 ) {
							someText = someText.substring(0,iSpaceIndex) + " " + capitaliseAllFirstLetters(someText.substr(iSpaceIndex+1));
						}
						return someText;
					}
				</script>
			</div>
		</div>
		
	  </div><!-- / span6 -->
	  <div class="span6" id="developer_channel_description">
	  <div class="well">
		<h3>Host Like Toast Developer Channel</h3>
	  	<p>By signing up to the Host Like Toast developer channel, we offer you free tools to help you with your web hosting and WordPress websites.</p>
	  	<p>Downloads include:</p>
	  	<ul>
	  		<li>Full CPanel web hosting backup script</li>
	  		<li>CPanel database backup script</li>
	  		<li>FreeAgent and Toggl API wrappers in PHP</li>
	  		<li><a href="http://bit.ly/HygCEa">Digital Access Pass</a> membership site add-ons.</li>
	  		<li><a href="http://bit.ly/GZSh9n">Full CPanel web hosting backup script for Resellers</a> (Premium).</li>
	  		<li><a href="http://bit.ly/GZSlGm">E-Book: How To Setup Google Apps</a> (Premium).</li>
	  	</ul>
	  </div>
	  </div><!-- / span6 -->
	</div><!-- / row -->
	
	<div class="row">
	  <div class="span6">
	  </div><!-- / span6 -->
	  <div class="span6">
	  	<p></p>
	  </div><!-- / span6 -->
	</div><!-- / row -->
	
</div><!-- / bootstrap-wpadmin -->

</div><!-- / wrap -->