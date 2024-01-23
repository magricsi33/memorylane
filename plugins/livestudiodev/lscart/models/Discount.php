<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class Discount extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $jsonable = ['products'];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $dates = ['date_end','date_start'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_discounts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => 'LivestudioDev\Lscart\Models\Product'
    ];
}
