<?php

namespace Database\Seeders;

use App\Enums\BookSituationEnum;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookGenre;
use Faker\Factory as Faker;

class BookSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Criar uma instância do Faker
        $faker = Faker::create();
        $books = [];

        // Gerar 10 livros com dados fictícios
        foreach (range(1, 50) as $index) {

            $booksGenre = BookGenre::inRandomOrder()->first();

            $book = Book::create([
                'name' => $faker->sentence,
                'author' => $faker->name,
                'situation_id' => BookSituationEnum::AVAILABLE,
                'genrer_id' => $booksGenre->id,
            ]);

            array_push($books, $book);

        }

        foreach ($books as $book) {
            $book->nr_serial = getSerialCode($book->id);
            $book->save();
        }

    }
}
