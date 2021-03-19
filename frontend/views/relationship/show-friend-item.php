<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/13/2015
 * Time: 10:15 PM
 */
$postCount = \common\models\Post::find()->where(['user_id' => $model['id']])->count();
$friendCount = \common\models\Relationship::find()->where(['user_id_1' => $model['id'], 'status' => 1])->count()
    + \common\models\Relationship::find()->where(['user_id_2' => $model['id'], 'status' => 1])->count();
?>

<a href="?r=user/show-friend-timeline&id=<?= $model['id'] ?>">
    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-aqua-active">
            <h3 class="widget-user-username"><?= $model['username'] ?></h3>
            <h5 class="widget-user-desc"><?= $model['job'] ?></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php
            if ($model['image'] != "") {
                echo Yii::$app->request->baseUrl ."/images/" .$model['image'];
            } else {
                echo Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
            }
            ?>" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="description-block">
                        <h5 class="description-header"><?= $postCount ?></h5>
                        <span class="description-text">Posts</span>
                    </div><!-- /.description-block -->
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <div class="description-block">
                        <h5 class="description-header"><?= $friendCount ?></h5>
                        <span class="description-text">Relationship</span>
                    </div><!-- /.description-block -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</a>
