<?php namespace Codergram\Slider\Models;

use Model;

/**
 * Model
 */
class Banner extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'codergram_slider_banners';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'image_desktop' => 'System\Models\File',
        'image_tablet' => 'System\Models\File',
        'image_phone' => 'System\Models\File'
    ];

    protected $jsonable = [
        'button',
        'title',
        'data'
    ];

}
