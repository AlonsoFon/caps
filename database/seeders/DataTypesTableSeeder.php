<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2026-07-26 02:16:15',
                'updated_at' => '2026-07-26 22:37:42',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2026-07-26 02:16:15',
                'updated_at' => '2026-07-26 02:16:15',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2026-07-26 02:16:15',
                'updated_at' => '2026-07-26 22:13:12',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'produtos',
                'slug' => 'produtos',
                'display_name_singular' => 'Produto',
                'display_name_plural' => 'Produtos',
                'icon' => 'voyager-lab',
                'model_name' => 'App\\Models\\Produto',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2026-07-26 17:39:00',
                'updated_at' => '2026-07-26 17:39:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'estoques',
                'slug' => 'estoques',
                'display_name_singular' => 'Estoque',
                'display_name_plural' => 'Estoques',
                'icon' => 'voyager-shop',
                'model_name' => 'App\\Models\\Estoque',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2026-07-26 17:41:12',
                'updated_at' => '2026-07-26 17:45:13',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'pedidos',
                'slug' => 'pedidos',
                'display_name_singular' => 'Pedido',
                'display_name_plural' => 'Pedidos',
                'icon' => 'voyager-bag',
                'model_name' => 'App\\Models\\Pedido',
                'policy_name' => NULL,
                'controller' => 'App\\Http\\Controllers\\Voyager\\PedidosController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2026-07-26 18:06:14',
                'updated_at' => '2026-07-26 19:49:40',
            ),
        ));
        
        
    }
}