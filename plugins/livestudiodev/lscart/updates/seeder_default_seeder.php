<?php namespace LivestudioDev\Lscart\Updates;

use Seeder;
use Model;
use LivestudioDev\Lscart\Updates\SeedVatkeys;
use LivestudioDev\Lscart\Updates\SeedMeasures;
use LivestudioDev\Lscart\Updates\SeedCurrencies;

class SeederDefaultSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(SeedVatkeys::class);
        $this->call(SeedMeasures::class);
        $this->call(SeedCurrencies::class);
    }
}