<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_permissions')->insert([
            [
                'role_id' => 1,
                'name' => 'user.view',
                'description' => 'view User',
                'created_at' => now(),
                'updated_at' => now(),
            ],  [
                'role_id' => 1,
                'name' => 'dashboard',
                'description' => 'access Module',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
