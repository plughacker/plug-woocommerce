<?php
require "tests/mocks/api.php";
require "tests/mocks/order.php";

if(is_dir("src"))
  require "src/plugins/woocommerce-plug-payments/includes/class-plug-charges-adapter.php";
else
  require "wp-content/plugins/woocommerce-plug-payments/includes/class-plug-charges-adapter.php";

use PHPUnit\Framework\TestCase;

/**
 * @covers Plug_Charges_Adapter::
 */
class AdaptersTest extends TestCase{
  /**
  * @covers Plug_Charges_Adapter::to_credit
  */  
  public function testCredit(){
    $input = json_decode( file_get_contents("tests/payloads/credit/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/credit/output.json"), true);

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_credit($input);

    $this->assertEquals($adapter->payload, $output);
  }

  /**
  * @covers Plug_Charges_Adapter::to_pix
  */    
  public function testPix(){
    $input = json_decode( file_get_contents("tests/payloads/pix/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/pix/output.json"), true);

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_pix($input);

    $this->assertEquals($adapter->payload, $output);
  }

  /**
  * @covers Plug_Charges_Adapter::to_boleto
  */  
  public function testBoleto(){    
    $input = json_decode( file_get_contents("tests/payloads/boleto/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/boleto/output.json"), true);
    
    $output['paymentMethod']['expiresDate'] = date('Y-m-d', strtotime('+5 days'));

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_boleto($input);

    $this->assertEquals($adapter->payload, $output);
  }
}
