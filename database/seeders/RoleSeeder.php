<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Academic Head', 'Academic Staff'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

    }
}
