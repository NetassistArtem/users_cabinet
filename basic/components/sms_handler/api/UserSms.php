<?php





class UserSms
{
    public $sms_text;
    public $chars_num = '123456789';
    public $chars_down_chars = 'qwertyuiopasdfghjklzxcvbnm';
    public $chars_up_chars = 'QWERTYUIOPASDFGHJKLZXCVBNM';
    public $user_code;
    public $lang;
    public $lang_code = array(
        'ru' => 0,
        'ru-RU' => 0,
        'RU' => 0,
        'RU-ru' => 0,
        0 => 0,
        'uk' => 1,
        'uk-UK' => 1,
        'UK' => 1,
        'UK-uk' => 1,
        1 => 1,
        'ua' => 1,
        'ua-UA' => 1,
        'UA' => 1,
        'UA-ua' => 1,
        'en' => 2,
        'en-EN' => 2,
        'EN' => 2,
        'EN-en' => 2,
        2 => 2,

    );

    public function __construct($lang = 0)
    {



        $this->lang = $this->lang_code[$lang];
    }

    public function codeCreate($length = 8, $chars_num = 1, $chars_down_chars = 0, $chars_up_chars = 0)
    {
        $chars = '';
        if ($chars_num == 1) {
            $chars .= $this->chars_num;
        }
        if ($chars_down_chars == 1) {
            $chars .= $this->chars_down_chars;
        }
        if ($chars_up_chars == 1) {
            $chars .= $this->chars_up_chars;
        }

        $num_chars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $num_chars) - 1, 1);
        }
        $this->user_code = $string;
        $_SESSION['confirmcode'] = $string;
        return $string;
    }

    public function translit($string)
    {
        if ($this->lang == 0) {

            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v',
                'г' => 'g', 'д' => 'd', 'е' => 'e',
                'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
                'и' => 'i', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

                'А' => 'A', 'Б' => 'B', 'В' => 'V',
                'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'I', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N',
                'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
                'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            );

            return strtr($string, $converter);
        }
        if ($this->lang == 1) {

            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v',
                'г' => 'h', 'д' => 'd', 'е' => 'e',
                'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
                'и' => 'y', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ь' => '\'', 'ї' => 'yi', 'ъ' => '\'', 'є' => 'ye',
                'ю' => 'yu', 'я' => 'ya', 'і' => 'i', 'ґ' => 'g',

                'А' => 'A', 'Б' => 'B', 'В' => 'V',
                'Г' => 'H', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'Y', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N',
                'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ь' => '\'', 'Ї' => 'Yi', 'Ъ' => '\'', 'Є' => 'ye',
                'Ю' => 'Yu', 'Я' => 'Ya', 'І' => 'I', 'Ґ' => 'G'
            );

            return strtr($string, $converter);
        }
        if ($this->lang == 2) {
            return $string;
        }


        return $string;
    }

    public function createSmsTextPasswordChange($text, $translit = 0, $code_length = 8, $chars_num = 1, $chars_down_chars = 0, $chars_up_chars = 0)
    {

        if ($translit == 1) {
            return $this->translit($text) . $this->codeCreate($code_length, $chars_num, $chars_down_chars, $chars_up_chars);
        } else {
            return $text . $this->codeCreate($code_length, $chars_num, $chars_down_chars, $chars_up_chars);
        }
    }

    public static function checkCode($post_user_code = null)
    {
        //  Debugger::Eho($_SESSION['user_code']);
        //  Debugger::Eho('</br>');
        //  Debugger::Eho($post_user_code);
        if (isset($_SESSION['confirmcode'])) {
            if ($post_user_code == $_SESSION['confirmcode']) {
                unset($_SESSION['confirmcode']);
                return true;
            } else {

                return false;
            }
        }
        return false;
    }


}