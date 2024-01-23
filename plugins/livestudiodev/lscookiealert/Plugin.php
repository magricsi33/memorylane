<?php namespace LivestudioDev\Lscookiealert;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Süti Üzenet',
                'description' => 'Süti manager beállításai.',
                'category'    => 'Cookie',
                'icon'        => 'icon-coffee',
                'class'       => 'LivestudioDev\Lscookiealert\Models\Settings',
                'order'       => 0,
                'keywords'    => 'cookie'
            ]
        ];
    }
}
