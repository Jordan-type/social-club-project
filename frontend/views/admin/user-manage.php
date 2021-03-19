<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 12/16/2015
 * Time: 5:03 PM
 */

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$dataProvider = new ActiveDataProvider([
    'query' => User::find(),
    'pagination' => [
        'pageSize' => 5,
    ],
]);

echo Html::beginForm(['admin/delete-user'],'post');
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'username',
        'email',
        'fullname',
        'created_at',
        'updated_at',
        ['class' => 'yii\grid\CheckboxColumn'],
    ],
]);
echo Html::submitButton('Delete selected User', ['class' => 'btn btn-success',]);
echo Html::endForm();
