<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AdFactory
 * @package Database\Factories
 */
class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title'       => $this->faker->word,
            'description' => $this->faker->text(500),
            'user_id' => User::all()->pluck('id')->random(),
        ];
    }
}
