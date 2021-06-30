<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'class_name'=>$this->faker->word(),
            'class_description'=>$this->faker->text,
        ];
    }
}
