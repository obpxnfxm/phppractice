<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2016/11/27
 * Time: 15:03
 * Function: 验证用户输入数据的函数集合
 */

// test that each variable has a value
function filled_out($form_vars) {
    foreach($form_vars as $key => $value) {
        if ( (!isset($key)) || ($value == '') ){
            return false;
        }
    }
    return true;
}

// check an email address is possibly valid
function valid_email($address) {
    if ( preg_match("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\.\-]+$", $address) ) {
        return true;
    } else {
        return false;
    }
}