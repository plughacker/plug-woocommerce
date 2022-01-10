<?php
defined( 'ABSPATH' ) || exit;

class WC_PlugPayments_API {
	public $gateway;

	public function __construct( $gateway = null ) {
		$this->gateway = $gateway;		
	}  

	public function money_format( $value ) {
		return intval(str_replace(array(' ', ',', '.'), '', $value));
	}

    public function payment_request( $order, $posted ) {
		$payment_method = isset( $posted['paymentType'] ) ? $posted['paymentType'] : '';

		if ( ! in_array( $payment_method, $this->gateway->allowedTypes ) ) {
			return array(
				'url'   => '',
				'data'  => '',
				'error' => array( '<strong>' . __( 'Plug', 'woocommerce-plugpayments' ) . '</strong>: ' .  __( 'Please, select a payment method.', 'woocommerce-plugpayments' ) ),
			);
		}

		$_POST['plugpayments_card_expiry'] = str_replace(array(' '), '', $_POST['plugpayments_card_expiry']);		
		$_POST['plugpayments_card_number'] = str_replace(array(' '), '', $_POST['plugpayments_card_number']);	

		$adapter = new Plug_Charges_Adapter( $this, $order, $_POST);

		call_user_func_array(array($adapter, 'to_' . $payment_method), array($_POST));

		$return = $this->gateway->sdk->post_charge($adapter->payload);
		if (isset($return['error'])) {
			$errors = array();
			if(isset($return['error']['message'])){
				$errors[] = __($return['error']['message'], 'woocommerce-plugpayments' );
			}

			if(isset($return['error']['details'])){
				foreach($return['error']['details'] as $error){
					$errors[] = __($error, 'woocommerce-plugpayments' );
				}
			}

			return array(
				'url'   => '',
				'data'  => '',
				'error' => $errors,
			);			
		}

		return array(
			'url'   => '',
			'data'  => $return
		);		
    }
}
