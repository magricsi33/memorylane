<?php

namespace LivestudioDev\Lscart\Models;

use Model;
use Event;
use Session;
use Cookie;
use LivestudioDev\Lscart\Models\CartItem;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\OrderItem;
use LivestudioDev\Lscart\Models\Settings;
use LivestudioDev\Lscart\Models\Coupon;
use LivestudioDev\Lscart\Models\ShippingMethod;
use LivestudioDev\Lscart\Models\PaymentMethod;
use LivestudioDev\Lscart\Models\Currency;
use LivestudioDev\Lscart\Models\ProductVariant;

/**
 * Model
 */
class Cart extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        'LivestudioDev.Lscart.Behaviors.Priceable'
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_carts';
    public $with = ['items'];
    public $hasMany = [
        'items' =>  [CartItem::class, 'order' => ['sort_order']]
    ];

    public $belongsTo = [
        'coupon' => [Coupon::class],
        'shipping' => [ShippingMethod::class],
        'payment' => [PaymentMethod::class],
        'currency' => [Currency::class]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [];

    protected $cachedTotals;
    protected $cachedListItems;

    public static function fromSession(): self
    {
        $cart = self::orderBy('created_at', 'DESC')->where('status', 0)->where('session_id', self::getSessionId())->first();
        if (!$cart) {
            $cart = new Cart();
            $cart->session_id = self::getSessionId();
            if(Settings::instance()->currency){
                $cart->currency = Settings::instance()->currency;
            }
            $cart->save();
        }
        return $cart;
    }

    private static function getSessionId(): string
    {
        $sessionId = Cookie::get('cart_session_id') ?? str_random(100);
        Cookie::queue('cart_session_id', $sessionId, 9e6);

        return $sessionId;
    }

    public static function regenerateSessionId(): string
    {
        $sessionId = str_random(100);
        Cookie::queue('cart_session_id', $sessionId, 9e6);

        return $sessionId;
    }

    public function convertToOrder(): Order
    {
        $order = new Order();

        $lastord = Order::latest('created_at')->first();
        if (!$lastord) {
            $coconut = 0;
        } else {
            $coconut = $lastord->order_number;
        }
        $settings = Settings::instance();

        $onum = intval($coconut);
        $order->order_number = str_pad(($onum + 1), 8, "0", STR_PAD_LEFT);
        $order->session_id = $this->session_id;
        $order->cart_id = $this->id;
        $order->coupon_id = $this->coupon_id;
        $order->payment_id = $this->payment_id;
        $order->shipping_id = $this->shipping_id;
        $order->currency_id = $this->currency_id;
        $order->save();

        if($this->coupon){
            $coupon = $this->coupon;
        }else {
            $coupon = null;
        }

        $user = \Auth::user();

        if($user && $user->discounts){
            $discounts = $user->discounts;
        }else {
            $discounts = null;
        }

        foreach ($this->items as $cartitem) {
            if($settings->useStock == true){
                if($cartitem->product->stock < $cartitem->quantity){
                    \Flash::error("Sajnos nem sikerült megrendelni a '{$cartitem->product->name}' nevű terméket, mert elfogyott a raktárkészlet.");
                    continue;
                }else {
                    if($cartitem->variant){
                        $variant = $cartitem->variant;
                        $variant->stock = ($variant->stock - $cartitem->quantity);
                        $variant->save();
                    }else {
                        $product = $cartitem->product;
                        $product->stock = ($product->stock - $cartitem->quantity);
                        $product->save();
                    }
                }
            }

            $i_history = [];
            $i_history["discountPriceBrutto"] = $cartitem->product->getItemPrice($cartitem->variant_id, null, true, $coupon, $discounts);
            $i_history["discountPriceNetto"] = $cartitem->product->getItemPriceNetto($cartitem->variant_id, null, true, $coupon, $discounts);
            $i_history["bruttoPrice"] = $cartitem->product->getItemPrice($cartitem->variant_id, null);
            $i_history["nettoPrice"] = $cartitem->product->getItemPriceNetto($cartitem->variant_id, null);
            
            $oitem = new OrderItem();
            $oitem->history = $i_history;
            $oitem->order_id = $order->id;
            $oitem->variant_id = $cartitem->variant_id;
            $oitem->editior_id = $cartitem->editior_id;
            $oitem->product = $cartitem->product;
            $oitem->quantity = $cartitem->quantity;
            $oitem->extras = $cartitem->extras;
            $oitem->save();
            $order->items()->add($oitem);
            $order->reloadRelations('items');
        }

        $this->reloadRelations('items');
        $this->flushCache();
        $this->delete();
        $this->regenerateSessionId();

        return $order;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($cart) {
            $cart->items()->delete();
        });
    }

    public function refreshRelations()
    {
        $this->reloadRelations('items');
        $this->reloadRelations('coupon');
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->save();
        $this->refreshRelations();
    }

    public function canApplyCoupon(Coupon $coupon, $user)
    {
        $result = true;
        // if(!$coupon->allcategory){
        //     $tempbool = false;
        //     foreach ($this->items as $item) {
        //         foreach ($coupon->categories as $value) {
        //             if($item->product->category->id == $value["category"]){
        //                 $tempbool = true;
        //                 break;
        //             }
        //         }
        //         if($tempbool){                    
        //             break;
        //         }
        //     }
        //     if(!$tempbool){
        //         $result = false;
        //     }
        // }

        if (!$coupon->alluser) {
            if ($user) {
                foreach ($coupon->users as $value) {
                    if ($user->id == $value["user"]) {
                        break;
                    }
                }
            } else {
                $result = false;
            }
        }

        return $result;
    }

    public function removeCoupon(Coupon $coupon)
    {
        $this->coupon = null;
        $this->save();
        $this->refreshRelations();
    }

    public function add(CartItem $item, int $quantity = 1)
    {
        if (!$item->exists) {
            $item->save();
        }

        if ($item->quantity === null) {
            $item->quantity = $quantity;
        }

        // Event::fire('offline.microcart.cart.beforeAdd', [$this, $item]);

        $this->items()->add($item);
        $this->reloadRelations('items');
        $item->reloadRelations('cart');

        $this->flushCache();

        // Event::fire('offline.microcart.cart.afterAdd', [$this, $item]);
    }

    public function addMany(CartItem ...$items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function remove($item)
    {
        // Event::fire('offline.microcart.cart.beforeRemove', [$this, $item]);

        $item->delete();

        $this->reloadRelations('items');
        $this->flushCache();

        // Event::fire('offline.microcart.cart.afterRemove', [$this, $item]);
    }


    public function hasProduct($item): bool
    {
        $exists = false;
        if($item->variant_id){
            foreach ($this->items as $hitem) {
                if ($hitem->product->id == $item->product_id && $hitem->variant && $hitem->variant->id == $item->variant_id) {
                    $exists = true;
                }
            }
        }else {
            foreach ($this->items as $hitem) {
                if ($hitem->product->id == $item->product_id) {
                    $exists = true;
                }
            }
        }

        return $exists;
    }

    public function hasItem($item): bool
    {
        return $this->items()->exists($item);
    }

    public function getItemByProduct($product_id)
    {
        return $this->items()->where('product_id',$product_id)->first();
    }

    public function getItemByVariant($variant_id)
    {
        return $this->items()->where('variant_id',$variant_id)->first();
    }

    public function clear()
    {
        foreach ($this->items as $item) {
            $item->delete();
        }

        $this->reloadRelations('items');
        $this->flushCache();
    }

    public function removeMany(CartItem ...$items)
    {
        foreach ($items as $item) {
            $this->remove($item);
        }
    }

    public function addQuantity($item)
    {
        if($item->variant){
            $had = $this->items()->where('product_id', $item->product->id)->where('variant_id',$item->variant->id)->first();
        }else {
            $had = $this->items()->where('product_id', $item->product->id)->first();
        }
        $had->quantity = ($had->quantity + $item->quantity);
        $had->save();

        $this->reloadRelations('items');
        $this->flushCache();
    }

    public function modifyItemQuantity($item,$quantity)
    {
        $had = $this->items()->find($item->id);
        $had->quantity = $quantity;
        $had->save();

        $this->reloadRelations('items');
        $this->flushCache();
    }

    public function modifyItemVariant($item,$variantid)
    {        
        $had = $this->items()->find($item->id);
        $had->variant = ProductVariant::find($variantid);
        $had->save();

        $this->reloadRelations('items');
        $this->flushCache();
    }

    public function addItemQuantity($item)
    {
        $had = $this->items()->find($item->id);
        $had->quantity = ($had->quantity + 1);
        $had->save();

        $this->reloadRelations('items');
        $this->flushCache();
    }

    public function removeItemQuantity($item)
    {
        $had = $this->items()->find($item->id);
        $had->quantity = ($had->quantity - 1);
        
        if($had->quantity <= 0) {
            $had->delete();
        } else {
            $had->save();
        }

        $this->reloadRelations('items');
        $this->flushCache();
    }


    public function setQuantity($item, int $quantity)
    {
        $item = $this->resolveItem($item);

        // Event::fire('offline.microcart.cart.beforeQuantityChange', [$this, $item]);

        $item->quantity = $quantity;
        $item->save();

        $this->reloadRelations('items');
        $this->flushCache();

        // Event::fire('offline.microcart.cart.afterQuantityChange', [$this, $item]);
    }

    protected function itemFromCartSession($id)
    {
        return CartItem::whereHas('cart', function ($q) {
            $q->where('session_id', static::getSessionId());
        })->findOrFail($id);
    }

    protected function ensureItemBelongsToSession(CartItem $item)
    {
        if ($item->cart->session_id !== static::getSessionId()) {
            throw new \LogicException('The modified item does not belong to the current user\'s cart.');
        }
    }

    public function getTotalsAttribute()
    {
        if ($this->cachedTotals !== null) {
            return $this->cachedTotals;
        }

        return $this->cachedTotals = new Totals($this);
    }

    public function getListItemsAttribute()
    {
        if ($this->cachedListItems) {
            return $this->cachedListItems;
        }

        return $this->cachedListItems = $this->items;
    }

    private function flushCache(): void
    {
        $this->cachedTotals      = null;
        $this->cachedListItems   = null;
    }
}
