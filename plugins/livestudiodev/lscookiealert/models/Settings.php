<?php namespace LivestudioDev\Lscookiealert\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'livestudiodev_lscookiealert_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}