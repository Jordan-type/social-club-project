<?php

use yii\helpers\Url;

$this->title = 'view details';
$this->params['breadcrumbs'][] = $this->title;

$listPost = \common\models\Post::find()->where(['user_id' => $model['id']])->asArray()->all();
$listTemp = $listPost;
foreach ($listTemp as $post) {
    $isCanRead = true;
    if ($post['permit'] == 1) {
        $isCanRead = false;
    } elseif ($post['permit'] == 2) {
        $isCanRead = \common\models\PostProtected::find()->where(['post_id' => $post['id'], 'user_id' =>
            Yii::$app->user->getId()])->count() > 0;
    } elseif ($post['permit'] == 3) {
        $isCanRead = \common\models\Relationship::isInRelationship($model['id'], Yii::$app->user->getId());
    }

    if (!$isCanRead) {
        if(($key = array_search($post, $listPost)) !== false) {
            unset($listPost[$key]);
        }
    }
}
$friendCount = \common\models\Relationship::find()->where(['user_id_1' => $model['id'], 'status' => 1])->count()
    + \common\models\Relationship::find()->where(['user_id_2' => $model['id'], 'status' => 1])->count();
?>

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div id="friend_timeline_profile" class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php
                if ($model['image'] != "") {
                    echo Yii::$app->request->baseUrl ."/images/" .$model['image'];
                } else {
                    echo Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
                }
                ?>" alt="User profile picture">
                <h3 class="profile-username text-center"><?= $model['fullname'] ?></h3>
                <p class="text-muted text-center"><?= $model['job'] ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Posts</b> <a class="pull-right"><?= sizeof($listPost) ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Relationship</b> <a class="pull-right"><?= $friendCount ?></a>
                    </li>
                </ul>
                <a href="<?= Url::to(['/message/compose-with-a-user', 'id' => $model['id']]) ?>" class="btn btn-block btn-warning btn-sm"><b>Send Message</b></a>
                
                <?php
                $user_id_1 = Yii::$app->user->getId();
                $user_id_2 = $model['id'];
                if ($user_id_1 > $user_id_2) {
                    $tg = $user_id_1;
                    $user_id_1 = $user_id_2;
                    $user_id_2 = $tg;
                }
                $isFriend = \common\models\Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2, 'status' => 1]) != null;
                $pendingRelationship = \common\models\Relationship::findOne(['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2, 'status' => 0]);
                $isFriendPending = $pendingRelationship != null;
                if (!$isFriend) {
                    if ($isFriendPending) {
                        if (Yii::$app->user->getId() != $pendingRelationship['user_id_action']) {
                            echo '<a id="accept_friend_btn" class="btn btn-block btn-success"><b>Accept requests</b></a>';
                        } else {
                            echo '<a class="btn btn-primary btn-block disabled"><b>Sent request</b></a>';
                        }
                    } else {
                        echo '<a id="add_friend_btn" class="btn btn-primary btn-block"><b>Add to relationship</b></a>';
                    }
                }
                ?>
                <div id="add_friend_group" class="row" style="margin-top: 10px; display: none">
                    <div class="col-lg-6">
                        <button id="user_id_1=<?= Yii::$app->user->getId() ?>&user_id_2=<?= $model['id'] ?>" class="add_friend_fellow btn btn-block btn-success">Friend</button>
                    </div>
                    <div class="col-lg-6">
                        <button id="user_id_1=<?= Yii::$app->user->getId() ?>&user_id_2=<?= $model['id'] ?>" class="add_friend_family btn btn-block btn-info">Relatives</button>
                    </div>
                </div>

                <div id="accept_friend_group" class="row" style="margin-top: 10px; display: none">
                    <div class="col-lg-6">
                        <button id="user_id_1=<?= Yii::$app->user->getId() ?>&user_id_2=<?= $model['id'] ?>" class="accept_friend_fellow btn btn-block btn-primary">Friend</button>
                    </div>
                    <div class="col-lg-6">
                        <button id="user_id_1=<?= Yii::$app->user->getId() ?>&user_id_2=<?= $model['id'] ?>" class="accept_friend_family btn btn-block btn-info">Relatives</button>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                <p class="text-muted">
                    <?= $model['education'] ?>
                </p>

                <hr>

                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                <p class="text-muted"><?= $model['location'] ?></p>

                <hr>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                <p>The life if a fight!</p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <?php
                        foreach ($listPost as $post) {
                            $cmtCount = \common\models\Comment::find()->where(['post_id' => $post['id']])->count();
                            if (strlen($post['content']) > 200) {
                                $postContent = substr($post['content'], 0, 200) ." ...";
                            } else {
                                $postContent = $post['content'];
                            }
                            if ($post['image'] != "") {
                                $image = Yii::$app->request->baseUrl ."/images/" .$post['image'];
                            } else {
                                $image =  Yii::$app->request->baseUrl ."/images/post-icon.png";
                            }
                            echo '<div class="post">'.
                        '<div class="user-block">'.
                            '<img class="img-circle img-bordered-sm" src="'.$image.'" alt="user image">'.
                        '<span class="username">'.
                          '<a href="?r=post/detail&id='.$post['id'].'">'. $post['title'] .'</a>'.
                          '<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>'.
                        '</span>'.
                            '<span class="description">'. $post['create_at'] .'</span>'.
                        '</div>'.
                        '<p>'.
                                $postContent.
                        '</p>'.
                        '<ul class="list-inline">'.
                            '<li class="pull-right"><a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments ('.$cmtCount.')</a></li>'.
                        '</ul>'.

                        '<input class="form-control input-sm" placeholder="Type a comment" type="text">'.
                    '</div>';
                        }
                    ?>

                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
</div>
