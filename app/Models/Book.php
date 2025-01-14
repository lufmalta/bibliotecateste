<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model da entidade livros (books).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class Book extends Model {

    protected $table = "books";

    /**
     * Obtém os livros do sistema, aplicando os filtros.
     *
     * @param [Eloquent] $query
     * @param [Request] $request
     * @return $query
     */
    public function scopeSearch($query, $request = null) {

        $query->select("bk.*")->from("books as bk")
            ->join("books_genres as bkg", "bkg.id", "bk.genrer_id");

        if ($request) {

            if ($request->search) {

                $search = trim($request->search);

                //Insere as condições where nas colunas pela pesquisa.
                getWheresQuery($query, $search, ['bk.name', 'bk.author', 'bkg.name']);

            }

        }

        return $query;

    }
    
}
