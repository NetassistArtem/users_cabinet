<?php

namespace app\controllers;

use app\models\ContactChangeForm;
use app\models\FeedbackForm;
use app\models\PhoneFirstChangeForm;
use app\models\PhoneSelectChangeForm;
use app\models\UpdateTodoForm;
use app\models\MessageTypeChangeForm;
use app\models\TechnicalSupportForm;
use app\models\CallRequestForm;
use app\models\PhoneFirstChangeConfirmForm;
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
                    'change-phone'
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
                            'change-phone'
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
                            'change-phone'
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

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];


        return $this->render('cabinet', ['user_data' => $user_data, 'lang' => $lang]);
    }

    public function actionCabinetManagement()
    {

        User::UserData();
        Yii::$app->session->remove('confirmcode');
        Yii::$app->session->remove('number_valid');

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

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

        $modelMessageTypeChange = new MessageTypeChangeForm();


        if ($modelMessageTypeChange->load(Yii::$app->request->post()) && $modelMessageTypeChange->setNewMessageType()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }

        $email_message_types = array();
        foreach (Yii::$app->params['email_message_types'] as $k => $v) {
            $email_message_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }

        $sms_message_types = array();
        foreach (Yii::$app->params['sms_message_types'] as $k => $v) {
            $sms_message_types[$k] = Yii::t('upravlenie-kabinetom', $v['lang_key']);
        }

        $selected_email_message_types = $user_data['email_message_type'];
        $selected_sms_message_types = $user_data['sms_message_type'];


        return $this->render('cabinet-management', [
            'user_data' => $user_data,
            'modelPasswordChange' => $modelPasswordChange,
            'modelContactChange' => $modelContactChange,
            'modelMessageTypeChange' => $modelMessageTypeChange,
            'modelPhoneSelectChange' => $modelPhoneSelectChange,
            'email_message_types' => $email_message_types,
            'sms_message_types' => $sms_message_types,
            'selected_email_message_types' => $selected_email_message_types,
            'selected_sms_message_types' => $selected_sms_message_types,


            // 'delete_phone_1_confirm' => $delete_phone_1_confirm,

        ]);
    }

    public function actionPayment()
    {

        User::UserData();

        //  $this->enableCsrfValidation = false;

        $payment = '';

        return $this->render('payment', [
            'payment' => $payment,

        ]);
    }

    public function actionPaymentHistory()
    {
        User::UserData();
        $payment_history = 'Тестовый текст страници - История платежей';

        return $this->render('payment-history', ['payment_history' => $payment_history]);
    }

    public function actionSupport()
    {
        User::UserData();

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelTechnicalSupport = new TechnicalSupportForm();


        if ($modelTechnicalSupport->load(Yii::$app->request->post()) && $modelTechnicalSupport->sendTechnicalInfo()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/tehnicheskaya-podderzhka']);
            }
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


        return $this->render('support', [
            'user_data' => $user_data,
            'modelTechnicalSupport' => $modelTechnicalSupport,
            'swith' => $swith,
            'operation_systems' => $operation_systems,
            'support_data' => User::SupportData(),
        ]);
    }

    public function actionSupportHistory()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        // User::TodoHistory($user_data['username']);

        //  Debugger::PrintR($test);
        //Debugger::PrintR(User::TodoHistory($user_data['username']));

        $todo_history_array = User::TodoHistory($user_data['username']);
        $pages = new Pagination(['totalCount' => count($todo_history_array), 'pageSize' => 10]);
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

        User::UserData();
        $modelCallRequest = new CallRequestForm();


        return $this->renderPartial('call-request',
            ['modelCallRequest' => $modelCallRequest]);


    }

    public function actionSubmitCallRequest()
    {

        User::UserData();
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

        return $this->render('color');
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

                  //  return $this->redirect(['/upravlenie-kabinetom']);
                } else {
                    return $this->redirect(['/phone-first-change-confirm']);
                }
            }
        }

        return $this->render('phone-change', [
            'user_data' => $user_data,
            'modelPhoneFirstChange' => $modelPhoneFirstChange,

        ]);
    }

    public function actionPhoneFirstChangeConfirm()
    {

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


            //  turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга

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
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //   Debugger::Eho($confirm);
        //   Debugger::testDie();

        if ($modelPhoneFirstChangeConfirm->load(Yii::$app->request->post())) {
            $confirm = $modelPhoneFirstChangeConfirm->setConfirmCode();

            if ($confirm) {
                // Debugger::Eho($confirm);
                // Debugger::Eho('test1');
                // Debugger::testDie();
                if ($confirm === 2) {

                    return $this->redirect(['/phone-first-change-confirm']);
                } elseif ($confirm === true) {


                    Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'phone_1_change')]);
                    return $this->redirect(['/upravlenie-kabinetom']);
                }
                return $this->redirect(['/upravlenie-kabinetom']);
            }


        }
        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

        return $this->render('phone-first-change-confirm',
            ['modelPhoneFirstChangeConfirm' => $modelPhoneFirstChangeConfirm,
                'contact_type' => 'phone_1',
                'lang' => $lang,
            ]);


    }


}
