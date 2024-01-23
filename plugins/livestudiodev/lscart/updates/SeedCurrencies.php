<?php namespace LivestudioDev\Lscart\Updates;

use Seeder;
use LivestudioDev\Lscart\Models\Currency;

class SeedCurrencies extends Seeder
{
    public function run()
    {
        $currency = Currency::firstOrCreate(
            ['code'  => 'HUF'],
            ['label' => 'Magyar forint',
            'shortcode' => 'Ft',
            'exchange_value' => 1]
        );
    }
}