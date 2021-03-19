<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/30/2015
 * Time: 10:56 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return "schedule";
    }
}