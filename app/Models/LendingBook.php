<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingBook extends Model {

    protected $table = "lending_books";

    public $casts = [
        'return_in' => 'date',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function book() {
        return $this->belongsTo('App\Models\Book');
    }

    /**
     * Obtém o histórico de status do empréstimos de livros
     *
     */
    public function statusHistory() {
        return $this->hasMany('App\Models\LendingBookStatusHistory', 'lending_book_id', 'id');
    }

    /**
     * Obtém a lista de empréstimos de livros do sistema
     *
     * @param [Eloquent] $query
     * @param [Request] $request
     */
    public function scopeSearch($query, $request = null) {

        $query->select("lb.*", "u.name as user_name", "bk.name as book_name", "lbs.name as current_status_name")
            ->from("lending_books as lb")
            ->join("users as u", "u.id", "lb.user_id")
            ->join("books as bk", "bk.id", "lb.book_id")
            ->join("lending_books_statuses as lbs", "lbs.id", "lb.current_status_id");

        //Caso exista a request, aplica os filtros que forem informados.
        if ($request) {

            if ($request->search) {

                $search = trim($request->search);
                getWheresQuery($query, $search, ["bk.name", "u.name", "u.email", "lbs.name", "bk.nr_serial"]);

            }

            if ($request->user_id) {
                $query->where("lb.user_id", $request->user_id);
            }

            if ($request->book_id) {
                $query->where("lb.book_id", $request->book_id);
            }

            if ($request->status_id) {
                $query->where("lb.current_status_id", $request->status_id);
            }

        }

        return $query;

    }

    /**
     * Obtém os livros emprestados do usuário informado.
     *
     * @param [Eloquent] $query
     * @param [integer] $userId
     */
    public function scopeGetToIndexBookForUser($query, $userId, $request = null) {

        $query->select("lb.*", "bk.name as book_name", "bk.author", "bk.nr_serial", "lbs.name as current_status_name")
            ->from("lending_books as lb")
            ->join("books as bk", "bk.id", "lb.book_id")
            ->join("lending_books_statuses as lbs", "lbs.id", "lb.current_status_id")
            ->where("lb.user_id", $userId)
            ->orderBy('lb.created_at', 'desc');

        if ($request->search) {

            $search = trim($request->search);
            getWheresQuery($query, $search, ["bk.name", "lbs.name", "bk.nr_serial"]);

        }

        return $query;

    }

}
