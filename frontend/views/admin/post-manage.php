<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 12/16/2015
 * Time: 5:04 PM
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$dataProvider = new ActiveDataProvider([
    'query' => \common\models\Post::find(),
    'pagination' => [
        'pageSize' => 4,
    ],
]);
echo Html::beginForm(['admin/delete-post'],'post');
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'content',
        'user_id',
        'create_at',
        ['class' => 'yii\grid\CheckboxColumn'],
    ],
]);
echo Html::submitButton('Delete selected Post', ['class' => 'btn btn-success']);
echo Html::endForm();