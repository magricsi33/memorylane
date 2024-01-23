<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class ShipDetail extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $jsonable = ['address'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_user_shipdetails';

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User']
    ];

    public function scopeActive($query) {
        return $query->where('active',1);
    }

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
