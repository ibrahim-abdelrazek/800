<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 18/11/17
 * Time: 09:04 م
 */

function getConfig($key, $return = null){
    $value = \App\Settings::where('key', $key)->first();
    if(!empty($value))
        return $value->value;
    if($return == 'int')
        return 0;
    return null;
}