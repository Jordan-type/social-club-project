<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/11/2015
 * Time: 1:48 AM
 */

namespace frontend\controllers;


use common\models\Message;
use common\models\PostNotification;
use common\models\RelationshipNotification;
use yii\web\Controller;

class NotificationController extends Controller
{
    public function actionMakeOldRelationshipNotification()
    {
        RelationshipNotification::updateAll(['status' => 1], 'status=0 AND receive_id=' .\Yii::$app->user->getId());
    }

    public function actionMakeOldMessageNotification()
    {
        Message::updateAll(['is_notified' => 1], 'is_notified=0 AND receiver_id=' .\Yii::$app->user->getId());
    }

    public function actionMakeOldPostNotification()
    {
        PostNotification::updateAll(['status' => 1], 'status=0 AND receiver_id=' .\Yii::$app->user->getId());
    }
}