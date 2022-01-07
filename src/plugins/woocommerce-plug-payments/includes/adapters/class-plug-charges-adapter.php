<?php
class Plug_Charges_Adapter {
    public $gateway, $payload;

	public function __construct($api, $order, $post) {
        $this->gateway = $api->gateway;

		$this->payload = array(
			"merchantId"=> $this->gateway->get_merchantId(),
			"amount"=> $api->money_format( $order->get_total() ),
			"statementDescriptor"=> $this->gateway->statement_descriptor,
			"capture"=> true,
			"orderId"=> $order->get_order_number(),
			"paymentMethod"=> array(
				"paymentType"=> $post['paymentType']
			)			
		);        
    }

    private function get_document( $post ) {
        if (isset($post['billing_persontype']) and !empty($post['billing_persontype'])){
            $document_type = ($post['billing_persontype'] == '1')? 'cpf' : 'cnpj';
            $document_number = ($post['billing_persontype'] == '1')? $post['billing_cpf'] : $post['billing_cnpj'];
        } else if (isset($post['billing_cpf']) and !empty($post['billing_cpf'])){
            $document_type = 'cpf';
            $document_number = $post['billing_cpf'];
        } else if (isset($post['billing_cnpj']) and !empty($post['billing_cnpj'])){
            $document_type = 'cnpj';
            $document_number = $post['billing_cnpj'];
        }
        $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        return array($document_type, $document_number);
    }

    public function to_credit( $post ) {
        if(!isset($post['plugpayments_card_installments'])) $post['plugpayments_card_installments'] = "1";

        $this->payload['paymentSource'] = array(
            "sourceType" => "card",
            "card"=> array(
                "cardNumber"=> $post['plugpayments_card_number'],
                "cardCvv"=> $post['plugpayments_card_cvv'],
                "cardExpirationDate"=> $post['plugpayments_card_expiry'],
                "cardHolderName"=> $post['plugpayments_card_holder_name']
            )
        );

        $this->payload['paymentMethod']['installments'] = intval($post['plugpayments_card_installments']);
    }

    public function to_pix( $post ) {
        list($document_type, $document_number) = $this->get_document($post);

        $this->payload['paymentSource'] = array(
            "sourceType" => "customer",
            "customer"=> array(
                "name"=> $post['billing_first_name'] . ' ' . $post['billing_last_name'],
                "phoneNumber"=> $post['billing_phone'],
                "email"=> $post['billing_email'],
                "document"=> array(
                    "number"=> $document_number,
                    "type"=> $document_type
                )
            )
        );

        $this->payload['paymentMethod']['expiresIn'] = 3600;
    }      


    public function to_boleto( $post ) {
        list($document_type, $document_number) = $this->get_document($post);

        $this->payload['paymentSource'] = array(
            "sourceType" => "customer",
            "customer"=> array(
                "name"=> $post['billing_first_name'] . ' ' . $post['billing_last_name'],
                "phoneNumber"=> $post['billing_phone'],
                "email"=> $post['billing_email'],
                "document"=> array(
                    "number"=> $document_number,
                    "type"=> $document_type
                )
            )
        );

        $this->payload['paymentMethod']['expiresDate'] = date('Y-m-d', strtotime(' + '.$this->gateway->get_option( 'boleto_expires', 5 ).' days'));
        $this->payload['paymentMethod']['instructions'] = $this->gateway->get_option( 'boleto_instructions', 'Instruções para pagamento do boleto' );
        $this->payload['paymentMethod']['interest'] = array(
            "days"=> intval($this->gateway->get_option( 'interest_days', '5' )),
            $this->gateway->get_option( 'interest_type', 'amount' )=> intval($this->gateway->get_option( 'interest_value', '5' ))
        );
        $this->payload['paymentMethod']['fine'] = array(
            "days"=> intval($this->gateway->get_option( 'fine_days', '5' )),
            $this->gateway->get_option( 'fine_type', 'amount' )=> intval($this->gateway->get_option( 'fine_value', '5' ))
        );
    }       
}