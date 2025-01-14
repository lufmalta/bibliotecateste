<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Controller da entidade usuarios (users).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class UserController extends Controller {

    /**
     * Obtém a lista de usuários do sistema.
     *
     * @param Request $request
     */
    public function index(Request $request) {

        $group = Auth::user()->group;
        $data = $group->getAllPermissions('users');

        //Obtém a ordenação e limite por página.
        $sort = $request->sort ?? "desc";
        $column = checkOrderColumn($request->column, ['name', 'email', 'nr_serial'], 'id');
        $limit = min($request->limit_per_page ?? 10, 100);

        $users = User::search($request)->orderBy($column, $sort)->paginate($limit);
        $data['users'] = $users;

        return view('user.index', $data);

    }

    /**
     * Obtém a view para criação.
     *
     */
    public function create() {
        return $this->form(new User());
    }

    /**
     * Obtém a view para edição.
     *
     * @param [integer] $id
     */
    public function edit($id) {

        $user = User::find($id);

        if ($user) {
            return $this->form($user);
        } else {
            return redirect('usuarios')->withErrors("Usuário não encontrado.");
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
            if ($this->save($request, new User())) {
                return redirect('usuarios')->withSuccess("Usuário criado com sucesso.");
            } else {
                return back()->withErrors("Não foi possível inserir usuário, tente novamente mais tarde.")->withInput(); 
            }

        } else {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

    }

    /**
     * Altera as informações no sistema.
     *
     * @param Request $request
     */
    public function update(Request $request) {

        $validator = $this->validation($request);

        //Verifica se não falhou a validação.
        if (!$validator->fails()) {

            $user = User::find($request->id);

            if ($user) {

                //Somente se salvar com sucesso.
                if ($this->save($request, $user)) {
                    return redirect('usuarios')->withSuccess("Usuário alterado com sucesso.");
                } else {
                    return back()->withErrors("Não foi possível alterar usuário, tente novamente mais tarde.")->withInput();
                }

            } else {
                return redirect('usuarios')->withErrors("Usuário não encontrado.");
            }

        } else {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

    }

    /**
     * Remove um usuario do sistema.
     *
     * @param Request $request
     */
    public function delete(Request $request) {

        if ($request->id && is_numeric($request->id)) {

            $user = User::find($request->id);

            if ($user) {

                //Verifica se o livro esta disponível antes de remove-lo.
                if (/* deverei verificar se existe algum livro emprestado para este usuário. */true) {

                    try {
    
                        $user->delete();
                        return redirect('usuarios')->withSuccess("Usuário removido com sucesso.");
    
                    } catch (\Exception $e) {
                        Log::error("[USER] Não foi possível remover usuário, erro: ".$e->getMessage());
                        return redirect('usuarios')->withErrors("Não foi possível remover usuário, tente novamente mais tarde.");
                    }

                } else {
                    return redirect('usuarios')->withErrors("Não é possível remover o usuário quando o mesmo possuir um livro emprestado.");
                }

            } else {
                return redirect('usuarios')->withErrors("Usuário não encontrado.");
            }

        } else {
            return redirect('usuarios')->withErrors("Requisição inválida.");
        }

    }

    /**
     * Retorna o formulário para criaçao/edição de usuários.
     *
     * @param [User] $user
     */
    private function form($user) {
        $groups = Group::orderBy('name', 'asc')->get();
        return view('user.create-edit', ['groups' => $groups, 'user' => $user]);
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
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($request->id)],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
            "password" => "nullable|string|between:6,20|confirmed",
        ]);

        $validator->sometimes('id', 'required|integer|exists:users,id', function($request) {
            return $request->_method == 'PUT';
        });

        return $validator;

    }

    /**
     * Salva as informações do usuário no sistema.
     *
     * @param Request $request
     * @param User $user
     */
    private function save(Request $request, User $user) {

        try {

            DB::beginTransaction();

            $isCreate = $request->id ? false : true;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->group_id = $request->group_id;

            if ($request->password) {
    			$user->password = bcrypt($request->password);
    		}

            $user->save();
    
            if ($isCreate) {
                $user->nr_serial = getSerialCode($user->id);
                $user->save();
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[USER] Não foi possível ".($isCreate ? 'inserir' : 'alterar')." usuário, erro: ".$e->getMessage());
            return false;
        }

    }

    
}
