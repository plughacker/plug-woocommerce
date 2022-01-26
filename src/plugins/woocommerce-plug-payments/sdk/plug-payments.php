<?php
class Plug_Payments_SDK {
    public $clientId, $tokenId, $environment_url, $headers;

	public function __construct($clientId, $tokenId, $is_sandbox = false) {
        $this->clientId = $clientId;
        $this->tokenId = $tokenId;
        
        $this->environment_url = $this->get_environment_url( $is_sandbox );  
        $this->headers = array(
            'Content-Type' => 'application/json',
            'X-Client-Id' => $this->clientId,
            'X-Api-Key' => $this->tokenId,
            'Accept-Language' => str_replace('_', '-',strtolower(get_locale())),
        );
    }

    private function get_environment_url($is_sandbox) {
        return 'https://' . ( ( 'yes' == $is_sandbox ) ? 'sandbox-' : '' ) . 'api.plugpagamentos.com';      
    }
    
    private function post($url, $payload) { 
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES);

        $response = wp_remote_post( $this->environment_url . $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => $this->headers,
            'body'        => $payload,
            'data_format' => 'body',
            )
        );
        
        return json_decode($response['body'], true);
    }

    public function post_charge($payload) {     
        return $this->post('/v1/charges', $payload);
    }      
}