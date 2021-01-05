@extends('layouts.temp')

@section('title', 'Registre-se')

@push('script')
<script src="{{asset('plugins/jquery-mask/jquery.mask.min.js')}}"></script>
<script>
    $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
	$('input[name="cell"]').mask('(000) 00000-0000');
	$('input[name="phone"]').mask('(000) 00000-0000');

    $(function () {
        $.validator.setDefaults({
            submitHandler: function (ev) {
                ev.preventDefault();
            }
        });
        $('#frm').validate({
            rules: {
                'name': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true,
                },
                'cpf': {
                    required: true
                },
                'genre': {
                    required: true
                },
                'cep': {
                    required: true
                },
                'rua': {
                    required: true
                },
                'numero': {
                    required: true
                },
                'bairro': {
                    required: true
                },
                'cidade': {
                    required: true
                },
                'estado': {
                    required: true
                },
                'terms_accept': {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Insira o seu nome"
                },
                'email': {
                    required: "Informe o seu email",
                    email: "Informe um email válido"
                },
                'cpf': {
                    required: "Informe o seu cpf"
                },
                'genre': {
                    required: "Informe o seu sexo/gênero"
                },
                'cep': {
                    required: "Informe o seu CEP"
                },
                'rua': {
                    required: "Informe o nome da rua"
                },
                'numero': {
                    required: "Informe o n° do imóvel"
                },
                'bairro': {
                    required: "Informe o nome do bairro"
                },
                'cidade': {
                    required: "Informe o nome da cidade"
                },
                'estado': {
                    required: "Informe a UF"
                },
                'estado': {
                    required: "Informe a UF"
                },
                'terms_accept': "Leia e aceite os termos de serviço"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush


@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="container-fluid pt-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <form method="POST" action="{{route('registrar')}}" novalidate="novalidate"
                                autocomplete="off" id="frm">
                                @csrf
                                <div class="card-header">Formulário de registro</div>

                                <div class="card-body">

                                    @if($errors->all())
                                    @foreach($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <i class="icon fas fa-ban"></i>
                                        {{ $error }}
                                    </div>
                                    @endforeach
                                    @endif

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Nome:</strong>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{old('name')}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{old('email')}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Cpf:</strong>
                                                <input type="text" name="cpf" class="form-control"
                                                    value="{{old('cpf')}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Sexo:</strong>
                                                <select name="genre" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="F" {{old('genre') == 'F' ? 'selected' : ''}}>Feminino
                                                    </option>
                                                    <option value="M" {{old('genre') == 'M' ? 'selected' : ''}}>
                                                        Masculino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Celular:</strong>
                                                <input type="text" name="cell" class="form-control"
                                                    value="{{old('cell')}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Fixo:</strong>
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{old('phone')}}">
                                            </div>
                                        </div>

                                        <x-endereco />

                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="terms_accept"
                                                        class="custom-control-input" id="terms_accept">
                                                    <label class="custom-control-label" for="terms_accept"> Eu aceito
                                                        os <a href="#">termos de serviço</a>.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="float-left">
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
