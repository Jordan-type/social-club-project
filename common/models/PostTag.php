<?php

namespace common\models;


use yii\db\ActiveRecord;

class PostTag extends ActiveRecord
{
    public static function tableName()
    {
        return "post_tag";
    }
}