<?php

namespace Database\Seeders;

use App\Enums\GroupEnum;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder de grupos para usuários.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class GroupSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        //Obtém os grupos e insere na base.
        $groups = GroupEnum::get()->toArray();

        Group::insert($groups);

    }
}
