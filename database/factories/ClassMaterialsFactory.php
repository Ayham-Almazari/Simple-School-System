<?php

namespace Database\Factories;

use App\Models\ClassMaterials;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassMaterialsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassMaterials::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "material"=>$this->faker->filePath(),
            "material_description"=>$this->faker->text
        ];
    }
}
