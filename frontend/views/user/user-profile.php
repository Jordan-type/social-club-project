<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/21/2015
 * Time: 11:01 PM
 */
$this->title = 'Profile Page';
$this->params['breadcrumbs'][] = $this->title;
$user = \common\models\User::findOne(['id' => Yii::$app->user->getId()]);
?>

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <a href=""><img class="profile-user-img img-responsive img-circle" src="<?php
                    if ($user['image'] != "") {
                        echo Yii::$app->request->baseUrl ."/images/" .$user['image'];
                    } else {
                        echo Yii::$app->request->baseUrl ."/images/avatar-default.jpg";
                    }
                    ?>" alt="User profile picture"></a>
                <h3 class="profile-username text-center"><?= $model['fullname'] ?></h3>
                <p class="text-muted text-center"><?= $model['job'] ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Posts</b> <a class="pull-right">100</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="pull-right">100</a>
                    </li>
                </ul>
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
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="settings">

                    <a class="edit_profile_success" style="display: none">
                        <div class="callout callout-info">
                            <h4>Success!</h4>
                            <p>You have successfully updated your personal information!</p>
                        </div>
                    </a>

                    <form class="form-horizontal" action="<?= \yii\helpers\Url::to(['/user/edit-user-profile']) ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[fullname]" value="<?= $model['fullname'] ?>" type="text" class="form-control" id="inputName" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputFile" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-2">
                                <input name="ProfileForm[avatar]" type="file" id="inputFile" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputGender" class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="ProfileForm[gender][]" id="inputGender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[oldPassword]" type="password" class="form-control" id="inputName" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">New Password</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[newPassword]" type="password" class="form-control" id="inputName" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEducation" class="col-sm-2 control-label">Education</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[education]" value="<?= $model['education'] ?>" type="text" class="form-control" id="inputEducation" placeholder="Education">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputJob" class="col-sm-2 control-label">Work</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[job]" value="<?= $model['job'] ?>" type="text" class="form-control" id="inputJob" placeholder="Job">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLocation" class="col-sm-2 control-label">Location</label>
                            <div class="col-sm-10">
                                <input name="ProfileForm[location]" value="<?= $model['location'] ?>" type="text" class="form-control" id="inputLocation" placeholder="Location">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <a class="edit_profile"><button type="submit" class="btn btn-success">Submit</button></a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
</div>
