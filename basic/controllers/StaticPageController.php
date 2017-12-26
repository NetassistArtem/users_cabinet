<?php

namespace app\controllers;

use app\models\ContactChangeForm;
use app\models\FeedbackForm;
use app\models\PhoneFirstChangeForm;
use app\models\EmailChangeForm;
use app\models\PhoneSelectChangeForm;
use app\models\EmailSelectChangeForm;
use app\models\SkinsChangeForm;
use app\models\UpdateTodoForm;
use app\models\MessageTypeChangeForm;
use app\models\TechnicalSupportForm;
use app\models\CallRequestForm;
use app\models\PhoneFirstChangeConfirmForm;
use app\models\EmailChangeConfirmForm;
use app\models\PhoneAddForm;
use app\models\SupportForm;
use app\models\RtfPrintForm;
use app\models\EmailAddForm;
use app\models\CreditForm;
use app\models\ServicesChangePauseStartForm;
use app\models\ServicesChangePauseFinishForm;
use app\models\ServicesTrafficLimitForm;
use app\models\ArhivNews;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PasswordChangeForm;
use app\components\debugger\Debugger;

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\Conn_db;
use app\components\user_contacts_update\SmsStatistics;

class StaticPageController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'cabinet',
                    'cabinet-management',
                    'payment',
                    'payment-history',
                    'support',
                    'support-history',
                    'feedback',
                    'tv',
                    'support-history-todo',
                    'phone-first-change-confirm',
                    'change-phone',
                    'arhiv-news-node-reade',
                    'arhiv-news-node',
                    'arhiv-news',
                    'bank',
                    'terminals',
                    'email-change-confirm',
                    'email-change',

                    'support-details',
                ],


                'rules' => [
                    [

                        'actions' => [
                            'cabinet',
                            'cabinet-management',
                            'payment',
                            'payment-history',
                            'support',
                            'support-history',
                            'feedback',
                            'tv',
                            'support-history-todo',
                            'phone-first-change-confirm',
                            'change-phone',
                            'arhiv-news-node-reade',
                            'arhiv-news-node',
                            'arhiv-news',
                            'bank',
                            'terminals',
                            'email-change-confirm',
                            'email-change',

                            'support-details',
                        ],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [

                        'actions' => [
                            'cabinet',
                            'cabinet-management',
                            'payment',
                            'payment-history',
                            'support',
                            'support-history',
                            'feedback',
                            'tv',
                            'support-history-todo',
                            'phone-first-change-confirm',
                            'change-phone',
                            'arhiv-news-node-reade',
                            'arhiv-news-node',
                            'arhiv-news',
                            'bank',
                            'terminals',
                            'email-change-confirm',
                            'email-change',

                            'support-details',
                        ],
                        'allow' => false,
                        'roles' => ['?'],

                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCabinet()
    {
        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

       // Debugger::EhoBr(get_skin($user_data['username']));//
       // Debugger::EhoBr($user_data['org_id']);//7

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];


        return $this->render('cabinet', ['user_data' => $user_data, 'lang' => $lang]);
    }

    public function actionCabinetManagement()
    {

        User::UserData();

        Yii::$app->session->remove('confirmcode');
        Yii::$app->session->remove('number_valid');
        Yii::$app->session->remove('add');

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        //  Debugger::PrintR(Yii::$app->session->get('user-data'));
        //  Debugger::Eho(Yii::$app->user->id);

        //  Debugger::testDie();

        $modelPasswordChange = new PasswordChangeForm();
        /*
                if (Yii::$app->request->isAjax && $modelCabinetChange->load(Yii::$app->request->post())) {

                    Debugger::Eho('</br>');
                    Debugger::Eho('</br>');
                    Debugger::Eho('</br>');
                    Debugger::Eho('test');
                    Debugger::Eho('</br>');
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelCabinetChange);
                } */

        if ($modelPasswordChange->load(Yii::$app->request->post()) && $modelPasswordChange->setNewPassword()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }


        $modelContactChange = new ContactChangeForm();

        if ($modelContactChange->load(Yii::$app->request->post()) && $modelContactChange->setNewContact()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }

        $modelPhoneSelectChange = new PhoneSelectChangeForm();

        if ($modelPhoneSelectChange->load(Yii::$app->request->post())) {
            $p_m_1 = $modelPhoneSelectChange->setNewPhone();

            if ($p_m_1) {
                if ($p_m_1 === 2) {

                    if (!Yii::$app->request->isPjax) {
                        return $this->redirect(['/upravlenie-kabinetom#contact_change']);
                    }
                } elseif ($p_m_1 === 3) {
                    if (!Yii::$app->request->isPjax) {
                        //    return $this->redirect(['/upravlenie-kabinetom#contact_change']);
                    }
                } else {
                    if (!Yii::$app->request->isPjax) {
                        return $this->redirect(['/phone-change']);
                    }
                }
            }
        }

        $modelPhoneAddForm = new PhoneAddForm();


        if ($modelPhoneAddForm->load(Yii::$app->request->post()) && $modelPhoneAddForm->setNewPhone()) {

            return $this->redirect(['/phone-first-change-confirm']);

        }

        $modelEmailSelectChange = new EmailSelectChangeForm();

        if ($modelEmailSelectChange->load(Yii::$app->request->post())) {
            $p_m_1 = $modelEmailSelectChange->setNewEmail();

            if ($p_m_1) {
                if ($p_m_1 === 2) {

                    if (!Yii::$app->request->isPjax) {
                        return $this->redirect(['/upravlenie-kabinetom#contact_change']);
                    }
                } elseif ($p_m_1 === 3) {
                    if (!Yii::$app->request->isPjax) {
                        //    return $this->redirect(['/upravlenie-kabinetom#contact_change']);
                    }
                } else {
                    if (!Yii::$app->request->isPjax) {
                        return $this->redirect(['/email-change']);
                    }
                }
            }
        }

        $modelEmailAddForm = new EmailAddForm();


        if ($modelEmailAddForm->load(Yii::$app->request->post()) && $modelEmailAddForm->setNewEmail()) {

            return $this->redirect(['/email-change-confirm']);

        }


        $modelMessageTypeChange = new MessageTypeChangeForm();


        if ($modelMessageTypeChange->load(Yii::$app->request->post()) && $modelMessageTypeChange->setNewMessageType()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }

        $modelSkinsChange = new SkinsChangeForm();


        if ($modelSkinsChange->load(Yii::$app->request->post()) && $modelSkinsChange->setNewSkin()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }



        $modelServicesChangePauseStart = new ServicesChangePauseStartForm();
        $active_services_array = array();
        foreach ($user_data["services_status_num"] as $key => $val) {
            if ($val != -2) {
                if (isset($user_data['services_tariff_name'][$key])) {

                    if ($user_data['services_tariff_info'][$key]['pause_allowed'] == 1) {
                        $active_services_array[$key] = $user_data['services_tariff_name'][$key];
                    }

                }

            }

        }


        if ($modelServicesChangePauseStart->load(Yii::$app->request->post()) && $modelServicesChangePauseStart->setPause()) {
            //  if (!Yii::$app->request->isPjax) {

            return $this->redirect(['/upravlenie-kabinetom']);
            //  }
        }


        $modelServicesChangePauseFinish = new ServicesChangePauseFinishForm();
        $paused_services_array = array();
        foreach ($user_data["services_status_num"] as $key => $val) {
            if ($val == -2) {
                if (isset($user_data['services_tariff_name'][$key])) {
                    $paused_services_array[$key] = $user_data['services_tariff_name'][$key];

                }

            }

        }


        if ($modelServicesChangePauseFinish->load(Yii::$app->request->post()) && $modelServicesChangePauseFinish->deletePause()) {

            //  if (!Yii::$app->request->isPjax) {

            return $this->redirect(['/upravlenie-kabinetom']);
            //  }
        }









        $modelServicesTrafficLimit = new ServicesTrafficLimitForm();

        if ($modelServicesTrafficLimit->load(Yii::$app->request->post()) && $modelServicesTrafficLimit->trafficLimitOnOff()) {
          //  if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
          //  }
        }










        $email_message_types = array();
        foreach (Yii::$app->params['email_message_types'] as $k => $v) {
            $email_message_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }

        $sms_message_types = array();
        foreach (Yii::$app->params['sms_message_types'] as $k => $v) {
            $sms_message_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }
        $telegram_message_types = array();
        foreach (Yii::$app->params['telegram_message_types'] as $k => $v) {
            $telegram_message_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }
        $message_lang = array();
        foreach (Yii::$app->params['lang'] as $k => $v) {
            $message_lang[$k] = Yii::t('upravlenie-kabinetom', $v['url']);
    }
       // Debugger::Br();
       // Debugger::PrintR($user_data['telegram_info']);
      //  Debugger::Eho($user_data['telegram_info']);
       // Debugger::testDie();
        $telegram_registration = 0;
        if(!$user_data['telegram_info']){
            global $request_vars;
            $telegram_registration = telegram_invite_acc(-1, Yii::$app->user->id, $user_data['account_id']); // функция биллинга, возвращает ссылку на регистрацию в телеграмме
     //  Debugger::EhoBr($telegram_registration);
        }
      //  Debugger::PrintR($user_data['telegram_info']);






        $skin_types = array();
        foreach (Yii::$app->params['skin_types'] as $k => $v) {
            $skin_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }

        $selected_email_message_types = $user_data['email_message_type'];
        $selected_sms_message_types = $user_data['sms_message_type'];
        $selected_telegram_message_types = $user_data['telegram_message_type'];
     //   Debugger::PrintR($user_data['email_message_type_all']);
      //  Debugger::PrintR($user_data['sms_message_type_all']);

        $selected_skin_type = -2;
        foreach(Yii::$app->params['skin_types'] as $k => $v){

            if($v['billing_key'] === $user_data['skin']){
                $selected_skin_type = $k;

            }
        }

        return $this->render('cabinet-management', [
            'user_data' => $user_data,
            'modelPasswordChange' => $modelPasswordChange,
            'modelContactChange' => $modelContactChange,
            'modelMessageTypeChange' => $modelMessageTypeChange,
            'modelPhoneSelectChange' => $modelPhoneSelectChange,
            'modelEmailSelectChange' => $modelEmailSelectChange,
            'modelPhoneAddForm' => $modelPhoneAddForm,
            'modelEmailAddForm' => $modelEmailAddForm,
            'modelSkinsChange' => $modelSkinsChange,
            'modelServicesTrafficLimit' => $modelServicesTrafficLimit,
            'modelServicesChangePauseStart' => $modelServicesChangePauseStart,
            'modelServicesChangePauseFinish' => $modelServicesChangePauseFinish,
            'email_message_types' => $email_message_types,
            'sms_message_types' => $sms_message_types,
            'telegram_message_types' => $telegram_message_types,
            'message_lang' => $message_lang,
            'skin_types' => $skin_types,
            'selected_email_message_types' => $selected_email_message_types,
            'selected_sms_message_types' => $selected_sms_message_types,
            'selected_telegram_message_types' => $selected_telegram_message_types,
            'selected_skin_type' => $selected_skin_type,
            'active_services_array' => $active_services_array,
            'paused_services_array' => $paused_services_array,
            'telegram_registration' => $telegram_registration,
            // 'delete_phone_1_confirm' => $delete_phone_1_confirm,
        ]);
    }

    public function actionPayment()
    {

        User::UserData();



        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];


        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];




       // $test = is_credit_denied($user_data['account_id']);
//Debugger::EhoBr($activation_services);
     //   Debugger::EhoBr('test');
      //  Debugger::PrintR($test);
       // Debugger::testDie();



        //  $this->enableCsrfValidation = false;
        $modelCredit = new CreditForm();
     //   Debugger::EhoBr('test');
       // Debugger::VarDamp($modelCredit->load(Yii::$app->request->post()));
      //  Debugger::testDie();
        if ($modelCredit->load(Yii::$app->request->post()) && $modelCredit->setCredit()) {

            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/oplata-uslug']);
            }
        }
        $credit_status = $user_data['account_credit_data'][0];
        $day_price = ($user_data['account_credit_data'][3]/30.5);
        $max_days = $user_data['account_credit_data'][2];
        $max_days0 = $user_data['account_credit_data'][1];
        $delta = $user_data['account_credit_data'][4];
        $max_credit = $credit_status == -6 ? ( ((int)($day_price*$max_days/10))/100 ) : '';
        $one_day_credit = $credit_status == -6 ? ( ((int)(($delta-$day_price)/10))/100 ) : '';

        $minus_many = $credit_status == -7 ? ( ((int)(($delta-$user_data['account_credit_data'][5])/10))/100 ) : '';
        $max_credit_2 = $credit_status == -7 ? ( ((int)($day_price*$max_days/10))/100 ) : '';


        return $this->render('payment', [
            'modelCredit' => $modelCredit,
            'user_data' => $user_data,
            'lang' => $lang,
            'credit_status' => $credit_status,
            'max_days' => $max_days,
            'max_days0' => $max_days0,
            'delta' => $delta/1000,
            'monthly' => $user_data['account_credit_data'][3]/1000,
            'day_price' => $day_price/1000,
            'max_credit' => $max_credit,
            'one_day_credit' => $one_day_credit,
            'minus_many' => $minus_many,
            'max_credit_2' => $max_credit_2,

        ]);
    }

    public function actionPaymentHistory()
    {
        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $payment_history_data = array_reverse(User::PaymentHistory($user_data['account_id']));

        $pages = new Pagination(['totalCount' => count($payment_history_data), 'pageSize' => Yii::$app->params['items_per_page']['payment_history']]);
        $pages->pageSizeParam = false;

        $payment_history_page = array_slice($payment_history_data, $pages->offset, $pages->limit, $preserve_keys = true);

        return $this->render('payment-history', [
            'payment_history_page' => $payment_history_page,
            'pages' => $pages,
        ]);
    }

    public function actionSupport()
    {
        User::UserData();


        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelSupport = new SupportForm();


        if ($modelSupport->load(Yii::$app->request->post()) && $modelSupport->sendProblem()) {
                return $this->redirect(["/tehnicheskaya-podderzhka/details#support_details_top"]);
        }


        $problem_types = array();
        foreach (Yii::$app->params['problem_types'] as $k => $v) {
            $problem_types[$k] = Yii::t('support', $v['lang_key']);
        }

        return $this->render('support', [
            'user_data' => $user_data,
            'modelSupport' => $modelSupport,
            'problem_types' => $problem_types,
            //'operation_systems' => $operation_systems,
            //'support_data' => User::SupportData(),
        ]);
    }

    public function actionSupportDetails()
    {
        User::UserData();



        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelTechnicalSupport = new TechnicalSupportForm();

        $problem_type = Yii::$app->session->get('problem') ? Yii::$app->session->get('problem') : -1;

       // Debugger::EhoBr($problem_type);
        Yii::$app->session->remove('problem');



        if ($modelTechnicalSupport->load(Yii::$app->request->post()) && $modelTechnicalSupport->sendTechnicalInfo()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/tehnicheskaya-podderzhka/details"]);
            }
        }

        if($problem_type == -1){
            // Debugger::testDie();
            return $this->redirect(["/istoriya-obrascheniy"]);
        }
        /*
        $swith = array();
        foreach(Yii::$app->params['swith'] as $k => $v){
            $swith[$k] = Yii::t('support',$v['lang_key']);
        } */
        global $request_vars;
        //$request_vars['submit_add'] = 1;
        //$request_vars['TechnicalSupportForm']['submit_add'] = 1;
        // Debugger::PrintR($request_vars);


        todo_ctx_preload_from_vars($request_vars, 0, TODO_INIT_SUPPORT);//функция API биллинга


        $swith = get_lang_opt_list('user_router_types'); //функция из api биллинга
        $swith[0] = Yii::t('support', 'select_option');
        /*
        $operation_systems = array();
        foreach(Yii::$app->params['operation_systems'] as $k => $v){
            $operation_systems[$k] = Yii::t('support',$v['lang_key']);
        } */
        //Debugger::PrintR( get_lang_opt_list('user_router_types'));
        $operation_systems = get_lang_opt_list('os_types'); //функция из api биллинга
        $operation_systems[0] = Yii::t('support', 'select_option');

        $user_speeds[0] = Yii::t('support', 'select_option');
        foreach (Yii::$app->params['user_speed'] as $k => $v) {
            $user_speeds[$k] = Yii::t('support', $v['lang_key']);
        }


        return $this->render('support-details', [
            'user_data' => $user_data,
            'modelTechnicalSupport' => $modelTechnicalSupport,
            'swith' => $swith,
            'operation_systems' => $operation_systems,
            'support_data' => User::SupportData(),
            'problem_type' => $problem_type,
            'user_speeds' => $user_speeds,
        ]);
    }

    public function actionSupportHistory()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        // User::TodoHistory($user_data['username']);

        //  Debugger::PrintR($test);
        //Debugger::PrintR(User::TodoHistory($user_data['username']));

        $todo_history_array = User::TodoHistory($user_data['username'], $user_data['account_id']);
      //  Debugger::PrintR($todo_history_array);
        $pages = new Pagination(['totalCount' => count($todo_history_array), 'pageSize' => Yii::$app->params['items_per_page']['todo_history']]);
        $pages->pageSizeParam = false;

        $todo_history_page = array_slice($todo_history_array, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('support-history', [
            'todo_history_array' => $todo_history_page,
            'pages' => $pages,
        ]);
    }

    public function actionSupportHistoryTodo()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $url = Yii::$app->request->url;

        $url_cl = explode('?', $url);
        $url_array = explode('/', $url_cl[0]);
        $todo_id = array_pop($url_array);



        $todo_history = User::TodoHistoryNode($user_data['username'], $todo_id, $user_data['account_id']);
        if(!$todo_history){
            $this->redirect(['site/error']);
          // return Yii::$app->errorHandler->errorAction;
        }

        $todo_history_node = iconv_safe('koi8-u', 'utf-8', $todo_history['todo_desc_web']);


        $modelUpdateTodo = new UpdateTodoForm();

        if ($modelUpdateTodo->load(Yii::$app->request->post()) && $modelUpdateTodo->setUpdate()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/istoriya-obrascheniy/' . $todo_id]);
            }
        }


        return $this->render('support-history-todo', [
            'todo_history_node' => $todo_history_node,
            'todo_id' => $todo_id,
            'todo_history' => $todo_history,
            'modelUpdateTodo' => $modelUpdateTodo
        ]);


    }

    public function actionFeedback()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelFeedback = new FeedbackForm();
        // $modelFeedback->files = UploadedFile::getInstances($modelFeedback, 'files');

        if ($modelFeedback->load(Yii::$app->request->post()) && $modelFeedback->setFeedback()) {
            // Debugger::PrintR($_POST);

            //  Debugger::testDie();
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/ostavit-otzyiv']);
            }
        }

        return $this->render('feedback', [
            'user_data' => $user_data,
            'modelFeedback' => $modelFeedback,

        ]);
    }

    public function actionTv()
    {
        User::UserData();
        $tv = 'Тестовый текст страници - Телевидение';

        return $this->render('tv', ['tv' => $tv]);
    }

    public function actionCallRequest()
    {
        if (!Yii::$app->user->isGuest) {
            User::UserData();
        }


        $modelCallRequest = new CallRequestForm();


        return $this->renderPartial('call-request',
            ['modelCallRequest' => $modelCallRequest]);


    }

    public function actionSubmitCallRequest()
    {

        if (!Yii::$app->user->isGuest) {
            User::UserData();
        }
        $modelCallRequest = new CallRequestForm();
        //  $modelCallRequest->load(Yii::$app->request->post());

        if ($modelCallRequest->load(Yii::$app->request->post()) && $modelCallRequest->setCallRequest()) {

            $success = true;
            return json_encode($success);
        } else {
            return $this->renderPartial('call-request',
                ['modelCallRequest' => $modelCallRequest]);
        }

    }


    public function actionColor()
    {


        global $acc_db_host;
        global $acc_db;
        global $acc_db_user;
        global $acc_db_pwd;

        $sms_statistics = new SmsStatistics($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);



      //  $sms_statistics->insertData(1);
      // $data = $sms_statistics->smsLimit(1,30,1);
       // $sms_statistics->deleteOld(60);
     //   Debugger::Br();

        //Debugger::VarDamp($data);


/*
 *
 *
 *
 * Создание таблици в биленге
 *
       global $acc_db;
        global $acc_db_host;
        global $acc_db_user;
        global $acc_db_pwd;

        $dbc = Conn_db::getConnection($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);

        $sql = 'create table `sms-statistics` (
         id int (10) AUTO_INCREMENT,
         user_id int(10) NOT NULL,
         time datetime NOT NULL,
         PRIMARY KEY (id)
          )';

        $sql = 'ALTER TABLE  `sms-statistics` CHANGE  `time`  `time` INT NOT NULL';

        $placeholders=array();

        $sth = $dbc->getPDO()->prepare($sql);
        $sth->execute($placeholders);
*/
        $test7 = $this->test7('20 -March ,2017');

     //  $test = get_all_address();

//Debugger::PrintR($test);

       // Debugger::PrintR(require_once (__DIR__ . '/../components/billing_api/all_addr_array.php'));


        return $this->render('color',[
        'test7' => $test7,
        ]);
    }



    public function test7($date)
    {
      //  $serch = array()
     // $date2 =  str_replace('[0-9]','', $date);
        $cultureKey = 'ua';
        $month_input = trim(preg_replace('/[0-9]/','',$date)," .,/-_*");


        $def_monthes = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

        switch ($cultureKey) {
            case 'en':
                $monthes = $def_monthes;
                break;
            case 'ua':
                $monthes = array('Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня');
                break;
            case 'ru':
            default:
                $monthes = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
                break;
        }
        if($month_input){
            $month_num = array_search($month_input, $def_monthes);
            $month_output = $monthes[$month_num];
            $date_output = str_replace($month_input, $month_output, $date);
        }else{
            $date_output = $date;
        }

        return $date_output;

    }



    public function actionPhoneChange()
    {

        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $modelPhoneFirstChange = new PhoneFirstChangeForm();

        if ($modelPhoneFirstChange->load(Yii::$app->request->post())) {

            $p_m_1 = $modelPhoneFirstChange->setNewPhone1();

            if ($p_m_1) {
                if ($p_m_1 === 2) {

                    return $this->redirect(['/upravlenie-kabinetom']);
                } elseif ($p_m_1 === 3) {
                    return $this->redirect(['/phone-change']);
                } else {
                    // Debugger::PrintR($_POST);
//Debugger::testDie();

                    return $this->redirect(['/phone-first-change-confirm']);
                }
            }
        }
        $p_o = str_split(Yii::$app->session->get('phone_to_change'));
        if(count($p_o) == 12){
            $full_old_phone = '+'.$p_o[0].$p_o[1].$p_o[2].' ('.$p_o[3].$p_o[4].') '.$p_o[5].$p_o[6].$p_o[7].' '.$p_o[8].$p_o[9].' '.$p_o[10].$p_o[11];

        } else{
            $full_old_phone = Yii::$app->session->get('phone_to_change');
        }
        $phone_old_short = (int)substr(Yii::$app->session->get('phone_to_change'), -9);

        return $this->render('phone-change', [
            'phone_old' => $full_old_phone,
            'phone_old_short' => $phone_old_short,
            'user_data' => $user_data,
            'modelPhoneFirstChange' => $modelPhoneFirstChange,

        ]);
    }


    public function actionEmailChange()
    {

        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $modelEmailChange = new EmailChangeForm();

        if ($modelEmailChange->load(Yii::$app->request->post())) {

            $p_m_1 = $modelEmailChange->setNewEmail();

            if ($p_m_1) {
                if ($p_m_1 === 2) {

                    return $this->redirect(['/upravlenie-kabinetom']);
                } elseif ($p_m_1 === 3) {
                    return $this->redirect(['/email-change']);
                } else {
                    // Debugger::PrintR($_POST);
//Debugger::testDie();

                    return $this->redirect(['/email-change-confirm']);
                }
            }
        }

        return $this->render('email-change', [
            'user_data' => $user_data,
            'modelEmailChange' => $modelEmailChange,

        ]);
    }


    public function actionPhoneFirstChangeConfirm()
    {

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        //User::UserData();
        if (Yii::$app->session->has('new_user_phone_or_email') && Yii::$app->session->has('confirmcode') && Yii::$app->request->get('sms')) {
            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
            $user_name = isset($user_data['username']) ? $user_data['username'] : '';
            $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
            $org_id = isset($user_data['org_id']) ? $user_data['org_id'] : '';

            $phone_number = Yii::$app->session->get('new_user_phone_or_email');

            turbosms_init($verbose = 1);//функция из апи биллинга, инициализирует работу с смс сообщениями
            ast_init();//функция из апи биллинга
            $normal_phone = asterisk_normalize_phone($phone_number);//функция из апи биллинга, нормализирует телефон отправленный пользователем

            $user_sms = new UserSms(Yii::$app->language);
            $sms_text = Yii::t('sms_messages', 'change_password');
            $full_sms_text = $user_sms->createSmsTextPasswordChange(
                $sms_text,
                Yii::$app->params['sms_send_conf']['transliteration'],
                Yii::$app->params['sms_send_conf']['verification_cod_length'],
                Yii::$app->params['sms_send_conf']['verification_cod_num'],
                Yii::$app->params['sms_send_conf']['verification_cod_down_chars'],
                Yii::$app->params['sms_send_conf']['verification_cod_up_chars']
            );


            global $acc_db_host;
            global $acc_db;
            global $acc_db_user;
            global $acc_db_pwd;

            $sms_statistics = new SmsStatistics($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
            $sms_statistics->deleteOld(Yii::$app->params['sms_time_limit_delete']);
            if ($sms_statistics->smsLimit(Yii::$app->user->id, Yii::$app->params['sms_time_limit'], Yii::$app->params['sms_limit'])) {
                turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга
                $sms_statistics->insertData(Yii::$app->user->id);
            } else {
                Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'limit_sms_send')]);
                $this->redirect("/$lang/upravlenie-kabinetom");
            }

        }

        if ((!Yii::$app->session->has('new_user_phone_or_email') || !Yii::$app->session->has('confirmcode')) && !Yii::$app->session->has('number_valid')) {

            Yii::$app->session->remove('new_user_phone_or_email');
            Yii::$app->session->remove('confirmcode');
            $this->redirect('/');
        }

        global $phone;
        $phone = Yii::$app->session->get('new_user_phone_or_email');

        $modelPhoneFirstChangeConfirm = new PhoneFirstChangeConfirmForm();
        // $confirm = $modelPhoneFirstChangeConfirm->setConfirmCode();
        // Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
         // Debugger::Eho($confirm);
        //   Debugger::testDie();
     //   Debugger::EhoBr(Yii::$app->session->get('confirmcode'));

        if ($modelPhoneFirstChangeConfirm->load(Yii::$app->request->post())) {

            $confirm = $modelPhoneFirstChangeConfirm->setConfirmCode();
            //Debugger::Eho($confirm);
            //          Debugger::Eho('test1');
            //        Debugger::testDie();
            if ($confirm) {

                if ($confirm === 2) {
//Debugger::Eho('ttttttttt');
                    // Debugger::testDie();
                    return $this->redirect(['/phone-first-change-confirm']);
                } elseif ($confirm === true) {
                    if (Yii::$app->session->has('add')) {
                        Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'phone_add')]);
                        Yii::$app->session->remove('add');
                        event_log2('common.contacts.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Add new user contact (phone number)');//функция биллинга записывает инфу в лог
                    } else {
                        Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'phone_1_change')]);
                        event_log2('common.contacts.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Changed user contact (phone number)');//функция биллинга записывает инфу в лог
                    }


                    return $this->redirect(['/upravlenie-kabinetom']);
                }
                return $this->redirect(['/upravlenie-kabinetom']);
            }


        }


        return $this->render('phone-first-change-confirm',
            ['modelPhoneFirstChangeConfirm' => $modelPhoneFirstChangeConfirm,
                'contact_type' => 'phone_1',
                'lang' => $lang,
            ]);


    }


    public function actionEmailChangeConfirm()
    {

        // User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        if (Yii::$app->session->has('new_user_phone_or_email') && Yii::$app->session->has('confirmcode') && Yii::$app->request->get('email')) {
            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
            $user_name = isset($user_data['username']) ? $user_data['username'] : '';
            $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
            $org_id = isset($user_data['org_id']) ? $user_data['org_id'] : '';

            $email = Yii::$app->session->get('new_user_phone_or_email');


            $user_email = new UserSms(Yii::$app->language);
            $email_text = Yii::t('email_messages', 'change_email');
            $full_email_text = $user_email->createSmsTextPasswordChange(
                $email_text,
                Yii::$app->params['email_send_conf']['transliteration'],
                Yii::$app->params['email_send_conf']['verification_cod_length'],
                Yii::$app->params['email_send_conf']['verification_cod_num'],
                Yii::$app->params['email_send_conf']['verification_cod_down_chars'],
                Yii::$app->params['email_send_conf']['verification_cod_up_chars']
            );

            $subject = Yii::t('sms_messages', 'subject');
            global $_admin_mail;
            $from_mail = $_admin_mail;
            $server_name = Yii::$app->params['server_name'];
            $domains_key = Yii::$app->params['domains'][$server_name];
            $from_user = Yii::t('site','admin') . Yii::t('site', Yii::$app->params['sites_data'][$domains_key]['company_name']['lang_key']);


            my_mail( $email, iconv_safe('utf-8','koi8-u',$full_email_text), iconv_safe('utf-8','koi8-u',$subject), $from_mail, $from_user);
            //  turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга

        }

        if ((!Yii::$app->session->has('new_user_phone_or_email') || !Yii::$app->session->has('confirmcode'))) {

            Yii::$app->session->remove('new_user_phone_or_email');
            Yii::$app->session->remove('confirmcode');
            $this->redirect('/');
        }

        global $email;
        $email = Yii::$app->session->get('new_user_phone_or_email');

        $modelEmailChangeConfirm = new EmailChangeConfirmForm();


      //   $confirm = $modelEmailChangeConfirm->setConfirmCode();
         //Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
         // Debugger::Eho('</br>');
        //   Debugger::Eho($confirm);
        //   Debugger::testDie();
      //  Debugger::EhoBr(Yii::$app->session->get('confirmcode'));

        if ($modelEmailChangeConfirm->load(Yii::$app->request->post())) {

            $confirm = $modelEmailChangeConfirm->setConfirmCode();
            //Debugger::EhoBr( $modelEmailChangeConfirm->confirmcode);

//            Debugger::Eho($confirm);
            //          Debugger::Eho('test1');
            //        Debugger::testDie();
            if ($confirm) {

                if ($confirm === 2) {
//Debugger::Eho('ttttttttt');
                    // Debugger::testDie();
                    return $this->redirect(['/email-change-confirm']);
                } elseif ($confirm === true) {
                    if (Yii::$app->session->has('add')) {
                        //function event_log2($src, $net_id, $acc_id, $user_id, $sw_id, $loc_id, $admin_id, $ref_todo_id, $ref_inv_id, $etype, $comment)
                        event_log2('common.contacts.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Add new user contact (e-mail)');//функция биллинга записывает инфу в лог
                        Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'email_add')]);
                        Yii::$app->session->remove('add');
                    } else {
                        event_log2('common.contacts.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Changed user contact (e-mail)');//функция биллинга записывает инфу в лог
                        Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'email_change')]);
                    }


                    return $this->redirect(['/upravlenie-kabinetom']);
                }
                return $this->redirect(['/upravlenie-kabinetom']);
            }


        }
        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

