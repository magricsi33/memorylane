<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class GroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();        
		$this->addCss("/plugins/livestudiodev/lscart/assets/css/groupController.css","1.0.0");
        $this->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css','5.13.0');
    }

    public function akciozas()
    {
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item', 'akciozas');
        $this->pageTitle = "Akciózás";
    }

    public function altalanos()
    {
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item', 'altalanos');
        $this->pageTitle = "Általános beállítások";
    }
}