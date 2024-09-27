<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name'              => 'User 1',
            'email'             => 'user1@example.com',
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ]);

        User::factory()->create([
            'name'              => 'User 2',
            'email'             => 'user2@example.com',
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ]);

        User::factory()->create([
            'name'              => 'User 3',
            'email'             => 'user3@example.com',
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ]);

        $this->call(ProjectSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(SubtaskSeeder::class);
    }
}
