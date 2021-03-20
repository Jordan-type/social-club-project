<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\ProfileForm;
use yii\web\Controller;

class UserController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionFindUsername()
    {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
        } else {
            $username = "";
        }

        $model = User::find()->where(['username' => $username])->asArray()->all();

        return $this->render('search-user', ['model' => $model]);
    }

    public function actionEditUserProfile()
    {
        $user = User::findOne(['id' => \Yii::$app->user->getId()]);
        $model = ProfileForm::cacheCurrentProfile($user);

        if ($model->load(\Yii::$app->request->post())) {
            $model->updateProfile($user);
        }

        return $this->render('user-profile', ['model' => $model]);
    }

    public function actionShowUserProfile($id)
    {
        $user = User::findOne(['id' => $id]);
        $model = ProfileForm::cacheCurrentProfile($user);

        return $this->render('user-profile', ['model' => $model]);
    }

    public function actionShowFriendTimeline($id)
    {
        $model = User::findOne(['id' => $id]);
        return $this->render('friend-timeline', ['model' => $model]);
    }
}