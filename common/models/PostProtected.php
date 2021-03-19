<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/21/2015
 * Time: 6:23 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class PostProtected extends ActiveRecord
{
    public static function tableName()
    {
        return "post_protected";
    }
}