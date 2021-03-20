<?php

namespace common\models;


use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return "message";
    }
}