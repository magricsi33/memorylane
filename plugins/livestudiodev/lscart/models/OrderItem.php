<?php namespace LivestudioDev\Lscart\Models;

use Model;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\Product;

/**
 * Model
 */
class OrderItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $jsonable = ['extras','history'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_orderitems';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'order'     =>  'LivestudioDev\Lscart\Models\Order',
        'variant'   => ['LivestudioDev\Lscart\Models\ProductVariant', 'key' => 'variant_id'],
        // 'product'   =>  'LivestudioDev\Lscart\Models\Product'
    ];

    public function getItemPriceAttribute()
    {
        $settings = Settings::instance();
        if($this->order->currency && $settings->currency && $this->order->currency == $settings->currency){
            return $this->product->getItemPrice($this->extras, $this->quantity);
        }else {
            if($this->order->currency->exchange_value > $settings->currency->exchange_value){
                return ($this->product->getItemPrice($this->extras,$this->quantity) / $this->order->currency->exchange_value);
            }else {
                return ($this->product->getItemPrice($this->extras,$this->quantity) * $settings->currency->exchange_value);
            }
        }
    }
    
    public $morphTo = [
        'product' => []
    ];
}
