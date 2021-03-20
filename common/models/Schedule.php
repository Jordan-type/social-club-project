<?php

namespace common\models;


use yii\db\ActiveRecord;

class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return "schedule";
    }
}