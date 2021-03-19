<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/12/2015
 * Time: 4:16 PM
 */

namespace frontend\controllers;


use common\models\Message;
use frontend\models\MessageCreateForm;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;

class MessageController extends Controller
{
    public function actionShowInbox()
    {
        Message::updateAll(['is_notified' => 1], 'is_notified=0 AND receiver_id=' .\Yii::$app->user->getId());

        $query = Message::find()->where(['receiver_id' => \Yii::$app->user->getId()])->orderBy('status');

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);

        $listMsg = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('inbox', [
            'model' => $listMsg,
            'pagination' => $pagination,
        ]);
    }

    public function actionShowOutbox()
    {
        $query = Message::find()->where(['sender_id' => \Yii::$app->user->getId()])->orderBy('status');

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);

        $listMsg = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('outbox', [
            'model' => $listMsg,
            'pagination' => $pagination,
        ]);
    }

    public function actionShowDrafts()
    {
        $query = Message::find()->where(['sender_id' => \Yii::$app->user->getId(), 'status' => -1]);

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);

        $listMsg = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('drafts', [
            'model' => $listMsg,
            'pagination' => $pagination,
        ]);
    }

    public function actionCompose()
    {
        $model = new MessageCreateForm();
        $model->create_at = date('Y-m-d h:i');
        $model->sender_id = \Yii::$app->user->getId();
        $model->status = 0;

        if ($model->load(\Yii::$app->request->post())) {
            $model->addMessage();
            $this->redirect(Url::to(['/message/show-outbox']));
        }

        return $this->render('compose', ['model' => $model]);
    }

    public function actionComposeWithAUser($user_id)
    {
        $model = new MessageCreateForm();
        $model->create_at = date('Y-m-d h:i');
        $model->sender_id = \Yii::$app->user->getId();
        $model->status = 0;
        $model->receiver[0] = $user_id;

        if ($model->load(\Yii::$app->request->post())) {
            $model->addMessage();
            $this->redirect(Url::to(['/message/show-outbox']));
        }

        return $this->render('compose', ['model' => $model]);
    }

    public function actionRecompose($id)
    {
        $message = Message::findOne(['id' => $id]);

        $model = new MessageCreateForm();
        $model->cacheDraftsMessage($message);
        $model->create_at = date('Y-m-d h:i');
        $model->sender_id = \Yii::$app->user->getId();
        $model->status = 0;

        if ($model->load(\Yii::$app->request->post())) {
            $model->addMessage();
            Message::deleteAll(['id' => $id]);
            $this->redirect(Url::to(['/message/show-outbox']));
        }

        return $this->render('compose', ['model' => $model]);
    }

    public function actionRead($id)
    {
        $model = Message::findOne(['id' => $id]);
        $model['status'] = 1;
        $model->save();

        return $this->render('read', ['model' => $model]);
    }

    public function actionSaveMessage()
    {

    }
}