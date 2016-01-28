<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="description" content="Свадебный салон, свадебный салон в Борисове, свадебные платья, свадебные платья в Борисове, свадебные платья 2016, свадебные аксессуары. Вечерние платья, детские платья, прокат платьев в Борисове" />
    <meta name="keywords" content="Свадебный салон &quot;Красотка&quot; в Борисове. Широкий выбор свадебных платьев, вечерних платьев, детских платьев и аксессуаров напрокат. В наличие всегда свежие и актуальные модели. Хотите найти лучший свадебный салон Борисова? Самые роскошные и достойные платья" />
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="3 month">
    <title>Свадебный салон "Красотка" в Борисове. Прокат свадебных платьев</title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@rootDir') ?>/favicon.ico" />
    <!-- свадебные платья Борисов -->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="background-color: #FFEFD5;">
    <?php
    NavBar::begin([
        'brandLabel' => 'Свадебный салон "Красотка"',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'ГЛАВНАЯ', 'url' => ['/site/index']],
            //['label' => 'О НАС', 'url' => ['/site/about']],
            ['label' => 'НАШИ КОНТАКТЫ', 'url' => ['/site/contact']],
            [
                'label' => Html::img('/img/vk.png', ['width' => '20px']),
                'url' => '//vk.com/krasotkame',
                'linkOptions' => ['target' => '_blank'],
                'encode' => false,
            ]
            /*Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],*/
        ],
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
        <p class="pull-left">&copy; Свадебный салон "Красотка" <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<?php if(YII_ENV_PROD): ?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-72852603-1', 'auto');
    ga('send', 'pageview');

</script>
<?php endif; ?>
</html>
<?php $this->endPage() ?>
