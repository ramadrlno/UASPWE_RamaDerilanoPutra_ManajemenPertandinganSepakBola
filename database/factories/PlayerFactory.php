<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Tentukan model yang terkait dengan factory ini.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Definisikan keadaan default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Nama pemain
            'position' => $this->faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']), // Posisi pemain
            'team' => $this->faker->randomElement(['Blue Lock', 'Japan National Team']), // Tim pemain
            'age' => $this->faker->numberBetween(16, 30), // Umur pemain
            'jersey_number' => $this->faker->unique()->numberBetween(1, 30), // Nomor punggung
            'image' => $this->faker->imageUrl(640, 480, 'people'), // URL gambar pemain
            'user_id' => User::factory(), // Menggunakan factory User untuk menghubungkan dengan pengguna
        ];
    }
}
