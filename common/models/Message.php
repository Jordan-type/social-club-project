<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/12/2015
 * Time: 5:27 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return "message";
    }
}