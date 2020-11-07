<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'type'        => User::TYPE_ADMIN,
            'name'        => 'admin',
            'email'       => 'admin@mail.com',
            'password'    => Hash::make('password'),
            'created_by'  => 'faker',
            'updated_by' => 'faker',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()
            ->times(5)
            ->state(new Sequence(['type' => 1], ['type' => 2]))
            ->has(Post::factory()->count(10))
            ->create();
    }
}
