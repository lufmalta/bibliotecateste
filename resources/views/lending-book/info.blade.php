@extends('layouts.app')

@section('content')

    <div class="page page-lending-book info">

        <div class="card">

            <div class="card-header">
                <h4>Informações do empréstimo</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-4">
                        <label>Usuário Biblioteca</label>
                        <input class="form-control" type="text" value="{{ $lendingBook->user->name." | ".$lendingBook->user->email }}" readonly="readonly">
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Livro</label>
                        <input class="form-control" type="text" value="{{ $lendingBook->book->name." | ".$lendingBook->book->nr_serial }}" readonly="readonly">
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Data de Devolução</label>
                        <input class="form-control" type="text" value="{{ $lendingBook->return_in->format('d/m/Y') }}" readonly="readonly">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Status</label>
                        <input class="form-control" type="text" value="{{ LendingBookStatusEnum::getName($lendingBook->current_status_id) }}" readonly="readonly">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Devolvido em</label>
                        <input class="form-control" type="text" value="{{ $lendingBook->delivered_at ? $lendingBook->delivered_at->format('d/m/Y H:i:s') : '' }}" readonly="readonly">
                    </div>
                </div>

                <div class="lending-history">

                    <div class="table-area">

                        <div class="table-responsive">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Criação</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($lendingBook->statusHistory as $history)
                                        <tr>
                                            <td>{{ $history->id }}</td>
                                            <td>{{ LendingBookStatusEnum::getName($history->status_id) }}</td>
                                            <td>{{ $history->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer">
                <a class="btn btn-secondary" href="{{ url('emprestimos') }}" title="Voltar">Voltar</a>
            </div>

        </div>

    </div>

@endsection