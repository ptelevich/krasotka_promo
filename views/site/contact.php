<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="site-contact">
    <div style="font-size: 18px; margin-bottom: 20px;">
        Наша страничка <?= Html::a(Html::img('/img/vkontakte.png', ['width' => '150px']), '//vk.com/krasotkame', ['target' => '_blank']) ?>
    </div>
    <img src="/img/contacts.jpg" />
</div>
