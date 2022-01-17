<?php
if (!function_exists('sanitize_text_field')) {
    function sanitize_text_field($str){
        return $str;
    }
}

if (!function_exists('sanitize_email')) {
    function sanitize_email($str){
        return $str;
    }
}