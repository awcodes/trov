<?php

namespace Database\Factories;

use Trov\Models\Meta;
use App\Models\DiscoveryTopic;
use FilamentCurator\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscoveryTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscoveryTopic::class;

    /**
     * Indicate that the model is in review status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inReview()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Review',
            ];
        });
    }

    /**
     * Indicate that the model is in published status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Published',
                'published_at' => now()->subDays(rand(0, 365)),
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(1, 8));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => 'Draft',
            'content' => [
                [
                    'full_width' => false,
                    'bg_color' => '',
                    'blocks' => [
                        [
                            "type" => "rich-text",
                            "data" => [
                                "content" => '<h1>' . Str::title($this->faker->words(rand(3, 8), true)) . '</h1><p>' . collect($this->faker->paragraphs(rand(1, 6)))->implode('</p><p>') . '</p><h2>' . Str::title($this->faker->words(rand(3, 8), true)) . '</h2><p>' . collect($this->faker->paragraphs(rand(1, 6)))->implode('</p><p>') . '</p>',
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
}
