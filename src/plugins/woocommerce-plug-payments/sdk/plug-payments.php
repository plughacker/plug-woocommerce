<?php
class Plug_Payments_SDK {
    public $clientId, $tokenId, $environment_url;

	public function __construct($clientId, $tokenId, $is_sandbox = false) {
        $this->clientId = $clientId;
        $this->tokenId = $tokenId;
        
        $this->environment_url = $this->get_environment_url( $is_sandbox );      
    }

    private function get_environment_url($is_sandbox) {
        return 'https://' . ( ( 'yes' == $is_sandbox ) ? 'sandbox-' : '' ) . 'api.plugpagamentos.com';      
    }   
    
    private function curl_init($url) {  
        $curl = curl_init();

        curl_setopt_array($curl, array(   
            CURLOPT_URL => $url,                     
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
              'Content-Type:application/json',
              'X-Client-Id: ' . $this->clientId,
              'X-Api-Key: ' . $this->tokenId,
              'Accept-Language: '.get_locale(),
            ),
          )
        );   

        return $curl;
    }
    
    private function curl_post($url, $payload) { 
        $curl = $this->curl_init($this->environment_url . $url);
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES);

        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload
        ));   

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function post_charge($payload) {     
        return $this->curl_post('/v1/charges', $payload);
    }      
}