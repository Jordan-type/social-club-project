<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 12/1/2015
 * Time: 10:15 PM
 */
$schedule = \common\models\Schedule::findOne(['id' => $model['schedule_id']]);
$actionUser = \common\models\User::findOne(['id' => $model['action_id']]);
?>
<div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php if ($actionUser['fullname'] != '') {
                        echo $actionUser['fullname'];
                    } else {
                        echo $actionUser['username'];
                    } ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <p>
                    <?= $schedule['title'] ?>
                </p>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="?r=schedule/decline-received-schedule&id=<?= $model['id'] ?>" class="btn btn-default">Skip</a>
                <a href="?r=schedule/accept-received-schedule&id=<?= $model['id'] ?>" class="btn btn-info pull-right">Add to calendar</a>
            </div><!-- /.box-footer -->
        </div>
    </div>
</div>
