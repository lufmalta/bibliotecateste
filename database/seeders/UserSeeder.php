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
        $users = [
            ['name' => 'Helio', 'email' => 'helio@appfacilita.com', 'group_id' => GroupEnum::ADMIN],
            ['name' => 'Luiz Fernando', 'email' => 'lufmalta@gmail.com', 'group_id' => GroupEnum::ADMIN],
            ['name' => 'Atendente', 'email' => 'atendente@gmail.com', 'group_id' => GroupEnum::ATTENDANT],
            ['name' => 'Usuario biblioteca', 'email' => 'usuariobiblioteca@gmail.com', 'group_id' => GroupEnum::LIBRARY_USER],
        ];

        foreach ($users as $us) {

            $user = new User();
            $user->name = $us['name'];
            $user->email = $us['email'];
            $user->password = bcrypt('teste');
            $user->group_id = $us['group_id'];
            $user->save();
            $user->nr_serial = getSerialCode($user->id);
            $user->save();

        }
        
        
    }
}
