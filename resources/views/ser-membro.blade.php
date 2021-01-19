@extends('layouts.site')

@section('title', 'Ser membro')

    @push('script')
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
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
                    <h1><i class="nav-icon fas fa-sign-in-alt"></i> Ser membro</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ser membro</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="card h-100">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
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

                <div class="row pt-3">
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

                        <div class="col-md-4 pb-4">
                            <div class="card bg-light h-100">
                                @if ($row->cover)
                                    <img class="card-img-top" src="{{ $row->cover }}" alt="{{ $row->nome }}">
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
                                        <a href="#" class="btn btn-sm btn-primary become" data-id="{{ $row->id }}"
                                            data-nome="{{ $row->nome }}">
                                            <i class="fas fa-sign-in-alt"></i> Tornar-se membro
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
