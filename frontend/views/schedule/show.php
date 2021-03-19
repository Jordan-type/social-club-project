<?php
use common\models\Relationship;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

$this->title = 'Lịch làm việc';
$this->params['breadcrumbs'][] = $this->title;

$listE = \common\models\Schedule::find()->where(['own_id' => Yii::$app->user->getId()])->asArray()->all();
$events = array();

foreach ($listE as $item) {
    $event = new \yii2fullcalendar\models\Event();
    $event->id = $item['id'];
    $event->title = $item['title'];
    $event->start = date($item['start']);
    $event->end = date($item['end']);
    $event->color = $item['color'];
    $events[] = $event;
}

$sql = 'SELECT * FROM relationship WHERE ((user_id_1=:user_id)
                  OR (user_id_2=:user_id)) AND status=1';
$arrRelationship = Relationship::findBySql($sql, [':user_id' => Yii::$app->user->getId()])->asArray()->all();
$arrUserName = array();
foreach ($arrRelationship as $rel) {
    if ($rel['user_id_1'] == Yii::$app->user->getId()) {
        $arrUserName[$rel['user_id_2']] = \common\models\User::findOne(['id' => $rel['user_id_2']])->username;
    } else {
        $arrUserName[$rel['user_id_1']] = \common\models\User::findOne(['id' => $rel['user_id_1']])->username;
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Create an event</h3>
            </div>
            <div class="box-body">
                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                    <ul class="fc-color-picker" id="color-chooser">
                        <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                </div><!-- /btn-group -->
                <form action="?r=schedule/create-event" method="post">
                    <input id="event_color" name="EventCreateForm[color]" style="display: none" value="#00C0EF">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <label style="background-color: #00C0EF; border-color: #00C0EF;" id="add-new-event" class="btn btn-primary btn-flat">Tên:</label>
                        </div><!-- /btn-group -->
                        <input name="EventCreateForm[title]" id="new-event" class="form-control" type="text">
                    </div><!-- /input-group -->
                    <div class="input-group" style="margin-top: 10px">
                        <?=
                        DateTimePicker::widget([
                            'name' => 'EventCreateForm[start]',
                            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd hh:ii'
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="input-group" style="margin-top: 10px">
                        <?=
                        DateTimePicker::widget([
                            'name' => 'EventCreateForm[end]',
                            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd hh:ii'
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="input-group" style="margin-top: 10px;">
                        <?=
                        Select2::widget([
                            'name' => 'EventCreateForm[friend][]',
                            'data' => $arrUserName,
                            'options' => ['multiple' => true, 'placeholder' => 'With?'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="input-group">
                        <button class="schedule_btn btn bg-purple margin" type="submit">Add an event</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="schedule_fail alert alert-info alert-dismissable" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> Success</h4>
            You have successfully added the calendar!
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
                    'events'=> $events,
                )); ?>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
    </div>
</div>
