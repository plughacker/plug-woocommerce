<?php
defined( 'ABSPATH' ) || exit;
?>

<fieldset id="plugpayments-payment-form" data-cart_total="<?php echo esc_attr( number_format( $cart_total, 2, '.', '' ) ); ?>">
	<style>.plugpayments-method-form{display: none;}</style>
	<?php foreach(WC_PLUGPAYMENTS_PAYMENTS_TYPES as $key => $label){ ?>
		<label>
			<input type="radio" name="paymentType" value="<?php echo $key; ?>">
			<?php _e( $label, 'woocommerce-plugpayments' ); ?>
		</label>
		<?php
		wc_get_template(
			"payment-types/$key.php", array(

			), 'woocommerce/plugpayments/', WC_Plug_Payments::get_templates_path()
		);		
	?>
	<?php } ?>	
</fieldset>
