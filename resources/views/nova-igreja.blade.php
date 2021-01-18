@extends('layouts.site')

@section('title', 'Nova igreja')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $("#cnpj").mask("99.999.999/9999-99");

            $(function() {
                $.validator.setDefaults({
                    submitHandler: function(ev) {
                        ev.preventDefault();
                    }
                });
                $('#create').validate({
                    rules: {
                        nome: {
                            required: true
                        },
                        cnpj: {
                            required: true
                        },
                        telefone: {
                            required: true
                        },
                        cep: {
                            required: true
                        },
                        rua: {
                            required: true
                        },
                        numero: {
                            required: true
                        },
                        bairro: {
                            required: true
                        },
                        cidade: {
                            required: true
                        },
                        estado: {
                            required: true
                        }
                    },
                    messages: {
                        nome: {
                            required: "Informe o nome da igreja"
                        },
                        cnpj: {
                            required: "Informe o cnpj da igreja"
                        },
                        telefone: {
                            required: "Informe o telefone da igreja"
                        },
                        cep: {
                            required: "Informe o cep da igreja"
                        },
                        rua: {
                            required: "Informe a rua da igreja"
                        },
                        numero: {
                            required: "Informe o n° da igreja"
                        },
                        bairro: {
                            required: "Informe o bairro da igreja"
                        },
                        cidade: {
                            required: "Informe a cidade da igreja"
                        },
                        estado: {
                            required: "Informe o estado da igreja"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });

        </script>
    @endpush


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-church"></i> Nova igreja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Nova igreja</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cadastrar nova igreja</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="create" method="POST" action="{{ route('home.cadastrar-igreja') }}" autocomplete="off"
                    novalidate="novalidate">
                    @csrf
                    <div class="row">

                        <div class="col-xs-6 col-sm-8 col-md-12">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                <input type="text" class="form-control" name="nome" id="nome"
                                    placeholder="Informe o nome da igreja" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-8 col-md-8">
                            <div class="form-group">
                                <strong>Cnpj:</strong>
                                <input type="text" class="form-control" name="cnpj" id="cnpj"
                                    placeholder="Informe o cnpj da igreja" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Telefone:</strong>
                                <input type="text" class="form-control" name="telefone" id="telefone"
                                    placeholder="Informe o telefone da igreja" required>
                            </div>
                        </div>

                        <x-endereco />

                        <div class="col-xs-6 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Sobre:</strong>
                                <textarea class="form-control" name="sobre" id="sobre" cols="30" rows="10"
                                    placeholder="Insira aqui uma breve descrição da igreja"></textarea>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success float-right">Criar</button>

                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Footer
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
@endsection
