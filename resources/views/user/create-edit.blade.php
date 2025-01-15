@extends('layouts.app')

@section('content')

    <div class="page page-user create-edit">

        <form action="{{ url('usuarios') }}" method="POST" data-parsley-validate>

            @csrf
            @method($user->id ? 'PUT' : 'POST')

            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="card">
    
                <div class="card-header">
                    <h4>Formulário para criar ou alterar usuários</h4>
                </div>
    
                <div class="card-body">

                    @include("partials._alert")
                    
                    <div class="form-group">
                        <label>Nome <span class="text-danger fas fa-asterisk"></span></label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="100" required="required">
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Grupo <span class="text-danger fas fa-asterisk"></span></label>
                            <select class="form-control" name="group_id" required="required">
                                <option value="">Selecione</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {!! old('group_id', $user->group_id) == $group->id ? 'selected="selected"' : '' !!}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Email <span class="text-danger fas fa-asterisk"></span></label>
                            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" maxlength="100" required="required">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="password">Nova senha {!! !$user->id? '<span class="text-danger fas fa-asterisk"></span>' : ''  !!}</label>
                                <input id="password" type="password" name="password" class="form-control password" minlength="6" maxlength="20" {{ !$user->id ? 'required="required"' : '' }} />
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="password_confirm">Confirmação de nova senha {!! !$user->id? '<span class="text-danger fas fa-asterisk"></span>' : ''  !!}</label>
                                <input type="password" name="password_confirmation" class="form-control password_confirm" minlength="6" maxlength="20" data-parsley-equalto="#password" {{ !$user->id ? 'required="required"' : '' }} />
                            </div>
                        </div>

                    </div>
    
                </div>

                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{ url('usuarios') }}" title="Voltar">Voltar</a>
                    <button class="btn btn-primary" title="Salvar">Salvar</button>
                </div>
    
            </div>

        </form>

    </div>

@endsection