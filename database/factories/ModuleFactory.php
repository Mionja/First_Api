<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name()                 ,
            'code'=>$this->faker->randomElement(['INFO_120','INFO_210','INFO_300','INFO_150','MATH_120','MATH_220','ENTR_120','ENTR_220'])          ,
            'hour'=>$this->faker->randomElement([8, 10, 24])    
        ];
    }
}
