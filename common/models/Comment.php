<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/3/2015
 * Time: 11:30 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return "comment";
    }
}