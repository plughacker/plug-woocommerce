<?php
defined( 'ABSPATH' ) || exit;

class WC_PlugPayments_API {
	protected $gateway;
    private $isSandbox;
    private $plug;

	public function __construct( $gateway = null ) {
		$this->gateway = $gateway;
        $this->$isSandbox = ( 'yes' == $this->gateway->sandbox );
        $this->$plug = new Plug_Payments_SDK( $this->$isSandbox );
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

        //process
    }
}