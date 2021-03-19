<?php

$cmtCount = \common\models\Comment::find()->where(['post_id' => $model['id']])->count();
$likeCount = \common\models\Like::find()->where(['post_id' => $model['id']])->count();

$isLiked = \common\models\Like::findOne(['post_id' => $model['id'], 'user_id' => Yii::$app->user->getId()]) != null;
?>

<div class="box box-widget">
    <div class="box-header with-border">
        <div class="user-block">
            <img class="img-circle" src="<?php
            if ($model['image'] != "") {
                echo Yii::$app->request->baseUrl ."/images/" .$model['image'];
            } else {
                echo Yii::$app->request->baseUrl ."/images/new-post-alert.jpg";
            }
            ?>" alt="user image">
            <span class="username"><a href="?r=post/detail&id=<?= $model['id'] ?>"><?= $model['title'] ?></a></span>
            <span class="description"><?= $model['create_at'] ?></span>
        </div><!-- /.user-block -->
        <div class="box-tools">
            <a href="<?= Yii::$app->request->baseUrl ."?r=post/edit&id=" .$model['id'] ?>" class="btn btn-box-tool" data-widget="edit" title="Click to edit"><i class="fa fa-edit"></i></a>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <a class="del_post" id="<?= $model['id'] ?>"><button class="btn btn-box-tool" title="Click to delete"><i class="fa fa-times"></i></button></a>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <!-- post text -->
        <p><?php if (strlen($model['content']) > 200) {
                echo substr($model['content'], 0, 200) ." ...";
            } else {
                echo $model['content'];
            } ?></p>

        <!-- Social sharing buttons -->
        <?php
            if ($isLiked) {
                echo '<a class="unlike_post" id="' .$model['id'] .'"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-down"></i> Unlike</button></a>';
            } else {
                echo '<a class="like_post" id="' .$model['id'] .'"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button></a>';
            }
        ?>
        <span class="pull-right text-muted"><?= $likeCount ?> likes - <?= $cmtCount ?> comments</span>
    </div><!-- /.box-body -->


</div>