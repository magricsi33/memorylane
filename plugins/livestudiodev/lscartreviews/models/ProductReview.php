<?php namespace LivestudioDev\Lscartreviews\Models;

use Model;
use LivestudioDev\Lscart\Models\ProductVariant;

/**
 * Model
 */
class ProductReview extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscartreviews_product_reviews';

    public $belongsTo = [
        'product' => 'LivestudioDev\Lscart\Models\Product',
        'variant' => ['LivestudioDev\Lscart\Models\Product', 'key' => 'variant_id']
    ];

    public function getVariantIdOptions()
    {
        return ProductVariant::all()->lists('name','id');
    }

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getFormattedNameAttribute()
    {
        $name = $this->name;
        if(!$this->trimmable) return $name;

        $parts = explode(' ',$name);

        foreach ($parts as $key => $part) {
            if($key == count($parts) - 1) break;
            
            $parts[$key] = strtoupper($part[0]).".";
        }

        return implode(' ',$parts);
    }

    public function beforeSave()
    {
        if(trim($this->variant_id) == null){
            $this->variant_id = 0;
        }
    }
}
