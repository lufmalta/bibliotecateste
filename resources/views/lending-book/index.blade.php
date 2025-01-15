@extends('layouts.app')

@section('content')

    <div class="page page-lending-book index">

        <div class="card">

            <div class="card-header">
                <h4>Gerencie os empréstimos do sistema</h4>
            </div>

            <div class="card-body">
                
                @include("partials._alert")
                @include("partials._filters")

                @if (count($lendingBooks))

    				<div class="table-responsive">
    
    					<table class="table table-striped table-actions table-ordered">
    
    						<thead>
    							<tr>
    								<th data-column="id">ID</th>
    								<th data-column="user_name">Usuário</th>
                                    <th data-column="book_name">Livro</th>
                                    <th data-column="current_status_name">Status</th>
    								<th data-column="return_in">Data de devolução</th>
                                    <th data-column="delivered_at">Devolvido em</th>
                                    <th data-column="created_at">Cadastrado</th>
                                    <th>Ações</th>
    							</tr>
    						</thead>
    
    						<tbody>
    
    							@foreach ($lendingBooks as $lendingBook)
                                    <tr>
                                        <td>{{ $lendingBook->id }}</td>
                                        <td>{{ $lendingBook->user_name }}</td>
                                        <td>{{ $lendingBook->book_name }}</td>
                                        <td>{{ $lendingBook->current_status_name }}</td>
                                        <td>{{ $lendingBook->return_in->format('d/m/Y') }}</td>
                                        <td>{{ $lendingBook->delivered_at ? $lendingBook->delivered_at->format('d/m/Y H:i:s') : '-' }}</td>
                                        <td>{{ $lendingBook->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>

                                            <a href="{{ url('emprestimos/'.$lendingBook->id.'/info') }}" class="btn btn-sm btn-secondary" title="Informações do empréstimo"><i class="fas fa-list"></i></a>

                                            @if ($canDelayed)

                                                @if ($lendingBook->current_status_id == LendingBookStatusEnum::RENTED)
                                                    <button class="btn btn-warning btn-sm btn-delayed" data-message="Tem certeza que deseja marcar como atrasado o empréstimo?" data-url="{{ url('emprestimos/atrasado') }}" data-id="{{ $lendingBook->id }}" title="Marcar como atrasado"><i class="fas fa-clock"></i></button>
                                                @elseif ($lendingBook->current_status_id == LendingBookStatusEnum::DELAYED)
                                                    <button disabled="disabled" class="btn btn-sm btn-warning" title="Somente é permitido marcar como atrasado, quando o mesmo esta emprestado."><i class="fas fa-clock"></i></button>
                                                @endif

                                            @endif

                                            @if ($canReturn && in_array($lendingBook->current_status_id, [LendingBookStatusEnum::RENTED, LendingBookStatusEnum::DELAYED]))
                                                <button class="btn btn-success btn-sm btn-return" data-message="Tem certeza que deseja marcar como devolvido o empréstimo?" data-url="{{ url('emprestimos/devolver') }}" data-id="{{ $lendingBook->id }}" title="Marcar como devolvido"><i class="fas fa-check"></i></button>
                                            @endif

                                            @if ($canDelete)

                                                @if ($lendingBook->current_status_id == LendingBookStatusEnum::RETURNED)
                                                    <a href="#" data-url="{{ url('emprestimos') }}" data-id="{{ $lendingBook->id }}" class="btn btn-danger btn-sm btn-delete" title="Remover empréstimo"><i class="fas fa-trash"></i></a>
                                                @else
                                                    <button disabled="disabled" class="btn btn-sm btn-danger" title="Somente pode remover o empréstimo se o mesmo ja tiver sido devolvido."><i class="fas fa-trash"></i></button>
                                                @endif

                                            @endif

                                        </td>

                                    </tr>
    							@endforeach
    
    						</tbody>
    
    					</table>
    
    				</div>

					{{ $lendingBooks->appends(Request::except('page'))->links() }}

				@else
					<div class="obs">Nenhum registro encontrado.</div>
				@endif

            </div>

            @if ($canInsert)
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ url('emprestimos/criar') }}" title="Novo Empréstimo">Novo Empréstimo</a>
                </div>
            @endif

        </div>

    </div>

@endsection