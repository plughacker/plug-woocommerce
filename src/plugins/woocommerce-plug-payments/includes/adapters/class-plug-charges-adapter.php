<?php
defined( 'ABSPATH' ) || exit;

class Plug_Charges_Adapter {
    public function to_credit( &$payload ) {
        if(!isset($_POST['plugpayments_card_installments'])) $_POST['plugpayments_card_installments'] = "1";

        $payload['paymentSource'] = array(
            "sourceType" => "card",
            "card"=> array(
                "cardNumber"=> $_POST['plugpayments_card_number'],
                "cardCvv"=> $_POST['plugpayments_card_cvv'],
                "cardExpirationDate"=> $_POST['plugpayments_card_expiry'],
                "cardHolderName"=> $_POST['plugpayments_card_holder_name']
            )
        );

        $payload['paymentMethod']['installments'] = intval($_POST['plugpayments_card_installments']);
    }

    public function to_pix( &$payload ) {
        $document_type = ($_POST['billing_persontype'] == '1')? 'cpf' : 'cnpj';
        $document_number = ($_POST['billing_persontype'] == '1')? $_POST['billing_cpf'] : $_POST['billing_cnpj'];
        $document_number = str_replace(array('.',',','-','/'), '', $document_number);

        $payload['paymentSource'] = array(
            "sourceType" => "customer",
            "customer"=> array(
                "name"=> $_POST['billing_first_name'] . ' ' . $_POST['billing_last_name'],
                "phoneNumber"=> $_POST['billing_phone'],
                "email"=> $_POST['billing_email'],
                "document"=> array(
                    "number"=> $document_number,
                    "type"=> $document_type
                )
            )
        );

        $payload['paymentMethod']['expiresIn'] = 3600;
    }      

    public function to_boleto( &$payload ) {
        $document_type = ($_POST['billing_persontype'] == '1')? 'cpf' : 'cnpj';
        $document_number = ($_POST['billing_persontype'] == '1')? $_POST['billing_cpf'] : $_POST['billing_cnpj'];
        $document_number = str_replace(array('.',',','-','/'), '', $document_number);

        $payload['paymentSource'] = array(
            "sourceType" => "customer",
            "customer"=> array(
                "name"=> $_POST['billing_first_name'] . ' ' . $_POST['billing_last_name'],
                "phoneNumber"=> $_POST['billing_phone'],
                "email"=> $_POST['billing_email'],
                "document"=> array(
                    "number"=> $document_number,
                    "type"=> $document_type
                )
            )
        );

        $payload['paymentMethod']['expiresDate'] = "2022-12-31";
        $payload['paymentMethod']['instructions'] = "Instruções para pagamento do boleto";
        $payload['paymentMethod']['interest'] = array(
            "days"=> 1,
            "amount"=> 100
        );
        $payload['paymentMethod']['fine'] = array(
            "days"=> 2,
            "amount"=> 200
        );
    }      
}