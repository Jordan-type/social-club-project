<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/10/2015
 * Time: 2:57 PM
 */

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