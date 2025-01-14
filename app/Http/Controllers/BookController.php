<?php

namespace App\Http\Controllers;

use App\Enums\BookSituationEnum;
use App\Models\Book;
use App\Models\BookGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Controller da entidade books (Livros).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 13/01/2025 
 * @version 1.0.0
 */
class BookController extends Controller {
    
    /**
     * Obtém a lista de livros do sistema.
     *
     * @param Request $request
     */
    public function index(Request $request) {

        $group = Auth::user()->group;
        $data = $group->getAllPermissions('books');

        //Obtém a ordenação e limite por página.
        $sort = $request->sort ?? "desc";
        $column = checkOrderColumn($request->column, ['name', 'author', 'situation_id'], 'id');
        $limit = min($request->limit_per_page ?? 10, 100);

        $books = Book::search($request)->orderBy($column, $sort)->paginate($limit);
        $data['books'] = $books;

        return view('book.index', $data);

    }

    /**
     * Obtém a view para criação.
     *
     */
    public function create() {
        return $this->form(new Book());
    }

    /**
     * Obtém a view para edição.
     *
     * @param [integer] $id
     */
    public function edit($id) {

        $book = Book::find($id);

        if ($book) {
            return $this->form($book);
        } else {
            return redirect('livros')->withErrors("Livro não encontrado.");
        }

    }

    /**
     * Insere um novo registro no sistema.
     *
     * @param Request $request
     */
    public function insert(Request $request) {

        $validator = $this->validation($request);

        //Verifica se não falhou a validação.
        if (!$validator->fails()) {

            //Somente se salvar com sucesso.
            if ($this->save($request, new Book())) {
                return redirect('livros')->withSuccess("Livro criado com sucesso.");
            } else {
                return back()->withErrors("Não foi possível inserir livro, tente novamente mais tarde.")->withInput(); 
            }

        } else {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

    }

    /**
     * Altera as informações de um livro no sistema.
     *
     * @param Request $request
     */
    public function update(Request $request) {

        $validator = $this->validation($request);

        //Verifica se não falhou a validação.
        if (!$validator->fails()) {

            $book = Book::find($request->id);

            if ($book) {

                //Somente se salvar com sucesso.
                if ($this->save($request, $book)) {
                    return redirect('livros')->withSuccess("Livro alterado com sucesso.");
                } else {
                    return back()->withErrors("Não foi possível alterar livro, tente novamente mais tarde.")->withInput();
                }

            } else {
                return redirect('livros')->withErrors("Livro não encontrado.");
            }

        } else {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

    }

    /**
     * Remove um livro do sistema.
     *
     * @param Request $request
     */
    public function delete(Request $request) {

        if ($request->id && is_numeric($request->id)) {

            $book = Book::find($request->id);

            if ($book) {

                //Verifica se o livro esta disponível antes de remove-lo.
                if ($book->situation_id == BookSituationEnum::AVAILABLE) {

                    try {
    
                        $book->delete();
                        return redirect('livros')->withSuccess("Livro removido com sucesso.");
    
                    } catch (\Exception $e) {
                        Log::error("[BOOK] Não foi possível remover livro, erro: ".$e->getMessage());
                        return redirect('livros')->withErrors("Não foi possível remover livro, tente novamente mais tarde.");
                    }

                } else {
                    return redirect('livros')->withErrors("Não é possível remover o livro quando o mesmo estiver emprestado.");
                }

            } else {
                return redirect('livros')->withErrors("Livro não encontrado.");
            }

        } else {
            return redirect('livros')->withErrors("Requisição inválida.");
        }

    }

    /**
     * Retorna o formulário para criaçao/edição de livros.
     *
     * @param [type] $book
     */
    private function form($book) {
        $bookGenres = BookGenre::orderBy('name', 'asc')->get();
        return view('book.create-edit', ['bookGenres' => $bookGenres, 'book' => $book]);
    }

    /**
     * Valida as informações da requisição.
     *
     * @param Request $request
     * @return Validator $validator
     */
    private function validation(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'author' => ['required', 'string', 'max:100'],
            'genrer_id' => ['required', 'integer', 'exists:books_genres,id']
        ]);

        $validator->sometimes('id', 'required|integer|exists:books,id', function($request) {
            return $request->_method == 'PUT';
        });

        return $validator;

    }

    /**
     * Salva as informações do livro no sistema.
     *
     * @param Request $request
     * @param Book $book
     */
    private function save(Request $request, Book $book) {

        try {

            DB::beginTransaction();

            $isCreate = $request->id ? false : true;

            $book->name = $request->name;
            $book->author = $request->author;
            $book->genrer_id = $request->genrer_id;
            $book->save();
    
            if ($isCreate) {
                $book->nr_serial = getSerialCode($book->id);
                $book->save();
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[BOOK] Não foi possível ".($isCreate ? 'inserir' : 'alterar')." livro, erro: ".$e->getMessage());
            return false;
        }

    }

}
