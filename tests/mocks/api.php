<?php 
class MockGateway{
    public $statement_descriptor;
    public $currency = "BRL";

    public function get_option($key, $default){
      return $default;
    }

    public function get_merchantId(){
      return '61aed09b-e369-453f-b707-5a1b66c9de7e';
    }
}

class MockAPI{
  public $gateway;

  public function __construct() {
    $this->gateway = new MockGateway();	
  }

	public function money_format( $value ) {
		return "1000";
	}  
}