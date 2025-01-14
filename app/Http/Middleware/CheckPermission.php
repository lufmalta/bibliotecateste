<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware responsável por checar a permissão do usuário autenticado para acessar uma funcionalidade.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class CheckPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {

        //Obtém a permissão da rota.
        $permission = $request->route()->getAction('permission');
        
        $group = Auth::user()->group;

        //Verifica se o grupo informado possui a permissão para acesso.
        if ($group->verifyPermission($permission)) {
            return $next($request);
        }

        abort(401);

    }
}
