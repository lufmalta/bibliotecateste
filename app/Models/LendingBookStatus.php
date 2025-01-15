<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model da entidade status empréstimos livros (lending_book_statuses).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class LendingBookStatus extends Model {

    protected $table = "lending_books_statuses";
    public $timestamps = false;
    
}
