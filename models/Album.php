<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "album".
 *
 * @property integer $id
 * @property integer $album_id
 * @property string $title
 * @property string $description
 * @property integer $vk_created
 * @property integer $vk_updated
 * @property integer $created_at
 * @property integer $updated_at
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'vk_created', 'vk_updated', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255]
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
            'title' => 'Title',
            'description' => 'Description',
            'vk_created' => 'Vk Created',
            'vk_updated' => 'Vk Updated',
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

    public function getPhotos()
    {
        return $this->hasMany(Photos::className(), ['album_id' => 'album_id']);
    }
}
