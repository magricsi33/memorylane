<?php namespace Codergram\Zoldszeged;

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
                'label'       => 'Weboldal',
                'description' => 'A weboldal alapértelmezett és egyéb beállításai.',
                'category'    => 'Weboldal',
                'icon'        => 'icon-cog',
                'class'       => 'Codergram\Zoldszeged\Models\Settings',
                'order'       => 0,
                'keywords'    => ''
            ],
        ];
    }
}
