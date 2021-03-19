<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->user->isGuest) {
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );

} else {
    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        frontend\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <?php
    $user = \common\models\User::findOne(['id' => Yii::$app->user->getId()]);
    if ($user['themeId'] == 1) {
        echo '<body class="skin-green sidebar-mini">';
    } elseif ($user['themeId'] == 2) {
        echo '<body class="skin-purple sidebar-mini">';
    } elseif ($user['themeId'] == 3) {
        echo '<body class="skin-red sidebar-mini">';
    } elseif ($user['themeId'] == 4) {
        echo '<body class="skin-yellow sidebar-mini">';
    } else {
        echo '<body class="skin-blue sidebar-mini">';
    }
    ?>
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    <script src="<?=Yii::$app->request->baseUrl.'/js/basic.js'?>"></script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
