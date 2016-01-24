<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "photos".
 *
 * @property integer $id
 * @property integer $album_id
 * @property integer $photo_id
 * @property string $vk_photo
 * @property string $photo_name
 * @property string $text
 * @property integer $vk_created
 * @property integer $created_at
 * @property integer $updated_at
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'photo_id', 'vk_photo', 'photo_name', 'text', 'vk_created', 'created_at', 'updated_at'], 'required'],
            [['id', 'album_id', 'photo_id', 'vk_created', 'created_at', 'updated_at'], 'integer'],
            [['vk_photo', 'photo_name', 'text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'photo_id' => 'Photo ID',
            'vk_photo' => 'Vk Photo',
            'photo_name' => 'Photo Name',
            'text' => 'Text',
            'vk_created' => 'Vk Created',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            'behaviorTimestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
}
