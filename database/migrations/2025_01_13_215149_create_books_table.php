<?php

use App\Enums\BookSituationEnum;
use App\Models\BookGenre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration da entidade livros (books).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 13/01/2025 
 * @version 1.0.0
 */
class CreateBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name', 100);
            $table->string('author', 100);
            $table->string('nr_serial', 20)->nullable()->unique();
            $table->integer('situation_id')->default(BookSituationEnum::AVAILABLE);
            $table->unsignedInteger('genrer_id');
            $table->timestamps();

            $table->foreign('genrer_id')->references('id')->on('books_genres');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
