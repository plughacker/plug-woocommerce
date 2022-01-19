<?php
$this->form_fields["boleto_expires"] = array(
    'title'       => __( 'Expires days', 'plug-payments-gateway' ),
    'type'        => 'number',
    'label_class' => 'mishaclass',
    'description' => __( 'Enter the number of days for the boleto to expire', 'plug-payments-gateway' ),
    'default'     => '5',
);

$this->form_fields["boleto_instructions"] = array(
    'title'       => __( 'Instructions', 'plug-payments-gateway' ),
    'type'        => 'text',
    'description' => __( 'Please enter your instructions for Boleto', 'plug-payments-gateway' ),
    'desc_tip'    => true,
    'default'     => 'Instruções para pagamento do boleto',
);

$this->form_fields["interest_type"] = array(
    'title'       => __( 'Interest', 'plug-payments-gateway' ),
    'type'        => 'select',
    'description' => __( 'Enter the format to interest', 'plug-payments-gateway' ),
    'options'     => array(
        'amount' => __('Amount', 'plug-payments-gateway' ),
        'percentage' => __('Percentage', 'plug-payments-gateway' )
    ),
);
$this->form_fields["interest_value"] = array(
    'type'        => 'number',
    'description' => __( 'Enter value for interest', 'plug-payments-gateway' ),
    'default'     => '1'
);
$this->form_fields["interest_days"] = array(
    'type'        => 'number',
    'description' => __( 'Enter days for interest', 'plug-payments-gateway' ),
    'default'     => '5'
);


$this->form_fields["fine_type"] = array(
    'title'       => __( 'Fine', 'plug-payments-gateway' ),
    'type'        => 'select',
    'description' => __( 'Enter the format to fine', 'plug-payments-gateway' ),
    'options'     => array(
        'amount' => __('Amount', 'plug-payments-gateway' ),
        'percentage' => __('Percentage', 'plug-payments-gateway' )
    ),
);
$this->form_fields["fine_value"] = array(
    'type'        => 'number',
    'description' => __( 'Enter value for fine', 'plug-payments-gateway' ),
    'default'     => '1'
);
$this->form_fields["fine_days"] = array(
    'type'        => 'number',
    'description' => __( 'Enter days for fine', 'plug-payments-gateway' ),
    'default'     => '5'
);