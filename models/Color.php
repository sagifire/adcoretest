<?php

namespace app\models;

use yii\base\Model;

/**
 * Class Color
 * @package app\models
 */
class Color extends Model {
    /** @var string */
    public $name;
    /** @var mixed */
    public $count;

    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['name', 'count'], 'required'],
            [['name'], 'string', 'min' => 3, 'max' => 255],
        ];
    }
}