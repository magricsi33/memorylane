<?php namespace LivestudioDev\Lscart\Models;

use Model;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\Currency;

/**
 * Model
 */
class Coupon extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $jsonable = ["categories","users"];

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User',
        'category' => 'LivestudioDev\Lscart\Models\Category',
        'currency' => ['LivestudioDev\Lscart\Models\Currency', 'key' => 'value_type']
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_coupons';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getValueTypeOptions()
    {
        $options = [];
        $options[50] = "Százalékos";
        
        $currencies = Currency::all();
        foreach ($currencies as $curr) {
            $options[$curr->id] = $curr->label;
        }

        return $options;
    }

    public function getCategoryNames()
    {
        $categories = $this->categories;
        $names = [];

        foreach ($categories as $cat) {
            $category = Category::find($cat["category"]);
            if($category){
                array_push($names,$category->name);
            }
        }
        return $names;
    }
}
