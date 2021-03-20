<?php

namespace frontend\controllers;

use common\models\Relationship;
use common\models\RelationshipNotification;
use common\models\User;
use Yii;
use yii\web\Controller;

class RelationshipController extends Controller
{
    public function actionSendFriendRequestAsFellow()
    {
        if (isset($_POST['user_id_1']) && isset($_POST['user_id_2']) && isset($_POST['create_at'])) {
            // Notification
            $notify = new RelationshipNotification();
            $notify['action_id'] = $_POST['user_id_1'];
            $notify['receive_id'] = $_POST['user_id_2'];

            $user_id_1 = $_POST['user_id_1'];
            $user_id_2 = $_POST['user_id_2'];
            // Relationship
            $rel = new Relationship();
            $rel['user_id_action'] = $user_id_1;
            if ($user_id_1 > $user_id_2) {
                $tg = $user_id_1;
                $user_id_1 = $user_id_2;
                $user_id_2 = $tg;
                $rel['with_user_2_is'] = 1;
            } else {
                $rel['with_user_1_is'] = 1;
            }
            $rel['user_id_1'] = $user_id_1;
            $rel['user_id_2'] = $user_id_2;
            $rel['status'] = 0;
            $rel['create_at'] = $_POST['create_at'];
            $rel->save();

            $notify['type'] = 1;
            $notify['status'] = 0;
            $notify['create_at'] = $_POST['create_at'];
            $notify->save();

            echo '<a id="add_friend_btn" class="btn btn-primary btn-block disabled"><b>Sent request</b></a>';
        } else {
            echo 'NO';
        }
    }

    public function actionSendFriendRequestAsFamily()
    {
        if (isset($_POST['user_id_1']) && isset($_POST['user_id_2']) && isset($_POST['create_at'])) {
            // Notification
            $notify = new RelationshipNotification();
            $notify['action_id'] = $_POST['user_id_1'];
            $notify['receive_id'] = $_POST['user_id_2'];

            $user_id_1 = $_POST['user_id_1'];
            $user_id_2 = $_POST['user_id_2'];

            $rel = new Relationship();
            $rel['user_id_action'] = $user_id_1;
            if ($user_id_1 > $user_id_2) {
                $tg = $user_id_1;
                $user_id_1 = $user_id_2;
                $user_id_2 = $tg;
                $rel['with_user_2_is'] = 2;
            } else {
                $rel['with_user_1_is'] = 2;
            }
            $rel['user_id_1'] = $user_id_1;
            $rel['user_id_2'] = $user_id_2;
            $rel['status'] = 0;
            $rel['create_at'] = $_POST['create_at'];
            $rel->save();

            $notify['type'] = 1;
            $notify['status'] = 0;
            $notify['create_at'] = $_POST['create_at'];
            $notify->save();

            echo '<a id="add_friend_btn" class="btn btn-primary btn-block disabled"><b>Sent request</b></a>';
        } else {
            echo 'NO';
        }
    }

    public function actionAcceptFriendRequestAsFellow()
    {
        if (isset($_POST['user_id_1']) && isset($_POST['user_id_2']) && isset($_POST['update_at'])) {
            // Notification
            $notify = new RelationshipNotification();
            $notify['action_id'] = $_POST['user_id_1'];
            $notify['receive_id'] = $_POST['user_id_2'];

            $user_id_1 = $_POST['user_id_1'];
            $user_id_2 = $_POST['user_id_2'];
            $user_id_action = $user_id_1;

            if ($user_id_1 > $user_id_2) {
                $tg = $user_id_1;
                $user_id_1 = $user_id_2;
                $user_id_2 = $tg;
            }
            $rel = Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2, 'status' => 0]);
            $rel['status'] = 1;
            $rel['update_at'] = $_POST['update_at'];
            $rel['user_id_action'] = $user_id_action;
            if ($user_id_action == $user_id_1) {
                $rel['with_user_1_is'] = 1;
            } else {
                $rel['with_user_2_is'] = 1;
            }
            $rel->save();

            $notify['type'] = 2;
            $notify['status'] = 0;
            $notify['create_at'] = $_POST['update_at'];
            $notify->save();

            echo 'YES';
        } else {
            echo 'NO';
        }
    }

    public function actionAcceptFriendRequestAsFamily()
    {
        if (isset($_POST['user_id_1']) && isset($_POST['user_id_2']) && isset($_POST['update_at'])) {
            // Notification
            $notify = new RelationshipNotification();
            $notify['action_id'] = $_POST['user_id_1'];
            $notify['receive_id'] = $_POST['user_id_2'];

            $user_id_1 = $_POST['user_id_1'];
            $user_id_2 = $_POST['user_id_2'];
            $user_id_action = $user_id_1;

            if ($user_id_1 > $user_id_2) {
                $tg = $user_id_1;
                $user_id_1 = $user_id_2;
                $user_id_2 = $tg;
            }
            $rel = Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2, 'status' => 0]);
            $rel['status'] = 1;
            $rel['update_at'] = $_POST['update_at'];
            $rel['user_id_action'] = $user_id_action;
            if ($user_id_action == $user_id_1) {
                $rel['with_user_1_is'] = 2;
            } else {
                $rel['with_user_2_is'] = 2;
            }
            $rel->save();

            $notify['type'] = 2;
            $notify['status'] = 0;
            $notify['create_at'] = $_POST['update_at'];
            $notify->save();

            echo 'YES';
        } else {
            echo 'NO';
        }
    }

    public function actionShowListFriend($friend_type)
    {
        $user_id = Yii::$app->user->getId();

        $sql = 'SELECT * FROM relationship WHERE ((user_id_1=:user_id AND with_user_1_is=:friend_type)
                  OR (user_id_2=:user_id AND with_user_2_is=:friend_type)) AND status=1';
        $arrRelationship = Relationship::findBySql($sql, [':user_id' => $user_id, ':friend_type' => $friend_type])->asArray()->all();

        $model = array();
        foreach ($arrRelationship as $relationship) {
            if ($relationship['user_id_1'] == $user_id) {
                array_push($model, User::findOne(['id' => $relationship['user_id_2']]));
            } else {
                array_push($model, User::findOne(['id' => $relationship['user_id_1']]));
            }
        }

        return $this->render('show-friend', ['model' => $model]);
    }
}