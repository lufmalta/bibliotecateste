<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model da entidade  histórico status empréstimo livro (lending_books_status_history)
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class LendingBookStatusHistory extends Model {

    protected $table = "lending_books_status_history";
    public $timestamps = false;
    public $casts = [
        'created_at' => 'datetime'
    ];

}
