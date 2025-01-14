<?php

namespace Database\Seeders;

use App\Models\BookGenre;
use Illuminate\Database\Seeder;

/**
 * Seeder de gêneros dos livros (books_genres).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 13/01/2025 
 * @version 1.0.0
 */
class BookGenresSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Insere os gêneros de livro no sistema.
        BookGenre::insert([
            ['name' => 'Ficção', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Romance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fantasia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aventura', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ação', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comédia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Crime', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Documentário', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drama', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Terror', 'created_at' => now(), 'updated_at' => now()]
        ]);

    }
}
