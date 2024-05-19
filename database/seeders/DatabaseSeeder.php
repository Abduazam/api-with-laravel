<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\Auth\PermissionsSeeder;
use Database\Seeders\Auth\RolesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RolesSeeder::class, PermissionsSeeder::class,]);

        $users = User::factory(10)->create();

        foreach ($users as $user) {
            $user->assignRole('user');
        }

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        Ticket::factory(50)->recycle($users)->create();
    }
}
