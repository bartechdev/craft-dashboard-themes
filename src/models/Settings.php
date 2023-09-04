<?php

namespace bartechdev\craftdashboardthemes\models;

use craft\base\Model;

class Settings extends Model
{
    public $theme = 'default';

    public function defineRules(): array
    {
        return [
            [['theme'], 'required'],
        ];
    }
}