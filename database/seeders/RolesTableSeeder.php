<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'created_at' => '2026-07-26 02:16:16',
                'updated_at' => '2026-07-26 02:16:16',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Administrador Estoque',
                'display_name' => 'ADM CAP',
                'created_at' => '2026-07-26 02:16:16',
                'updated_at' => '2026-07-26 02:26:32',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Usuario Estoque',
                'display_name' => 'Usuario Estoque',
                'created_at' => '2026-07-26 02:27:28',
                'updated_at' => '2026-07-26 02:27:28',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Responsavel do estoque',
                'display_name' => 'Responsavel do estoque',
                'created_at' => '2026-07-26 18:09:00',
                'updated_at' => '2026-07-26 18:09:00',
            ),
        ));
        
        
    }
}