@extends('layouts.site')

@section('title', 'Usuário | Perfil')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            $("#avatar_blob").change(function() {
                let input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.profile-user-img').attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        </script>
    @endpush


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perfil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Usuário</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (!Auth::user()->avatar_blob)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('img/user2-160x160.jpg') }}" alt="User profile picture" }>
                                @else
                                    <img class="profile-user-img img-fluid img-circle" src="{{ Auth::user()->avatar_blob }}"
                                        alt="User profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">

                    <!--<div class="card">

                  <div class="card-header">
                    <h3 class="card-title">Dados pessoais</h3>
                  </div>



                </div>-->

                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#dados" data-toggle="tab">Dados
                                        pessoais</a></li>
                                <li class="nav-item"><a class="nav-link" href="#senha" data-toggle="tab">Alterar senha</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="dados">
                                    <!-- dados -->

                                    <form method="POST" role="form" action="{{ route('perfil.atualizar') }}"
                                        autocomplete="off" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">

                                        <div class="row">

                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="email">Nome:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Seu nome" value="{{ $user->name }}">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Seu email" value="{{ $user->email }}">
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Foto do perfil</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="avatar_blob"
                                                                name="avatar_blob">
                                                            <label class="custom-file-label" for="avatar_blob">Escolher
                                                                foto</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Perfis ativos:</label>
                                                    <input type="text" class="form-control" value="{{ $roles }}" readonly>
                                                </div>
                                            </div>

                                            @php
                                            $endereco = $user->endereco()->count() != 0 ? $user->endereco()->get()[0] :
                                            null;

                                            @endphp

                                            @if (isset($endereco->cep) || isset($endereco->rua) || isset($endereco->numero) || isset($endereco->complemento) || isset($endereco->bairro) || isset($endereco->cidade) || isset($endereco->estado))

                                                <x-endereco :cep="$endereco->cep" :rua="$endereco->rua"
                                                    :numero="$endereco->numero" :complemento="$endereco->complemento"
                                                    :bairro="$endereco->bairro" :cidade="$endereco->cidade"
                                                    :estado="$endereco->estado" />
                                            @else
                                                <x-endereco />

                                            @endif


                                        </div>

                                        <button type="submit" class="btn btn-danger">Salvar</button>

                                    </form>

                                    <!-- /.dados -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="senha">
                                    <!-- senha -->
                                    <form method="POST" action="{{ route('perfil.novasenha') }}" autocomplete="off"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="senha">Nova senha:</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Nova senha" autocomplete="off">
                                        </div>
                                        <button type="submit" class="btn btn-danger">Salvar</button>
                                    </form>
                                    <!-- senha -->
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>





                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>

@endsection
