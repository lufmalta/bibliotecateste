<?php

namespace App\Http\Controllers;

use App\Enums\BookSituationEnum;
use App\Enums\GroupEnum;
use App\Enums\LendingBookStatusEnum;
use App\Models\Book;
use App\Models\LendingBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Controller da entidade empréstimos livros (lending_books)
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class LendingBookController extends Controller {

    /**
     * Obtém a lista de empréstimos do sistema.
     *
     * @param Request $request
     */
    public function index(Request $request) {

        $group = Auth::user()->group;
        $data = $group->getAllPermissions('lending-books', ['insert', 'delete', 'delayed', 'return']);

        //Obtém a ordenação e limite por página.
        $sort = $request->sort ?? "desc";
        $column = checkOrderColumn($request->column, ['user_name', 'book_name', 'current_status_name'], 'id');
        $limit = min($request->limit_per_page ?? 10, 100);

        $lendingBooks = LendingBook::search($request)->orderBy($column, $sort)->paginate($limit);
        $data['lendingBooks'] = $lendingBooks;

        return view('lending-book.index', $data);

    }

    /**
     * Obtém a view para criação.
     *
     */
    public function create() {
        return view('lending-book.create', new LendingBook());
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
            if ($this->save($request, new LendingBook())) {
                return redirect('emprestimos')->withSuccess("Empréstimo criado com sucesso.");
            } else {
                return back()->withErrors("Não foi possível inserir empréstimo, tente novamente mais tarde.")->withInput(); 
            }

        } else {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

    }

    /**
     * Remove um empréstimo do sistema.
     *
     * @param Request $request
     */
    public function delete(Request $request) {

        if ($request->id && is_numeric($request->id)) {

            $lendingBook = LendingBook::find($request->id);

            if ($lendingBook) {

                //Somente deverá permitir remover se o status ja estiver como devolvido.
                if ($lendingBook->current_status_id == LendingBookStatusEnum::RETURNED) {

                    try {
    
                        $lendingBook->delete();
                        return redirect('emprestimos')->withSuccess("Empréstimo removido com sucesso.");
    
                    } catch (\Exception $e) {
                        Log::error("[LENDING-BOOK] Não foi possível remover empréstimo livro, erro: ".$e->getMessage());
                        return redirect('emprestimos')->withErrors("Não foi possível remover empréstimo livro, tente novamente mais tarde.");
                    }

                } else {
                    return redirect('emprestimos')->withErrors("Não é possível remover o empréstimo do livro quando o mesmo estiver alugado/atrasado.");
                }

            } else {
                return redirect('emprestimos')->withErrors("Empréstimo não encontrado.");
            }

        } else {
            return redirect('emprestimos')->withErrors("Requisição inválida.");
        }

    }

    /**
     * Obtém as informações do empréstimo.
     *
     * @param [type] $id
     */
    public function info($id) {

        $lendingBook = LendingBook::find($id);

        if ($lendingBook) {
            return view('lending-book.info', ['lendingBook' => $lendingBook]);
        } else {
            return redirect('emprestimos')->withErrors("Empréstimo não encontrado.");
        }

    }

    /**
     * Marca como atrasado o empréstimo.
     *
     * @param Request $request
     */
    public function delayed(Request $request) {

        if ($request->id && is_numeric($request->id)) {

            $lendingBook = LendingBook::find($request->id);

            if ($lendingBook) {

                if ($lendingBook->current_status_id == LendingBookStatusEnum::RENTED) {

                    try {

                        DB::beginTransaction();

                        $lendingBook->current_status_id = LendingBookStatusEnum::DELAYED;
                        $lendingBook->save();

                        $lendingBook->statusHistory()->insert([
                            'lending_book_id' => $lendingBook->id,
                            'status_id' => LendingBookStatusEnum::DELAYED
                        ]);

                        DB::commit();
                        return redirect('emprestimos')->withSuccess("Empréstimo marcado como atrasado com sucesso.");

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("[LENDING-BOOK] Não foi possível marcar como atrasado no empréstimo, erro: ".$e->getMessage());
                        return redirect('emprestimos')->withErrors("Não foi possível marcar como atrasado o empréstimo, tente novamente mais tarde.");
                    }

                } else {
                    return redirect('emprestimos')->withErrors("Somente empréstimos que ainda não estão no status atrasado/devolvido que podem tomar esta ação.");
                }

            } else {
                return redirect('emprestimos')->withErrors("Empréstimo não encontrado.");
            }

        } else {
            return redirect('emprestimos')->withErrors("Requisição inválida.");
        }

    }

    /**
     * Marca como devolvido o empréstimo. 
     *
     * @param Request $request
     */
    public function returnBook(Request $request) {

        if ($request->id && is_numeric($request->id)) {

            $lendingBook = LendingBook::find($request->id);

            if ($lendingBook) {

                if (in_array($lendingBook->current_status_id, [LendingBookStatusEnum::RENTED, LendingBookStatusEnum::DELAYED])) {

                    try {

                        DB::beginTransaction();

                        $lendingBook->current_status_id = LendingBookStatusEnum::RETURNED;
                        $lendingBook->delivered_at = now();
                        $lendingBook->save();

                        $lendingBook->book()->update(['situation_id' => BookSituationEnum::AVAILABLE]);

                        $lendingBook->statusHistory()->insert([
                            'lending_book_id' => $lendingBook->id,
                            'status_id' => LendingBookStatusEnum::RETURNED
                        ]);

                        DB::commit();
                        return redirect('emprestimos')->withSuccess("Empréstimo marcado como devolvido com sucesso.");

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("[LENDING-BOOK] Não foi possível marcar como devolvido o empréstimo, erro: ".$e->getMessage());
                        return redirect('emprestimos')->withErrors("Não foi possível marcar como devolvido o empréstimo, tente novamente mais tarde.");
                    }

                } else {
                    return redirect('emprestimos')->withErrors("Somente empréstimos que estão no status emprestado/atrasado que podem tomar esta ação.");
                }

            } else {
                return redirect('emprestimos')->withErrors("Empréstimo não encontrado.");
            }

        } else {
            return redirect('emprestimos')->withErrors("Requisição inválida.");
        }

    }

    /**
     * Obtém os usuários da biblioteca para o formulário do empréstimo.
     *
     * @param Request $request
     */
    public function getUsers(Request $request) {
        $users = User::getLibraryUsers($request)->limit(50)->get();
        return response($users, Response::HTTP_OK);
    }

    /**
     * Obtém os livros da biblioteca disponíveis para empréstimo.
     *
     * @param Request $request
     */
    public function getBooks(Request $request) {

        $books = Book::getBooksToLending($request)->limit(50)->get();

        // Eu sei que o default é o http_ok, apenas estou mostrando que também sei como retornar dados para api.
        return response($books, Response::HTTP_OK);

    }

    /**
     * Obtém a view index para visualização dos livros emprestados pelo usuário biblioteca.
     *
     */
    public function indexBookForUsers(Request $request) {

        $user = Auth::user();
        $group = $user->group;

        //Verifica se o grupo é usuário biblioteca, porque por enquanto apenas este grupo poderá acessar esta tela.
        if ($group->id == GroupEnum::LIBRARY_USER) {

            $lendingBooks = LendingBook::getToIndexBookForUser($user->id, $request)->paginate(10);
            return view("user.lending-book-index", ['lendingBooks' => $lendingBooks]);

        } else {
            return redirect('/')->withErrors("Somente usuários biblioteca possuem acesso a esta tela.");
        }

    }

    /**
     * Valida as informações da requisição.
     *
     * @param Request $request
     * @return Validator $validator
     */
    private function validation(Request $request) {

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'book_id' => ['required', 'integer'],
            'return_in' => ['required', 'string', 'date_format:Y-m-d']
        ]);

        $validator->after(function($validator) use ($request) {

            if ($request->book_id) {

                $book = Book::find($request->book_id);

                //Caso não encontre o livro informado.
                if (!$book) {
                    $validator->errors()->add('book_id', "Livro não encontrado.");
                    return false;
                }

                //Caso o livro ja estiver emprestado.
                if ($book->situation_id == BookSituationEnum::BORROWED) {
                    $validator->errors()->add('book_id', "O Livro solicitado ja esta emprestado");
                    return false;
                }

            }

            if ($request->user_id) {

                $user = User::find($request->user_id);

                if (!$user) {
                    $validator->errors()->add('user_id', "O usuário não foi encontrado.");
                    return false;
                }

                //Deverá barrar quando informar algum usuário que não seja da biblioteca.
                if ($user->group_id != GroupEnum::LIBRARY_USER) {
                    $validator->errors()->add('user_id', "Somente é permitido usuários da biblioteca.");
                    return false;
                }

            }


        });
        
        return $validator;

    }

    /**
     * Salva as informações do livro no sistema.
     *
     * @param Request $request
     * @param LendingBook $lendingBook
     */
    private function save(Request $request, LendingBook $lendingBook) {

        try {

            DB::beginTransaction();

            $lendingBook->user_id = $request->user_id;
            $lendingBook->book_id = $request->book_id;
            $lendingBook->current_status_id = LendingBookStatusEnum::RENTED;
            $lendingBook->return_in = Carbon::createFromFormat('Y-m-d', $request->return_in);
            $lendingBook->save();

            //Altera a situação do livro para emprestado.
            $lendingBook->book()->update(['situation_id' => BookSituationEnum::BORROWED]);

            //Insere o status atual no histórico.
            $lendingBook->statusHistory()->insert([
                'lending_book_id' => $lendingBook->id,
                'status_id' => LendingBookStatusEnum::RENTED
            ]);

            DB::commit();
    
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[LENDING-BOOK] Não foi possível criar empréstimo, erro: ".$e->getMessage());
            return false;
        }

    }

    
}
