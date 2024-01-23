<?php namespace LivestudioDev\Lscart\Models;

use Model;
use LivestudioDev\Lscart\Models\Product;

/**
 * Model
 */
class Measure extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $fillable = ['name'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_measures';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getProductsAttribute()
    {
        return Product::where('unit_id',$this->id)->count();
    }
}
