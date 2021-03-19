<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 10/11/2015
 * Time: 9:53 PM
 */

namespace frontend\models;


use common\models\Post;
use common\models\PostProtected;
use yii\base\Model;
use yii\web\UploadedFile;

class PostEditForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $permit;
    public $date;
    public $user_id;
    public $reader;
    /**
     * @var UploadedFile
     */
    public $thumbnail;

    public function rules()
    {
        return [
            [['title', 'content', 'permit'], 'required'],
            ['title', 'string', 'min' => 5, 'max' => 100],
            ['content', 'string', 'min' => 5],
            ['permit', 'integer', 'min' => 1, 'max' => 4],
            ['date', 'string'],
            ['thumbnail', 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'checkExtensionByMimeType' => false],
            ['reader', 'each', 'rule' => ['integer']],
        ];
    }

    public static function cacheCurrentPostInfo($currentPost)
    {
        $model = new PostEditForm();
        $model->user_id = $currentPost['user_id'];
        $model->id = $currentPost['id'];
        $model->title = $currentPost['title'];
        $model->content = $currentPost['content'];
        $model->permit[0] = $currentPost['permit'];
        $model->date = $currentPost['create_at'];

        return $model;
    }

    public function editPost($editPost)
    {
        $editPost['title'] = $this->title;
        $editPost['content'] = $this->content;
        $editPost['permit'] = $this->permit[0];
        if ($this->upload()) {
            $editPost['image'] = $this->thumbnail;
        }
        if ($this->date == "") {
            $editPost['create_at'] = date("Y-m-d");
        } else {
            $editPost['create_at'] = $this->date;
        }
        $editPost['user_id'] = $this->user_id;
        $editPost->save();

        PostProtected::deleteAll(['post_id' => $editPost['id']]);
        if ($editPost['permit'] == 2) {
            foreach ($this->reader as $userId) {
                $newPostProtected = new PostProtected();
                $newPostProtected['create_at'] = $editPost['create_at'];
                $newPostProtected['post_id'] = $editPost['id'];
                $newPostProtected['user_id'] = $userId;
                $newPostProtected->save();
            }
        }
    }

    public function upload()
    {
        if (!$this->hasErrors()) {
            $this->thumbnail = UploadedFile::getInstance($this, 'thumbnail');
            if ($this->thumbnail == null) {
                return false;
            }
            $this->thumbnail->saveAs('images/' . $this->thumbnail->baseName . '.' . $this->thumbnail->extension);
            $this->thumbnail = $this->thumbnail->baseName . '.' . $this->thumbnail->extension;
            return true;
        } else {
            return false;
        }
    }
}