<?php

use yii\widgets\LinkPager;
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
                    <li><a href="<?=Url::to (['message/show-inbox']) ?>"><i class="fa fa-inbox"></i> News received <span class="label label-primary pull-right"><?= $newCount ?></span></a></li>
                    <li><a href="<?=Url::to (['message/show-outbox']) ?>"><i class="fa fa-envelope-o"></i> News sent</a></li>
                    <li class="active"><a href="<?=Url::to (['message/show-drafts']) ?>"><i class="fa fa-file-text-o"></i> Draft news</a></li>
                </ul>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">News box</h3>
                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input class="form-control input-sm" placeholder="Search Mail" type="text">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                        <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                        <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                        <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <?php
                        foreach ($model as $item) {
                            echo '<tr>
                            <td><div aria-disabled="false" aria-checked="false" style="position: relative;" class="icheckbox_flat-blue"><input style="position: absolute; opacity: 0;" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div></td>
                            <td class="mailbox-star"><a href=""><i class="fa fa-star-o text-yellow"></i></a></td>
                            <td class="mailbox-name"><a href="?r=message/recompose&id='.$item['id'].'">Tin nháp</a></td>
                            <td class="mailbox-subject"><b> '.$item['subject'].'</b> '.$item['content'].'</td>
                            <td class="mailbox-date">5 mins ago</td>
                            </tr>';
                        }
                        ?>
                        </tbody>
                    </table><!-- /.table -->
                </div><!-- /.mail-box-messages -->
            </div><!-- /.box-body -->
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <div class="pull-right">
                        <?= LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>
                </div>
            </div>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>