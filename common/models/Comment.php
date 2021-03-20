<?php

namespace common\models;


use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return "comment";
    }
}