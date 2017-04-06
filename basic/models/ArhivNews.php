<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ArhivNews extends Model
{

    // public $many;


    /**
     * @return array the validation rules.
     */

    public function getArhiv($account_id)
    {

        //$test = user_msg_get_global('');


        //   user_msg_log_add($account_id, '', '', '', 2, 'Test message7, test message7, test message7, test message7 test message7, test message7, test message6 test message6, test message6, test message6 test message6, test message6, test message6 test message6, test message6, test message6 test message6, test message6, test message6 test message6, test message6, test message6 test message6, test message6, test message6 test message6, test message6, test message6', 'test');
        // Debugger::testDie();
        //    user_msg_log_read(1);
////
        $message_data_array = array();
        $log_message_reverse = user_msg_log_get('', $account_id);//функция биллинга дает массив всех сообщений пользователю (включая "для всех" где только ссылка на айди в другом массиве)
        if ($log_message_reverse) {
            $log_message = array_reverse($log_message_reverse);


            foreach ($log_message as $k => $v) {
                if ($v[USER_MSG_LOG_REF_MSG_ID_IDX] || $v[USER_MSG_LOG_TXT_IDX]) {
                    $message_data_array[$k]['date'] = date("d.m.Y", strtotime(ptimestamp_to_str($v[USER_MSG_LOG_PTS_IDX], $sep = " ", $dsep = "-", $isep = ":")));
                    // $message_data_array[$k]['date_fore_url'] = date("Y-m-d-h-i-s", strtotime(ptimestamp_to_str($v[USER_MSG_LOG_PTS_IDX], $sep = " ", $dsep = "-", $isep = ":")));
                    $message_data_array[$k]['id'] = $v[USER_MSG_LOG_REC_ID_IDX];
                    if ($v[USER_MSG_LOG_REF_MSG_ID_IDX]) {
                        $global_message = user_msg_get_global('', $v[USER_MSG_LOG_REF_MSG_ID_IDX]);//функция биллинга, дает массив со всей инф. для общих сообщения
                        $message_data_array[$k]['text'] = iconv_safe('koi8-u', 'utf-8', $global_message[0][USER_MSG_TXT_IDX]);

                    } else {
                        $message_data_array[$k]['text'] = iconv_safe('koi8-u', 'utf-8', $v[USER_MSG_LOG_TXT_IDX]);
                    }
                    $message_data_array[$k]['view'] = $v[USER_MSG_LOG_VIEW_PTS_IDX];

                    $text_length = mb_strlen($message_data_array[$k]['text']);
                    if ($text_length > Yii::$app->params['user_message_length']) {
                        $message_data_array[$k]['short_text'] = substr($message_data_array[$k]['text'], 0, Yii::$app->params['user_message_length']);
                        $message_data_array[$k]['short_text'] = rtrim($message_data_array[$k]['short_text'], "!,.-");
                        $message_data_array[$k]['short_text'] = substr($message_data_array[$k]['short_text'], 0, strrpos($message_data_array[$k]['short_text'], ' '));
                        $message_data_array[$k]['short_text'] = $message_data_array[$k]['short_text'] . ' ...';

                    } else {
                        $message_data_array[$k]['short_text'] = '';
                    }
                }
            }
        }

        // Debugger::PrintR($log_message);
        //  Debugger::PrintR($message_data_array);
        //  Debugger::EhoBr($test2);
        //  Debugger::VarDamp($test2);
        //   Debugger::testDie();
        return $message_data_array;

    }

    public function newsReadeStatus($news_status, $news_id)
    {

        if (!$news_status) {

            user_msg_log_read($news_id);//функция биллинга, переводит новость в статус прочитанных
        }

    }


}