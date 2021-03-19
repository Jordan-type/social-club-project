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

class PostCreateForm extends Model
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
            [['title', 'content', 'permit', 'date'], 'required'],
            ['title', 'string', 'min' => 5, 'max' => 100],
            ['content', 'string', 'min' => 5],
            ['permit', 'integer', 'min' => 1, 'max' => 4],
            ['date', 'string'],
            ['thumbnail', 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'checkExtensionByMimeType' => false],
            ['reader', 'each', 'rule' => ['integer']],
        ];
    }

    public function createPost()
    {
        $newPost = new Post();
        $newPost['title'] = $this->title;
        $newPost['content'] = $this->content;
        $newPost['permit'] = $this->permit[0];
        if($this->upload()){
            $newPost['image'] = $this->thumbnail;
        }
        if ($this->date == "") {
            $newPost['create_at'] = date("Y-m-d");
        } else {
            $newPost['create_at'] = $this->date;
        }
        $newPost['user_id'] = $this->user_id;
        $newPost->save();

        if ($newPost['permit'] == 2) {
            foreach ($this->reader as $userId) {
                $newPostProtected = new PostProtected();
                $newPostProtected['create_at'] = $newPost['create_at'];
                $newPostProtected['post_id'] = $newPost['id'];
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