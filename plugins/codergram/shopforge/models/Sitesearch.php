<?php namespace Codergram\Shopforge\Models;

use Model;

/**
 * Model
 */
class Sitesearch extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'codergram_shopforge_sitesearch';

    protected $fillable = [
        'name',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
