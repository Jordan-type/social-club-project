<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/11/2015
 * Time: 2:39 PM
 */

use yii\widgets\LinkPager;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-show">
    <?php
    if (sizeof($model) == 0) {
        echo '<div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i>&nbsp;&nbsp;No posts yet:</h4>
            Please select the button in the bottom right corner to write your first post! :D
        </div>
    </div>';
    }
    ?>

    <div class="row">
        <div class="col-lg-1">

        </div>

        <div class="col-lg-5">

            <?php
            $i = 0;
            foreach($model as $item) {
                if ($i % 2 == 0) {
                    echo $this->render('item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>

        <div class="col-lg-5">
            <?php
            $i = 0;
            foreach($model as $item) {
                if ($i % 2 != 0) {
                    echo $this->render('item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>
    </div>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>

    <a class="btn btn-app" href="<?= \yii\helpers\Url::to(['/post/create']) ?>" style="position: fixed; bottom: 50px; right: 10px; border-color: #3c8dbc">
        <i class="fa fa-edit"></i> Reply
    </a>

</div>
