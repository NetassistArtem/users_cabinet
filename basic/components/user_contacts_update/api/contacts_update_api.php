<?php
/*Функция обновляет информацию в таблице user_list,  поля: user_phone, user_phone2, user_mail
 *
 * необходимо заинклюдить contacts_update_api.php
 *
 *
 * Функция обновляет информацию в таблице user_list,  поля: user_phone, user_phone2, user_mail.
 * функция update_contact_fields($host, $db_name, $user, $pass, $user_id,array $phones_active = array(), array $email_active = array(),  $one_field = 1, $phone_email_update = 1)
 *
 * Параметры функции:
 * $host -хост
 *
 * $db_name - имя базы данных
 *
 * $user - пользователь базы данных
 *
 * $pass - пароль
 *
 * $user_id - id пользователя
 *
 * $phones_active - массив содержащий активные телефоны пользователя, по умалчанию пустой массив
 * (Например $phones_active = array(
 *                                  0 => '380669998877',
 *                                  1 => '380975557878'
 *                                  ))
 *
 * $email_active - массив содержащий активные электронные адреса пользователя, по умалчанию пустой массив
 * (Например $email_active = array(
 *                                  0 => 'test@test.com.ua',
 *                                  1 => '77test@test.com'
 *                                  ))
 *
 * $one_field - параметр обновления телефонов пользователя. Така как есть два поля user_phone, user_phone2,с помощью
 * этого параметра можно определить куда именно будут записаны телефоны, значение 1 - все телефоны в первое поле,
 * вклюяая и телефоны из второго поля (во втором поле телефоны исчезнут), 2- два поля, во второе городские номера,
 * по умолчанию = 1, в одно поле
 *
 * $phone_email_update - определяет какие поля обновлять. 1-обновляются только телефоны, 2- обновляются только EMAIL, 3- обновляются все поля(телефоны и email)
 *
 *
 */


function update_contact_fields($host, $db_name, $user, $pass, $user_id,array $phones_active = array(), array $email_active = array(),  $one_field = 1, $phone_email_update = 1)
{
    require_once ('UserContactsUpdate.php');

    $userContactUpdate = new UserContactsUpdate($user_id, $phones_active, $email_active,  $one_field, $phone_email_update);



    switch($phone_email_update){
        case 1 :{
            $userContactUpdate->updatePhoneFields($host, $db_name, $user, $pass);
            break;

        }
        case 2 :{
            $userContactUpdate->updateEmailFields($host, $db_name, $user, $pass);
            break;

        }
        case 3 :{
            $userContactUpdate->updatePhoneEmailFields($host, $db_name, $user, $pass);
            break;

        }
        default :{
            $userContactUpdate->updatePhoneFields($host, $db_name, $user, $pass);
            break;

        }
    }
}