<?php namespace LivestudioDev\Lscart\Models;

use Model;
Use LivestudioDev\Lscart\Models\Settings;
Use LivestudioDev\Lscart\Models\Currency;

/**
 * Model
 */
class ShippingMethod extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $jsonable = ['payments','prices'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_shipping_methods';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'payment' => 'LivestudioDev\Lscart\Models\PaymentMethod',
        'vatkey' => 'LivestudioDev\Lscart\Models\VatKey'
    ];

    public $attachOne = [
        'logo' => 'System\Models\File'
    ];

    public function getPaymentMethod($id)
    {
        return PaymentMethod::find($id);
    }

    public function checkCondition($cond,$cval,$val){
        switch ($cond) {
            case 'more':
                if($val > $cval){
                    return true;
                }else {
                    return false;
                }
                break;

            case 'equal':
                if($val == $cval){
                    return true;
                }else {
                    return false;
                }
                break;

            case 'less':
                if($val < $cval){
                    return true;
                }else {
                    return false;
                }
                break;
        }
    }

    public function applyRules($value)
    {
        $rules = $this->prices;

        foreach ($rules as $rule) {
            if($this->checkCondition($rule["condition1"],$rule["condition1_value"],$value) && $this->checkCondition($rule["condition2"],$rule["condition2_value"],$value)){
                return $rule["value"];
            }
        }
    }

    public function exchangeValue($currency, $value)
    {
        return $value; // Not needed here and its problematic
        $settings = Settings::instance();
        $self_curr = $settings->currency;
        $new_curr = Currency::find($currency);

        if ($self_curr->exchange_value > $new_curr->exchange_value) {
            $temp_price = $value * $new_curr->exchange_value;
        } else {
            $temp_price = $value / $new_curr->exchange_value;
        }

        return $temp_price;
    }

    public function getSelfCost($model,$netto = false, $currency = null)
    {
        if($model) {
            if($currency){
                $value = $this->exchangeValue($currency,$this->applyRules($model->getTotalPriceBrutto()));
            }else {
                $value =  $this->applyRules($model->getTotalPriceBrutto());
            }

            if($netto){
                return $value / (1 + ($this->vatkey->value / 100));
            }else {
                return $value;
            }
        }
    }

    public function getPaymentCost($model,$netto = false, $currency = null)
    {
        if($model) {
            $dprice = 0;
            foreach ($this->payments as $item) {
                if($item["payment"] == $model->payment_id){
                    $dprice += $item["value"];
                }
            }

            if($currency){
                $value = $this->exchangeValue($currency,$dprice);
            }else {
                $value = $dprice;
            }

            if($netto){
                return $value / (1 + ($this->vatkey->value / 100));
            }else {
                return $value;
            }

            return $value;
        }
    }

    public function getDeliveryDayAttribute()
    {
        return \Carbon\Carbon::now()->addDays($this->delivery_delay);   
    }

    public function getCost($model,$netto = false, $currency = null)
    {
        if($model){
            $dprice = $this->applyRules($model->getTotalPriceBrutto());
            foreach ($this->payments as $item) {
                if($item["payment"] == $model->payment_id){
                    $dprice += $item["value"];
                }
            }

            if($currency){
                $value = $this->exchangeValue($currency,$dprice);
            }else {
                $value = $dprice;
            }

            if($netto){
                return $value / (1 + ($this->vatkey->value / 100));
            }else {
                return $value;
            }

            return $value;
        }

    }
}
