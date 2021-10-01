<?php
$this->form_fields["boleto_expires"] = array(
    'title'       => __( 'Expires days', 'woocommerce-plugpayments' ),
    'type'        => 'number',
    'description' => __( 'Enter the number of days for the boleto to expire', 'woocommerce-plugpayments' ),
    'default'     => '5',
);

$this->form_fields["boleto_instructions"] = array(
    'title'       => __( 'Instructions', 'woocommerce-plugpayments' ),
    'type'        => 'text',
    'description' => __( 'Please enter your instructions for Boleto', 'woocommerce-plugpayments' ),
    'desc_tip'    => true,
    'default'     => 'Instruções para pagamento do boleto',
);

$this->form_fields["interest_type"] = array(
    'title'       => __( 'Interest', 'woocommerce-plugpayments' ),
    'type'        => 'select',
    'description' => __( 'Enter the format to interest', 'woocommerce-plugpayments' ),
    'options'     => array(
        'amount' => 'Amount',
        'percentage' => 'Percentage'
    ),
);
$this->form_fields["interest_value"] = array(
    'type'        => 'number',
    'description' => __( 'Enter value for interest', 'woocommerce-plugpayments' ),
    'default'     => '1'
);
$this->form_fields["interest_days"] = array(
    'type'        => 'number',
    'description' => __( 'Enter days for interest', 'woocommerce-plugpayments' ),
    'default'     => '5'
);


$this->form_fields["fine_type"] = array(
    'title'       => __( 'Fine', 'woocommerce-plugpayments' ),
    'type'        => 'select',
    'description' => __( 'Enter the format to fine', 'woocommerce-plugpayments' ),
    'options'     => array(
        'amount' => 'Amount',
        'percentage' => 'Percentage'
    ),
);
$this->form_fields["fine_value"] = array(
    'type'        => 'number',
    'description' => __( 'Enter value for fine', 'woocommerce-plugpayments' ),
    'default'     => '1'
);
$this->form_fields["fine_days"] = array(
    'type'        => 'number',
    'description' => __( 'Enter days for fine', 'woocommerce-plugpayments' ),
    'default'     => '5'
);