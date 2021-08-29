<?php

namespace Database\Seeders;

use Exception;
use App\Models\Ad;
use App\Models\Image;
use Illuminate\Database\Seeder;

/**
 * Class AdTableSeeder
 * @package Database\Seeders
 */
class AdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        Ad::factory()->count(100)->create()
            ->each(function (Ad $ad) {
                Image::factory()
                    ->count(random_int(1, 3))
                    ->create(['ad_id' => $ad->id]);
            });
    }
}
