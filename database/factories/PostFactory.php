<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
// use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $seed = $this->faker->unique()->slug();
    $imageUrl = "https://picsum.photos/seed/{$seed}/800/600";

    return [
      'user_id' => User::factory(),
      'image' => $imageUrl,
      'title' => $this->faker->sentence(),
      'slug' => $this->faker->unique()->slug(3),
      'body' => $this->faker->paragraphs(10, true),
      'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 week'),
      'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
    ];
  }
}
