<?php
defined( 'ABSPATH' ) || exit;
?>

<fieldset id="plugpayments-payment-form">
	<style>.plugpayments-method-form{display: none;}</style>

	<?php foreach(WC_PLUGPAYMENTS_PAYMENTS_TYPES as $key => $label){ ?>

		<?php if (in_array($key, $allowedTypes)){ ?>

			<label>
				<input type="radio" name="paymentType" value="<?php echo esc_attr($key); ?>">
				<?php _e( $label, 'woocommerce-plugpayments' ); ?>
			</label>
			<?php
			wc_get_template(
				"payment-types/$key.php", array(
					'cart_total'           => $cart_total,
					'minimum_installment'  => $minimum_installment,
				), 'woocommerce/plugpayments/', WC_Plug_Payments::get_templates_path()
			);		
			?>

		<?php } ?>

	<?php } ?>	

</fieldset>
