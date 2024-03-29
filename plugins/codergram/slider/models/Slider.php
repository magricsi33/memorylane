<?php namespace Codergram\Slider\Models;

use Model;

/**
 * Model
 */
class Slider extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'codergram_slider_sliders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'image' => 'System\Models\File',
        'image_mobile' => 'System\Models\File'
    ];

    protected $jsonable = [
        'button',
        'title',
        'data'
    ];
}
