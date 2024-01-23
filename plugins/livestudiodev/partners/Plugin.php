<?php namespace LivestudioDev\Partners;

use LivestudioDev\Lscart\Models\Order;
use System\Classes\PluginBase;
use RainLab\User\Models\User;
use RainLab\User\Controllers\Users as UserController;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        \Event::listen('lscart.order.successfull', function($id) {
            $order = Order::find($id);

            $vars = [
                'name' => $order->name,
                'order' => $order
            ];

            \Mail::send('bakonyiklima::mail.order', $vars, function($message) use($order) {

                $message->to($order->email, $order->name)->cc('kapcsolat@codergram.hu');
                $message->subject('Sikeres rendelésleadás.');

            });
        });
        
        \Event::listen('backend.form.extendFields', function($widget) {
            if($widget->getController() instanceof UserController) {
                if($widget->model instanceof User) {
                    $widget->addTabFields([
                        'company' => [
                            'label'   => 'Cégnév',
                            'type'    => 'text',
                            'tab'     => 'rainlab.user::lang.user.account',
                            'span'    => 'auto'
                        ],
                        'address' => [
                            'label'   => 'Cím',
                            'type'    => 'text',
                            'tab'     => 'rainlab.user::lang.user.account',
                            'span'    => 'auto'
                        ],
                        'tax_number' => [
                            'label'   => 'Adószám',
                            'type'    => 'text',
                            'tab'     => 'rainlab.user::lang.user.account',
                            'span'    => 'auto'
                        ],
                        'phone' => [
                            'label'   => 'Telefonszám',
                            'type'    => 'text',
                            'tab'     => 'rainlab.user::lang.user.account',
                            'span'    => 'auto'
                        ]
                    ]);
                }
            }

        });
    }
}
