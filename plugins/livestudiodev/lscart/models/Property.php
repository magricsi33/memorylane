<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class Property extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $fillable = [
        'name',
        'type',
        'extra',
        'filter_type',
        'filter_unit',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_properties';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['extra'];

    public function getTypeNameAttribute()
    {
        switch ($this->type) {
            case 0:
                return "text";
            
            case 1:
                return "number";

            case 2:
                return "dropdown";
            
            case 3:
                return "multiselect";

            case 4:
                return "switch";

            default:
                return "text";
        }
    }

    public function getValueAttribute()
    {
        if($this->pivot){
            if($this->type == 2){
                return $this->extra[$this->pivot->propertable_value]['item'];//$extra->where('item',$this->pivot->propertable_value);
            }else if($this->type == 3){
                $ids = explode(',',$this->pivot->propertable_value);
                
                $returnarr = [];
                foreach ($ids as $id) {
                    $returnarr[$id] = $this->extra[$id];
                }
                return $returnarr;
            }else {
                return $this->pivot->propertable_value;
            }
        }

        return null;
    }

    public $morphedByMany = [
        'products'  => ['LivestudioDev\Lscart\Models\Product', 'name' => 'propertable', 'table' => 'livestudiodev_lscart_propertables', 'pivot' => 'propertable_value'],
        'categories' => ['LivestudioDev\Lscart\Models\Category', 'name' => 'propertable', 'table' => 'livestudiodev_lscart_propertables', 'pivot' => 'propertable_value']
    ];

}
