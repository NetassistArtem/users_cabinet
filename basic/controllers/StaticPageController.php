<?php

namespace app\controllers;

use app\models\ContactChangeForm;
use app\models\FeedbackForm;
use app\models\MessageTypeChangeForm;
use app\models\TechnicalSupportForm;
use app\models\CallRequestForm;
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
                    'support-history-todo'
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
                            'support-history-todo'
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
                            'support-history-todo'
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




        return $this->render('cabinet', ['user_data' => $user_data]);
    }

    public function actionCabinetManagement()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $cabinet_management = 'Тестовый текст страници - Управление кабинетом';
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

        $modelMessageTypeChange = new MessageTypeChangeForm();


        if ($modelMessageTypeChange->load(Yii::$app->request->post()) && $modelMessageTypeChange->setNewMessageType()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/upravlenie-kabinetom']);
            }
        }

        $email_message_types = array();
        foreach(Yii::$app->params['email_message_types'] as $k => $v){
            $email_message_types[$k] = Yii::t('upravlenie-kabinetom',$v['lang_key']);
        }

        $sms_message_types = array();
        foreach(Yii::$app->params['sms_message_types'] as $k => $v){
            $sms_message_types[$k] = Yii::t('upravlenie-kabinetom',$v['lang_key']);
        }

        $selected_email_message_types = $user_data['email_message_type'];
        $selected_sms_message_types = $user_data['sms_message_type'];



        return $this->render('cabinet-management', [
            'user_data' =>$user_data,
            'cabinet_management' => $cabinet_management,
            'modelPasswordChange' => $modelPasswordChange,
            'modelContactChange' => $modelContactChange,
            'modelMessageTypeChange' => $modelMessageTypeChange,
            'email_message_types' => $email_message_types,
            'sms_message_types' => $sms_message_types,
            'selected_email_message_types' => $selected_email_message_types,
            'selected_sms_message_types' => $selected_sms_message_types,

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
        $support = 'Тестовый текст страници - Техническая поддержка';
      //  $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelTechnicalSupport = new TechnicalSupportForm();

        if ($modelTechnicalSupport->load(Yii::$app->request->post()) && $modelTechnicalSupport->sendTechnicalInfo()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/tehnicheskaya-podderzhka']);
            }
        }
        $swith = array();
        foreach(Yii::$app->params['swith'] as $k => $v){
            $swith[$k] = Yii::t('support',$v['lang_key']);
        }
        $operation_systems = array();
        foreach(Yii::$app->params['operation_systems'] as $k => $v){
            $operation_systems[$k] = Yii::t('support',$v['lang_key']);
        }


        return $this->render('support', [
            'support' => $support,
          //  'user_data' =>$user_data,
            'modelTechnicalSupport' =>$modelTechnicalSupport,
            'swith' => $swith,
            'operation_systems' => $operation_systems,
            'support_data' => User::SupportData(),
        ]);
    }
    public function actionSupportHistory()
    {
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $support_history = 'Тестовый текст страници - История обращения';
       // User::TodoHistory($user_data['username']);

      //  Debugger::PrintR($test);
        //Debugger::PrintR(User::TodoHistory($user_data['username']));

        $todo_history_array = User::TodoHistory($user_data['username']);
        $pages = new Pagination(['totalCount' => count($todo_history_array), 'pageSize' => 10]);
        $pages->pageSizeParam = false;

        $todo_history_page = array_slice($todo_history_array, $pages->offset,$pages->limit,$preserve_keys = true);



        return $this->render('support-history', [
            'support_history' => $support_history,
            'todo_history_array' => $todo_history_page,
            'pages' => $pages,
        ]);
    }
    public function actionSupportHistoryTodo(){
        User::UserData();
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        $url = Yii::$app->request->url;

        $url_cl = explode('?', $url);
        $url_array = explode('/', $url_cl[0]);
        $todo_id = array_pop($url_array);

        $todo_history = User::TodoHistoryNode($user_data['username'],$todo_id, $user_data['account_id']);
        $todo_history_node = iconv_safe('koi8-u','utf-8',$todo_history['todo_desc_web']);

        $modelFeedback = new FeedbackForm();

        if ($modelFeedback->load(Yii::$app->request->post()) && $modelFeedback->setFeedback()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/istoriya-obrascheniy/'.$todo_id]);
            }
        }


        return $this->render('support-history-todo', [
            'todo_history_node' => $todo_history_node,
            'todo_id' => $todo_id,
            'modelFeedback'=>$modelFeedback
        ]);



    }
    public function actionFeedback()
    {
        User::UserData();
        $feedback = 'Тестовый текст страници - Оставить отзыв';
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $modelFeedback = new FeedbackForm();
       // $modelFeedback->files = UploadedFile::getInstances($modelFeedback, 'files');

        if ($modelFeedback->load(Yii::$app->request->post()) && $modelFeedback->setFeedback()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(['/ostavit-otzyiv']);
            }
        }

        return $this->render('feedback', [
            'feedback' => $feedback,
            'user_data' => $user_data,
            'modelFeedback'=>$modelFeedback,

        ]);
    }
    public function actionTv()
    {
        User::UserData();
        $tv = 'Тестовый текст страници - Телевидение';

        return $this->render('tv', ['tv' => $tv]);
    }

    public  function actionCallRequest(){

        User::UserData();
        $modelCallRequest = new CallRequestForm();



        return $this->renderPartial('call-request',
            ['modelCallRequest' => $modelCallRequest]);


    }

    public  function actionSubmitCallRequest(){

        User::UserData();
        $modelCallRequest = new CallRequestForm();
      //  $modelCallRequest->load(Yii::$app->request->post());

        if ($modelCallRequest->load(Yii::$app->request->post()) && $modelCallRequest->setCallRequest()) {

            $success=true;
            return json_encode($success);
        }else{
            return $this->renderPartial('call-request',
                ['modelCallRequest' => $modelCallRequest]);
        }





    }

    public function actionColor(){

        return $this->render('color');
    }





}
