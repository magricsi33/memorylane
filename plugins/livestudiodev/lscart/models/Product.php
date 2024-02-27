<?php

namespace LivestudioDev\Lscart\Models;

use Winter\Storm\Database\Model;
use LivestudioDev\Lscart\Models\Currency;
use LivestudioDev\Lscart\Models\Measure;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\Settings;
use LivestudioDev\Lscart\Models\Discount;
use LivestudioDev\Lscart\Models\ProductVariant;
use LivestudioDev\Lscart\Models\StorageItem;

/**
 * Model
 */
class Product extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\Sluggable;
    use \Winter\Storm\Database\Traits\Sortable;

    protected $slugs = ['slug' => 'name'];

    public $jsonable = ['materials', 'parameters', 'sizes', 'containers', 'options', 'gallery_links', 'b_sku', 'editior_inputs'];

    public $fillable = [
        'b_sku', 
        'name', 
        'cikkszam', 
        'stock', 
        'image_link', 
        'gallery_links', 
        'price', 
        'brand_id', 
        "vatkey_id", 
        "unit_id", 
        "description", 
        "category_id", 
        "slug", 
        "price_brutto", 
        "sort_order", 
        "meta_title", 
        "meta_description", 
        "meta_keywords", 
        "created_at", 
        "updated_at", 
        "properties", 
        "variantonly", 
        "status"
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_products';

    public $attachOne = [
        'image' => [
            'System\Models\File', 
            'image' => 'auto', 
            'disk' => 'local', 
            'folder' => 'images', 
            'extensions' => 'jpg,jpeg,png', 
            'imageWidth' => 800, 
            'imageHeight' => 600, 
            'quality' => 90
        ],
        'editor_image' => 'System\Models\File',    
    ];

    public $hasMany = [
        'variants' => ['LivestudioDev\Lscart\Models\ProductVariant', 'scope' => 'isActive'],
        'allvariants' => ['LivestudioDev\Lscart\Models\ProductVariant'],
        'storages' => ['LivestudioDev\Lscart\Models\StorageItem'],
        'reviews' => ['LivestudioDev\Lscartreviews\Models\ProductReview'],
    ];

    public $attachMany = [
        'gallery' => ['System\Models\File', 'delete' => 'true' ]
    ];

    public $morphOne = [
        'product' => ['LivestudioDev\Lscart\Models\CartItem', 'name' => 'product'],
        'product' => ['LivestudioDev\Lscart\Models\OrderItem', 'name' => 'product'],
    ];

    public $morphToMany = [
        'properties' => ['LivestudioDev\Lscart\Models\Property', 'name' => 'propertable', 'table' => 'livestudiodev_lscart_propertables', 'pivot' => 'propertable_value']
    ];

    public function scopeIsActive($query)
    {
        return $query->where('status', '<>', 0)->orderBy('name', 'desc');
    }

    public function scopeNonTrashed($query)
    {
        return $query->whereNull('deleted_at');
    }

    public $belongsTo = [
        'category' => ['LivestudioDev\Lscart\Models\Category', 'key' => 'category_id'],
        'unit'   =>  'LivestudioDev\Lscart\Models\Measure',
        'vatkey'   =>  'LivestudioDev\Lscart\Models\VatKey',
    ];

    public $belongsToMany = [
        'related_products' => ['LivestudioDev\Lscart\Models\Product', 'table' => 'livestudiodev_lscart_related_products', 'key' => 'product_id', 'otherKey' => 'related_id', 'scope' => 'isActive'],
    ];

    public function getStorageItem() {

        $storage = $this->storages()->orderBy('price_netto', 'ASC')->first();
        return $storage;

    }

    public function beforeSave() {

        // $product = Product::find($this->id);

        

        // if ($product && $this->getStorageItem()) {
    
        //     if ($this->profit != $product->profit) {
        //         $this->price = $this->getStorageItem()->price_netto * (($this->profit ?? 1) / 100 + 1);
        //         $this->price_brutto = $this->getStorageItem()->price_brutto * (($this->profit ?? 1) / 100 + 1);
        //     }
    
        // } else {

        //     if ($this->getStorageItem()) {

        //         $this->price = $this->getStorageItem()->price_netto * (($this->profit ?? 1) / 100 + 1);
        //         $this->price_brutto = $this->getStorageItem()->price_brutto * (($this->profit ?? 1) / 100 + 1); 

        //     }

        // }

    }

    public function getPriceAttribute($value)
    {

        // if (!$value) {
        //     $this->save();
        // }

        if (!$this->vatkey) return $value;

        $vat = ($this->vatkey->value / 100);
        if ($this->attributes["price_brutto"]) {
            return ceil(($this->attributes["price_brutto"] / (1 + $vat)));
        } else {
            return $value;
        }
    }

    public function getStatusNameAttribute()
    {
        $statuses = $this->getStatusOptions();

        return $statuses[$this->status];
    }

    public function getStatusOptions()
    {
        $statuses = [];
        $statuses[0] = "Inaktív";
        $statuses[1] = "Aktív";
        $statuses[2] = "Aktív, nem elérhető";

        return $statuses;
    }

    public function getVariant($variantid)
    {
        return ProductVariant::find($variantid);
    }

    public function getCheapestVariantAttribute()
    {
        $vrs = $this->variants;
        $cheapest = $vrs[0];
        $min = $vrs[0]->pricediff;

        foreach($vrs as $vr){
            if($vr->pricediff < $min){
                $min = $vr->pricediff;
                $cheapest = $vr;
            }
        }

        return $vr->id;
    }

    public function getItemPrice($variantid = null, $currency = null, $discount = true, $coupon = null, $userdc = null)
    {
        $value = 0;
        if ($currency) {
            if (!$variantid) {
                $value = intval($this->price_brutto);
            } else {
                $variant = ProductVariant::find($variantid)->pricediff;
                $value = (intval($this->price_brutto) + $variant);
            }

            $value = $this->exchangeValue($currency, $value);
        } else {
            if (!$variantid) {
                $value = intval($this->price_brutto);
            } else {
                $variant = ProductVariant::find($variantid)->pricediff;
                $value = (intval($this->price_brutto) + $variant);
            }
        }

        if ($userdc) {
            foreach ($userdc as $udiscount) {
                $tempbool = false;
                $dc_value = 0;
                $udiscount = (object) $udiscount;

                foreach ($udiscount->discounts as $indival) {
                    if ($indival["category"] == $this->category->id) {
                        $tempbool = true;
                        $dc_value = $indival["value"];
                        break;
                    }
                }

                if ($tempbool) {
                    $value = $value * (1 - ($dc_value / 100));
                    break;
                }
            }
        }

        if ($this->isDiscounted() && $discount) {
            $discount = $this->getDiscount();

            $negate = (1 - ($discount->discount / 100));
            $value = ($value * $negate);

            // if ($discount->discount_type == 1) {
            //     $negate = (1 - ($discount->discount / 100));
            //     $value = ($value * $negate);
            // }else if($discount->discount_type == 0) {
            //     $negate = $discount->discount;
            //     $value = $value - $negate;
            // }
        }

        if ($coupon) {
            $tempbool = false;
            if ($coupon->allcategory) {
                $tempbool = true;
            } else {
                foreach ($coupon->categories as $value) {
                    if ($this->category->id == $value["category"]) {
                        $tempbool = true;
                        break;
                    }
                }
            }

            if ($tempbool) {
                if ($coupon->value_type == 50) {
                    $value = $value * (1 - ($coupon->value / 100));
                } else {
                    $value = $value - $coupon->value;
                }
            }
        }

        return $value;
    }

    public static function exchangeValueStatic($currency, $value)
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

    public function getItemPriceNetto($variantid = null, $currency = null, $discount = true, $coupon = null, $userdc = null)
    {
        $value = 0;
        if ($currency) {
            if (!$variantid) {
                $value = intval($this->price);
            } else {
                $variant = ProductVariant::find($variantid)->pricediff;
                $value = (intval($this->price) + $variant);
            }

            $value = $this->exchangeValue($currency, $value);
        } else {
            if (!$variantid) {
                $value = intval($this->price);
            } else {
                $variant = ProductVariant::find($variantid)->pricediff;
                $value = (intval($this->price) + $variant);
            }
        }

        if ($userdc) {
            foreach ($userdc as $udiscount) {
                $tempbool = false;
                $dc_value = 0;
                $udiscount = (object) $udiscount;

                foreach ($udiscount->discounts as $indival) {
                    if ($indival["category"] == $this->category->id) {
                        $tempbool = true;
                        $dc_value = $indival["value"];
                        break;
                    }
                }

                if ($tempbool) {
                    $value = $value * (1 - ($dc_value / 100));
                    break;
                }
            }
        }

        if ($this->isDiscounted() && $discount) {
            $discount = $this->getDiscount();

            $negate = (1 - ($discount->discount / 100));
            $value = ($value * $negate);

            // if ($discount->discount_type == 1) {
            //     $negate = (1 - ($discount->discount / 100));
            //     $value = ($value * $negate);
            // }else if($discount->discount_type == 0) {
            //     $negate = $discount->discount;
            //     $value = $value - $negate;
            // }
        }

        if ($coupon) {
            $tempbool = false;
            if ($coupon->allcategory) {
                $tempbool = true;
            } else {
                foreach ($coupon->categories as $value) {
                    if ($this->category->id == $value["category"]) {
                        $tempbool = true;
                        break;
                    }
                }
            }

            if ($tempbool) {
                if ($coupon->value_type == 50) {
                    $value = $value * (1 - ($coupon->value / 100));
                } else {
                    $value = $value - $coupon->value;
                }
            }
        }

        return $value;
    }

    public function getCategoryIdOptions()
    {
        $categories = Category::all();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->id] = str_pad("", $category->nest_depth, "> ", STR_PAD_LEFT) . $category->name;
        }
        return $result;
    }

    public function getDiscount()
    {
        $discounts = Discount::all();
        foreach ($discounts as $discount) {
            $indiscount = false;
            if ($discount->date_end->greaterThan(\Carbon\Carbon::now())) {
                foreach ($discount->products as $value) {
                    $id = $value["product"];
                    $active = $value["active"];
                    if ($id == $this->id && $active) {
                        $indiscount = true;
                        break;
                    }
                }

                if ($indiscount) {
                    return $discount;
                }
            }
        }
        return null;
    }

    public function isDiscounted()
    {
        if ($this->getDiscount()) {
            return true;
        } else {
            return false;
        }
    }

    public function hasProperty($propid,$value = 1)
    {    
        $property = $this->properties()->find($propid);
        if($property && $property->pivot->propertable_value = $value){
            return true;
        }else {
            return false;
        }
    }

    /**
     * @var array Validation rules
     */
    public $rules = [];
}
