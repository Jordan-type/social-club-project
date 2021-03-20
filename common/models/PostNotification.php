<?php

namespace common\models;


use yii\db\ActiveRecord;

class PostNotification extends ActiveRecord
{
    public static function tableName()
    {
        return "post_notification";
    }
}