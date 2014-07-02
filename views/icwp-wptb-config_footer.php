<?php include_once( dirname(__FILE__).'/include_js.php' ); ?>

	</div><!-- / bootstrap-wpadmin -->
</div><!-- / wrap -->

<div class="wrap">
	<style type="text/css">
		.bootstrap-wpadmin .row.row_number_1 {
			padding-top: 18px;
		}
		.bootstrap-wpadmin .span4 {
			width: 325px;
		}
		.bootstrap-wpadmin .control-group {
			border: 1px dashed #DDDDDD;
			border-radius: 8px;
			padding: 10px;
		}
		.bootstrap-wpadmin .control-group:hover {
			background-color: #f8f8f8;
		}
		.bootstrap-wpadmin .control-group .control-label {
			font-weight: bold;
			font-size: 12px;
			width: 110px;
		}
		.bootstrap-wpadmin .control-group span.label-less-name {
			font-weight: normal;
			font-size: 11px;
			display: block;
			margin-bottom: 2px;
			clear: both;
			float: left;
		}
		.bootstrap-wpadmin .control-group .controls {
			margin-left: 120px;
		}
		.bootstrap-wpadmin .control-group .option_section {
			border: 1px solid transparent;
		}
		.help_section  {
			padding-top: 8px;
			border-top: 1px solid #DDDDDD;
		}
		.toggle_checkbox {
			float:right;
		}
		.bootstrap-wpadmin .form-horizontal .form-actions {
			padding-left: 75px;
			padding-right: 75px;
		}
	</style>
	<script type="text/javascript">
		function triggerColor( inoEl ) {
			var $ = jQuery;

			var $oThis = $( inoEl );
			var aParts = $oThis.attr( 'id' ).split( '_' );

			var $oColorInput = $( '#<?php echo $icwp_var_prefix; ?>less_'+ aParts[3] );

			if ( $oThis.is( ':checked' ) ) {
				$oColorInput.miniColors( 'destroy' );
				$oColorInput.css( 'width', '130px' );
			}
			else {
				$oColorInput.miniColors();
				$oColorInput.css( 'width', '100px' );
			}
		}

		jQuery( document ).ready(
			function() {
				var $ = jQuery;

				$( 'input[name^=hlt_toggle_less]' ).on( 'click',
					function() {
						triggerColor( this );
					}
				);

				$( 'input[name^=hlt_toggle_less]' ).each(
					function( index, el ) {
						triggerColor( this );
					}
				);

			}
		);
	</script>