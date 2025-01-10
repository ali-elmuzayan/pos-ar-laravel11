<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Use predefined Arabic category names
        $arabicNames = [
            'ملابس', 'أثاث', 'إلكترونيات', 'كتب', 'ألعاب',
            'أطعمة', 'أدوات منزلية', 'مجوهرات', 'رياضة', 'أدوات مكتبية'
        ];
        return [
//            'name' => $this->faker->unique()->word,
        'name' => $this->faker->unique()->randomElement($arabicNames),
        ];
    }
}
