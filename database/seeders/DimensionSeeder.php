<?php

namespace Database\Seeders;

use App\Models\Dimension;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        Dimension::truncate();
        Schema::enableForeignKeyConstraints();

        $dimensions = [
            [
                'dimension_width' => 100,
                'dimension_length' => 300,
                'pixel_width' => 400,
                'pixel_length' => 1500,
                'pixel_count' => 600000,
            ],
            [
                'dimension_width' => 100,
                'dimension_length' => 200,
                'pixel_width' => 400,
                'pixel_length' => 1000,
                'pixel_count' => 400000,
            ],
            [
                'dimension_width' => 100,
                'dimension_length' => 400,
                'pixel_width' => 400,
                'pixel_length' => 2000,
                'pixel_count' => 800000,
            ],
            [
                'dimension_width' => 120,
                'dimension_length' => 180,
                'pixel_width' => 480,
                'pixel_length' => 900,
                'pixel_count' => 432000,
            ],
            [
                'dimension_width' => 160,
                'dimension_length' => 230,
                'pixel_width' => 640,
                'pixel_length' => 1150,
                'pixel_count' => 736000,
            ],
            [
                'dimension_width' => 200,
                'dimension_length' => 300,
                'pixel_width' => 800,
                'pixel_length' => 1500,
                'pixel_count' => 1200000,
            ],
            [
                'dimension_width' => 250,
                'dimension_length' => 350,
                'pixel_width' => 1000,
                'pixel_length' => 1750,
                'pixel_count' => 1750000,
            ],
            [
                'dimension_width' => 300,
                'dimension_length' => 400,
                'pixel_width' => 1200,
                'pixel_length' => 2000,
                'pixel_count' => 2400000,
            ]

        ];

        foreach ($dimensions as $dimension) {
            Dimension::create($dimension);
        }
    }
}
