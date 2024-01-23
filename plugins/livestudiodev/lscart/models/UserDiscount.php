<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class UserDiscount extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $jsonable = ['discounts'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_user_discounts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'category' => ['LivestudioDev\Lscart\Models\Category']
    ];
    
    public $belongsToMany = [
        'users' => ['RainLab\User\Models\User', 'table' => 'livestudiodev_lscart_user_user_discounts', 'otherKey' => 'user_id', 'key' => 'userdiscount_id']
    ];

    public function getUserCountAttribute() {
        return $this->users->count();
    }
}
