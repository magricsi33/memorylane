<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class StorageItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_storage_items';

    public $fillable = [
        'name', 
        'partner', 
        'stock', 
        'description', 
        "cikkszam",
        "price_brutto",
        "price_netto",
        "image_link",
        "image",
        "gallery_links",
        "category_id",
        "type",
        "brand",
        "transport",
        "properties",
        'b_sku',
    ];

    public $jsonable = ['properties', 'b_sku'];

    public $belongsTo = [
        'category' => 'LivestudioDev\Lscart\Models\Category',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
