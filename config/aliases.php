<?php

Yii::setAlias('mediaDir', '/web/media/');

if(YII_ENV_DEV) {
    Yii::setAlias('mediaDir', '/media/');
}
