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
				'error' => array( '<strong>' . __( 'Plug', 'plug-payments-gateway' ) . '</strong>: ' .  __( 'Please, select a payment method.', 'plug-payments-gateway' ) ),
			);
		}	

		$adapter = new Plug_Charges_Adapter( $this, $order, $_POST);

		call_user_func_array(array($adapter, 'to_' . $payment_method), array($_POST));

		if( 'yes' == $this->gateway->fraudanalysis ){
			$adapter->set_fraudanalysis($_POST, $order);
		}

        $payment_flow = apply_filters( 'malga_payment_flow', false, $order, $post );
		if( $payment_flow ){
			$adapter->set_payment_flow($payment_flow);
		}

		$return = $this->gateway->sdk->post_charge($adapter->payload);

		if( 'yes' == $this->gateway->debuger ){
			$request = json_encode($adapter->hide_sensitive($adapter->payload), JSON_UNESCAPED_SLASHES);
			
			$order->add_order_note( 'Request: '.$request, 'plug-payments-gateway' );
			$order->add_order_note( 'Return: '.json_encode($return), 'plug-payments-gateway' );
		}

		if($return['status'] == 'failed'){
			$errors = array();
			if(isset($return['transactionRequests'][0]['providerError'])){
				$error = $return['transactionRequests'][0]['providerError']['networkDeniedMessage'];
				$errors[] = __($error, 'plug-payments-gateway' );
			}

			return array(
				'url'   => '',
				'data'  => '',
				'error' => $errors,
			);
		}

		if (isset($return['error'])) {
			$errors = array();
			if(isset($return['error']['message'])){
				$errors[] = __($return['error']['message'], 'plug-payments-gateway' );
			}

			if(isset($return['error']['details'])){
				foreach($return['error']['details'] as $error){
					$errors[] = __($error, 'plug-payments-gateway' );
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
