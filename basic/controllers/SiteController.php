<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RenewPasswordConfirmForm;
use app\models\RenewPasswordForm;
use app\components\debugger\Debugger;
use app\models\User;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','about','contact', 'payment-result'],


                'rules' => [
                    [
                        'controllers' => ['site'],
                        'actions' => ['logout','index','about','contact', 'payment-result'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => ['logout','about','index','contact', 'payment-result'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (Yii::$app->session->has('confirmcode')) {

               Yii::$app->session->remove('confirmcode');
        }
        if (Yii::$app->session->has('renew_password_phone')) {

            Yii::$app->session->remove('renew_password_phone');
        }
        if (Yii::$app->session->has('renew_password_email')) {

            Yii::$app->session->remove('renew_password_email');
        }
        if (Yii::$app->session->has('username_password_renew')) {

            Yii::$app->session->remove('username_password_renew');
        }
        if (Yii::$app->session->has('userid_password_renew')) {

            Yii::$app->session->remove('userid_password_renew');
        }



        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
//Debugger::EhoBr(md5(Yii::$app->request->get('ses_id').Yii::$app->params['security_key']));
      //  Debugger::testDie();
     //   Debugger::PrintR($_COOKIE);
        $model = new LoginForm();
        $security_key_get = false;
        $security_key_post = false;
        if(Yii::$app->request->get('ses_id') && Yii::$app->request->get('key')){
            $security_key_get = md5(Yii::$app->request->get('ses_id').Yii::$app->params['security_key'])== Yii::$app->request->get('key');
          //
        }elseif(Yii::$app->request->post('ses_id') && Yii::$app->request->post('key')){
            $security_key_post = md5(Yii::$app->request->post('ses_id').Yii::$app->params['security_key']) == Yii::$app->request->post('key');
        }
        if (($model->load(Yii::$app->request->post()) || (Yii::$app->request->get('ses_id') && $security_key_get ) || (Yii::$app->request->post('ses_id') && $security_key_post )) && $model->login()) {

            return $this->goBack();
        }
        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];
        return $this->render('login', [
            'model' => $model,
            'lang' => $lang,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionRenewPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $modelRenewPassword = new RenewPasswordForm;

        if ($modelRenewPassword->load(Yii::$app->request->post())) {
            $send_new_password = $modelRenewPassword->sendNewPasswordCode();
            if($send_new_password){
                if($send_new_password == 2){
                    return $this->redirect(['/renew-password']);
                }else{

                    return $this->redirect(['/renew-password-confirm']);
                }

            }



        }

        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

        return $this->render('renew-password', [
            'modelRenewPassword' => $modelRenewPassword,
            'lang' => $lang,
        ]);

    }
    public function actionRenewPasswordConfirm(){
        if (!Yii::$app->session->has('confirmcode')) {

         //   Yii::$app->session->remove('confirmcode');
            $this->redirect('/');
        }

        $modelRenewPasswordConfirm = new RenewPasswordConfirmForm();

        if(Yii::$app->session->get('renew_password_phone')){
            $contact_type = 'phone';
            $contact_type_value = Yii::$app->session->get('renew_password_phone');
          //  Yii::$app->session->remove('renew_password_phone');
        }elseif(Yii::$app->session->get('renew_password_email')){
            $contact_type = 'email';
            $contact_type_value = Yii::$app->session->get('renew_password_email');
          //  Yii::$app->session->remove('renew_password_email');
        }else{
            $contact_type = '';
            $contact_type_value = '';
        };

       // Debugger::EhoBr($contact_type);
       // Debugger::EhoBr($contact_type_value);

        if (!$modelRenewPasswordConfirm->load(Yii::$app->request->post()) && $contact_type_value && (Yii::$app->request->get('email') || Yii::$app->request->get('phone'))){

            if($contact_type == 'email' && Yii::$app->request->get('email')){
                $modelRenewPassword = new RenewPasswordForm;
                $modelRenewPassword->sendEmailConfirm();
                Yii::$app->session->setFlash('renewPasswordConfirm', ['value' => Yii::t('flash-message', 'code_resend_by_email')]);
               // Yii::$app->session->set('renew_password_email', Yii::$app->session->get('renew_password_email'));
            }elseif($contact_type == 'phone' && Yii::$app->request->get('phone')){
                $modelRenewPassword = new RenewPasswordForm;
                $modelRenewPassword->sendSmsConfirm(Yii::$app->session->get('userid_password_renew'));
                Yii::$app->session->setFlash('renewPasswordConfirm', ['value' => Yii::t('flash-message', 'code_resend_by_phone')]);
               // Yii::$app->session->set('renew_password_phone', Yii::$app->session->get('renew_password_phone'));
            }else{
                $this->redirect('/');
            }
        }




        // $confirm = $modelPhoneFirstChangeConfirm->setConfirmCode();
        // Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //   Debugger::Eho($confirm);
        //   Debugger::testDie();
        // Debugger::EhoBr(Yii::$app->session->get('confirmcode'));

        if ($modelRenewPasswordConfirm->load(Yii::$app->request->post())) {

           // Debugger::EhoBr('test');
           // Debugger::testDie();
            $confirm = $modelRenewPasswordConfirm->setConfirmCode($contact_type,$contact_type_value);
            //Debugger::Eho($confirm);
            //          Debugger::Eho('test1');
            //        Debugger::testDie();
            if ($confirm) {

                if ($confirm === 2) {
//Debugger::Eho('ttttttttt');
                    // Debugger::testDie();
                    return $this->redirect(['/renew-password-confirm']);
                } elseif ($confirm === true) {

                     //   event_log('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'],-1,-1,'Changed user contact (e-mail)');//функция биллинга записывает инфу в лог
                        Yii::$app->session->setFlash('renewPasswordConfirm', ['value' => Yii::t('flash-message', 'password_changed')]);



                    return $this->redirect(['/login']);
                }
                return $this->redirect(['/login']);
            }


        }



        $lang_arr = explode('-', Yii::$app->language);
        $lang = $lang_arr[0];

        return $this->render('renew-password-confirm',
            ['modelRenewPasswordConfirm' => $modelRenewPasswordConfirm,
                'contact_type' => $contact_type,
                'contact_type_value' => $contact_type_value,
                'lang' => $lang,
            ]);

}

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');


            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        Debugger::Eho('</br>');
        Debugger::Eho('</br>');
        Debugger::Eho('</br>');
    //    Debugger::PrintR(Yii::$app->user->identity);
        Debugger::PrintR(Yii::$app->session->get('user-data')[Yii::$app->user->id]);

        return $this->render('about');
    }
    public function actionPaymentResult()
    {
        User::UserData();

        $status = Yii::$app->session->get('get-data');
        $result = -1;
        if($status){
            if($status['fail']){
                $result = -1;
            }elseif($status['sent'] || $status['submit'] || $status['status']){
                $result = 1;
            }else{
                $result = -1;
            }
        }


        return $this->render('payment-result',[
        'result' => $result,
        ]);
    }

    public function actionPaymentResultRedirect()
    {
        User::UserData();

        $sent = Yii::$app->request->get('sent');
        $fail = Yii::$app->request->get('fail');
        $submit = Yii::$app->request->get('submit');
        $status = Yii::$app->request->get('status');


        $get_data = array(
            'sent' => $sent? $sent : '',
            'fail' => $fail? $fail : '',
            'submit' => $submit? $submit : '',
            'status' => $status? $status : '',
        );
        Yii::$app->session->set('get-data', $get_data);


        $this->redirect("/payment-result");
    }
    public function actionPaymentIsRequired()
    {
       // global $use_sessions;
       // $use_sessions = 1;
        $user_name= Yii::$app->request->get('user_name');
        Yii::$app->session->set('u_name', $user_name);
        User::UserData();

        return $this->renderPartial('payment-is-required',
            ['user_name'=> $user_name]);
    }
}
