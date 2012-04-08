<?php 
	include_once( dirname(__FILE__).'/widgets/bootstrapcss_widgets.php' );
?>

<div class="wrap">
	<a href="http://www.hostliketoast.com/"><div class="icon32" style="background: url(<?php echo $hlt_plugin_url; ?>images/toaster_32x32.png) no-repeat;" id="hostliketoast-icon"><br></div></a>
	<h2>Host Like Toast: Plugins Dashboard</h2>

<div class="bootstrap-wpadmin">

	<div class="row">
	  <div class="span12">
		<div class="alert alert-error">
 		 <h4 class="alert-heading">Important Notice (1)</h4>
 		 Support for Twitter Bootstrap Legacy CSS will be removed from <strong>version 2.0.3</strong> onwards. Now is the time to update your plugin settings to use the latest version.</div>
	  </div><!-- / span12 -->
	</div><!-- / row -->

	<div class="row">
	  <div class="span12">
		<div class="alert alert-warning">
 		 <h4 class="alert-heading">Important Notice (2)</h4>
 		 The option to select individual Twitter Bootstrap Javascript libraries will be removed from <strong>version 2.0.3</strong> onwards. "All" Javascript libraries will be the only option.</div>
	  </div><!-- / span12 -->
	</div><!-- / row -->

	<?php include_once( dirname(__FILE__).'/bootstrapcss_common_widgets.php' ); ?>

	<div class="row" id="worpit_promo">
	  <div class="span12">
	  	<?php echo getWidgetIframeHtml('dashboard-widget-worpit'); ?>
	  </div>
	</div><!-- / row -->
	
	<div class="row" id="developer_channel_promo">
	  <div class="span12">
	  	<?php echo getWidgetIframeHtml('dashboard-widget-developerchannel'); ?>
	  </div>
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
	
	<div class="row">
	  <div class="span6">
	  </div><!-- / span6 -->
	  <div class="span6">
	  	<p></p>
	  </div><!-- / span6 -->
	</div><!-- / row -->
	
</div><!-- / bootstrap-wpadmin -->

</div><!-- / wrap -->