<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $jsonable = ['billingo'];

    public $settingsCode = 'livestudiodev_lscart_settings';

    public $settingsFields = 'fields.yaml';

    public $belongsTo = [
        'vatkey' => 'LivestudioDev\Lscart\Models\VatKey',
        'measure' => 'LivestudioDev\Lscart\Models\Measure',
        'currency' => 'LivestudioDev\Lscart\Models\Currency'
    ];
}
