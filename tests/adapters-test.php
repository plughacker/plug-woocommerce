<?php
require "wp-load.php";

use PHPUnit\Framework\TestCase;

class MockGateway{
  public function get_option($key, $default){
    return $default;
  }
}

class AdaptersTest extends TestCase{
  public function testCredit(){
    $post = [
      'plugpayments_card_installments' => '2',
      'plugpayments_card_number' => '5261424250184574', //fake
      'plugpayments_card_cvv' => '321',
      'plugpayments_card_expiry' => '06/2028',
      'plugpayments_card_holder_name' => 'JOAO DA SILVA'
    ]; 
    
    $payload = call_user_func_array(array('Plug_Charges_Adapter', 'to_credit'), array($post, $payload));

    $this->assertEquals($payload, [
      'paymentSource' => [
        'sourceType' => "card",
        'card' => [
          'cardNumber' => "5261424250184574",
          'cardCvv' => "321",
          'cardExpirationDate' => "06/2028",
          'cardHolderName' => "JOAO DA SILVA",
        ]
      ],
      'paymentMethod' => [
        'installments' => 2
      ]    
    ]);
  }

  public function testPix(){
    $post = [
      'billing_persontype' => 1,
      'billing_cpf' => "049.510.800-60", //fake
      'billing_phone' => '(88) 98888999',
      'billing_email' => 'test@plugpagamentos.com',
      'billing_first_name' => 'Testador',
      'billing_last_name' => 'Plug'
    ];

    $payload = call_user_func_array(array('Plug_Charges_Adapter', 'to_pix'), array($post, $payload));

    $this->assertEquals($payload, [
      'paymentSource' => [
        'sourceType' => "customer",
        'customer' => [
          'name' => "Testador Plug",
          'phoneNumber' => "(88) 98888999",
          'email' => "test@plugpagamentos.com",
          'document' => [
            'number' => '04951080060',
            'type' => 'cpf'
          ],
        ]
      ],
      'paymentMethod' => [
        'expiresIn' => 3600
      ]    
    ]);
  }


  public function testBoleto(){
    $post = [
      'billing_persontype' => 1,
      'billing_cpf' => "049.510.800-60", //fake
      'billing_phone' => '(88) 98888999',
      'billing_email' => 'test@plugpagamentos.com',
      'billing_first_name' => 'Testador',
      'billing_last_name' => 'Plug'
    ];

    $gateway = new MockGateway();
    $payload = call_user_func_array(array('Plug_Charges_Adapter', 'to_boleto'), array($post, $payload, $gateway));

    $this->assertEquals($payload, [
      'paymentSource' => [
        'sourceType' => "customer",
        'customer' => [
          'name' => "Testador Plug",
          'phoneNumber' => "(88) 98888999",
          'email' => "test@plugpagamentos.com",
          'document' => [
            'number' => '04951080060',
            'type' => 'cpf'
          ],
        ]
      ],
      'paymentMethod' => [
        'expiresDate' => '2021-10-19',
        'instructions' => 'Instruções para pagamento do boleto',
        'interest' => [
          'days' => 5,
          'amount' => 5,
        ],
        'fine' => [
          'days' => 5,
          'amount' => 5
        ],
      ]    
    ]);
  }
}
