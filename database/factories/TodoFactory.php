<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'todo' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        Temporibus in dolores accusamus expedita? Reiciendis deleniti suscipit quam deserunt, 
                        temporibus consequatur, 
                        minima consequuntur aspernatur enim maiores accusamus inventore architecto, totam facilis.',
        ];
    }

    /**
     * Indicate that the todo has been completed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function completed($status)
    {
        return $this->state(function (array $attributes) use ($status) {
            return [
                'completed' => $status,
            ];
        });
    }
}
