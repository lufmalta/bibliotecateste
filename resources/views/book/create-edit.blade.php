@extends('layouts.app')

@section('content')

    <div class="page page-book create-edit">

        <form action="{{ url('livros') }}" method="POST" data-parsley-validate>

            @csrf
            @method($book->id ? 'PUT' : 'POST')

            <input type="hidden" name="id" value="{{ $book->id }}">

            <div class="card">
    
                <div class="card-header">
                    <h4>Formulário para criar ou alterar livros</h4>
                </div>
    
                <div class="card-body">

                    @include("partials._alert")
                    
                    <div class="form-group">
                        <label>Nome <span class="text-danger fas fa-asterisk"></span></label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', $book->name) }}" maxlength="100" required="required">
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Autor <span class="text-danger fas fa-asterisk"></span></label>
                            <input class="form-control" type="text" name="author" value="{{ old('author', $book->author) }}" maxlength="100" required="required">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Gênero <span class="text-danger fas fa-asterisk"></span></label>
                            <select class="form-control" name="genrer_id" required="required">
                                <option value="">Selecione</option>
                                @foreach ($bookGenres as $genrer)
                                    <option value="{{ $genrer->id }}" {!! old('genrer_id', $book->genrer_id) == $genrer->id ? 'selected="selected"' : '' !!}>{{ $genrer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                </div>

                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{ url('livros') }}" title="Voltar">Voltar</a>
                    <button class="btn btn-primary" title="Salvar">Salvar</button>
                </div>
    
            </div>

        </form>

    </div>

@endsection