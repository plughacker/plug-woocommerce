<?php
defined( 'ABSPATH' ) || exit;

class WC_Plug_Gateway extends WC_Payment_Gateway {
	public function __construct() {
		$this->id                 = 'plugpayments';
		$this->icon               = apply_filters( 'woocommerce_plugpayments_icon', plugins_url( 'assets/images/poweredbyplug.png', plugin_dir_path( __FILE__ ) ) );
		$this->method_title       = __( 'Plug', 'woocommerce-plugpayments' );
		$this->method_description = __( 'Accept payments by credit card, bank debit or banking ticket using the Plug Payments.', 'woocommerce-plugpayments' );
		$this->order_button_text  = __( 'Pay', 'woocommerce-plugpayments' );

		$this->init_form_fields();

		$this->init_settings();   

		$this->title               = $this->get_option( 'title' );
		$this->description         = $this->get_option( 'description' );
		$this->clientId            = $this->get_option( 'clientId' );
		$this->tokenId             = $this->get_option( 'tokenId' );
		$this->merchantId          = $this->get_option( 'merchantId' );
		$this->sandbox_merchantId  = $this->get_option( 'sandbox_merchantId' );
		$this->invoice_prefix      = $this->get_option( 'invoice_prefix', 'WC-' );
		$this->sandbox             = $this->get_option( 'sandbox', 'no' );    
		$this->minimum_installment = $this->get_option( 'minimum_installment', '5' );  
		$this->allowedTypes = array();
		foreach(WC_PLUGPAYMENTS_PAYMENTS_TYPES as $key => $label){
			if($this->get_option( "allow_$key", 'yes' ) == 'yes'){
				$this->allowedTypes[] = $key;
			}
		}
		
		$this->sdk = new Plug_Payments_SDK( $this->clientId, $this->tokenId, ( 'yes' == $this->sandbox ) );	
		$this->api = new WC_PlugPayments_API( $this );

		add_action( 'wp_enqueue_scripts', array( $this, 'checkout_scripts' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );
    }
    
	public function init_form_fields() {
		$this->form_fields = array(
			'title' => array(
				'title'       => __( 'Title', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => __( 'PlugPayments', 'woocommerce-plugpayments' ),
			),
			'description' => array(
				'title'       => __( 'Description', 'woocommerce-plugpayments' ),
				'type'        => 'textarea',
				'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce-plugpayments' ),
				'default'     => __( 'Pay via Plug', 'woocommerce-plugpayments' ),
			),
			'minimum_installment' => array(
				'title'       => __( 'Minimum value of the installment', 'woocommerce-plugpayments' ),
				'type'        => 'number',
				'description' => __( 'Please enter your minimum value of the installment', 'woocommerce-plugpayments' ),
				'default'     => '',
			),			
			'integration' => array(
				'title'       => __( 'Integration', 'woocommerce-plugpayments' ),
				'type'        => 'title',
				'description' => '',
			),
			'clientId' => array(
				'title'       => __( 'X-Client-Id', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter your Plug email address. This is needed in order to take payment.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => '',
            ),
			'tokenId' => array(
				'title'       => __( 'X-Api-Key', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter your Plug email address. This is needed in order to take payment.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => '',
            ),			
			'merchantId' => array(
				'title'       => __( 'MerchantId', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter your Plug email address. This is needed in order to take payment.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => '',
            ),						
			'sandbox' => array(
				'title'       => __( 'Sandbox', 'woocommerce-plugpayments' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable Plug Sandbox', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => 'no',
				'description' => __( 'Plug Sandbox can be used to test the payments.', 'woocommerce-plugpayments' ),
			),
			'merchantId' => array(
				'title'       => __( 'MerchantId', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter your Plug email address. This is needed in order to take payment.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => '',
            ),
			'sandbox_merchantId' => array(
				'title'       => __( 'Sandbox MerchantId', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter your Plug sandbox merchantId', 'woocommerce-plugpayments' ),
				'default'     => '',
			),
			'behavior' => array(
				'title'       => __( 'Integration Behavior', 'woocommerce-plugpayments' ),
				'type'        => 'title',
				'description' => '',
			),
			'invoice_prefix' => array(
				'title'       => __( 'Invoice Prefix', 'woocommerce-plugpayments' ),
				'type'        => 'text',
				'description' => __( 'Please enter a prefix for your invoice numbers.', 'woocommerce-plugpayments' ),
				'desc_tip'    => true,
				'default'     => 'WC-',
			),
			'transparent_checkout' => array(
				'title'       => __( 'Transparent Checkout Options', 'woocommerce-plugpayments' ),
				'type'        => 'title',
				'description' => '',
			),			
		);
		
		foreach(WC_PLUGPAYMENTS_PAYMENTS_TYPES as $key => $label){
			$this->form_fields["allow_$key"] = array(
				'title'   => __( $label, 'woocommerce-plugpayments' ),
				'type'    => 'checkbox',
				'label'   => __( "Enable $label", 'woocommerce-plugpayments' ),
				'default' => 'yes',
			);
		}
	}    

	public function checkout_scripts() {
		if ( is_checkout() && $this->is_available() ) {
			if ( ! get_query_var( 'order-received' ) ) {
				wp_enqueue_style( 'plugpayments-checkout', plugins_url( 'assets/css/transparent-checkout.css', plugin_dir_path( __FILE__ ) ), array(), WC_PLUGPAYMENTS_VERSION );
				wp_enqueue_script( 'plugpayments-checkout', plugins_url( 'assets/js/min/transparent-checkout-min.js', plugin_dir_path( __FILE__ ) ), array( 'jquery' ), WC_PLUGPAYMENTS_VERSION, true );
			}
		}
	}

	public function payment_fields() {
		wp_enqueue_script( 'wc-credit-card-form' );

		$description = $this->get_description();
		if ( $description ) {
			echo wpautop( wptexturize( $description ) ); // WPCS: XSS ok.
		}

		$cart_total = $this->get_order_total();

		wc_get_template(
			'transparent-checkout-form.php', array(
				'cart_total'         => $cart_total,
				'minimum_installment'=> $this->minimum_installment,
			), 'woocommerce/plugpayments/', WC_Plug_Payments::get_templates_path()
		);
	}	

	public function get_clientId() {
		return $this->clientId;
	}

	public function get_tokenId() {
		return $this->tokenId;
	}	

	public function get_merchantId() {
		return 'yes' === $this->sandbox ? $this->sandbox_merchantId : $this->gateway->merchantId;
	}		
	
	public function update_order_status( $order, $payment ) {
		switch ( $payment['status'] ) {
			case 'authorized':
				$order->update_status( 'processing', __( 'Plug: Payment approved.', 'woocommerce-plugpayments' ) );
				$order->add_order_note( sprintf(__( 'Plug: Payment approved (%s) by %s', 'woocommerce-plugpayments' ), $payment['id'], $payment['paymentMethod']['paymentType']) );
				wc_reduce_stock_levels( $order->get_order_number() );				
				break;
			case 'pre_authorized':
				$order->update_status( 'on-hold', __( 'Plug: Payment is pre-authorized', 'woocommerce-plugpayments' ) );				
				break;
			case 'pending':				
				$order->update_status( 'pending"', __( 'Plug: Payment is pending', 'woocommerce-plugpayments' ) );	
				break;
			case 'failed':				
				$order->update_status( 'failed', __( 'Plug: Payment is failed', 'woocommerce-plugpayments' ) );	
				break;
			case 'canceled':				
				$order->update_status( 'failed', __( 'Plug: Payment is canceled', 'woocommerce-plugpayments' ) );	
				break;
			case 'voided':
				$order->update_status( 'refunded', __( 'Plug: Payment refunded', 'woocommerce-plugpayments' ) );
				wc_increase_stock_levels( $order->get_order_number() );
				break;	
			case 'charged_back':
				$order->update_status( 'refunded', __( 'Plug: Payment came into dispute.', 'woocommerce-plugpayments' ) );							
				break;																			
			default:
				break;				
		}
	}

	protected function save_payment_meta_data( $order, $payment ) {
		$meta_data    = array(
			'paymentStatus' => $payment['status'],
			'paymentType' => $payment['paymentMethod']['paymentType'],
		);

		$meta_data['_wc_plug_payment_data'] = $payment;

		foreach ( $meta_data as $key => $value ) {
			$order->update_meta_data( $key, $value );
		}
		$order->save();		
	}

	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );
	
		$response = $this->api->payment_request( $order, $_POST );

		if ( !empty($response['data']) ) {
			$this->update_order_status( $order, $response['data'] );
			$this->save_payment_meta_data( $order, $response['data'] );

			if( $response['data']['status']  == 'authorized' || $response['data']['status']  == 'pending') {
				WC()->cart->empty_cart();

				if($response['data']['status']  == 'authorized'){ 
					$redirect = $order->get_checkout_order_received_url();
				} else { 
					$redirect = $order->get_checkout_payment_url( true );
				}

				return array(
					'result'   => 'success',
					'redirect' => $redirect
				);			
			}else{
				wc_add_notice( array('Plug: Your payment '. $response['data']['status'] .' :('), 'error' );					
				return array(
					'result'   => 'fail',
					'redirect' => ''
				);						
			}				
		}else{
			if(!isset($response['error']) || empty($response['error'])){
				$errors = array( 
					__( 'Internal error :(', 'woocommerce-plugpayments' ) 
				);
			}
			
			foreach ( $response['error'] as $error ) {
				wc_add_notice( $error, 'error' );
			}
	
			return array(
				'result'   => 'fail',
				'redirect' => '',
			);
		}
	}

	public function receipt_page( $order_id ) {
		$order        = wc_get_order( $order_id );

		$paymentType = $order->get_meta( 'paymentType');
		$paymentStatus =  $order->get_meta( 'paymentStatus');
		$paymentData =  $order->get_meta( '_wc_plug_payment_data');

		wc_get_template(
			"receipt/$paymentType.php", array(
				'payment_data'         => $paymentData,
			), 'woocommerce/plugpayments/', WC_Plug_Payments::get_templates_path()
		);
	}
}