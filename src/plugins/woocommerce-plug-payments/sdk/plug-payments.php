<?php
class Plug_Payments_SDK {
    private $isSandbox;

	public function __construct($isSandbox = false) {
        $this->$isSandbox = $isSandbox;
    }
}