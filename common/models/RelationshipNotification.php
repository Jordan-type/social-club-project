<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/11/2015
 * Time: 12:18 AM
 */

namespace common\models;



use yii\db\ActiveRecord;

class RelationshipNotification extends ActiveRecord
{
    public static function tableName()
    {
        return "relationship_notification";
    }
}