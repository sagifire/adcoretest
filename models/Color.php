<?php

namespace app\models;

use yii\base\Model;

class Color extends Model {
    public $name;
    public $count;

    public function rules()
    {
        return [
            [['name', 'count'], 'required'],
            [['name'], 'string', 'min' => 3, 'max' => 255],
        ];
    }
}