<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AlfaBlackAsset;
use app\assets\AlfaBlackCrtAsset;
use app\assets\AlfaGrayAsset;
use app\assets\AlfaWhiteAsset;
use app\assets\KuziaAsset;
use app\components\debugger\Debugger;
use app\widgets\WLang;
use yii\helpers\Url;
use app\components\LangRequest;
use app\controllers\StaticPageController;

$user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
//$lang_request = new LangRequest();
$admin = false;
if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->username === 'admin') {
        $admin = true;
    }
}

$lang_arr = explode('-',Yii::$app->language);
$lang = $lang_arr[0];


                    //if(isset($flash_message)):
                       // $this->registerJs('$("#request_call").click(function(){ $("#modal-contact").modal("show")});');  //function(){ $("#modal-contact").modal("hide")}
//$this->registerJs('function test(){$("#modal-contact").modal("show")};');
                       // echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_2.php');
                   // endif;
//$static_page_controller = new StaticPageController(Yii::$app->user->id, null);

//$static_page_controller->actionCallRequest();





// Переключение стилей в зависимости от сайта

$asset = 'app\assets\AppAsset';
$styles = 'default';
foreach(Yii::$app->params['domains'] as $k=>$v){
    if(strpos(Url::base(true),$v) !== false){
        $styles = $k;
    }
}

$testt = 3;
$server_name = Yii::$app->params['server_name'];
$styles =  Yii::$app->params['domains'][$server_name];
global $sites_data;
switch($styles){
    case 'alfa':
      switch($testt){ //get_skin(Yii::$app->user->identity->username)
          case 0 :
              AlfaGrayAsset::register($this);
              global $asset;
              $asset = 'app\assets\AlfaGrayAsset';
              $sites_data = Yii::$app->params['sites_data']['alfa'];
              Yii::$app->session->set('sites_data', $sites_data);
              break;
          case 1 :
              AlfaBlackAsset::register($this);
              global $asset;
              $asset = 'app\assets\AlfaBlackAsset';
              $sites_data = Yii::$app->params['sites_data']['alfa'];
              break;
          case 2 :
              AlfaBlackCrtAsset::register($this);
              global $asset;
              $asset = 'app\assets\AlfaBlackCrtAsset';
              $sites_data = Yii::$app->params['sites_data']['alfa'];
              break;
          case 3 :
              AlfaWhiteAsset::register($this);
              global $asset;
              $asset = 'app\assets\AlfaWhiteAsset';
              $sites_data = Yii::$app->params['sites_data']['alfa'];
              break;
          case -1 :
              switch(Yii::$app->params['alfa-styles-default']){
                  case 0 :
                      AlfaGrayAsset::register($this);
                      global $asset;
                      $asset = 'app\assets\AlfaGrayAsset';
                      $sites_data = Yii::$app->params['sites_data']['alfa'];
                      break;
                  case 1 :
                      AlfaBlackAsset::register($this);
                      global $asset;
                      $asset = 'app\assets\AlfaBlackAsset';
                      $sites_data = Yii::$app->params['sites_data']['alfa'];
                      break;
                  case 2 :
                      AlfaBlackCrtAsset::register($this);
                      global $asset;
                      $asset = 'app\assets\AlfaBlackCrtAsset';
                      $sites_data = Yii::$app->params['sites_data']['alfa'];
                      break;
                  case 3 :
                      AlfaWhiteAsset::register($this);
                      global $asset;
                      $asset = 'app\assets\AlfaWhiteAsset';
                      $sites_data = Yii::$app->params['sites_data']['alfa'];
                      break;
              }
      }

        break;
    case 'kuzia':
        KuziaAsset::register($this);
        global $asset;
        $asset = 'app\assets\KuziaAsset';
        $sites_data = Yii::$app->params['sites_data']['kuzia'];
        Yii::$app->session->set('sites_data', $sites_data);
        break;
    default:
        AppAsset::register($this);
        global $asset;
        $asset = 'app\assets\AppAsset';
}

// папап подтверждений

$this->registerJsFile(
    'scripts/index.js',
    ['depends'=>$asset]
);

$this->registerJsFile(
    'scripts/insert.js',
    ['depends'=>$asset]
);
//подтверждение изменения пароля перед сохранением
$this->registerJsFile(
    'scripts/password_change_confirm.js',
    ['depends'=>$asset]
);
$this->registerJsFile(
    'scripts/phone_delete_confirm.js',
    ['depends'=>$asset]
);



//echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_2.php');




?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= Yii::$app->view->renderFile('@app/views/static-page/modal/modal_2.php'); ?>


<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-fixed-top logo_background',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [

            $admin ? (
            ['label' => 'Админпанель', 'url' => ['/admin'], 'active' => (Yii::$app->request->url == "/admin"), 'options' => ['class' => 'li_admin']]

            ) : '',
     WLang::widget(),//вывод языковых переключателей

