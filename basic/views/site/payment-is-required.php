<?php
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

$lang_arr = explode('-', Yii::$app->language);
$lang = $lang_arr[0];

$url = Yii::$app->request->url;
$url_cl = explode('?', $url);
$url_array = explode('/', $url_cl[0]);


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
foreach (Yii::$app->params['domains'] as $k => $v) {
    if (strpos(Url::base(true), $v) !== false) {
        $styles = $k;
    }
}

$alfa_style = $user_data ? $user_data['skin'] : Yii::$app->params['alfa-styles-default'] ;


$server_name = Yii::$app->params['server_name'];
$styles = Yii::$app->params['domains'][$server_name];

global $sites_data;
switch ($styles) {
    case 'alfa':
        switch ($alfa_style) { //get_skin(Yii::$app->user->identity->username)
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
                switch (Yii::$app->params['alfa-styles-default']) {
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


//echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_2.php');

$logo_no_internet_patch = $sites_data['logo_no_internet'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon"
          href="<?php echo Yii::$app->request->baseUrl; ?>/<?= Yii::$app->params['sites_data'][$styles]['ico'] ?>"
          type="image/x-icon"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">
        <div class="site-about" >
            <div class="logo-centre" >
                <img src="<?= $logo_no_internet_patch ?>" alt="logo">
            </div>
            <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-8 text-center" >
                <div class="alert alert-danger">
                    <p><?= Yii::t('payment-is-required', 'internet_stop')?></p>
                </div>
                <div class="alert alert-info" >
                    <div class="icon_info">
                        <i class="fa fa-info-circle fa-3x" aria-hidden="true"></i>
                    </div>
                    <p><?= Yii::t('payment-is-required', 'message')?></p>
                </div>
                <div class=" btn  btn-custom btn-lg " >
                    <a href="/<?= $lang ?>/oplata-uslug"><?= Yii::t('payment-is-required', 'pay')?></a>
                </div>
                <div class="btn  btn-custom btn-lg" >
                    <a href="/<?= $lang ?>/oplata-uslug#credit"><?= Yii::t('payment-is-required', 'credit')?></a>
                </div>
            </div>


        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('site', $sites_data['company_name']['lang_key']); ?> <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
