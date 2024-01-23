<?php namespace LivestudioDev\Lscart\Models;

use LivestudioDev\Lscart\Models\Product;
use Winter\Storm\Database\Model;

/**
 * Model
 */
class Category extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\NestedTree;
    use \Winter\Storm\Database\Traits\Sluggable;

    protected $fillable = [
        'name',
        'active'
    ];
    
    protected $slugs = ['slug' => 'name'];
    CONST PARENT_ID = 'parent_id';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'products'  =>  [Product::class, 'key' => 'category_id', 'otherKey' => 'id', 'scope' => 'isActive']
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public $morphToMany = [
        'properties' => ['LivestudioDev\Lscart\Models\Property', 'name' => 'propertable', 'table' => 'livestudiodev_lscart_propertables', 'pivot' => 'propertable_value']
    ];
}
