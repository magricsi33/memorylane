<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ShippingMethods extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item', 'side-menu-item8');
        $this->pageTitle = "Szállítási módok";
    }
}
