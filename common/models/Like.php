<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Like extends ActiveRecord
{
    public static function tableName()
    {
        return "like";
    }

    public static function addLike($post_id, $user_id)
    {
        $like = new Like();
        $like['user_id'] = $user_id;
        $like['post_id'] = $post_id;
        $like->save();
    }

    public static function isLiked($post_id, $user_id)
    {
        if (Like::find()->where(['post_id' => $post_id, 'user_id' => $user_id])->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}