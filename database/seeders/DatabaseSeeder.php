<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(RolesTableSeeder::class);
        //$this->call(PermissionsTableSeeder::class);
        //$this->call(PermissionRoleTableSeeder::class);
        $this->call(DataTypesTableSeeder::class);
        $this->call(DataRowsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ProdutoSeeder::class);
        \DB::table("users")->where("email", "=", "alonso_fon@hotmail.com")->update([
            "role_id" => 1
        ]);
    }
}
