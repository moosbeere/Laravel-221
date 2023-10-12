<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'title' => $this->faker->sentence(),
            'shortDesc' => $this->faker->paragraph(),
            'text' => $this->faker->text(),
            'user_id' => $this->faker->randomDigitNotNull(),
        ];
    }
}
