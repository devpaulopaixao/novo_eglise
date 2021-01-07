@extends('layouts.site')

@section('title', 'Home')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

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

            $(document).on('click', '.become', function(e) {
                e.preventDefault();
                var row = $(this);

                Swal.fire({
                    title: 'Você tem certeza?',
                    html: 'Ao confirmar esta ação, você se tornará membro da <b>' + row.attr('data-nome') +
                        '</b>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, confirmar!',
                    cancelButtonText: 'Não, cancelar!'
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: '/membros/conectar/' + row.attr('data-id'),
                            type: 'GET',
                            success: function(data) {
                                // handle success response

                                Toast.fire({
                                    type: 'success',
                                    title: (data.message) ? data.message : 'Vinculado à ' +
                                        row.attr('data-nome') + ' com sucesso!'
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 1800);

                            },
                            error: function(data) {
                                // handle error response
                                //console.log(response.data);
                                Toast.fire({
                                    type: 'error',
                                    title: 'Erro ao realizar vínculo à ' + row.attr(
                                        'data-nome') + '. </br>Contacte o suporte!'
                                });
                            },
                            contentType: false,
                            processData: false
                        });

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
                    <h1><i class="nav-icon fas fa-home"></i> Home</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="#">Home</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        @if (\Request::session()->get('igreja_id'))
            <!--Conteúdo para membros-->
        @else

            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#member" data-toggle="tab">
                                Tornar-se membro de uma igreja
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#church" data-toggle="tab">Cadastrar uma igreja</a>
                        </li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="member">
                            <!-- member -->

                            <div class="container-fluid">
                                <form>
                                    <div class="row">
                                        <div class="col-md-10 offset-md-1">
                                            <div class="form-group">
                                                <div class="input-group input-group-lg">
                                                    <input type="search" class="form-control form-control-lg"
                                                        placeholder="Informe aqui o nome da igreja">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-lg btn-primary">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="row">
                                    @php
                                    $igrejas = \App\Igreja::select(
                                    'igrejas.id',
                                    'igrejas.nome',
                                    'igrejas.sobre',
                                    'igrejas.telefone',
                                    'users.name as criador',
                                    'enderecos.cep',
                                    'enderecos.rua',
                                    'enderecos.numero',
                                    'enderecos.complemento',
                                    'enderecos.bairro',
                                    'enderecos.cidade',
                                    'enderecos.estado',
                                    'enderecos.pais',
                                    )
                                    ->join('enderecos', 'igrejas.id', '=', 'enderecos.igreja_id')
                                    ->join('users', 'igrejas.user_id', '=', 'users.id')
                                    ->get();
                                    @endphp

                                    @foreach ($igrejas as $row)

                                        <div class="col-md-4 pb-4 offset-md-1">
                                            <div class="card bg-light h-100">
                                                @if ($row->cover)
                                                    <img class="card-img-top" src="{{ $row->cover }}"
                                                        alt="{{ $row->nome }}">
                                                @endif
                                                <div class="card-body pt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h2><b>{{ $row->nome }}</b></h2>

                                                            <p class="text-muted text-sm">
                                                                <b>Sobre: </b> {{ $row->sobre }}
                                                            </p>

                                                            <ul class="ml-4 fa-ul text-muted">
                                                                <li class="small"><span class="fa-li">
                                                                        <i class="fas fa-lg fa-building"></i>
                                                                    </span> Endereço:
                                                                    {{ "$row->rua $row->numero, $row->bairro $row->cidade-$row->estado" }}
                                                                </li>
                                                                <li class="small mt-2"><span class="fa-li">
                                                                        <i class="fas fa-lg fa-phone"></i>
                                                                    </span> Telefone: {{ $row->telefone }}
                                                                </li>
                                                                <li class="small mt-2"><span class="fa-li">
                                                                        <i class="fas fa-lg fa-user"></i>
                                                                    </span> Criador: {{ $row->criador }}
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <a href="#" class="btn btn-sm btn-primary become"
                                                            data-id="{{ $row->id }}" data-nome="{{ $row->nome }}">
                                                            <i class="fas fa-sign-in-alt"></i> Tornar-se membro
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <!-- /.member -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="church">
                            <!-- New church -->
                            <form id="create" method="POST" action="{{ route('home.cadastrar-igreja') }}" autocomplete="off"
                                novalidate="novalidate">
                                @csrf
                                <div class="row">

                                    <div class="col-xs-6 col-sm-8 col-md-8">
                                        <div class="form-group">
                                            <strong>Nome:</strong>
                                            <input type="text" class="form-control" name="nome" id="nome"
                                                placeholder="Informe o nome da igreja" required>
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

                                <div class="row">
                                    <div class="col-xs-6 col-sm-8 col-md-8">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">Salvar</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <!-- New church -->
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>

        @endif

    </section>

@endsection
