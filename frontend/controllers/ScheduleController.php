<?php

namespace frontend\controllers;


use common\models\Schedule;
use common\models\ScheduleNotification;
use common\models\User;
use yii\helpers\Url;
use frontend\models\EventCreateForm;
use yii\web\Controller;

class ScheduleController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionShow()
    {
        return $this->render('show');
    }

    public function actionCreateEvent()
    {
        $model = new EventCreateForm();
        $model->own_id = \Yii::$app->user->getId();
        $model->create_at = date('Y-m-d h:i');

        if ($model->load(\Yii::$app->request->post())) {
            if (!$model->validate()) {
                return $this->render('error');
            }
            if (sizeof($model->friend) > 0) {
                $title = $model->title .' (Member: ' .User::findOne(['id' => \Yii::$app->user->getId()])->username;
                foreach ($model->friend as $userId) {
                    $title = $title .', ' .User::findOne(['id' => $userId])->username;
                }
                $title = $title .')';
            } else {
                $title = $model->title;
            }
            $eventId = $model->addEvent($title);

            if (sizeof($model->friend) > 0) {
                foreach ($model->friend as $userId) {
                    $scheduleNotify = new ScheduleNotification();
                    $scheduleNotify['schedule_id'] = $eventId;
                    $scheduleNotify['receiver_id'] = $userId;
                    $scheduleNotify['action_id'] = \Yii::$app->user->getId();
                    $scheduleNotify['create_at'] = $model->create_at;
                    $scheduleNotify->save();
                }
            }
            $this->refresh();
        }
        return $this->render('show', ['model' => $model]);
    }

    public function actionShowReceivedSchedule($id)
    {
        $model = ScheduleNotification::findOne(['id' => $id]);

        return $this->render('show-received', ['model' => $model]);
    }

    public function actionAcceptReceivedSchedule($id)
    {
        $scheduleNotify = ScheduleNotification::findOne(['id' => $id]);

        $schedule = Schedule::findOne(['id' => $scheduleNotify['schedule_id']]);

        $newSchedule = new Schedule();
        $newSchedule['title'] = $schedule['title'];
        $newSchedule['color'] = $schedule['color'];
        $newSchedule['start'] = $schedule['start'];
        $newSchedule['end'] = $schedule['end'];
        $newSchedule['create_at'] = $schedule['create_at'];
        $newSchedule['own_id'] = \Yii::$app->user->getId();
        $newSchedule->save();

        ScheduleNotification::deleteAll(['id' => $id]);

        $this->redirect(Url::to(['schedule/create-event']));
    }

    public function actionDeclineReceivedSchedule($id)
    {
        ScheduleNotification::deleteAll(['id' => $id]);

        $this->redirect(Url::to(['schedule/create-event']));
    }
}