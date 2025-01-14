<?php

namespace Database\Seeders;

use App\Enums\GroupEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para usuários.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 13/01/2025 
 * @version 1.0.0
 */
class UserSeeder extends Seeder {

    /**
     * Cria os usuários fixos para a aplicação.
     *
     * @return void
     */
    public function run() {

        //Insere os usuários na tabela de usuários.
        User::insert([
            ['name' => 'Luiz Fernando', 'email' => 'lufmalta@gmail.com', 'password' => bcrypt('teste'), 'group_id' => GroupEnum::ADMIN, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Helio', 'email' => 'helio@appfacilita.com', 'password' => bcrypt('teste'), 'group_id' => GroupEnum::ADMIN, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Atendente', 'email' => 'atendente@gmail.com', 'password' => bcrypt('teste'), 'group_id' => GroupEnum::ATTENDANT, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Usuario biblioteca', 'email' => 'usuariobiblioteca@gmail.com', 'password' => bcrypt('teste'), 'group_id' => GroupEnum::LIBRARY_USER, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
