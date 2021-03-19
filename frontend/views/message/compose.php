<?php

use common\models\Relationship;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Texting';
$this->params['breadcrumbs'][] = $this->title;

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
        <a href="<?=Url::to (['message/show-inbox']) ?>" class="btn btn-primary btn-block margin-bottom">Back to the inbox</a>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?=Url::to (['message/show-inbox']) ?>"><i class="fa fa-inbox"></i> News received <span class="label label-primary pull-right">12</span></a></li>
                    <li><a href="<?=Url::to (['message/show-outbox']) ?>"><i class="fa fa-envelope-o"></i> News sent</a></li>
                    <li><a href="<?=Url::to (['message/show-drafts']) ?>"><i class="fa fa-file-text-o"></i> Draft news</a></li>
                </ul>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
    </div><!-- /.col -->
    <div class="col-md-9">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Compose a new message</h3>
            </div><!-- /.box-header -->

            <?php $form = ActiveForm::begin()?>
            <div class="box-body">
                <?php
                if (is_array($model['receiver']) && sizeof($model['receiver']) <= 0) {
                    echo $form->field($model, 'receiver[]')->widget(Select2::classname(), [
                        'data' => $arrUserName,
                        'language' => 'en',
                        'options' => ['multiple' => true, 'placeholder' => 'To ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }
                ?>

                <?= $form->field($model,'subject')?>

                <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                    'options' => ['rows' => 10],
                    'preset' => 'basic'
                ]) ?>
            </div>

            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i>  To Send</button>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>
