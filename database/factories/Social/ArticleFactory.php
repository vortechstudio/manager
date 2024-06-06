<?php

namespace Database\Factories\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Spatie\LaravelOptions\Options;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(190),
            'type' => collect(Options::forEnum(ArticleTypeEnum::class)->toArray())->random()['value'],
            'description' => $this->faker->realText(190),
            'contenue' => $this->faker->paragraph(rand(1, 5)),
            'published' => $this->faker->boolean(),
            'published_at' => Carbon::now(),
            'publish_social' => $this->faker->boolean(),
            'publish_social_at' => Carbon::now(),
            'promote' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'author' => 1,

            'cercle_id' => function () {
                return Cercle::get()->random()->id;
            },
        ];
    }
}
