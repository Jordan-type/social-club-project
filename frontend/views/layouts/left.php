<?php
use yii\helpers\Url;


$model = \common\models\User::findOne(['id' => Yii::$app->user->getId()]);

$isAdmin = $model['is_admin'] == 1;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php
                if ($model['image'] != "") {
                    echo Yii::$app->request->baseUrl ."/images/" .$model['image'];
                } else {
                    echo Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
                }
                ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?=Url::to (['user/find-username']) ?>" method="post" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="username" class="form-control" placeholder="Search ..."/>
              <span class="input-group-btn">
                <button type="submit"  id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Table of options', 'options' => ['class' => 'header']],
                    ['label' => 'Posts', 'icon' => 'edit', 'url' => ['post/show-all'], 'active' => '0'],
                    [
                        'label' => 'Relationship',
                        'icon' => 'group',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Friend', 'icon' => 'circle-o', 'url' => '?r=relationship/show-list-friend&friend_type=1',],
                            ['label' => 'Relatives', 'icon' => 'circle-o', 'url' => '?r=relationship/show-list-friend&friend_type=2',],
                        ],
                    ],
                    // ['label' => 'Calendar', 'icon' => 'fa fa-calendar', 'url' => ['/schedule/show']],
                    ['label' => 'Message', 'icon' => 'envelope', 'url' => ['message/show-inbox']],
                    [
                        'label' => 'Administrators',
                        'icon' => 'cogs',
                        'url' => '#',
                        'visible' => $isAdmin,
                        'items' => [
                            ['label' => 'user management', 'icon' => 'user', 'url' => ['admin/user-manage']],
                            ['label' => 'Managing articles', 'icon' => 'edit', 'url' => ['admin/post-manage']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
