<?php namespace LivestudioDev\Lscartbarion\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'livestudiodev_lscartbarion_settings';

    public $settingsFields = 'fields.yaml';
}
