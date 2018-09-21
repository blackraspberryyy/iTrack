<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('prettyPrint')){
    function prettyPrint($var){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }   
}