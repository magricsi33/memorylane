<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class ProductVariant extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_product_variants';

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getStatusNameAttribute()
    {
        $statuses = $this->getStatusOptions();

        return $statuses[$this->status];
    }
    
    public function scopeIsActive($query)
    {
        return $query->where('status','<>',0)->orderBy('name', 'desc');
    }

    public function getStatusOptions()
    {
        $statuses = [];
        $statuses[0] = "Inaktív";
        $statuses[1] = "Aktív";
        $statuses[2] = "Aktív, nem elérhető";

        return $statuses;
    }
}
