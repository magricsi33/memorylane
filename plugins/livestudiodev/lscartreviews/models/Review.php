<?php namespace LivestudioDev\Lscartreviews\Models;

use Model;

/**
 * Model
 */
class Review extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscartreviews_reviews';

    public $belongsTo = [
        'order' => 'LivestudioDev\Lscart\Models\Order'
    ];

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
}
