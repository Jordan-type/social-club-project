<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/13/2015
 * Time: 10:03 PM
 */
$this->title = 'Search for users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="show-friend">
    <div class="row">
        <div class="col-lg-3">
            <?php
            $i = 0;
            foreach ($model as $item) {
                if ($i % 4 == 0) {
                    echo $this->render('search-user-item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>

        <div class="col-lg-3">
            <?php
            $i = 0;
            foreach ($model as $item) {
                if ($i % 4 == 1) {
                    echo $this->render('search-user-item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            $i = 0;
            foreach ($model as $item) {
                if ($i % 4 == 2) {
                    echo $this->render('search-user-item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            $i = 0;
            foreach ($model as $item) {
                if ($i % 4 == 3) {
                    echo $this->render('search-user-item', ['model' => $item]);
                }
                $i ++;
            }
            ?>
        </div>
    </div>
</div>
