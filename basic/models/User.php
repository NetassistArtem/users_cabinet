<?php

namespace app\models;

use Yii;

use app\components\debugger\Debugger;
use app\models\ArhivNews;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;


    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',

        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',

        ],
        '103' => [
            'id' => '103',
            'username' => 'test',
            'password' => 'test',

        ],
    ];

    public static function UserIdentityData()
    {

        if (Yii::$app->request->isPost && isset(Yii::$app->request->post('LoginForm')['username'])) {
            global $is_admin;

            $is_admin = _is_admin(Yii::$app->request->post('LoginForm')['username'], Yii::$app->request->post('LoginForm')['password']);
            $user_id_data = array(
                'id' => $GLOBALS['auth_user_id'],
                'username' => $GLOBALS['auth_user_name'],
                'password' => Yii::$app->request->post('LoginForm')['password'],
            );


            Yii::$app->session->set('user-data-id', $user_id_data);
            Yii::$app->session->set('u_name', $GLOBALS['auth_user_name']);//нужно для работы billing api
        }

        $user_identity_data = array(
            Yii::$app->session->get('user-data-id')['id'] => array(
                'id' => Yii::$app->session->get('user-data-id')['id'],
                'username' => Yii::$app->session->get('user-data-id')['username'],
                'password' => Yii::$app->session->get('user-data-id')['password'],
                // 'u_name' => Yii::$app->session->get('user-data-id')['u_name'],
            ),
            '103' => array(
                'id' => 103,
                'username' => 'test',
                'password' => 'test'
            )

        );


        if (!empty(self::$users)) {
            self::$users = $user_identity_data;
        }
        return self::$users;
    }

    public static function UserData()
    {

        //   Debugger::PrintR(get_user_info_by_ids(Yii::$app->user->id));
        global $is_admin;


        $is_admin = _is_admin();//функция апи биллинга, проверяет пользователя сравнивая с сесией, при каждой загрузке страници
      // Debugger::Br();
       // Debugger::VarDamp($is_admin);
        $user_data_by_billing = get_user_info_by_ids(Yii::$app->user->id);//iconv_safe('koi8','utf-8',get_user_info_by_ids(Yii::$app->user->id)) ;
        $test = iconv_safe('koi8-u', 'utf-8', $user_data_by_billing['34']);
        // $test2 = get_acc_options($user_data_by_billing[UINFO_ACC_ID_IDX], -1) ;//$user_data_by_billing[UINFO_ACC_ID_IDX]

        //  echo '</br>';
        //  echo '</br>';
        //  echo '</br>';

        // Debugger::PrintR($test2);
        //   echo '</br>';
        // echo $test2;
        global $gw;
        global $ip_1;
        global $ip_2;
        global $netmask;
        global $netmask2;
        global $external_smtp;
        global $dns1_ip;
        global $dns2_ip;
//$is_admin = 0;
       // Debugger::Eho($is_admin);


        if (user_option_check(USER_OPT_HAVE_BLOCK_CTL, $user_data_by_billing[UINFO_NET_ID_IDX])) {  //функции api биллинга
            get_user_ipv4_settings($user_data_by_billing[UINFO_REAL_IP4_IDX], $user_data_by_billing[UINFO_LOCAL_IP4_IDX], $user_data_by_billing[UINFO_NET_ID_IDX], $gw, $ip_1, $ip_2, $netmask, $netmask2, $external_smtp, $dns1_ip, $dns2_ip);//функции api биллинга
        }


        $access_mx = get_user_mx_options(Yii::$app->user->id);


        $mx_string = iconv_safe('koi8-u', 'utf-8', get_access_mxs_str($access_mx, $lang_id = -1));


        $sm_flags = get_acc_options($user_data_by_billing[UINFO_ACC_ID_IDX], -1); //функции api биллинга


        //Debugger::PrintR($sm_flags);


        $sms_mail_flags_arr = print_sm_options($sm_flags[4], "sm_flag", SM_FLAGS_CTL_ARR); //функции api биллинга

        // Debugger::PrintR($sms_mail_flags_arr);

        $array_sms_mail = array_chunk($sms_mail_flags_arr, 5);

        $array_sms_flags = array();
        $array_mail_flags = array();
        foreach ($array_sms_mail[0] as $k => $v) {
            if ($v[1] != 0) {
                $array_mail_flags[] = $k;
            }
        }

        foreach ($array_sms_mail[1] as $k => $v) {
            if ($v[1] != 0) {
                $array_sms_flags[] = $k;
            }
        }


        //   Debugger::Eho('</br>');
        //   Debugger::Eho('</br>');
        //   Debugger::Eho('</br>');
        //   Debugger::Eho('</br>');
        //   Debugger::Eho('</br>');
        //   Debugger::Eho('</br>');
        //  Debugger::PrintR($user_data_by_billing);
        //  Debugger::Eho($test);
        global $user_acc_offset;

        // преобразование контактов из строки в массив
        $phone_1_array = !empty($user_data_by_billing[UINFO_PHONE_IDX]) ? explode(',', $user_data_by_billing[UINFO_PHONE_IDX]) : array();
        //  $phone_1_array = explode(',',$user_data_by_billing[UINFO_PHONE_IDX] );
        $phone_2_array = !empty($user_data_by_billing[UINFO_PHONE2_IDX]) ? explode(',', $user_data_by_billing[UINFO_PHONE2_IDX]) : array();
        //  $phone_2_array = explode(',',$user_data_by_billing[UINFO_PHONE2_IDX] );
        $email_a = !empty($user_data_by_billing[UINFO_EMAIL_IDX]) ? explode(',', $user_data_by_billing[UINFO_EMAIL_IDX]) : array();
        //$email_array = explode(',',$user_data_by_billing[UINFO_EMAIL_IDX] );
        $phone_all_a = array_merge($phone_1_array, $phone_2_array);
        $phone_all_array = array();
        foreach ($phone_all_a as $k => $v) {
            $phone_all_array[$k + 1] = $v;
        }
        $email_array = array();
        foreach ($email_a as $key => $val) {
            $email_array[$key + 1] = $val;
        }

        $lang = explode('-', Yii::$app->language)[0];
        // получение данных по услугам пользователей
        global $svc_log_offs;//переменная биллинга
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho(get_tariff_name(3, $lang));

        $svc_name = array();
        $svc_enable_name = array();
        $svc_enable_num = array();
        $svc_time_to = array();
        $svc_tariff_name = array();
        $svc_price_monthly = array();
        $svc_auto_activation = array();
        $svc_activation_number = array();
        $svc_pause_date_start = array();
        $svc_tariff_info = array();
        $svc_credit_allowed = array();
        $svc_type_id = array();
        $svc_subtype_id = array();
        $svc_tariff_daily_price = array();
        $svc = svc_get_list($user_data_by_billing[UINFO_ACC_ID_IDX], -1, -1, 2);//функция биллинга
        foreach ($svc as $t => $v) {
            $svc[$t] = svc_get_rec_info($v[SVC_LOG_REC_ID_IDX], $v[SVC_LOG_CHAIN_ID_IDX]); //функция биллинга
            $svc_name_str = db_unquote($svc[$t][$svc_log_offs + SVC_LIST_NAME_IDX]);
            $svc_enable_name_str = iconv_safe('koi8-u', 'utf-8', get_svc_state_name($svc[$t][SVC_LOG_ENABLE_IDX], $lang));// get_svc_state_name функция биллинга
            $svc_time_to_str = !empty($svc[$t][SVC_LOG_PTS2_IDX]) ? date("d.m.Y", strtotime(ptimestamp_to_str($svc[$t][SVC_LOG_PTS2_IDX], $sep = " ", $dsep = "-", $isep = ":"))) : Yii::t('cabinet', 'end_time');// ptimestamp_to_str функция биллинга
            $svc_tariff_name_str = get_tariff_name($v[SVC_LOG_TARIFF_ID_IDX], $lang);
            $svc_tariff_info_str = parse_tariff_info($v[SVC_LOG_TARIFF_ID_IDX]);
            $svc_activation_number_str = $v[SVC_LOG_PERIODS_IDX];
            $svc_pause_date_start_str = !empty($v[SVC_LOG_PAUSE_PTS1_IDX]) ? date("d.m.Y", strtotime(ptimestamp_to_str($v[SVC_LOG_PAUSE_PTS1_IDX], $sep = " ", $dsep = "-", $isep = ":"))) : 0;

            //   Debugger::Eho('</br>');
            // Debugger::Eho('</br>');
            //  Debugger::Eho('</br>');
            // Debugger::Eho($svc_activation_number_str);
            // Debugger::Eho($v[SVC_LOG_TARIFF_ID_IDX]);
            //  Debugger::Eho('</br>');
            //   Debugger::Eho(get_tariff_name($v[SVC_LOG_TARIFF_ID_IDX], $lang));


            $svc_price_monthly_str = $v[SVC_LOG_MONTHLY_IDX] * 0.001;
            $svc_auto_activation_str = $v[SVC_LOG_AUTO_IDX];
            $svc_enable_num_str = $v[SVC_LOG_ENABLE_IDX];
            $svc_type_id_str = $v[SVC_LOG_TYPE_IDX];
            $svc_subtype_id_str = $v[SVC_LOG_SUBTYPE_IDX];
            $svc_tariff_daily_price_str = $v[SVC_LOG_DAILY_IDX];
            $svc_credit_allowed_str = $svc[$t][$svc_log_offs + SVC_LIST_ALLOW_CREDIT_IDX];
            $svc[$t]['svc_name'] = $svc_name_str;
            $svc_name[] = $svc_name_str;
            $svc[$t]['enable_name'] = $svc_enable_name_str;
            $svc_enable_name[] = $svc_enable_name_str;
            $svc[$t]['time_to'] = $svc_time_to_str;
            $svc_time_to[] = $svc_time_to_str;
            $svc[$t]['tariff_name'] = $svc_tariff_name_str;
            $svc_tariff_name[] = $svc_tariff_name_str;
            $svc[$t]['price_monthly'] = $svc_price_monthly_str;
            $svc_price_monthly[] = $svc_price_monthly_str;
            $svc_tariff_daily_price[] = $svc_tariff_daily_price_str;
            $svc[$t]['price_daily'] = $svc_tariff_daily_price_str;
            $svc[$t]['auto_activation'] = $svc_auto_activation_str;
            $svc_auto_activation[] = $svc_auto_activation_str;
            $svc[$t]['enable_num'] = $svc_enable_num_str;
            $svc_enable_num[] = $svc_enable_num_str;
            $svc_tariff_info[] = $svc_tariff_info_str;
            $svc[$t]['svc_tariff_info'] = $svc_tariff_info_str;
            $svc_activation_number[] = $svc_activation_number_str;
            $svc[$t]['svc_activation_number'] = $svc_activation_number_str;
            $svc_pause_date_start[] = $svc_pause_date_start_str;
            $svc[$t]['svc_pause_date_start'] = $svc_pause_date_start_str;
            $svc_credit_allowed[] = $svc_credit_allowed_str;
            $svc[$t]['svc_credit_allowed'] = $svc_credit_allowed_str;
            $svc_subtype_id[] = $svc_subtype_id_str;
            $svc[$t]['svc_subtype_id'] = $svc_subtype_id_str;
            $svc_type_id[] = $svc_type_id_str;
            $svc[$t]['svc_type_id'] = $svc_type_id_str;

        }
      //  Debugger::PrintR($svc);

        // Debugger::Eho($user_a/cc_offset);
        //  Debugger::Eho('</br>');
        // Debugger::Eho($user_data_by_billing[$user_acc_offset+AINFO_MONEY_IDX]);
        //  Debugger::PrintR($user_data_by_billing);
//Debugger::Eho(Yii::$app->user->id);
            //  Debugger::testDie();

        $modelArhivNews = new ArhivNews();
        $archive_news_data = $modelArhivNews->getArhiv($user_data_by_billing[UINFO_ACC_ID_IDX]);

        $archive_news_not_reade = array();
        foreach($archive_news_data as $k => $v){
            if(!$v['view']){
                $archive_news_not_reade[] = $v;
            }
        }
        $user_name = Yii::$app->user->identity->username;
        $user_skin = get_skin($user_name);



        $ipv6 = get_user_ipv6_settings(Yii::$app->user->id, $user_data_by_billing[UINFO_IP6_IDX],
            /* OUTPUT */
            $gw6, $netmask6, $cli_v6_net, $cli_v6_gw, $cli_v6_mask, $ipv6_dns, $rt_list);

        

        $user_data = array(
            Yii::$app->session->get('user-data-id')['id'] => array(
              //  'test' => svc_get_avg_pay_rate($user_data_by_billing[UINFO_ACC_ID_IDX], SVC_SUM_SEPARATE),
                'username' => $user_name,
                'fio' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[$user_acc_offset + AINFO_CONTRACT_NAME_IDX]),
                'password' => $user_data_by_billing[UINFO_PWD_IDX],
                'email' => $user_data_by_billing[UINFO_EMAIL_IDX],
                'email_array' => $email_array,
                'pin' => normalize_pay_pin($user_data_by_billing[$user_acc_offset + AINFO_PIN_IDX], $user_data_by_billing[UINFO_ACC_ID_IDX]) ,
                'address' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[UINFO_ADDR_IDX]),
                'address_id' => $user_data_by_billing[UINFO_BASE_LOC_ID_IDX],
                'phone_1' => $user_data_by_billing[UINFO_PHONE_IDX],
                'phone_1_array' => $phone_1_array,
                'phone_2' => $user_data_by_billing[UINFO_PHONE2_IDX],
                'phone_2_array' => $phone_2_array,
                'phone_all_array' => $phone_all_array,
                'skin' => $user_skin == -1 ? Yii::$app->params['alfa_skin_default'] : $user_skin,
                'account_id' => $user_data_by_billing[UINFO_ACC_ID_IDX],
                'account_balance' => $user_data_by_billing[$user_acc_offset + AINFO_MONEY_IDX] * 0.001,
                'account_credit' => $user_data_by_billing[$user_acc_offset + AINFO_DEBT_IDX] * 0.001,
                'account_max_credit' => $user_data_by_billing[$user_acc_offset + AINFO_MAX_DEBT_IDX] * 0.001,
                'account_currency' => iconv_safe('koi8-u', 'utf-8', get_curr_name_by_cid($user_data_by_billing[$user_acc_offset + AINFO_C_ID_IDX])),
                'services' => $svc_name,
                'services_status_num' => $svc_enable_num,
                'services_tariff_info' => $svc_tariff_info,
                'services_status' => $svc_enable_name,
                'services_date' => $svc_time_to,
                'services_tariff_name' => $svc_tariff_name,
                'services_tariff_month_price' => $svc_price_monthly,
                'services_tariff_daily_price' => $svc_tariff_daily_price,
                'svc_auto_activation' => $svc_auto_activation,
                'svc_activation_number' => $svc_activation_number,
                'svc_pause_date_start' => $svc_pause_date_start,
                'svc_credit_allowed' => $svc_credit_allowed,
                'svc_type_id' => $svc_type_id,
                'svc_subtype_id' => $svc_subtype_id,
                'svc' => $svc,
                'ip_real_constant' => $user_data_by_billing[UINFO_REAL_IP4_IDX],
                'ip_local_constant' => $user_data_by_billing[UINFO_LOCAL_IP4_IDX],
                'ip_1' => $ip_1,
                'ip_2' => $ip_2,
                'gw' => $gw,
                'dns1_ip' => $dns1_ip,
                'dns2_ip' => $dns2_ip,
                'netmask' => $netmask,
                'netmask2' => $netmask2,
                'external_smtp' => $external_smtp,
                'mx_string' => $mx_string,
                'ipv6' => $ipv6,
                'gw6' => $gw6,
                'netmask6' => $netmask6,
                'cli_v6_net' => $cli_v6_net,
                'cli_v6_gw' => $cli_v6_gw,
                'cli_v6_mask' => $cli_v6_mask,
                'ipv6_dns_array' => isset($ipv6_dns) ? explode(',',$ipv6_dns) : array(),
                'net_id' => $user_data_by_billing[UINFO_NET_ID_IDX],
                'org_id' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[$user_acc_offset + AINFO_ORG_ID_IDX]),
                'real_name' => $user_data_by_billing[UINFO_REAL_NAME_IDX],
                'req_id' => $user_data_by_billing[$user_acc_offset + AINFO_REQ_ID_IDX],
                'loc_id' => $user_data_by_billing[UINFO_BASE_LOC_ID_IDX],
                'archive_news_not_reade' => $archive_news_not_reade,


                'email_message_type' => $array_mail_flags,
                'sms_message_type' => $array_sms_flags,
                'email_message_type_all' => $array_sms_mail[0],
                'sms_message_type_all' => $array_sms_mail[1],
            ),
            '103' => array(
                'username' => 'test',
                'fio' => array(
                    'f' => 'Test',
                    'i' => 'Иван',
                    'o' => 'Иванович',
                ),
                'account_balance' => '5,7',
                'services' => array('"Безлимитный"'),
                'services_date' => array('03.08.17'),
                'ip' => '94.154.293.84',
            ),

        );
