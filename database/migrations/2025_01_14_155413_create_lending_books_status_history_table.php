<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration da entidade histórico status empréstimo livros (lending_books_status_history).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class CreateLendingBooksStatusHistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lending_books_status_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lending_book_id');
            $table->integer('status_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('lending_book_id')->references('id')->on('lending_books')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('lending_books_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lending_books_status_history');
    }
}
