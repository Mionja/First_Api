<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name()    ,
            'email'=>$this->faker->safeEmail()   ,
            'age'=>$this->faker->randomElement([18, 19, 20, 21])  ,
            'gender'=>$this->faker->randomElement(['M', 'F'])  ,
            // 'grade'=>$this->faker->randomElement(['L1', 'L2', 'L3', 'M1', 'M2'])  ,
            // 'group'=>$this->faker->randomElement(['G1', 'G2'])  ,
        ];
    }
}
