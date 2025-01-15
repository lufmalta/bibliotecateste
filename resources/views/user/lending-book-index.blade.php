@extends('layouts.app')

@section('content')

    <div class="page page-lending-book-user index">

        <div class="card">

            <div class="card-header">
                <h4>Visualize os empréstimos realizados no sistema</h4>
            </div>

            <div class="card-body">
                
                @include("partials._filters")

                @if (count($lendingBooks))

    				<div class="table-responsive">
    
    					<table class="table table-striped table-actions table-ordered">
    
    						<thead>
    							<tr>
    								<th data-column="id">ID</th>
                                    <th data-column="book_name">Livro</th>
                                    <th data-column="nr_serial">Número de Cadastro</th>
                                    <th data-column="current_status_name">Status</th>
    								<th data-column="return_in">Data de devolução</th>
                                    <th data-column="delivered_at">Devolvido em</th>
                                    <th data-column="created_at">Cadastrado</th>
    							</tr>
    						</thead>
    
    						<tbody>
    
    							@foreach ($lendingBooks as $lendingBook)
                                    <tr>
                                        <td>{{ $lendingBook->id }}</td>
                                        <td>{{ $lendingBook->book_name }}</td>
                                        <td>{{ $lendingBook->nr_serial }}</td>
                                        <td>{{ $lendingBook->current_status_name }}</td>
                                        <td>{{ $lendingBook->return_in->format('d/m/Y') }}</td>
                                        <td>{{ $lendingBook->delivered_at ? $lendingBook->delivered_at->format('d/m/Y H:i:s') : '-' }}</td>
                                        <td>{{ $lendingBook->created_at->format('d/m/Y H:i:s') }}</td>
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

        </div>

    </div>

@endsection