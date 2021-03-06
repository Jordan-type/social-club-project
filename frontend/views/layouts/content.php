<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2021 <a href="">Jordan Muthemba</a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <h2 class="control-sidebar-heading">&nbsp; Choose the right color for theme</h2>

    <a href="?r=site/change-theme-color&id=1" class="btn btn-block btn-success btn-lg">Green</a>

    <a href="?r=site/change-theme-color&id=2" class="btn btn-block btn-info btn-lg" style="background-color: #605CA8; border-color: #605CA8">Purple</a>

    <a href="?r=site/change-theme-color&id=3" class="btn btn-block btn-danger btn-lg">Red</a>

    <a href="?r=site/change-theme-color&id=4" class="btn btn-block btn-warning btn-lg">Yellow</a>

    <a href="?r=site/change-theme-color&id=0" class="btn btn-block btn-primary btn-lg">Blue</a>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>