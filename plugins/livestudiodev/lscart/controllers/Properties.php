<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Properties extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item', 'side-menu-item');
    }

    public function formAfterSave($model)
    {

        $property_extras = $model->extra;
        foreach ($property_extras as $key => $property) {
            if($property['slug'] == null && $property['item'] != null){
                $property['slug'] = str_slug($property['item'], '-');
            }
            $property_extras[$key] = $property;
        }

        $model->extra = $property_extras;
        $model->save();
    }
}
