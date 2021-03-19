<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/13/2015
 * Time: 4:26 PM
 */

namespace common\models;


use Yii;
use yii\db\ActiveRecord;

class Relationship extends ActiveRecord
{
    public static function tableName()
    {
        return "relationship";
    }

    public static function addPending($user_id_1, $user_id_2)
    {
        $relationship = new Relationship();

        $relationship['user_id_action'] = $user_id_1;
        if ($user_id_1 > $user_id_2) {
            $temp = $user_id_1;
            $user_id_1 = $user_id_2;
            $user_id_2 = $temp;
        }
        $relationship['user_id_1'] = $user_id_1;
        $relationship['user_id_2'] = $user_id_2;
        $relationship['status'] = 0;

        $relationship->save();
    }

    public static function updatePendingToAccepted($user_id_1, $user_id_2)
    {
        $user_id_action = $user_id_1;
        if ($user_id_1 > $user_id_2) {
            $temp = $user_id_1;
            $user_id_1 = $user_id_2;
            $user_id_2 = $temp;
        }
        $relationship = Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2]);

        $relationship['status'] = 1;
        $relationship['user_id_action'] = $user_id_action;
    }

    public static function updatePendingToDeclined($user_id_1, $user_id_2)
    {
        $user_id_action = $user_id_1;
        if ($user_id_1 > $user_id_2) {
            $temp = $user_id_1;
            $user_id_1 = $user_id_2;
            $user_id_2 = $temp;
        }
        $relationship = Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2]);

        $relationship['status'] = 2;
        $relationship['user_id_action'] = $user_id_action;
    }

    public static function updatePendingToBlocked($user_id_1, $user_id_2)
    {
        $user_id_action = $user_id_1;
        if ($user_id_1 > $user_id_2) {
            $temp = $user_id_1;
            $user_id_1 = $user_id_2;
            $user_id_2 = $temp;
        }
        $relationship = Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2]);

        $relationship['status'] = 3;
        $relationship['user_id_action'] = $user_id_action;
    }

    public static function isInRelationship($user_id_1, $user_id_2)
    {
        $sql = 'SELECT * FROM relationship WHERE ((user_id_1=:user_id_1 AND user_id_2=:user_id_2)
                  OR (user_id_1=:user_id_2 AND user_id_2=:user_id_1)) AND status=1';
        return Relationship::findBySql($sql, [':user_id_1' => $user_id_1, ':user_id_2' => $user_id_2])->count() > 0;
    }
}