<?php

namespace common\models;


use yii\db\ActiveRecord;

class ScheduleNotification extends ActiveRecord
{
    public static function tableName()
    {
        return "schedule_notification";
    }
}