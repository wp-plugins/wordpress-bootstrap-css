<?php
?>

				<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
				<style type="text/css">
					#mc_embed_signup form { width: 400px; padding-left: 0px;}
					#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
					#mc_embed_signup input#mce-FNAME, #mc_embed_signup input#mce-EMAIL {
						border-radius: 3px;
						padding: 8px;
						text-indent: 0;
						width:300px !important;
					}
					#mc_embed_signup input.button {color:#444444; width:200px}

					div.meta-box-sortables {
					
						padding-left: 44px;
					}
				</style>


<div class="wrap">
	<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br></div></a>
	<h2>Host Like Toast: Plugins Dashboard</h2>
	
	<div style="width:500px;" class="postbox-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">

				<!-- Begin MailChimp Signup Form -->
				<div id="mc_embed_signup">
				<form action="http://hostliketoast.us2.list-manage.com/subscribe/post?u=e736870223389e44fb8915c9a&amp;id=85b59ab8a6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
					<label for="mce-EMAIL">Subscribe to the Host Like Toast Developer Channel</label>
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
			<div class="meta-box-sortables ui-sortable">
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
	
	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>
</div>