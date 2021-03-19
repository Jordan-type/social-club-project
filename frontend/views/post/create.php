<?php

use common\models\Relationship;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Reply';
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

<div class="post-create-form">

    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Fill content to create a post</h3>
                </div>
                <div class="box-body">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])?>
                    <?= $form->field($model,'title')?>

                    <?= $form->field($model, 'thumbnail')->fileInput(['accept' => 'image/*', 'maxSize' => 10097152]) ?>

                    <div class="form-group">
                        <?php
                        echo '<label>Date</label>';
                        echo DatePicker::widget([
                            'name' => 'PostCreateForm[date]',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                    </div>


                    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                        'options' => ['rows' => 10],
                        'preset' => 'basic'
                    ]) ?>

                    <div class="form-group">
                        <label for="inputPermit">Permission</label>
                        <div class="row">
                            <div class="col-lg-2">
                                <select id="inputPermit" class="form-control" name="PostCreateForm[permit][]">
                                    <option value="1">private</option>
                                    <option value="2">protected 1</option>
                                    <option value="3">protected 2</option>
                                    <option value="4">public</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="postReader" style="display: none">
                        <?=
                        $form->field($model, 'reader[]')->widget(Select2::classname(), [
                            'data' => $arrUserName,
                            'language' => 'en',
                            'options' => ['multiple' => true, 'placeholder' => 'Who read?'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                    <div class="form-group" style="margin-top:30px">
                        <?= Html::submitButton('Create',['class' => 'btn btn-success'])?>
                    </div>
                    <?php ActiveForm::end() ?>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

</div>
