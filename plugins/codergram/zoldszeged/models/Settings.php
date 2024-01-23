<?php namespace Codergram\Zoldszeged\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'codergram_zoldszeged_settings';

    public $settingsFields = 'fields.yaml';

    public $belongsTo = [

    ];
}
