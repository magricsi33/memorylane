<?php

namespace LivestudioDev\Lscart\Models;

use Model;
use October\Rain\Database\Traits\Sortable;
use LivestudioDev\Lscart\Models\Settings;

/**
 * Model
 */
class CartItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_cartitems';
    protected $touches = ['cart'];
    public $jsonable = ['extras'];

    public $timestamps = false;

    public $belongsTo = [
        'cart' => Cart::class,        
        'variant'   => ['LivestudioDev\Lscart\Models\ProductVariant', 'key' => 'variant_id'],
    ];

    public $morphTo = [
        'product' => []
    ];

    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
    }

    public function getItemPriceAttribute()
    {
        $user = \Auth::user();
        $discounts = $user && $user->discounts ? $user->discounts : null;
        
        return $this->product->getItemPrice($this->variant_id, $this->cart->currency,true,$this->cart->coupon,$discounts) * $this->quantity;
    }

    public function getUnitPriceAttribute()
    {
        $user = \Auth::user();
        $discounts = $user && $user->discounts ? $user->discounts : null;
        
        return $this->product->getItemPrice($this->variant_id, $this->cart->currency,true,$this->cart->coupon,$discounts);
    }

    /**
     * @var array Validation rules
     */
    public $rules = [];
}
