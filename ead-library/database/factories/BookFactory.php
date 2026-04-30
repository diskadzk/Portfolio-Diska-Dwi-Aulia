<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $categories = ['Novel', 'Teknologi', 'Sains', 'Bisnis', 'Referensi'];

        return [
            'title' => fake()->unique()->sentence(3),
            'author' => fake()->name(),
            'category' => fake()->randomElement($categories),
            'published_year' => fake()->numberBetween(1995, now()->addYear()->year),
            'stock' => fake()->numberBetween(0, 25),
            'summary' => fake()->optional()->paragraph(),
        ];
    }
}