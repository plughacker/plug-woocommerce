<?php
require "tests/mocks/api.php";
require "tests/mocks/order.php";
require "wp-content/plugins/woocommerce-plug-payments/includes/adapters/class-plug-charges-adapter.php";

use PHPUnit\Framework\TestCase;

class AdaptersTest extends TestCase{
  public function testCredit(){
    $input = json_decode( file_get_contents("tests/payloads/credit/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/credit/output.json"), true);

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_credit($input);

    $this->assertEquals($adapter->payload, $output);
  }

  public function testPix(){
    $input = json_decode( file_get_contents("tests/payloads/pix/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/pix/output.json"), true);

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_pix($input);

    $this->assertEquals($adapter->payload, $output);
  }


  public function testBoleto(){    
    $input = json_decode( file_get_contents("tests/payloads/boleto/input.json"), true);
    $output = json_decode( file_get_contents("tests/payloads/boleto/output.json"), true);

    $adapter = new Plug_Charges_Adapter( new MockAPI(), new MockOrder(), $input);

    $adapter->to_boleto($input);
    
    $this->assertEquals($adapter->payload, $output);
  }
}
