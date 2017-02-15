<?php

require_once ('Conn_db.php');

class UserContactsUpdate
{
    public $phones_active = array();
    public $phones_delete = array();
    public $emails_active = array();
    public $emails_delete = array();
    public $one_field;//1 - все телефоны в первое поле,вклюяая и телефоны из второго поля (во втором поле телефоны исчезнут), 2- два поля, во второе городские
    public $phone_email_update;//1-обновляются только телефоны, 2- обновляются только EMAIL, 3- обновляются все поля(телефоны и email)
    public $phone_string_all;
    public $phone_string_1;
    public $phone_string_2;
    public $user_id;
    public $email_string_all;


    public function __construct($user_id,array $phones_active = array(), array $email_active = array(),  $one_field = 1, $phone_email_update = 1)
    {
        $this->phones_active = $phones_active;
        $this->emails_active = $email_active;
        $this->one_field = $one_field;
        $this->phone_email_update = $phone_email_update;
        $this->user_id = $user_id;

    }

    public function createPhoneFields()
    {


        foreach($this->phones_active as $val){
            if($this->one_field == 1){
                $this->phone_string_all .= trim($val).',';
            }elseif($this->one_field == 2){
                if(strpos($val,'38044') === 0){
                    $this->phone_string_1 = trim($val).',';
                }else{
                    $this->phone_string_2 = trim($val).',';
                }
            }else{
                $this->phone_string_all .= trim($val).',';
            }

        }

        $this->phone_string_all = substr($this->phone_string_all, 0, -1);
        $this->phone_string_1 = substr($this->phone_string_1, 0, -1);
        $this->phone_string_2 = substr($this->phone_string_2, 0, -1);


     //   Debugger::Eho($this->phone_string_all);
     //   Debugger::Eho('</br>');
     //   Debugger::Eho($this->phone_string_1);
     //   Debugger::Eho('</br>');
     //   Debugger::Eho($this->phone_string_2);
     //   Debugger::Eho('</br>');
     //   Debugger::testDie();
    }

    public function createEmailFields()
    {
        foreach($this->emails_active as $val){
            $this->email_string_all .= trim($val).',';
        }
        $this->email_string_all = substr($this->email_string_all, 0, -1);
    }


    public function updatePhoneFields($host, $db_name, $user, $pass)
    {

        $dbc = Conn_db::getConnection($host, $db_name, $user, $pass);



        $this->createPhoneFields();


        $sql = 'UPDATE `user_list` SET `user_phone2`= :user_phone2, `user_phone`= :user_phone WHERE `user_id` = :user_id';
        if($this->phone_string_all){

            $placeholders = array(
                'user_phone' =>$this->phone_string_all,
                'user_phone2' => '',
                'user_id' => $this->user_id,
            );
        }elseif($this->phone_string_1 || $this->phone_string_2){

            $placeholders = array(
                'user_phone2' =>$this->phone_string_2,
                'user_id' => $this->user_id,
                'user_phone' => $this->phone_string_1
            );
        }else{
            $placeholders = array(
                'user_phone2' => '',
                'user_id' => '',
                'user_phone' => ''
            );
        }

        $sth = $dbc->getPDO()->prepare($sql);
        $sth->execute($placeholders);


    }

    public function updateEmailFields($host, $db_name, $user, $pass)
    {
        $dbc = Conn_db::getConnection($host, $db_name, $user, $pass);

        $this->createEmailFields();
        $this->createPhoneFields();

        $sql = 'UPDATE `user_list` SET `user_mail`= :user_mail WHERE `user_id` = :user_id';

        $placeholders = array(
            'user_mail' =>$this->email_string_all,
            'user_id' => $this->user_id,
        );

        $sth = $dbc->getPDO()->prepare($sql);
        $sth->execute($placeholders);
    }

    public function updatePhoneEmailFields($host, $db_name, $user, $pass)
    {
        $dbc = Conn_db::getConnection($host, $db_name, $user, $pass);

        $this->createEmailFields();

        $sql = 'UPDATE `user_list` SET `user_mail`= :user_mail, `user_phone2`= :user_phone2, `user_phone`= :user_phone WHERE `user_id` = :user_id';


        if($this->phone_string_all){

            $placeholders = array(
                'user_phone' =>$this->phone_string_all,
                'user_phone2' => '',
                'user_mail' =>$this->email_string_all,
                'user_id' => $this->user_id,
            );
        }elseif($this->phone_string_1 || $this->phone_string_2){

            $placeholders = array(
                'user_phone2' =>$this->phone_string_2,
                'user_id' => $this->user_id,
                'user_mail' =>$this->email_string_all,
                'user_phone' => $this->phone_string_1
            );
        }else{
            $placeholders = array(
                'user_phone2' => '',
                'user_id' => '',
                'user_phone' => '',
                'user_mail' => ''
            );
        }

        $sth = $dbc->getPDO()->prepare($sql);
        $sth->execute($placeholders);

    }




    public function getNewContacts()
    {
        if($this->phone_string_all){

            return array(
                'user_phone' =>$this->phone_string_all,
                'user_phone2' => '',
                'phone_1_array' => explode(',',$this->phone_string_all),
                'phone_2_array' => array(),
                'phone_all_array' => explode(',',$this->phone_string_all),

            );
        }elseif($this->phone_string_1 || $this->phone_string_2){
            $phone_1_array = explode(',',$this->phone_string_1);
            $phone_2_array = explode(',',$this->phone_string_2);
            $phone_all_a = array_merge($phone_1_array, $phone_2_array);
            $phone_all_array = array();
            foreach($phone_all_a as $k=>$v){
                $phone_all_array[$k+1] = $v;
            }

            return array(
                'user_phone2' =>$this->phone_string_2,
                'user_phone' => $this->phone_string_1,
                'phone_1_array' => $phone_1_array,
                'phone_2_array' => $phone_2_array,
                'phone_all_array' => $phone_all_array,
            );
        }else{
          return array();
        }
    }



}