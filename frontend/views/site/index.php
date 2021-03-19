<?php


use yii\helpers\Url;

$this->title = "Posts of the day";
$this->params['breadcrumbs'][] = $this->title;

$listPost = \common\models\Post::find()->where(['create_at' => date('Y-m-d')])->asArray()->all();
?>

<ul class="timeline">

    <li class="time-label">
        <span class="bg-red">
            <?= date('Y-m-d') ?>
        </span>
    </li>

    <?php
    foreach ($listPost as $post) {
        $user = \common\models\User::findOne(['id' => $post['user_id']]);
        if (strlen($post['content']) > 200) {
            $content = substr($post['content'], 0, 200) ." ...";
        } else {
            $content = $post['content'];
        }

        echo '<li>
        <i class="fa fa-edit bg-red"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i>'.$post['create_at'].'</span>
            <h3 class="timeline-header"><a href="?r=user/show-friend-timeline&id='.$user['id'].'">'.$user['fullname'].'</a> has posted an article</h3>
            <div class="timeline-body">
                '.$content.'
            </div>
            <div class="timeline-footer">
                <a href="?r=post/detail&id='.$post['id'].'" class="btn btn-primary btn-flat btn-xs">See the article</a>
            </div>
        </div>
    </li>';
    }
    ?>

    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>
