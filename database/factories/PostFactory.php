<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Get all available images from the public/img directory.
     *
     * @return array<string|null>
     */
    protected static function getAvailableImages(): array
    {
        $images = [null]; // Include null for posts without images
        $publicPath = public_path('img');

        if (is_dir($publicPath)) {
            // Get images from main img directory
            $mainImages = glob($publicPath.'/*.{png,jpg,jpeg,gif,webp}', GLOB_BRACE);
            foreach ($mainImages as $imagePath) {
                $images[] = '/img/'.basename($imagePath);
            }

            // Get SVG images from svg subdirectory
            $svgPath = $publicPath.'/svg';
            if (is_dir($svgPath)) {
                $svgImages = glob($svgPath.'/*.svg');
                foreach ($svgImages as $svgPath) {
                    $images[] = '/img/svg/'.basename($svgPath);
                }
            }
        }

        return $images;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $images = static::getAvailableImages();

        return [
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'title' => $title,
            'slug' => str($title)->slug().'-'.fake()->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => fake()->randomElement($images),
            'is_published' => fake()->boolean(70),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
