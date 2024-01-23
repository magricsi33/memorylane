<?php namespace LivestudioDev\Lscart\Updates;

use Seeder;
use LivestudioDev\Lscart\Models\Measure;

class SeedMeasures extends Seeder
{
    public function run()
    {
        $measure = Measure::firstOrCreate(
            ['name' => 'db']
        );
    }
}