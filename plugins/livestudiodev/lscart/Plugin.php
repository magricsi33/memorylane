<?php namespace LivestudioDev\Lscart;

use LivestudioDev\Lscart\Classes\FeedType;
use LivestudioDev\Lscart\Classes\XmlFeedResolver;
use System\Classes\PluginBase;
use RainLab\User\Models\User;
use RainLab\User\Controllers\Users as UserController;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];
    
    public function registerComponents()
    {
        return [
            'LivestudioDev\Lscart\Components\Cart' => 'cart'
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'LivestudioDev\Lscart\ReportWidgets\Products' => [
                'label'   => 'LS - Termékeink',
                'context' => 'dashboard'
            ],
            'LivestudioDev\Lscart\ReportWidgets\Sales' => [
                'label'   => 'LS - Eladások',
                'context' => 'dashboard'
            ]
        ];
    }

    public function registerSchedule($schedule)
    {
        // register a schedule that runs every 2 days
        $schedule->call(function () {
            // Import products from XML feeds
            XmlFeedResolver::syncProducts();
        })->cron('0 0 */2 * *');
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Beállítások',
                'description' => 'A webshop alapértelmezett és egyéb beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\Lscart\Models\Settings',
                'order'       => 0,
                'keywords'    => 'default options currency measure vatkey'
            ],
            // 'measure' => [
            //     'label'       => 'Mértékegységek',
            //     'description' => 'Hozzon létre, módosítson vagy töröljön mértékegységeket.',
            //     'category'    => 'Webshop',
            //     'icon'        => 'icon-university',
            //     'url'         => \Backend::url('livestudiodev/lscart/measures'),
            //     'order'       => 0,
            //     'keywords'    => 'measures'
            // ],
            // 'currency' => [
            //     'label'       => 'Pénznemek',
            //     'description' => 'Hozzon létre, módosítson vagy töröljön pénznemeket.',
            //     'category'    => 'Webshop',
            //     'icon'        => 'icon-dollar',
            //     'url'         => \Backend::url('livestudiodev/lscart/currencies'),
            //     'order'       => 0,
            //     'keywords'    => 'currency'
            // ],
            // 'vatkeys' => [
            //     'label'       => 'Adókulcsok',
            //     'description' => 'Hozzon létre, módosítson vagy töröljön adókulcsokat.',
            //     'category'    => 'Webshop',
            //     'icon'        => 'icon-key',
            //     'url'         => \Backend::url('livestudiodev/lscart/vatkeys'),
            //     'order'       => 0,
            //     'keywords'    => 'vatkeys vat'
            // ],
        ];
    }

    public function registerMarkupTags()
    {
    }

    public function boot()
    {
        User::extend(function($model) {
            $model->belongsToMany['discounts'] = ['LivestudioDev\Lscart\Models\UserDiscount', 'table' => 'livestudiodev_lscart_user_user_discounts', 'key' => 'user_id', 'otherKey' => 'userdiscount_id'];
            $model->hasMany['shipaddresses'] = ['LivestudioDev\Lscart\Models\ShipDetail'];
            $model->hasMany['orders'] = ['LivestudioDev\Lscart\Models\Order'];
            $model->hasOne['active_address'] = ['LivestudioDev\Lscart\Models\ShipDetail', 'scope' => 'active'];

            $model->addDynamicMethod('getAllOrderedAttribute', function($value) use ($model) {
                $counter = 0;
                foreach($model->orders as $order){
                    $counter += $order->items()->count();
                }
                return $counter;
            });

            $model->addDynamicMethod('getAllOrderAmountAttribute', function($value) use ($model) {
                $counter = 0;
                foreach($model->orders as $order){
                    $counter += $order->getTotalPriceBrutto();
                }
                return $counter;
            });
        });

        \Event::listen('backend.form.extendFields', function($widget) {
            if($widget->getController() instanceof UserController) {
                if($widget->model instanceof User) {
                    $widget->addFields([
                        'discounts' => [
                            'label'   => 'Kedvezmény',
                            'commentAbove' => 'Válasszon felhasználói kedvezményeket',
                            'type'    => 'relation',
                            'emptyOption' => "Nincs"
                        ]
                    ]);
        
                    $widget->addTabFields([
                        'shipaddresses' => [
                            'label' => 'Szállítási címek',
                            'type' => 'partial',
                            'tab' => 'Szállítási címek',
                            'path' => '$/livestudiodev/lscart/partials/_shipaddresses.htm'
                        ]
                    ]);
                }
            }

            if($widget->getController() instanceof \LivestudioDev\Lscart\Controllers\PaymentMethods) {
                if($widget->model instanceof \LivestudioDev\Lscart\Models\PaymentMethod) {
                    $gates_available = false;
                    if(class_exists("LivestudioDev\Lscartborgun\Classes\BorgunDriver")){
                        $gates_available = true;
                    }
            
                    if(class_exists("LivestudioDev\Lscartbarion\Classes\BarionDriver")){
                        $gates_available = true;
                    }

                    
                    if($gates_available){
                        $widget->addFields([
                            'payment_gate' => [
                                'label'   => 'Fizetőkapu',
                                'comment' => '(A választott fizetőkapu lesz használva a rendelések leadásához)',
                                'type'    => 'dropdown',
                                'span'    => 'auto',
                                'emptyOption' => "Nincs"
                            ]
                        ]);
                    }
                }
            }

        });
    }
}
