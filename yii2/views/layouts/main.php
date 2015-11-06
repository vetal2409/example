<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="screen"></div>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Frontend',
        'brandUrl' => Yii::$app->urlManagerFrontEnd->createUrl('site'),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
        'brandOptions' => [
            'target' => '_blank'
        ]
    ]);
    if (Yii::$app->user->role === 'moder') {
        $menuItems = [
            ['label' => 'Registrations', 'url' => ['/registration/index']],
            ['label' => 'Invoices', 'url' => ['/invoice/index']],
            ['label' => 'Hotels', 'url' => ['/hotel/index']],
            ['label' => 'Rooms', 'url' => ['/room/index']],
            ['label' => 'Departments', 'url' => ['/department/index']]
        ];
    } elseif (Yii::$app->user->role === 'manager') {
        $menuItems = [
            ['label' => 'Registrations', 'url' => ['/registration/index']],
            ['label' => 'Rooms', 'url' => ['/room/index']],
        ];
    } else {
        $menuItems = [
            //['label' => 'Frontend', 'url' => Yii::$app->urlManagerFrontEnd->createUrl('site/index')],
            ['label' => 'Registrations', 'url' => ['/registration/index']],
            ['label' => 'Invoices', 'url' => ['/invoice/index']],
            ['label' => 'Hotels', 'url' => ['/hotel/index']],
            ['label' => 'Rooms', 'url' => ['/room/index']],
            ['label' => 'Cities', 'url' => ['/city/index']],
            ['label' => 'Countries', 'url' => ['/country/index']],
            ['label' => 'Room Types', 'url' => ['/room-type/index']],
            ['label' => 'Languages', 'url' => ['/lang/index']],
            ['label' => 'Users', 'url' => ['/user/index']],
            ['label' => 'Departments', 'url' => ['/department/index']]
        ];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; CWT Meeting &amp; Events <?= date('Y') ?></p>

        <p class="pull-right"><? //= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
