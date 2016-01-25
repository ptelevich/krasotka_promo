<?php

Yii::setAlias('mediaDir', '/web/media/');
Yii::setAlias('rootDir', '/web/');

if(YII_ENV_DEV) {
    Yii::setAlias('mediaDir', '/media/');
    Yii::setAlias('rootDir', '/');
}
