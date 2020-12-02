<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class User
 * @package app\models
 *
 * @property string $email
 * @property string $name
 * @property array[] $colors
 */
class User extends ActiveRecord
{
    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['email', 'name'], 'string', 'min' => 3, 'max' => 255],
            ['email','email'],
            ['colors', 'validateColor'],
            ['colors', 'convertTypes'],
            ['colors', 'each', 'rule' => ['validateColorItem']],
        ];
    }

    /** Convert colors count to int */
    public function convertTypes(/* $attribute, $params */) {
        $colors = $this->colors;
        if (is_array($colors)) foreach ($colors as $index => &$color) {
            if (isset($color['count'])) {
                $color['count'] = (int)$color['count'];
            }
        }
        $this->colors = $colors;
    }

    /** Validate colors type */
    public function validateColor($attribute, $params) {
        $value = $this->{$attribute};
        if (!empty($value) && !is_array($value)) {
            $this->addError('colors', $attribute . ' must be an array.');
        }
    }

    /** Validate colors each item attributes */
    public function validateColorItem($attribute, $params, $context, $current) {
        $colorModel = new Color();
        $colorModel->setAttributes($current);
        $colorModel->validate();
        if ($colorModel->hasErrors()) {
            $this->addError('colors', 'One of colors items has errors: ' . implode(', ', $colorModel->getErrorSummary(false)));
        }
    }
}
