<?php

namespace common\models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    public static function tableName()
    {
        return "post";
    }

    public static function getPostById($id)
    {
        return Post::findOne(['id' => $id]);
    }
}