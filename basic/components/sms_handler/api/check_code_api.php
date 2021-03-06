<?php

/* Функции создания кода для отправки пользователям в виде смс или в электронной почте с последующей
 * проверкой прваильности введеного кода пользователем.
 *
 * необходимо заинклюдить check_code_api.php
 *
 * Функция создания текста с кодом
 * create_code($lang, $text, $translit, $length = 8, $chars_num = 1, $chars_down_chars = 0, $chars_up_chars = 0)
 *
 * Параметры функции:
 *
 * $lang - язык в виде кода (например, ua,UA,ua-UA, UA-ua,uk,UK, uk-UK, UK-uk)
 * $text - текст который будет предшествовать коду (например: Введите следующий код: $code),если без текста то ""
 * $translit - транслитерация текста 1 - транслитерация, 0 - без транслитерации, по умолчанию 0
 * $length - длинна кода в символах, по умалчанию 8
 * $chars_num - использование в формировании кода цифр 1-использовать, 0-не использовать, по умолчанию 1
 * $chars_down_chars -использовать в формировании кода буквы англ. алфавита в нижнем регистре 1- использовать,
 *  0- не использовать,по умаолчанию 0
 * $chars_up_chars = использовать в формировании кода буквы англ. алфавита в верхнем регистре 1- использовать,
 *  0- не использовать,по умаолчанию 0
 *
 * Возвращает строку содержащую текст сообщения с кодом
 *
 *
 * Функция проверки кода введенного пользователем
 * check_code($post_user_code)
 *
 * Параметры функции:
 *
 * $post_user_code - код введенный пользователем (допустим из пост запроса)
 *
 * Возвращает THRUE  если проверка прошла успешно и FALSE  если не совпадает
 *
 *
 *
 */


function create_code($lang, $text = '', $translit = 0, $length = 8, $chars_num = 1, $chars_down_chars = 0, $chars_up_chars = 0)
{
    require_once ('UserSms.php');

    $userSms = new UserSms($lang);

 return   $userSms->createSmsTextPasswordChange($text, $translit, $length, $chars_num, $chars_down_chars, $chars_up_chars);

}

function check_code($post_user_code)
{
    require_once ('UserSms.php');

    $userSms = new UserSms();

  return  $userSms->checkCode($post_user_code);

}