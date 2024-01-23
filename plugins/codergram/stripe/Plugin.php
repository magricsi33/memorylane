<?php namespace Codergram\Stripe;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'stripesettings' => [
                'label'       => 'Stripe beállítások',
                'description' => 'Stripe fizetőportál beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-cog',
                'class'       => 'Codergram\Stripe\Models\Settings',
                'order'       => 0,
                'keywords'    => 'Stripe apikey invoice'
            ]
        ];
    }
}