//Debugger::EhoBr(Yii::$app->session->get('testt'));

        return $this->render('phone-first-change-confirm',
            ['modelPhoneFirstChangeConfirm' => $modelEmailChangeConfirm,
                'contact_type' => 'email',
                'lang' => $lang,
            ]);


    }

    public function actionTerminals()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        return $this->render('terminals', [
            'user_data' => $user_data,
        ]);
    }

    public function actionBank()
    {
        User::UserData();
        global $is_admin;
       //Debugger::PrintR($_SESSION);
       // Debugger::VarDamp($is_admin);
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $modelRtfPrint = new RtfPrintForm();


        if ($modelRtfPrint->load(Yii::$app->request->post()) && $modelRtfPrint->createRtf()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/oplata-uslug/bank']);
            }
        }

        return $this->render('bank', [
            'user_data' => $user_data,
            'modelRtfPrint' => $modelRtfPrint,
        ]);
    }

    public function actionArhivNews()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

        $modelArhivNews = new ArhivNews();
        $arhiv_data = $modelArhivNews->getArhiv($user_data['account_id']);
       // Debugger::PrintR($arhiv_data);





        $pages = new Pagination(['totalCount' => count($arhiv_data), 'pageSize' => Yii::$app->params['items_per_page']['news_archive']]);
        $pages->pageSizeParam = false;

        $archive_data_page = array_slice($arhiv_data, $pages->offset, $pages->limit, $preserve_keys = true);

   //     return $this->render('payment-history', [
     //       'payment_history_page' => $payment_history_page,
      //      'pages' => $pages,






        return $this-> render('arhiv-news',[
            'user_data' => $user_data,
            'modelArhivNews' => $modelArhivNews,
            'archive_data_page' => $archive_data_page,
            'lang' => $lang,
            'pages' => $pages,
        ]);
    }

    public function actionArhivNewsNode()
    {
        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

        $url = Yii::$app->request->url;

        $url_cl = explode('?', $url);
        $url_array = explode('/', $url_cl[0]);
      //  Debugger::PrintR($url_array);
        $news_id = array_pop($url_array);

        $modelArhivNews = new ArhivNews();
        $arhiv_data_total = $modelArhivNews->getArhiv($user_data['account_id']);
        $arhiv_data_news = array();
        foreach($arhiv_data_total as $k=>$v){
            if($v['id'] == $news_id){
                $arhiv_data_news[]= $v;
            }
        }

        $modelArhivNews->newsReadeStatus($arhiv_data_news[0]['view'], $arhiv_data_news[0]['id']);

        return $this->render('arhiv-news-node',[
            'lang' => $lang,
            'news_id' => $news_id,
            'arhiv_data_news'=> $arhiv_data_news[0],

            ]);
    }
    public function actionArhivNewsNodeReade()
    {
        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];
        $url = Yii::$app->request->url;

        $url_cl = explode('?', $url);
        $url_array = explode('/', $url_cl[0]);
        $news_id = array_pop($url_array);

        $modelArhivNews = new ArhivNews();
        $arhiv_data_total = $modelArhivNews->getArhiv($user_data['account_id']);
        $arhiv_data_news = array();
        foreach($arhiv_data_total as $k=>$v){
            if($v['id'] == $news_id){
                $arhiv_data_news[]= $v;
            }
        }

        $modelArhivNews->newsReadeStatus($arhiv_data_news[0]['view'], $arhiv_data_news[0]['id']);
        return $this->redirect(["/arhiv-novostei"]);
    }


}
