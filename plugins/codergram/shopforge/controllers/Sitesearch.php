<?php namespace Codergram\Shopforge\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Sitesearch extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Codergram.Shopforge', 'main-menu-item', 'side-menu-item3');
    }
}
