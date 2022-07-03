<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                'nama' => 'admin',
                'keterangan' => 'Role Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'sekretaris',
                'keterangan' => 'Role Sekretaris',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
