<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Category;
use App\Models\Size;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Roles
        $adminRole = Role::create(['name' => 'admin']);
        $ownerRole = Role::create(['name' => 'owner']);
        $kasirRole = Role::create(['name' => 'kasir']);
        $pelangganRole = Role::create(['name' => 'pelanggan']);

        // Seed Categories
        Category::create(['name' => 'Skinny Jeans', 'slug' => 'skinny-jeans']);
        Category::create(['name' => 'Slim Fit', 'slug' => 'slim-fit']);
        Category::create(['name' => 'Regular Fit', 'slug' => 'regular-fit']);

        // Seed Sizes
        foreach (['28', '29', '30', '31', '32', '33', '34'] as $size) {
            Size::create(['name' => $size]);
        }

        // Seed Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@awenkjeans.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        // Seed Kasir User
        User::create([
            'name' => 'Kasir Awenk',
            'email' => 'kasir@awenkjeans.com',
            'password' => bcrypt('password'),
            'role_id' => $kasirRole->id,
        ]);
    }
}