//'javascript:void(0);'
            "<li class='li_call_request'><a class='request_call' id ='request_call' href='/call-request'>".Yii::t('top_menu','request_call')."</a></li>",
            //['label' => Yii::t('top_menu','request_call'), 'url' => ['javascript:void(0);'], 'active' => (Yii::$app->request->url == ""), 'options' => ['class' => 'li_call_request', 'id' =>'request_call', 'onclick' => 'testt()']],
            ['label' => $sites_data['phone_1'], 'url' => ['#'], 'active' => (Yii::$app->request->url == "#"), 'options' => ['class' => 'li_phone']],
            Yii::$app->user->isGuest ? (
            ['label' => Yii::t('top_menu','login'), 'url' => ['/login'], 'active' => (Yii::$app->request->url == "/login"), 'options' => ['class' => 'li_login']]
            ) : (
                '<li class = li_logout>'
                . Html::beginForm(['/logout'], 'post')
                . Html::submitButton(
                    Yii::t('top_menu','logout'),
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>


        <?php
        if (!Yii::$app->user->isGuest):
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 account-data-block">
                    <p><?= $user_data['fio'] ?></p>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-1">
                            <a href="/cabinet">
                                <div>
                                    <h4><?= Yii::t('top_info_block','login') ?></h4>
                                    <p><?= $user_data['username'] ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-2">
                            <a href="/cabinet#finance">
                                <div>
                                    <h4><?= Yii::t('top_info_block','account_balance') ?></h4>
                                    <p> <?= $user_data['account_balance'].' '. $user_data['account_currency'] ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-3">
                            <a href="/oplata-uslug">
                                <div>
                                    <h4><?= Yii::t('top_info_block','payment_code') ?></h4>
                                    <p> <?= $user_data['pin'] ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-4">
                            <a href="/cabinet#finance">
                                <div>
                                    <h4><?= Yii::t('top_info_block','services') ?></h4>
                                    <?php if (count($user_data['services']) <= 2):
                                        foreach ($user_data['services'] as $k => $v):
                                            ?>
                                            <p><?= $v ?></p>
                                            <?php
                                        endforeach;
                                    else:?>
                                        <p><?=$user_data['services'][0]?></p>
                                        <p><?= Yii::t('top_info_block','other_services') ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-5">
                            <a href="/cabinet#finance">
                                <div>
                                    <h4><?= Yii::t('top_info_block','active') ?></h4>
                                    <?php if (count($user_data['services_date']) <= 2):
                                        foreach ($user_data['services_date'] as $k => $v):
                                            ?>
                                            <p><?= $v ?></p>
                                            <?php
                                        endforeach;
                                    else:?>
                                        <p><?=$user_data['services_date'][0]?></p>
                                    <?php endif; ?>

                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 account-data-block-6">
                            <a href="/cabinet#network">
                                <div>
                                    <h4><?= Yii::t('top_info_block','ip') ?></h4>
                                    <p> <?= isset($user_data['ip_1']) ? $user_data['ip_1'] : $user_data['ip_real_constant'] ?></p>
                                    <p><?= $user_data['ip_2'] ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 ">
                    <?= $content; ?>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 sitebar-right">

                    <?php

                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'items' => [

                            ['label' => Yii::t('sidebar_menu','total_data'), 'url' => ['/cabinet'], 'active' => (Yii::$app->request->url == "/$lang/cabinet" || Yii::$app->request->url == "/cabinet")],
                            ['label' => Yii::t('sidebar_menu','account_manager'), 'url' => ['/upravlenie-kabinetom'], 'active' => (Yii::$app->request->url == "/$lang/upravlenie-kabinetom" || Yii::$app->request->url == "/upravlenie-kabinetom")],
                            ['label' => Yii::t('sidebar_menu','payment'), 'url' => ['/oplata-uslug'], 'active' => (Yii::$app->request->url == "/$lang/oplata-uslug" || Yii::$app->request->url == "/oplata-uslug")],
                            ['label' => Yii::t('sidebar_menu','payment_history'), 'url' => ['/istoriya-platezhey'], 'active' => (Yii::$app->request->url == "/$lang/istoriya-platezhey" || Yii::$app->request->url == "/istoriya-platezhey")],
                            ['label' => Yii::t('sidebar_menu','technical_support'), 'url' => ['/tehnicheskaya-podderzhka'], 'active' => (Yii::$app->request->url == "/$lang/tehnicheskaya-podderzhka" || Yii::$app->request->url == "/tehnicheskaya-podderzhka")],
                            ['label' => Yii::t('sidebar_menu','support_history'), 'url' => ['/istoriya-obrascheniy'], 'active' => (Yii::$app->request->url == "/$lang/istoriya-obrascheniy" || Yii::$app->request->url == "/$lang/istoriya-obrascheniy/*" || Yii::$app->request->url == "/istoriya-obrascheniy" || Yii::$app->request->url == "/istoriya-obrascheniy/*")],
                            ['label' => Yii::t('sidebar_menu','feedback'), 'url' => ['/ostavit-otzyiv'], 'active' => (Yii::$app->request->url == "/$lang/ostavit-otzyiv" || Yii::$app->request->url == "/ostavit-otzyiv")],
                            ['label' => Yii::t('sidebar_menu','tv'), 'url' => ['/televidenie'], 'active' => (Yii::$app->request->url == "/$lang/televidenie" || Yii::$app->request->url == "/televidenie")],
                            ['label' => Yii::t('sidebar_menu','news_arhiv'), 'url' => ['/arhiv-novostei'], 'active' => (Yii::$app->request->url == "/$lang/arhiv-novostei" || Yii::$app->request->url == "/arhiv-novastei")],
                        ],
                    ]);

                    ?>

                </div>
            </div>

        <?php else:
            echo $content;
        endif;
        ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('site',$sites_data['company_name']['lang_key']);    ?> <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
