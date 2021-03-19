<?php
/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 11/12/2015
 * Time: 1:19 AM
 */

namespace frontend\models;


use common\models\Schedule;
use yii\base\Model;

class EventCreateForm extends Model
{
    public $title;
    public $start;
    public $end;
    public $color;
    public $create_at;
    public $own_id;
    public $friend;

    public function rules()
    {
        return [
            ['title', 'string'],
            ['start', 'string'],
            ['end', 'string'],
            ['color', 'string'],
            ['create_at', 'string'],
            ['friend', 'each', 'rule' => ['integer']],
        ];
    }

    public function validate()
    {
        return ($this->title != "") && ($this->start != "") && (($this->start <= $this->end)|| ($this->end==""));
    }

    public function addEvent($title)
    {
        $event = new Schedule();
        $event['title'] = $title;
        $event['start'] = $this->start;
        $event['end'] = $this->end;
        $event['create_at'] = $this->create_at;
        $event['own_id'] = $this->own_id;
        $event['color'] = $this->color;
        $event->save();

        return $event['id'];
    }
}