<?php namespace LivestudioDev\Lscartreviews;

use System\Classes\PluginBase;
use Event;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscartreviews\Models\ReviewCode;
use LivestudioDev\Lscartreviews\Models\Product;

class Plugin extends PluginBase
{
    public $require = ['LivestudioDev.Lscart'];

    public function registerComponents()
    {
    }

    public function registerNavigation()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Véleményezési beállítások',
                'description' => 'Vásárlói véleményadás beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\Lscartreviews\Models\Settings',
                'order'       => 0,
                'keywords'    => 'security location'
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'livestudiodev.lscartreviews::mail.reviewcode'
        ];
    }

    public function boot()
    {
        Event::listen('lscart.order.afterupdate', function($param) {
            // \Log::info(json_encode($param));
            $order = Order::find($param);
            if($order->status == 6){
                $code = ReviewCode::generateFromOrder($order);
                $vars = ['url' => $code, 'order' => $order];
    
                \Mail::send('livestudiodev.lscartreviews::mail.reviewcode', $vars, function ($message) use ($order) {
                    $message->to($order->email);
                });
            }

        });

        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->addSideMenuItems('LivestudioDev.Lscart','main-menu-item2', [
                'reviews' =>[
                    'label' =>  'Vélemények',
                    'icon'  =>  'icon-comments',
                    'code'  =>  'reviews',
                    'owner' =>  'LivestudioDev.Lscart',
                    'url'   =>  \Backend::url('livestudiodev/lscartreviews/reviews')
                ],
            ]);
            $manager->addSideMenuItems('LivestudioDev.Lscart','main-menu-item2', [
                'productreviews' =>[
                    'label' =>  'Termék Vélemények',
                    'icon'  =>  'icon-comments',
                    'code'  =>  'productreviews',
                    'owner' =>  'LivestudioDev.Lscart',
                    'url'   =>  \Backend::url('livestudiodev/lscartreviews/productreviews')
                ],
            ]);
        });
    }
}
