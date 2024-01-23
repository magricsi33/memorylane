<?php namespace LivestudioDev\Lscartreviews\Models;

use Model;
use Cms\Classes\Page as Pg;
use Cms\Classes\Theme;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'livestudiodev_lscartreviews_settings';
    public $settingsFields = 'fields.yaml';

    public function getPageOptions()
    {
        $theme = Theme::getEditTheme();
        $pages = Pg::listInTheme($theme, true);

        $options = [];
        foreach ($pages as $page) {
            $options[$page->baseFileName] = $page->title . ' ('.$page->url.')';
        }
        
        asort($options);
        return $options;
    }
}