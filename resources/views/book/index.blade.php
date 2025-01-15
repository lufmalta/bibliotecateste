@extends('layouts.app')

@section('content')

    <div class="page page-book index">

        <div class="card">

            <div class="card-header">
                <h4>Gerencie os livros do sistema</h4>
            </div>

            <div class="card-body">
                
                @include("partials._alert")
                @include("partials._filters")

                @if (count($books))

    				<div class="table-responsive">
    
    					<table class="table table-striped table-actions table-ordered">
    
    						<thead>
    							<tr>
    								<th data-column="id">ID</th>
    								<th data-column="name">Nome</th>
                                    <th data-column="nr_serial">Número Cadastro</th>
                                    <th data-column="situation_id">Situação</th>
    								<th data-column="created_at">Cadastro</th>
                                    @if ($canUpdate || $canDelete)
    								    <th>Ações</th>
                                    @endif
    							</tr>
    						</thead>
    
    						<tbody>
    
    							@foreach ($books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->name }}</td>
                                        <td>{{ $book->nr_serial }}</td>
                                        <td>{{ BookSituationEnum::getName($book->situation_id) }}</td>
                                        <td>{{ $book->created_at->format('d/m/Y H:i:s') }}</td>
                                        @if ($canUpdate || $canDelete)
                                            <td>

                                                {{-- <a href="{{ url('livros/'.$book->id.'/info') }}" data-id="{{ $book->id }}" class="btn btn-secondary btn-icon-only" title="Informações do usuário"><i class="flaticon-list"></i></a> --}}

                                                {{-- TODO Ate pensei em não permitir editar se o livro estiver emprestado, mas como não foi solicitado isto vou permitir funcionar normalmente. --}}
                                                @if ($canUpdate)
                                                    <a href="{{ url('livros/'.$book->id.'/editar') }}" class="btn btn-sm btn-primary" title="Editar livro"><i class="fas fa-pencil"></i></a>
                                                @endif

                                                @if ($canDelete)

                                                    @if ($book->situation_id == BookSituationEnum::AVAILABLE)
                                                        <a href="#" data-url="{{ url('livros') }}" data-id="{{ $book->id }}" class="btn btn-danger btn-sm btn-delete" title="Remover livro"><i class="fas fa-trash"></i></a>
                                                    @else
                                                        <button disabled="disabled" class="btn btn-danger btn-sm btn-icon-only" title="Existem empréstimos relacionadas a este livro."><i class="fas fa-trash"></i></button>
                                                    @endif

                                                @endif

                                            </td>

                                        @endif
                                    </tr>
    							@endforeach
    
    						</tbody>
    
    					</table>
    
    				</div>

					{{ $books->appends(Request::except('page'))->links() }}

				@else
					<div class="obs">Nenhum registro encontrado.</div>
				@endif

            </div>

            @if ($canInsert)
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ url('livros/criar') }}" title="Novo Livro">Novo Livro</a>
                </div>
            @endif

        </div>

    </div>

@endsection