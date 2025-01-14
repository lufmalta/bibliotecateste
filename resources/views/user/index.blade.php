@extends('layouts.app')

@section('content')

    <div class="page page-user index">

        <div class="card">

            <div class="card-header">
                <h4>Gerencie os usuários do sistema</h4>
            </div>

            <div class="card-body">
                
                @include("partials._filters")

                @if (count($users))

    				<div class="table-responsive">
    
    					<table class="table table-striped table-actions table-ordered">
    
    						<thead>
    							<tr>
    								<th data-column="id">ID</th>
    								<th data-column="name">Nome</th>
                                    <th data-column="group_name">Grupo</th>
                                    <th data-column="email">Email</th>
                                    <th data-column="nr_serial">Número Cadastro</th>
    								<th data-column="created_at">Cadastro</th>
                                    @if ($canUpdate || $canDelete)
    								    <th>Ações</th>
                                    @endif
    							</tr>
    						</thead>
    
    						<tbody>
    
    							@foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->group_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nr_serial }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                                        @if ($canUpdate || $canDelete)
                                            <td>

                                                @if ($canUpdate)
                                                    <a href="{{ url('usuarios/'.$user->id.'/editar') }}" class="btn btn-sm btn-primary" title="Editar usuário"><i class="fas fa-pencil"></i></a>
                                                @endif

                                                @if ($canDelete)

                                                    {{-- TODO deverei verificar se existe algum emprestimo de livro com este usuário e que o mesmo ainda não esta disponivel $user->situation_id == BookSituationEnum::AVAILABLE --}}
                                                    @if (true)
                                                        <a href="#" data-url="{{ url('usuarios') }}" data-id="{{ $user->id }}" class="btn btn-danger btn-sm btn-delete" title="Remover usuário"><i class="fas fa-trash"></i></a>
                                                    @else
                                                        <button disabled="disabled" class="btn btn-danger btn-icon-only" title="Existem empréstimos de livros relacionadas a este usuário."><i class="fas fa-trash"></i></button>
                                                    @endif

                                                @endif

                                            </td>

                                        @endif
                                    </tr>
    							@endforeach
    
    						</tbody>
    
    					</table>
    
    				</div>

					{{ $users->appends(Request::except('page'))->links() }}

				@else
					<div class="obs">Nenhum registro encontrado.</div>
				@endif

            </div>

            @if ($canInsert)
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ url('usuarios/criar') }}" title="Novo Usuário">Novo Usuário</a>
                </div>
            @endif

        </div>

    </div>

@endsection