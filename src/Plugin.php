<?php

namespace bartechdev\craftdashboardthemes;

use Craft;
use craft\base\Plugin as BasePlugin;
use bartechdev\craftdashboardthemes\assets\DashboardThemesAsset;
use bartechdev\craftdashboardthemes\models\Settings;
use craft\base\Model;

/**
 * Dashboard Themes plugin
 *
 * @method static Plugin getInstance()
 * @author Bartlomiej Witkowski <contact@bar-tech.dev>
 * @copyright Bartlomiej Witkowski
 * @license https://craftcms.github.io/license/ Craft License
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';

    public function init(): void
    {
        $this->hasCpSettings = true;

        parent::init();


        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Craft::$app->view->registerAssetBundle(DashboardThemesAsset::class);
            $this->setBodyClass();
            $this->setWidgetHtml();
        }
        
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    private function setBodyClass(): void
    {
        $theme = $this->settings->theme;
        Craft::$app->getView()->hook(
            'cp.layouts.base',
            static function(array &$context) use ($theme) {
                array_push($context['bodyAttributes']['class'], ...[$theme]);
            }
        );
    }

    
    private function setWidgetHtml(): void
    {
        $user = Craft::$app->getUser()->getIdentity();

        if(!$user){
            return;
        }

        $view = Craft::$app->getView();

        $bgUrl = \Craft::$app->assetManager->getPublishedUrl(
            '@bartechdev/craftdashboardthemes/assets/dist/images',
            true,
            $this->settings->theme . '.png'
        );

        $template = $view->renderTemplate('dashboard-themes/widget', [
            'user' => $user, 
            'bgUrl' => $bgUrl 
        ]);

        $view->registerJs(
            'window.__DT = {}' . ";\n" .
            'window.__DT.widgetHtml = ' . json_encode($template) . ";\n"
        );
    }



    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate(
            'dashboard-themes/settings',
            [ 'settings' => $this->getSettings() ]
        );
    }

}
