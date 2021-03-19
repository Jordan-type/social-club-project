<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 12/1/2015
 * Time: 10:00 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

class ScheduleNotification extends ActiveRecord
{
    public static function tableName()
    {
        return "schedule_notification";
    }
}