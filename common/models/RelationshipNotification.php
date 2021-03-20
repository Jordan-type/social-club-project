<?php


namespace common\models;



use yii\db\ActiveRecord;

class RelationshipNotification extends ActiveRecord
{
    public static function tableName()
    {
        return "relationship_notification";
    }
}