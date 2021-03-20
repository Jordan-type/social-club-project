<?php

namespace common\models;


use yii\db\ActiveRecord;

class PostProtected extends ActiveRecord
{
    public static function tableName()
    {
        return "post_protected";
    }
}