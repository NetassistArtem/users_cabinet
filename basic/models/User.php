<?php

namespace app\models;

use Yii;

use app\components\debugger\Debugger;

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

            _is_admin(Yii::$app->request->post('LoginForm')['username'], Yii::$app->request->post('LoginForm')['password']);
            $user_id_data = array(
                'id' => $GLOBALS['auth_user_id'],
                'username' => $GLOBALS['auth_user_name'],
                'password' => Yii::$app->request->post('LoginForm')['password'],
            );


            Yii::$app->session->set('user-data-id', $user_id_data);
            Yii::$app->session->set('u_name' , $GLOBALS['auth_user_name']);//нужно для работы billing api
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

        _is_admin();//функция апи биллинга, проверяет пользователя сравнивая с сесией, при каждой загрузке страници
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
        if (user_option_check(USER_OPT_HAVE_BLOCK_CTL, $user_data_by_billing[UINFO_NET_ID_IDX])) {  //функции api биллинга
            get_user_ipv4_settings($user_data_by_billing[UINFO_REAL_IP4_IDX], $user_data_by_billing[UINFO_LOCAL_IP4_IDX], $user_data_by_billing[UINFO_NET_ID_IDX], $gw, $ip_1, $ip_2, $netmask, $netmask2, $external_smtp, $dns1_ip, $dns2_ip);//функции api биллинга
        }


        $access_mx = get_user_mx_options(Yii::$app->user->id);



       $mx_string = iconv_safe('koi8-u', 'utf-8', get_access_mxs_str($access_mx, $lang_id=-1));


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
        $phone_1_array = !empty($user_data_by_billing[UINFO_PHONE_IDX]) ? explode(',',$user_data_by_billing[UINFO_PHONE_IDX] ) : array();
      //  $phone_1_array = explode(',',$user_data_by_billing[UINFO_PHONE_IDX] );
        $phone_2_array = !empty($user_data_by_billing[UINFO_PHONE2_IDX]) ? explode(',',$user_data_by_billing[UINFO_PHONE2_IDX] ) : array();
      //  $phone_2_array = explode(',',$user_data_by_billing[UINFO_PHONE2_IDX] );
        $email_array = !empty($user_data_by_billing[UINFO_EMAIL_IDX]) ? explode(',',$user_data_by_billing[UINFO_EMAIL_IDX] ) : array();
        //$email_array = explode(',',$user_data_by_billing[UINFO_EMAIL_IDX] );
        $phone_all_a = array_merge($phone_1_array, $phone_2_array);
        $phone_all_array = array();
        foreach($phone_all_a as $k=>$v){
            $phone_all_array[$k+1] = $v;
        }


        $user_data = array(
            Yii::$app->session->get('user-data-id')['id'] => array(
                'username' => Yii::$app->user->identity->username,
                'fio' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[$user_acc_offset+AINFO_CONTRACT_NAME_IDX]),
                'password' => $user_data_by_billing[UINFO_PWD_IDX],
                'email' => $user_data_by_billing[UINFO_EMAIL_IDX],
                'email_array' => $email_array,
                'address' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[UINFO_ADDR_IDX]),
                'address_id' => $user_data_by_billing[UINFO_BASE_LOC_ID_IDX],
                'phone_1' => $user_data_by_billing[UINFO_PHONE_IDX],
                'phone_1_array' => $phone_1_array,
                'phone_2' => $user_data_by_billing[UINFO_PHONE2_IDX],
                'phone_2_array' => $phone_2_array,
                'phone_all_array' =>$phone_all_array,
                'account_id' => $user_data_by_billing[UINFO_ACC_ID_IDX],
                'account_balance' => $user_data_by_billing[$user_acc_offset+AINFO_MONEY_IDX],
                'account_credit' => $user_data_by_billing[$user_acc_offset+AINFO_DEBT_IDX],
                'account_currency' => iconv_safe('koi8-u', 'utf-8', get_curr_name_by_cid($user_data_by_billing[$user_acc_offset+AINFO_C_ID_IDX])),
                'services' => array('"Безлимитный"', 'IpTV'),
                'services_date' => array('20.08.17', '21.09.17'),
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
                'ipv6' => $user_data_by_billing[UINFO_IP6_IDX],
                'net_id' => $user_data_by_billing[UINFO_NET_ID_IDX],
                'org_id' => iconv_safe('koi8-u', 'utf-8', $user_data_by_billing[$user_acc_offset+AINFO_ORG_ID_IDX]),
                'real_name' => $user_data_by_billing[UINFO_REAL_NAME_IDX],
                'req_id' => $user_data_by_billing[$user_acc_offset+AINFO_REQ_ID_IDX],
                'loc_id' => $user_data_by_billing[UINFO_BASE_LOC_ID_IDX],


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


        Yii::$app->session->set('user-data', $user_data);
    }

    public static function SupportData()
    {

        $data = get_lang_opt_list("support_classes");//функция из api биллинга
        $data[0] =  Yii::t('support','select_option');

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
                        'todo_subj' =>  iconv_safe('koi8-u', 'utf-8', $k[TODO_SUBJ_IDX]),//web_encode($k[TODO_SUBJ_IDX]),
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
