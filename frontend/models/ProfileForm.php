<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/22/2015
 * Time: 10:19 AM
 */

namespace frontend\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ProfileForm extends Model
{
    public $fullname;
    public $oldPassword;
    public $newPassword;
    public $education;
    public $location;
    public $job;
    public $gender;
    /**
     * @var UploadedFile
     */
    public $avatar;

    public function rules()
    {
        return [
            ['fullname', 'string'],
            ['oldPassword', 'string', 'min' => 6],
            ['newPassword', 'string', 'min' => 6],
            ['education', 'string'],
            ['location', 'string'],
            ['job', 'string'],
            ['gender', 'string'],
            ['avatar', 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'checkExtensionByMimeType' => false],
        ];
    }

    public static function cacheCurrentProfile($user)
    {
        $model = new ProfileForm();

        $model->fullname = $user['fullname'];
        $model->education = $user['education'];
        $model->location = $user['location'];
        $model->job = $user['job'];
        $model->gender[0] = $user['gender'];

        return $model;
    }

    public function updateProfile($user)
    {
        $user->fullname = $this->fullname;
//        $user->setPassword($this->newPassword);
        $user->education = $this->education;
        $user->location = $this->location;
        $user->job = $this->job;
        $user->gender = $this->gender[0];
        if ($this->upload()) {
            $user->image = $this->avatar;
        }
        $user->save();
    }

    public function upload()
    {
        if (!$this->hasErrors()) {
            $this->avatar = UploadedFile::getInstance($this, 'avatar');
            if ($this->avatar == null) {
                return false;
            }
            $this->avatar->saveAs('images/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            $this->avatar = $this->avatar->baseName . '.' . $this->avatar->extension;
            return true;
        } else {
            return false;
        }
    }
}