<?php namespace LivestudioDev\Lscart\Updates;

use Seeder;
use LivestudioDev\Lscart\Models\VatKey;

class SeedVatkeys extends Seeder
{
    public function run()
    {
        $vatkey = VatKey::firstOrCreate(
            ['name' => 'Áfa'],
            ['value'  => 27]
        );
    }
}