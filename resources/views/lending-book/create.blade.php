@extends('layouts.app')

@section('content')

    <div class="page page-lending-book create">

        <form action="{{ url('emprestimos') }}" method="POST" data-parsley-validate>

            @csrf

            <div class="card">
    
                <div class="card-header">
                    <h4>Formulário para criação de empréstimos</h4>
                </div>
    
                <div class="card-body">
                    
                    @include("partials._alert")

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Usuário <span class="text-danger fas fa-asterisk"></span></label>
                            <select class="form-control select-user" name="user_id" data-old-id="{{ old('user_id') }}" data-parsley-errors-container="#select-user-errors" required="required"></select>
                            <div id="select-user-errors"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Livro <span class="text-danger fas fa-asterisk"></span></label>
                            <select class="form-control select-book" name="book_id" data-old-id="{{ old('book_id') }}" data-parsley-errors-container="#select-book-errors" required="required"></select>
                            <div id="select-book-errors"></div>
                        </div>

                        {{-- CAMPO ONDE DEVERÁ TER A DATA DE DEVOLUÇÃO. --}}
                        <div class="form-group col-sm-4">
                            <label>Data de Devolução</label>
                            <input type="date" class="form-control" value="{{ old('return_in') }}" name="return_in" min="{{ now()->addDay()->format('Y-m-d') }}" required="required">
                        </div>

                    </div>
    
                </div>

                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{ url('emprestimos') }}" title="Voltar">Voltar</a>
                    <button class="btn btn-primary" title="Salvar">Salvar</button>
                </div>
    
            </div>

        </form>

    </div>

@endsection