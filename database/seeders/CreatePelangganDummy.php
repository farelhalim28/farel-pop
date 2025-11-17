<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan; // <- ini penting

class CreatePelangganDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Generate 1000 pelanggan
        for ($i = 1; $i <= 1000; $i++) {
            $gender = $faker->randomElement(['Male', 'Female', 'Other']);

            Pelanggan::create([
                'first_name' => $faker->firstName($gender === 'Male' ? 'male' : 'female'),
                'last_name' => $faker->lastName,
                'birthday' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'gender' => $gender,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('1000 Pelanggan berhasil di-seed!');
    }
}

