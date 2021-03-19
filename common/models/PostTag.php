<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/4/2015
 * Time: 6:11 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class PostTag extends ActiveRecord
{
    public static function tableName()
    {
        return "post_tag";
    }
}