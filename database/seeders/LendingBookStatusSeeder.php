<?php

namespace Database\Seeders;

use App\Enums\LendingBookStatusEnum;
use App\Models\LendingBookStatus;
use Illuminate\Database\Seeder;

/**
 * Seeder de status de empréstimos de livros.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class LendingBookStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Obtém os status de empréstimos de livros do enum e insere no banco.
        $lendingBookStatuses = LendingBookStatusEnum::get()->toArray();
        LendingBookStatus::insert($lendingBookStatuses);

    }
}
