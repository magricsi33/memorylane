<?php

namespace LivestudioDev\Partners\Models;

use Model;

/**
 * Model
 */
class Partner extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_partners_partners';

    /**
     * @var array Validation rules
     */
    public $rules = [];
}
