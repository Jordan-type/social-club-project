<?php

$this->title = 'Detail post';
$this->params['breadcrumbs'][] = $this->title;
$listCmt = \common\models\Comment::find()->where(['post_id' => $model['id']])->asArray()->all();
$likeCount = \common\models\Like::find()->where(['post_id' => $model['id']])->count();
$isLiked = \common\models\Like::findOne(['post_id' => $model['id'], 'user_id' => Yii::$app->user->getId()]) != null;
?>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <!-- Box Comment -->
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    <img class="img-circle" src="<?php
                    if ($model['image'] != "") {
                        echo Yii::$app->request->baseUrl ."/images/" .$model['image'];
                    } else {
                        echo Yii::$app->request->baseUrl ."/images/post-icon.png";
                    }
                    ?>" alt="user image">
                    <span class="title"><a href="#">&nbsp;&nbsp;&nbsp;<?= $model['title'] ?></a></span>
                    <span class="description"><?= $model['create_at'] ?></span>
                </div><!-- /.user-block -->
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read"><i class="fa fa-circle-o"></i></button>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- post text -->
                <p>
                    <?= $model['content'] ?>
                </p>

                <!-- Social sharing buttons -->
                <?php
                if ($isLiked) {
                    echo '<a class="unlike_post" id="' .$model['id'] .'"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-down"></i> Unlike</button></a>
                            <a class="like_post" id="' .$model['id'] .'" style="display:none;"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button></a>';
                } else {
                    echo '<a class="unlike_post" id="' .$model['id'] .'" style="display:none;"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-down"></i> Unlike</button></a>
                            <a class="like_post" id="' .$model['id'] .'"><button class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button></a>';
                }
                ?>
                <span class="pull-right text-muted"><?= $likeCount ?> likes - <?= sizeof($listCmt) ?> comments</span>
            </div><!-- /.box-body -->
            <div class="box-footer box-comments" id="box-comment">
                <?php
                foreach ($listCmt as $comment) {
                    $user = \common\models\User::findOne(['id' => $comment['user_id']]);
                    if ($user['image'] != "") {
                        $image = Yii::$app->request->baseUrl ."/images/" .$user['image'];
                    } else {
                        $image = Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
                    }
                    echo '<div class="box-comment">'.
                        '<img class="img-circle img-sm" src="'.$image.'" alt="user image">'.
                        '<div class="comment-text">'.
                        '<span class="username">'.
                        $user['username'].
                        '<span class="text-muted pull-right">'.$comment['create_at'].'</span>'.
                        '</span>'.
                        $comment['content'].
                        '</div>'.
                        '</div>';
                }
                ?>
            </div><!-- /.box-footer -->
            <div class="box-footer">

                    <img class="img-responsive img-circle img-sm" src="<?php
                    $cmtPerson = \common\models\User::findOne(['id' => Yii::$app->user->getId()]);
                    if ($cmtPerson['image'] != "") {
                        echo Yii::$app->request->baseUrl ."/images/" .$cmtPerson['image'];
                    } else {
                        echo Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
                    }
                    ?>" alt="alt text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <input id="user_id=<?= Yii::$app->user->getId() ?>&post_id=<?= $model['id'] ?>" type="text" class="post_comment form-control input-sm" placeholder="Press enter to post comment">
                    </div>

            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div >
</div>
