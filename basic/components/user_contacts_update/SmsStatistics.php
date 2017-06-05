<?php


namespace app\components\user_contacts_update;

use app\components\user_contacts_update\Conn_db;
use yii\base\Exception;
use app\components\debugger\Debugger;


class SmsStatistics
{
    private $host;
    private $db_name;
    private $user;
    private $pass;

    public function __construct($host, $db_name, $user, $pass)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->user = $user;
        $this->pass = $pass;

    }

    public function dbConnect()
    {
        return Conn_db::getConnection($this->host, $this->db_name, $this->user, $this->pass);
    }

    public function insertData($user_id)
    {
        $connection = $this->dbConnect();



        $sql = 'INSERT INTO `sms-statistics`( `user_id`, `time`) VALUES (:user_id,:datetime )';

        $placeholders = array(
            'user_id' =>$user_id,
            'datetime' => time(),//date("Y-m-d H:i:s"),
        );

        $sth = $connection->getPDO()->prepare($sql);
        $sth->execute($placeholders);

    }


    public function smsLimit($user_id, $time_limit, $sms_limit)
    {

        $connection = $this->dbConnect();
        $time_l = time() - $time_limit;
        $sql = 'SELECT `id`, `user_id`, `time` FROM `sms-statistics` WHERE  `user_id` = :user_id AND `time` > :time_l';
        $placeholders = array(
            'user_id' => $user_id,
            'time_l' => $time_l,
        );
        $data = $connection->getDate($sql,$placeholders);
        if(!empty($data)){
            if(count($data) >= $sms_limit){
                return false;
            }else{
                return true;
            }

        }else{
            return true;
        }

    }

    public function deleteOld($time_limit)
    {
        $connection = $this->dbConnect();
        $time_l = time() - $time_limit;
        $sql = 'DELETE FROM `sms-statistics` WHERE `time`< :time_l';
        $placeholders = array(
            'time_l' => $time_l,
        );

        $sth = $connection->getPDO()->prepare($sql);
        $sth->execute($placeholders);
    }

    public function test()
    {
        $connection = $this->dbConnect();

        $sql = 'DELETE FROM `sms-statistics` WHERE `user_id` = 1';
        $placeholders = array(

        );

        $sth = $connection->getPDO()->prepare($sql);
        $sth->execute($placeholders);

    }



}