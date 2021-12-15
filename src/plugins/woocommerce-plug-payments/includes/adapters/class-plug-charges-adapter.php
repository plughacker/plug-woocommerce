<?php
class Plug_Charges_Adapter {
    public function to_credit( $post, $payload, $gateway = false ) {
        
        if(!isset($post['plugpayments_card_installments'])) $post['plugpayments_card_installments'] = "1";

        $payload['paymentSource'] = array(
            "sourceType" => "card",
            "card"=> array(
                "cardNumber"=> $post['plugpayments_card_number'],
                "cardCvv"=> $post['plugpayments_card_cvv'],
                "cardExpirationDate"=> $post['plugpayments_card_expiry'],
                "cardHolderName"=> $post['plugpayments_card_holder_name']
            )
        );

        $payload['paymentMethod']['installments'] = intval($post['plugpayments_card_installments']);

        return $payload;
    }

    public function to_pix( $post, $payload, $gateway = false ) {
        if (isset($post['billing_persontype']) and !empty($post['billing_persontype'])){
            $document_type = ($post['billing_persontype'] == '1')? 'cpf' : 'cnpj';
            $document_number = ($post['billing_persontype'] == '1')? $post['billing_cpf'] : $post['billing_cnpj'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        } else if (isset($post['billing_cpf']) and !empty($post['billing_cpf'])){
            $document_type = 'cpf';
            $document_number = $post['billing_cpf'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        } else if (isset($post['billing_cnpj']) and !empty($post['billing_cnpj'])){
            $document_type = 'cnpj';
            $document_number = $post['billing_cnpj'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        }

        $payload['paymentSource'] = array(
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

        $payload['paymentMethod']['expiresIn'] = 3600;

        return $payload;
    }      

    public function to_boleto( $post, $payload, $gateway = false ) {
        if (isset($post['billing_persontype']) and !empty($post['billing_persontype'])){
            $document_type = ($post['billing_persontype'] == '1')? 'cpf' : 'cnpj';
            $document_number = ($post['billing_persontype'] == '1')? $post['billing_cpf'] : $post['billing_cnpj'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        } else if (isset($post['billing_cpf']) and !empty($post['billing_cpf'])){
            $document_type = 'cpf';
            $document_number = $post['billing_cpf'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        } else if (isset($post['billing_cnpj']) and !empty($post['billing_cnpj'])){
            $document_type = 'cnpj';
            $document_number = $post['billing_cnpj'];
            $document_number = str_replace(array('.',',','-','/'), '', $document_number);
        }

        $payload['paymentSource'] = array(
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

        $payload['paymentMethod']['expiresDate'] = date('Y-m-d', strtotime($date. ' + '.$gateway->get_option( 'boleto_expires', 5 ).' days'));
        $payload['paymentMethod']['instructions'] = $gateway->get_option( 'boleto_instructions', 'Instruções para pagamento do boleto' );
        $payload['paymentMethod']['interest'] = array(
            "days"=> intval($gateway->get_option( 'interest_days', '5' )),
            $gateway->get_option( 'interest_type', 'amount' )=> intval($gateway->get_option( 'interest_value', '5' ))
        );
        $payload['paymentMethod']['fine'] = array(
            "days"=> intval($gateway->get_option( 'fine_days', '5' )),
            $gateway->get_option( 'fine_type', 'amount' )=> intval($gateway->get_option( 'fine_value', '5' ))
        );

        return $payload;
    }       
}