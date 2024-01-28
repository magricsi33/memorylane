<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class EditiorItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_editior_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
    
    public $belongsTo = [
        'editior'   =>  'LivestudioDev\Lscart\Models\Editior',
    ];
}
