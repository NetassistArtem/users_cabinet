<?php

return [
    'server_name' => $_SERVER['SERVER_NAME'],
    'adminEmail' => 'admin@example.com',
    'sites_data' => array(
        'alfa' => array(
            'phone_1' => '(044) 239-89-89',
            'phone_fore_call' => '+380442398989',
            'company_name' => array(
                0 => 'Альфа инет',
                'lang_key' => 'alfa',
            ),
            'ico' => 'alfa.ico',
            'player_link' =>'http://iptv.alfa-inet.net/files/alfa-IpTvPlayer-setup.exe',
            'tv_playlist' => 'https://alfa-inet.net/files/tv_playlist.m3u',
        ),

        'kuzia' => array(
            'phone_1' => '(044) 223-333-7',
            'phone_fore_call' => '+380442233337',
            'company_name' => array(
                0 => 'Кузя',
                'lang_key' => 'kuzia',
            ),
            'ico' => 'kuzia.ico',
            'player_link' =>' http://kuzia.net.ua/IpTvPlayer-Kuzia-setup.exe',
            'tv_playlist' => 'http://kuzia.net.ua/tv_playlist.m3u',
        ),
    ),
    'phone_1' => '223-333-7',
    'payment_code' => '39481498',
    'domains' => array(
        'lk.alfa-inet.net' => 'kuzia',
        'my.kuzia.net.ua' => 'kuzia',
        'my.alfa-inet.net' => 'alfa',
    ),
    'alfa-styles' => array(
        -1 => 'Default',
        0 => "Gray",
        1 => "Black",
        2 => "Black-CRT",
        3 => "White",
    ),
    'alfa-styles-default' => 0,

    'lang' => array(
        1 => array(
            'id' => 1,
            'url' => 'ru',
            'local' => 'ru-RU',
            'default' => 1,
            'name' => 'Русский',
            'symbol' => 'RU'
        ),
        2 => array(
            'id' => 2,
            'url' => 'en',
            'local' => 'en-EN',
            'default' => 0,
            'name' => 'English',
            'symbol' => 'EN'
        ),
        3 => array(
            'id' => 3,
            'url' => 'uk',
            'local' => 'uk-UK',
            'default' => 0,
            'name' => 'Українська',
            'symbol' => 'UK'
        ),

    ),
    'items_per_page' => array(
        'todo_history' => 10,
        'payment_history' => 25,
        'news_archive' => 10,
    ),

    'swith' => array(
        0 => array(
            0 => 'Выберите вариант ответа',
            'lang_key' => 'select_option'
        ),
        1 => array(
            0 => 'Нет',
            'lang_key' => 'no'
        ),
        2 => array(
            0 => 'WiFi-роутер (беспроводной)',
            'lang_key' => 'wifi'
        ),
        3 => array(
            0 => 'WiFi-точка',
            'lang_key' => 'wifi_point'
        ),
        4 => array(
            0 => 'Проводной роутер',
            'lang_key' => 'wired_router'
        ),
        5 => array(
            0 => 'Свитч',
            'lang_key' => 'swith'
        ),
    ),

    'operation_systems' => array(
        0 => array(
            0 => 'Выберите вариант ответа',
            'lang_key' => 'select_option'
        ),
        9 => array(
            0 => 'MacOS',
            'lang_key' => 'macos'
        ),
        7 => array(
            0 => 'Linux',
            'lang_key' => 'linux'
        ),
        8 => array(
            0 => 'FreeBSD',
            'lang_key' => 'freebsd'
        ),
        12 => array(
            0 => 'Windows 10',
            'lang_key' => 'windows_10'
        ),
        6 => array(
            0 => 'Windows 8',
            'lang_key' => 'windows_8'
        ),
        8 => array(
            0 => 'Windows 7',
            'lang_key' => 'windows_7'
        ),
        4 => array(
            0 => 'Vista',
            'lang_key' => 'vista'
        ),
        2 => array(
            0 => 'Windows XP',
            'lang_key' => 'windows_xp'
        ),
        3 => array(
            0 => 'Windows XP Home',
            'lang_key' => 'windows_xp_home'
        ),
        11 => array(
            0 => 'Прочие Windows',
            'lang_key' => 'another_windows'
        ),
    ),

    'todo_type' => array(
        1 => array(
            'type_id' => 1,
            'billing_name' => 'монтаж-включение',
            'name' => 'Подключения',
            'name_file' => 'connect_new'
        ),
        2 => array(
            'type_id' => 3,
            'billing_name' => 'обращение в суппорт',
            'name' => 'Обращение в суппорт',
            'name_file' => 'todo_all'
        ),
        3 => array(
            'type_id' => 8,
            'billing_name' => 'вызов на дом',
            'name' => 'Вызовы на дом',
            'name_file' => 'to_home'
        ),
        4 => array(
            'type_id' => 12,
            'billing_name' => 'монтаж - авария',
            'name' => 'Аварии',
            'name_file' => 'todo_alarm'
        ),
        5 => array(
            'type_id' => 13,
            'billing_name' => 'админ - авария',
            'name' => 'Админ-аварии',
            'name_file' => 'todo_admin_alarm'
        ),
        6 => array(
            'type_id' => 100,
            'billing_name' => 'отключения',
            'name' => 'Отключения',
            'name_file' => 'todo_disconnecting'
        )
    ),
    'todo_status' => array(
        0 => array(
            0 => 'New',
            'lang_key' => 'new'
        ),
        5 => array(
            0 => 'Подготовить',
            'lang_key' => 'prepare'
        ),
        6 => array(
            0 => 'Утверждено',
            'lang_key' => 'approved'
        ),
        10 => array(
            0 => 'Проверить',
            'lang_key' => 'check'
        ),
        15 => array(
            0 => 'Перезвонить (support)',
            'lang_key' => 'call_back_support'
        ),
        16 => array(
            0 => 'Перезвонить (исполн.)',
            'lang_key' => 'call_back_executed'
        ),
        20 => array(
            0 => 'В очереди',
            'lang_key' => 'queue'
        ),
        21 => array(
            0 => 'Забрать',
            'lang_key' => 'pick_up'
        ),
        30 => array(
            0 => 'Уже делаем',
            'lang_key' => 'already_done'
        ),
        40 => array(
            0 => 'Перекур',
            'lang_key' => 'smoko'
        ),
        42 => array(
            0 => 'Перекур по просьбе',
            'lang_key' => 'smoke_to_request'
        ),
        50 => array(
            0 => 'Скоро',
            'lang_key' => 'soon'
        ),
        60 => array(
            0 => 'Когда-нибудь',
            'lang_key' => 'someday'
        ),
        61 => array(
            0 => 'Интересовались',
            'lang_key' => 'interested'
        ),
        90 => array(
            0 => 'Готовим отчет',
            'lang_key' => 'prepare_report'
        ),
        92 => array(
            0 => 'Отчет готов',
            'lang_key' => 'report_ready'
        ),
        100 => array(
            0 => 'Complete',
            'lang_key' => 'complete'
        ),
        110 => array(
            0 => 'Архив',
            'lang_key' => 'archive'
        ),
        200 => array(
            0 => 'Lost',
            'lang_key' => 'lost'
        ),
        210 => array(
            0 => 'Не актуально',
            'lang_key' => 'not_relevant'
        ),
        250 => array(
            0 => 'Дубликат',
            'lang_key' => 'duplicate'
        ),
        900 => array(
            0 => 'Тема закрыта',
            'lang_key' => 'close'
        ),
        901 => array(
            0 => 'spam',
            'lang_key' => 'spam'
        ),
    ),


    'email_message_types' => array(
        1 => array(
            0 => 'Уведомления',
            'lang_key' => 'notice'
        ),
        2 => array(
            0 => 'Обновления обращения в техническую поддержку',
            'lang_key' => 'treatment_updates_technical_support'
        ),
        3 => array(
            0 => 'Напоминания об оплате',
            'lang_key' => 'reminders_payment'
        ),
        4 => array(
            0 => 'Уведомление о поступлении средств',
            'lang_key' => 'notice_payment_receipt'
        ),

    ),


    'sms_message_types' => array(
        1 => array(
            0 => 'Напоминания об оплате',
            'lang_key' => 'reminders_payment'
        ),
        2 => array(
            0 => 'Не звонить',
            'lang_key' => 'do_not_call'
        ),


    ),

    'skin_types' => array(

        1 => array(
            0 => 'Серый',
            'lang_key' => 'gray',
            'billing_key' => 0,
        ),
        2 => array(
            0 => 'Черный',
            'lang_key' => 'black',
            'billing_key' => 1,
        ),
        3 => array(
            0 => 'Черный-CRT',
            'lang_key' => 'black_crt',
            'billing_key' => 2,
        ),
        4 => array(
            0 => 'Белый',
            'lang_key' => 'white',
            'billing_key' => 3,
        ),

    ),
    'problem_types' => array(
        1 => array(
            0 => 'Состояние счета',
            'lang_key' => 'state_account',
        ),
        2 => array(
            0 => 'Нет связи',
            'lang_key' => 'no_connection',
        ),
        3 => array(
            0 => 'Низкая скорость',
            'lang_key' => 'low_speed',
        ),
        4 => array(
            0 => 'Переадресация на главную',
            'lang_key' => 'home_redirecting',
        ),
        5 => array(
            0 => 'Недоступна часть ресурсов',
            'lang_key' => 'unavailable_part_resources',
        ),
        6 => array(
            0 => 'Недоступен ресурс/сайт',
            'lang_key' => 'unavailable_resource',
        ),
        7 => array(
            0 => 'Проблемы с ПО',
            'lang_key' => 'soft_problem',
        ),
        8 => array(
            0 => 'Организационные вопросы',
            'lang_key' => 'organizational_issues',
        ),
    ),
    'net_connection_type' => array(
        1 => array(
            0 => 'Напрямую, через комрьютер',
            'lang_key' => 'thru_comp',
        ),
        2 => array(
            0 => 'Через роутер, по Wi-Fi',
            'lang_key' => 'thru_router',
        ),
        3 => array(
            0 => 'Через роутер, по кабелю',
            'lang_key' => 'cable_thru_router',
        ),
    ),
    'short_answer' => array(
        1 => array(
            0 => 'Да',
            'lang_key' => 'yes',
        ),
        -1 => array(
            0 => 'Да',
            'lang_key' => 'no',
        ),
        0 => array(
            0 => 'Нет данных',
            'lang_key' => 'unknown',
        ),
    ),
    'user_speed' =>array(
        1 => array(
            0 => 'до 10 Мбит/с (1-2 Мбайт/с)',
            'lang_key' => '10_mb',
        ),
        2 => array(
            0 => 'c 10 до 50 Мбит/с (2-4 Мбайт/с)',
            'lang_key' => '50_mb',
        ),
        3 => array(
            0 => 'с 50 до 80 Мбит/с (4-8 Мбайт/с)',
            'lang_key' => '80_mb',
        ),
        4 => array(
            0 => 'выше 100 Мбит/с (10-15 Мбайт/с)',
            'lang_key' => '100_mb',
        ),
    ),
    'alfa_skin_default' => 2,

    'sms_send_conf' => array(
        'transliteration' =>1, //транслитерация sms - 1 - да, 0 - нет
        'verification_cod_length' => 4,//количество символов в коде подтверждения отправляемого пользователю (при изменении контактов)
        'verification_cod_num' =>1, // использовать цифры для формирования кода подтверждения отпрвляемого пользователю, 1- использовать, 0 - не использовать
        'verification_cod_down_chars' =>0, //использовать буквы нижнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
        'verification_cod_up_chars' =>0, //использовать буквы верхнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
    ),
    'email_send_conf' => array(
        'transliteration' =>0, //транслитерация текста - 1 - да, 0 - нет
        'verification_cod_length' => 4,//количество символов в коде подтверждения отправляемого пользователю (при изменении контактов)
        'verification_cod_num' =>1, // использовать цифры для формирования кода подтверждения отпрвляемого пользователю, 1- использовать, 0 - не использовать
        'verification_cod_down_chars' =>1, //использовать буквы нижнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
        'verification_cod_up_chars' =>1, //использовать буквы верхнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
    ),
    'user_message_length' => 250,
    'sms_send_conf_renew_pass' => array(
        'transliteration' =>1, //транслитерация sms - 1 - да, 0 - нет
        'verification_cod_length' => 4,//количество символов в коде подтверждения отправляемого пользователю (при изменении контактов)
        'verification_cod_num' =>1, // использовать цифры для формирования кода подтверждения отпрвляемого пользователю, 1- использовать, 0 - не использовать
        'verification_cod_down_chars' =>0, //использовать буквы нижнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
        'verification_cod_up_chars' =>0, //использовать буквы верхнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
    ),
    'email_send_conf_renew_pass' => array(
        'transliteration' =>0, //транслитерация sms - 1 - да, 0 - нет
        'verification_cod_length' => 4,//количество символов в коде подтверждения отправляемого пользователю (при изменении контактов)
        'verification_cod_num' =>1, // использовать цифры для формирования кода подтверждения отпрвляемого пользователю, 1- использовать, 0 - не использовать
        'verification_cod_down_chars' =>1, //использовать буквы нижнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
        'verification_cod_up_chars' =>1, //использовать буквы верхнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
    ),
    'renew_password' => array(
        'verification_cod_length' => 8,//количество символов в коде подтверждения отправляемого пользователю (при изменении контактов)
        'verification_cod_num' =>1, // использовать цифры для формирования кода подтверждения отпрвляемого пользователю, 1- использовать, 0 - не использовать
        'verification_cod_down_chars' =>1, //использовать буквы нижнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
        'verification_cod_up_chars' =>1, //использовать буквы верхнего регистра для формирования кода подтверждения, 1- использовать, 0 - не использовать
    ),

    'sms_limit' => 2,
    'sms_time_limit' =>86400, //3600 - час, 86400 - сутки
    'sms_time_limit_delete' => 2592000, //2592000 - 30 дней
    'sms_limit_pass_renew' => 4,

];
