<?php
namespace bartechdev\craftdashboardthemes\assets;

use bartechdev\craftdashboardthemes\Plugin;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class DashboardThemesAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@bartechdev/craftdashboardthemes/assets/dist';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $theme = Plugin::getInstance()->getSettings()->theme;
        

        $this->js = [
            'js/dt.min.js',
        ];

        $this->css = [
            'css/'.$theme.'.min.css',
            'css/dt-default.min.css',
        ];

        parent::init();
    }
}