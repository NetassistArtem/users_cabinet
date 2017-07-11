<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 08.07.17
 * Time: 16:38
 */
$formFields = array();
foreach($test as $k=> $value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value, ENT_QUOTES|ENT_HTML401);
}