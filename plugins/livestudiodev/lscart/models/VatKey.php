<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class VatKey extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $fillable = ['name','value'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_vatkeys';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
