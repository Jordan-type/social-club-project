<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 12/16/2015
 * Time: 5:02 PM
 */

namespace frontend\controllers;


use common\models\Comment;
use common\models\Like;
use common\models\Message;
use common\models\Post;
use common\models\PostNotification;
use common\models\PostProtected;
use common\models\PostTag;
use common\models\Relationship;
use common\models\RelationshipNotification;
use common\models\Schedule;
use common\models\ScheduleNotification;
use common\models\User;
use Yii;
use yii\web\Controller;

class AdminController extends Controller
{
    public function actionUserManage()
    {
        return $this->render('user-manage');
    }

    public function actionPostManage()
    {
        return $this->render('post-manage');
    }

    public function actionDeleteUser()
    {
        $selection= (array) Yii::$app->request->post('selection');

        foreach ($selection as $id) {
            if ($id != Yii::$app->params['adminId']) {
                User::deleteAll(['id' => $id]);
                Post::deleteAll(['user_id' => $id]);
                PostNotification::deleteAll(['action_id' => $id]);
                PostNotification::deleteAll(['receiver_id' => $id]);
                Comment::deleteAll(['user_id' => $id]);
                Like::deleteAll(['user_id' => $id]);
                Message::deleteAll(['sender_id' => $id]);
                Message::deleteAll(['receiver_id' => $id]);
                Relationship::deleteAll(['user_id_1' => $id]);
                Relationship::deleteAll(['user_id_2' => $id]);
                RelationshipNotification::deleteAll(['action_id' => $id]);
                RelationshipNotification::deleteAll(['receive_id' => $id]);
                Schedule::deleteAll(['own_id' => $id]);
                ScheduleNotification::deleteAll(['action_id' => $id]);
                ScheduleNotification::deleteAll(['receiver_id' => $id]);
            }
        }

        return $this->render('user-manage');
    }

    public function actionDeletePost()
    {
        $selection= (array) Yii::$app->request->post('selection');

        foreach ($selection as $id) {
            Post::deleteAll(['id' => $id]);
            Like::deleteAll(['post_id' => $id]);
            Comment::deleteAll(['post_id' => $id]);
            PostTag::deleteAll(['post_id' => $id]);
            PostNotification::deleteAll(['post_id' => $id]);
            PostProtected::deleteAll(['post_id' => $id]);
        }

        return $this->render('post-manage');
    }
}