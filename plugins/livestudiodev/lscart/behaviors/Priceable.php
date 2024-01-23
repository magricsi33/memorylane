<?php namespace LivestudioDev\Lscart\Behaviors;

use LivestudioDev\Lscart\Models\Settings;
use LivestudioDev\Lscart\Models\Currency;
use LivestudioDev\Lscart\Models\Product;
use RainLab\User\Facades\Auth;

class Priceable extends \October\Rain\Extension\ExtensionBase
{
    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    public function getTotalPrice($coupon = true, $discount = true, $currency = null)
    {
        $model = $this->parent;

        $items = $model->items;
        $userdc = Auth::user() ? Auth::user()->discounts : null;

        $price = 0;
        if($coupon && $model->coupon){
            foreach ($items as $item) {
                $price += ($item->product->getItemPriceNetto($item->variant_id,1,$discount, $model->coupon, $userdc) * $item->quantity);
            }
        }else {
            foreach ($items as $item) {
                
                if (isset($item->product)) {
                    $price += ($item->product->getItemPriceNetto($item->variant_id,1,$discount, null, $userdc) * $item->quantity);
                }
                
            }
        }
        
        $value = $price < 0 ? 0 : $price;

        if($currency){
            $value = Product::exchangeValueStatic($currency,$value);
        }

        return $value;
    }

    public function getTotalPriceBrutto($coupon = true, $discount = true, $currency = null)
    {
        $model = $this->parent;

        $items = $model->items;
        $userdc = Auth::user() ? Auth::user()->discounts : null;

        $price = 0;
        if($coupon && $model->coupon){
            foreach ($items as $item) {
                $price += ($item->product->getItemPrice($item->variant_id,1,$discount, $model->coupon, $userdc) * $item->quantity);
            }
        }else {
            foreach ($items as $item) {

                if (isset($item->product)) {
                    $price += ($item->product->getItemPrice($item->variant_id,1,$discount, null, $userdc) * $item->quantity);
                }

            }
        }
        
        $value = $price < 0 ? 0 : $price;

        if($currency){
            $value = Product::exchangeValueStatic($currency,$value);
        }

        return $value;
    }

    public function getTotalQuantity()
	{
		$items = $this->parent->items;
		$qt = 0;
		foreach ($items as $value) {
			$qt = $qt + $value->quantity;
		}

		return $qt;
    }

    public function getVatValue($price)
	{
		$settings = Settings::instance();
		$vat = $settings->vatkey->value;

		return $price - ($price / (1 + ($vat / 100)));
    }

    public function getAbsolutePrice($currency = null)
	{
		$shipping_cost = $this->parent->getShippingCost(false,$currency);
		$cost = $this->parent->getTotalPriceBrutto();

        $value = ($cost + $shipping_cost);
        
        if($currency){
            $value = Product::exchangeValueStatic($currency,$value);
        }

        return $value;
    }
    
    public function getVatPrice($currency = null)
    {
        $value = ($this->parent->getTotalPriceBrutto(false,false) - $this->parent->getTotalPrice(false,false));
        
        if($currency){
            $value = Product::exchangeValueStatic($currency,$value);
        }

        return $value;
    }

    public function getAbsoluteNetto($currency = null)
	{
		$shipping_cost = $this->parent->getShippingCost(true, $currency);
		$cost = $this->parent->getTotalPrice($currency);

		return ($cost + $shipping_cost);
	}

	public function getShippingCost($netto = false, $currency = null)
	{
		if($this->parent->shipping){
			return $this->parent->shipping->getCost($this->parent,$netto,$currency);
		}
		return 0;
    }
    
    public function getOnlyShippingCost($netto = false,$currency = null)
    {
        if($this->parent->shipping){
			return $this->parent->shipping->getSelfCost($this->parent,$netto,$currency);
		}
		return 0;
    }

    public function getOnlyPaymentCost($netto = false,$currency = null)
    {
        if($this->parent->shipping){
			return $this->parent->shipping->getPaymentCost($this->parent,$netto,$currency);
		}
		return 0;
    }
}
