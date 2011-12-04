<?php
?>
	<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
	<style type="text/css">
			#mc_embed_signup {clear:left; font:14px Helvetica,Arial,sans-serif;background-color: transparent;}
			#mc_embed_signup form { width: 400px; padding-left: 0px; background-color: transparent;}
			#mc_embed_signup input#mce-FNAME, #mc_embed_signup input#mce-EMAIL {
			border-radius: 3px;
			padding: 8px;
			text-indent: 0;
			width:300px !important;
		}
		#mc_embed_signup input.button {color:#444444; width:200px}
	</style>

<div class="wrap">
	<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br></div></a>
	<h3>Host Like Toast: Plugins Dashboard</h3>
	
	<div style="clear:both"></div>
	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
	<div style="clear:both"></div>

	<div style="width:500px;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
			<div class="postbox">
				<h3>Subscribe to the Host Like Toast Developer Channel</h3>
				<!-- Begin MailChimp Signup Form -->
				<div class="inside">
					<div id="mc_embed_signup">
					<form action="http://hostliketoast.us2.list-manage.com/subscribe/post?u=e736870223389e44fb8915c9a&amp;id=85b59ab8a6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
	
						<input type="text" onblur="clickrecall(this,'Your Name')" onclick="clickclear(this, 'Your Name')" value="Your Name" name="FNAME" class="required" id="mce-FNAME">
						<input type="email" onblur="clickrecall(this,'Your Email Address')" onclick="clickclear(this, 'Your Email Address')" value="Your Email Address" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="email address" required>
						<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					</form>
					</div>
					<!--End mc_embed_signup-->
					<div>
						<p>Sign up to the Host Like Toast Developer Channel to get access to lots of free downloads to help with your Wordpress
						and Web Hosting experience.</p>
						<p>Some of the things you can get access to are:</p>
						<ol>
							<li>A free script to do a complete backup of your CPanel web hosting account.</li>
							<li>A free script to do a complete backup of all MySQL Databases in your CPanel web hosting account.</li>
							<li>Tools to assist with certain Wordpress Membership software tools.</li>
							<li>...and more...</li>
						</ol>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	
	<div style="width:500px;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
			<div class="postbox">
				<h3>Wordpress Bootstrap CSS Plugin now comes with Shortcodes</h3>
				<div class="inside">
					<div>
						<p>To learn more about what shortcodes are, <a href="http://www.hostliketoast.com/2011/12/how-extend-wordpress-powerful-shortcodes/">check this link</a></p>
						<p>The following shortcodes are available:</p>
						<ol>
							<li>[TBS_BUTTON]</li>
							<li>[TBS_LABEL]</li>
							<li>[TBS_BLOCK]</li>
							<li>[TBS_CODE]</li>
							<li>[TBS_TWIPSY]</li>
							<li>[TBS_POPOVER]</li>
							<li>[TBS_DROPDOWN] + [TBS_DROPDOWN_OPTION].</li>
							<li>[TBS_TABGROUP] + [TBS_TAB].</li>
						</ol>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>
	
	<div style="width:500px;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
			<div class="postbox">
				<h3>Shortcode Usage Examples</h3>
				<div class="inside">
					<div class="shortcode-usage">
						<p>The following are just some examples of how you can use the shortcodes with the associated HTML output</p>
						<ul>
							<li><span class="code">[TBS_BUTTON id="mySpecialButton" link="http://www.hostliketoast.com"]Click Me[/TBS_BUTTON]</span>
							<p>will give the following HTML:</p>
							<p class="code">&lt;a href="http://www.hostliketoast.com/" class="btn default"&gt;Click Me&lt;/a&gt;</p>
							<p class="code-description">This will produce a full-featured button with modern gradient, hover and click styles.</p>
							</li>
						</ul>
					</div>
					<div class="shortcode-usage">
						<ul>
							<li><span class="code">[TBS_LABEL class="important"]highlighted text[/TBS_LABEL]</span>
							<p>will give the following HTML:</p>
							<p class="code">&lt;span class="label important"&gt;highlighted text&lt;/span&gt;</p>
							<p class="code-description">This will highlight the text. You can optionally add a class to change the highlight colour: new, warning, important, notice</p>
							</li>
						</ul>
					</div>
					<div class="shortcode-usage">
						<p>There will be much more <a href="http://www.hostliketoast.com/wordpress-resource-centre/wordpress-plugins/">documentation forthcoming on the Host Like Toast website</a>.</a></p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
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
	</script>
	<div style="clear:both"></div>
	
	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>