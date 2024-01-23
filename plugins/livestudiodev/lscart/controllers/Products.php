<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use LivestudioDev\Lscart\Models\Property;
use LivestudioDev\Lscart\Models\Product;
use LivestudioDev\Lscart\Models\ProductVariant;

class Products extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController','Backend\Behaviors\RelationController','Backend.Behaviors.ImportExportController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item', 'side-menu-item3');
        $this->pageTitle = "Termékek";
    }

    public function formBeforeSave($model)
    {
        if($model instanceof \LivestudioDev\Lscart\Models\Product && $model->category) {
            $ids = $model->category->properties()->where('type','<>','4')->pluck('livestudiodev_lscart_properties.id');
    
            $inputs = \Input::all();
    
            foreach ($ids as $propid) {
                $propval = $inputs["property_".$propid."_value"];
                if(is_array($propval)) {
                    $propval = implode(',',$propval);
                }
                $property = Property::find($propid);
                
                if($model->properties()->find($propid)){
                    $model->properties()->updateExistingPivot($property->id, array('propertable_value' => $propval), false);
                }else {
                    $model->properties()->attach($propid, array('propertable_value' => $propval));
                }
    
            }   

            $cbids = $model->category->properties()->where('type','4')->pluck('livestudiodev_lscart_properties.id');

            foreach ($cbids as $propid) {
                $propon = $model->properties()->find($propid);
                $propval = isset($inputs["property_".$propid."_value"]) ? $inputs["property_".$propid."_value"] : null;

                if($propon && $propval) {
                    $model->properties()->updateExistingPivot($propon->id, array('propertable_value' => $propval), false);
                }else if($propon && !$propval){
                    $model->properties()->updateExistingPivot($propon->id, array('propertable_value' => 0), false);
                }else if(!$propon && $propval){
                    $model->properties()->attach($propid, array('propertable_value' => $propval));
                }
            }
        }
    }

    public function onRelationManageUpdate($model)
    {
        $sessionKey = \Input::get('_session_key');
        $inputs = \Input::all();
        $variant = ProductVariant::find($inputs['manage_id']);
        $images = $variant->gallery()->withDeferred($sessionKey)->get();
        
        if(count($images) != 0){
            foreach ($images as $image) {
                $variant->gallery()->add($image);
            }
        }else {
            foreach ($variant->gallery as $image) {
                $image->delete();
            }
        }

        $i_var = $inputs['ProductVariant'];

        foreach ($i_var as $key => $field) {
            $variant->{$key} = $field;
        }
        $variant->save();

        $ids = $variant->product->properties()->where('type','<>','4')->pluck('livestudiodev_lscart_properties.id');

        foreach ($ids as $propid) {
            $propval = $inputs["property_".$propid."_value"];
            if(is_array($propval)) {
                $propval = implode(',',$propval);
            }
            $property = Property::find($propid);

            if($variant->properties()->find($propid)){
                // probably should delete the connection if its the same value as the product's || IMPLEMENTED
                $defiant_value = $variant->product->properties()->find($propid)->pivot->propertable_value;
                if($propval != $defiant_value){
                    $variant->properties()->updateExistingPivot($property->id, array('propertable_value' => $propval), false);
                }else {
                    $variant->properties()->detach($propid);
                }
            }else {
                // probably should not create the connection if its the same value as the product's || IMPLEMENTED
                $defiant_value = $variant->product->properties()->find($propid)->pivot->propertable_value;
                if($propval != $defiant_value){
                    $variant->properties()->attach($propid, array('propertable_value' => $propval));
                }
            }

        }

        // HANDLE CHECKBOXES

        $cbids = $variant->product->properties()->where('type','4')->pluck('livestudiodev_lscart_properties.id');

        foreach ($cbids as $propid) {
            $propon = $variant->properties()->find($propid);
            $propval = isset($inputs["property_".$propid."_value"]) ? $inputs["property_".$propid."_value"] : null;
            $defiant_value = $variant->product->properties()->find($propid)->pivot->propertable_value;

            if($propon && $propval) {
                $variant->properties()->updateExistingPivot($propon->id, array('propertable_value' => $propval), false);
            }else if($propon && !$propval){
                $variant->properties()->updateExistingPivot($propon->id, array('propertable_value' => 0), false);
            }else if(!$propon && $propval){
                $variant->properties()->attach($propid, array('propertable_value' => $propval));
            }else if(!$propon && !$propval){
                $variant->properties()->attach($propid, array('propertable_value' => 0));
            }
        }
    }

    public function onOpenSetCategoriesModal()
    { 
        $checked_items_ids = input('checked');
        $this->vars["checked_items_ids"] = $checked_items_ids;
        return $this->makePartial('set_categories');
    }

    public function onSetCategories()
    { 
        $categoryId = post('categoryId');
        $products = post('products');

        foreach ($products as $key => $id) {

            Product::find($id)->update([
                'category_id' => $categoryId,
            ]);

        }

        return \Redirect::refresh();

    }
}
