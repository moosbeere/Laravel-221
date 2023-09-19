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
            'name' => $this->faker->sentence(),
            'short_desc' => $this->faker->paragraph(),
            'desc' => $this->faker->text(),
            'author_id' => '1'
        ];
    }
}
