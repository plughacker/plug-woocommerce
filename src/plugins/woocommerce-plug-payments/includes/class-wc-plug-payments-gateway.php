<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Plug_Gateway extends WC_Payment_Gateway {
	public function __construct() {
		$this->id                 = 'plugpayments';
		$this->icon               = apply_filters( 'woocommerce_plugpayments_icon', plugins_url( 'assets/images/plug-50x23.png', plugin_dir_path( __FILE__ ) ) );
		$this->method_title       = __( 'Plug', 'woocommerce-plugpayments' );
		$this->method_description = __( 'Accept payments by credit card, bank debit or banking ticket using the Plug Payments.', 'woocommerce-plugpayments' );
		$this->order_button_text  = __( 'Pay', 'woocommerce-plugpayments' );

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();   

		// Define user set variables.
		$this->title              = $this->get_option( 'title' );
		$this->description        = $this->get_option( 'description' );
		$this->clientId           = $this->get_option( 'clientId' );
		$this->tokenId            = $this->get_option( 'tokenId' );
		$this->merchantId         = $this->get_option( 'merchantId' );
		$this->sandbox_merchantId = $this->get_option( 'sandbox_email' );
		$this->invoice_prefix     = $this->get_option( 'invoice_prefix', 'WC-' );
		$this->sandbox            = $this->get_option( 'sandbox', 'no' );    
		
		add_action( 'wp_enqueue_scripts', array( $this, 'checkout_scripts' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
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
			)
		);	
	}    

	public function checkout_scripts() {
		if ( is_checkout() && $this->is_available() ) {
			if ( ! get_query_var( 'order-received' ) ) {
				wp_enqueue_style( 'plugpayments-checkout', plugins_url( 'assets/css/frontend/transparent-checkout.css', plugin_dir_path( __FILE__ ) ), array(), WC_PLUGPAYMENTS_VERSION );
				wp_enqueue_script( 'plugpayments-checkout', plugins_url( 'assets/js/frontend/transparent-checkout.js', plugin_dir_path( __FILE__ ) ), array( 'jquery' ), WC_PLUGPAYMENTS_VERSION, true );
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
				'cart_total'        => $cart_total,
				'tc_credit'         => $this->tc_credit,
				'tc_transfer'       => $this->tc_transfer,
				'tc_ticket'         => $this->tc_ticket,
				'tc_ticket_message' => $this->tc_ticket_message,
				'flag'              => plugins_url( 'assets/images/brazilian-flag.png', plugin_dir_path( __FILE__ ) ),
			), 'woocommerce/plugpayments/', WC_Plug_Payments::get_templates_path()
		);
	}		
}