//Debugger::PrintR($user_data);
//Debugger::PrintR($user_data_by_billing);
        Yii::$app->session->set('user-data', $user_data);

    }

    public static function SupportData()
    {

        $data = get_lang_opt_list("support_classes");//функция из api биллинга
        $data[0] = Yii::t('support', 'select_option');

        $support_data = array(

            'problem-type' => $data,

        );

        return $support_data;
    }


    public static function TodoHistory($user_name)
    {
        $todo_array = array();
        $todo_filters = array("user_name" => $user_name, "user_only" => 1, "all" => 1);
        $todo_records_result = list_todo(0, false, false, "upd", "upd", 0, $todo_filters);
        if ($todo_records_result) {
            $todo_records = list_todo_enum($todo_records_result, $todo_filters, 0, 1000);
            if (is_array($todo_records)) {
                foreach ($todo_records as $v => $k) {
                    $todo_array[$v] = array(
                        'todo_id' => $k[TODO_ID_IDX],
                        'todo_init_time' => itimestamp_to_str($k[TODO_INIT_TIME_IDX], $sep = " ", $dsep = "-", $isep = ":"),
                        'todo_end_time' => itimestamp_to_str($k[TODO_REQ_TIME_IDX], $sep = " ", $dsep = "-", $isep = ":"),
                        'todo_admin_id' => get_user_info_by_ids(UID_ANY, $k[TODO_ACC_ID_IDX])[UINFO_NAME_IDX],//$k[TODO_ADMIN_ID_IDX],
                        'todo_state' => Yii::t('support_history_todo_status', Yii::$app->params['todo_status'][$k[TODO_STATE_IDX]]['lang_key']),
                        'todo_subj' => iconv_safe('koi8-u', 'utf-8', $k[TODO_SUBJ_IDX]),//web_encode($k[TODO_SUBJ_IDX]),
                    );
                }
                // $todo_records = iconv_safe('koi8-u','utf-8',$todo_records);
            }
        }
        return $todo_array;
    }

    public static function TodoHistoryNode($user_name, $todo_id, $account_id)
    {

        $todo_data = load_todo_simple($todo_id, 0, $account_id);

        /*
                       echo '</br>';
                       echo '</br>';
                       echo '</br>';
                       echo '</br>';
                       echo $todo_data;

                       Debugger::PrintR($todo_data);
              */
        /*
                $todo_filters = array( "target_todo_id" => '$todo_id',"user_name" => $user_name, "user_only" => 1, "all" => 1 );
                $todo_records_result = list_todo(0, false, false, "upd", "upd", 2,   $todo_filters);
                if($todo_records_result) {
                    $todo_records = list_todo_enum($todo_records_result, $todo_filters, 0, 1000);
                    if(is_array($todo_records)) {
                       // Debugger::PrintR($todo_records);
                        foreach($todo_records as $v => $k){
                            if($k[TODO_ID_IDX] == $todo_id){
                             $todo_data[] = $k;
                              //  return $todo_data;
                             //   $todo_data['todo_id'] = $k[TODO_ID_IDX];
                             //   $todo_data ['todo_init_time'] = itimestamp_to_str($k[TODO_INIT_TIME_IDX],$sep=" ",$dsep="-",$isep=":");
                            //    $todo_data['todo_end_time'] = itimestamp_to_str($k[TODO_END_TIME_IDX],$sep=" ",$dsep="-",$isep=":");
                            //    $todo_data['todo_admin_id'] = get_user_info_by_ids( $k[TODO_ADMIN_ID_IDX])[UINFO_NAME_IDX];//$k[TODO_ADMIN_ID_IDX],
                            //    $todo_data['todo_state'] = Yii::t('support_history_todo_status',Yii::$app->params['todo_status'][$k[TODO_STATE_IDX]]['lang_key']);
                           //    $todo_data['todo_subj'] = iconv_safe('koi8-u','utf-8',$k[TODO_SUBJ_IDX]);

                        }
                        }
                        // $todo_records = iconv_safe('koi8-u','utf-8',$todo_records);
                    }
                } */
        return $todo_data;
    }

    public static function PaymentHistory($account_id)
    {
        $payment_array = array();

        $payment_data_array = get_pay_info_ex('', 0, $account_id, 0, -1, -1, 0, 0, 0, "", 0);
        if ($payment_data_array) {
            if (is_array($payment_data_array)) {
                foreach ($payment_data_array as $k => $v) {
                    $add_date = '';
                    $currency = iconv_safe('koi8-u', 'utf-8', get_curr_name_by_cid($v[PSTAT_C_ID_IDX]));
                    $account_inc = $v[PSTAT_ACCOUNT_INC_IDX];
                   // $payment_idx = $v[PSTAT_PAYMENT_IDX];
                    $credit_inc = $v[PSTAT_CREDIT_INC_IDX];
                    if($account_inc){
                        $main_acc = $account_inc * 0.001 .$currency;
                    }else{
                        $main_acc = '';
                    }
                    if($credit_inc){
                        $credit_acc = $credit_inc * 0.001 .$currency;
                    }else{
                        $credit_acc = '';
                    }
                    $payment_type_name = array(
                        BN_ANY => '',
                        BN_CASH => Yii::t('site', 'cash'),
                        BN_WIRE => Yii::t('site', 'wire'),
                        BN_WM => Yii::t('site', 'ww'),

                    );
                    /*
                    if($account_inc > 0){
                        $charge = '';
                        $payment = $account_inc * 0.001 .$currency;
                    }elseif($account_inc < 0){
                        $charge = $account_inc * -0.001 .$currency;
                        $payment = '';
                    }else{
                        $charge = '';
                        $payment = '';
                    }
                    if($payment_idx){
                        $charge = '';
                        $payment = $payment_idx * 0.001 .$currency;
                    }
                    */
                    $payment_array[$k] = array(
                        'date' => date("d.m.Y", strtotime(ptimestamp_to_str($v[PSTAT_PTS_IDX], $sep = " ", $dsep = "-", $isep = ":"))),
                        'payment_purpose' => iconv_safe('koi8-u', 'utf-8',make_up_pay_c($v[PSTAT_COMMENT_IDX], $add_date)),
                        'main_acc' => $main_acc,
                        'credit_acc' => $credit_acc,
                        'type' => $payment_type_name[$v[PSTAT_BN_IDX]],
                    );
                }
            }
        }
        return $payment_array;

    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        self::UserIdentityData();
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        self::UserIdentityData();
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        $users = self::UserIdentityData();
        foreach ($users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {

                return new static($user);
            }
        }
        /*
        self::UserData();
        print_r(self::$users);
        die('ups');

        if (strcasecmp(self::$users['username'], $username) === 0) {
            return new static(self::$users['username']);
        } */
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
