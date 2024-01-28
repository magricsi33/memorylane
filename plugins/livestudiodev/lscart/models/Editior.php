<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class Editior extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_editiors';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = [
        'datas'
    ];

    public $attachMany = [
        'gallery' => 'System\Models\File'
    ];

    public $belongsTo = [
        'product'   =>  'LivestudioDev\Lscart\Models\Product',
        'variant'   =>  'LivestudioDev\Lscart\Models\Variant',
        'cartitem'   =>  'LivestudioDev\Lscart\Models\CartItem',
    ];

    public $hasMany = [
        'items'   =>  'LivestudioDev\Lscart\Models\EditiorItem',
    ];

}
