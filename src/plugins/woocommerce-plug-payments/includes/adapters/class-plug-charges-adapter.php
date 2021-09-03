<?php
defined( 'ABSPATH' ) || exit;

class Plug_Charges_Adapter {
    public function to_credit( $posted ) {
        return array();
    }

    public function to_pix( $posted ) {
        return array();
    }      

    public function to_boleto( $posted ) {
        return array();
    }      
}