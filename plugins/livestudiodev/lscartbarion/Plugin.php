<?php namespace LivestudioDev\Lscartbarion;

use System\Classes\PluginBase;
use LivestudioDev\Lscartbarion\Classes\BarionDriver;
use LivestudioDev\Lscart\Models\PaymentMethod;
use LivestudioDev\Lscart\Controllers\PaymentMethods;
use Event;

class Plugin extends PluginBase
{
    public $require = ['LivestudioDev.Lscart'];

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'barionsettings' => [
                'label'       => 'Barion beállítások',
                'description' => 'Barion fizetőportál beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\Lscartbarion\Models\Settings',
                'order'       => 0,
                'keywords'    => 'barion apikey invoice'
            ]
        ];
    }

    public function boot()
    {
        // Event::listen('backend.form.extendFields', function($widget) {

        //     if (!$widget->getController() instanceof \LivestudioDev\Lscart\Controllers\PaymentMethods) {
        //         return;
        //     }

        //     if (!$widget->model instanceof \LivestudioDev\Lscart\Models\PaymentMethod) {
        //         return;
        //     }

        //     $widget->addFields([
        //         'payment_gate' => [
        //             'label'   => 'Fizetőkapu',
        //             'comment' => '(A választott fizetőkapu lesz használva a rendelések leadásához)',
        //             'type'    => 'dropdown',
        //             'span'    => 'auto',
        //             'emptyOption' => "Nincs"
        //         ]
        //     ]);            
        // });

        // PaymentMethod::extend(function($model) {
        //     $model->addDynamicMethod('getPaymentGateOptions', function($value) {
        //         $modes = [];
        //         $modes["Barion"] = "Barion";

        //         return $modes;
        //     });
        // });
    }
}
