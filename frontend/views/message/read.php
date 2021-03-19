<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/12/2015
 * Time: 4:28 PM
 */
use yii\helpers\Url;

$this->title = 'Message';
$this->params['breadcrumbs'][] = $this->title;
$newCount = \common\models\Message::find()->where(['receiver_id' => Yii::$app->user->getId(), 'status' => 0])->count();
?>

<div class="row">
    <div class="col-md-3">
        <a href="<?=Url::to (['message/compose']) ?>" class="btn btn-primary btn-block margin-bottom">Composer</a>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?=Url::to (['message/show-inbox'])  ?>"><i class="fa fa-inbox"></i> News received <span class="label label-primary pull-right"><?= $newCount ?></span></a></li>
                    <li><a href="<?=Url::to (['message/show-outbox']) ?>"><i class="fa fa-envelope-o"></i> News sent</a></li>
                    <li><a href="<?=Url::to (['message/show-drafts']) ?>"><i class="fa fa-file-text-o"></i> Draft news</a></li>
                </ul>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Read Mail</h3>

            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3><?= $model['subject'] ?></h3>
                    <h5>From: <?php
                        $user = \common\models\User::findOne(['id' => $model['sender_id']]);
                        if ($user['fullname'] != "") {
                            echo $user['username'].' ('.$user['fullname'].')';
                        } else {
                            echo $user['username'];
                        }
                        ?> <span class="mailbox-read-time pull-right"><?= $model['create_at'] ?></span></h5>
                    <h5>To: <?php
                        $user = \common\models\User::findOne(['id' => $model['receiver_id']]);
                        if ($user['fullname'] != "") {
                            echo $user['username'].' ('.$user['fullname'].')';
                        } else {
                            echo $user['username'];
                        }
                        ?></h5>
                </div><!-- /.mailbox-read-info -->

                <div class="mailbox-read-message">
                    <p>
                        <?= $model['content'] ?>
                    </p>
                </div><!-- /.mailbox-read-message -->
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer -->
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>
