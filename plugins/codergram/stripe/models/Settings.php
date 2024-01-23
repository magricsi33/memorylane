<?php namespace Codergram\Stripe\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'codergram_stripe_settings';

    public $settingsFields = 'fields.yaml';
}
