@extends('layouts.site')

@section('title', 'Project Manager | Home')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    @endpush


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-church"></i> Configurações da {{ $igreja->nome }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Igreja</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações básicas</h3>
            </div>
            <form action="{{ route('igreja.configurar') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>URL:</strong>
                                <input type="text" name="url" class="form-control"
                                    value="{{ isset($configuracao[0]->url) ? $configuracao[0]->url : '' }}">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Youtube:</strong>
                                <input type="text" name="youtube" class="form-control"
                                    value="{{ isset($configuracao[0]->youtube) ? $configuracao[0]->youtube : '' }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Twitter:</strong>
                                <input type="text" name="twitter" class="form-control"
                                    value="{{ isset($configuracao[0]->twitter) ? $configuracao[0]->twitter : '' }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Facebook:</strong>
                                <input type="text" name="facebook" class="form-control"
                                    value="{{ isset($configuracao[0]->facebook) ? $configuracao[0]->facebook : '' }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Instagram:</strong>
                                <input type="text" name="instagram" class="form-control"
                                    value="{{ isset($configuracao[0]->instagram) ? $configuracao[0]->instagram : '' }}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Whatsapp:</strong>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ isset($configuracao[0]->whatsapp) ? $configuracao[0]->whatsapp : '' }}">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        @if ($endereco->count() > 0)
                            <x-endereco :cep="$endereco[0]->cep" :rua="$endereco[0]->rua" :numero="$endereco[0]->numero"
                                :complemento="$endereco[0]->complemento" :bairro="$endereco[0]->bairro"
                                :cidade="$endereco[0]->cidade" :estado="$endereco[0]->estado" />
                        @else
                            <x-endereco />
                        @endif

                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="form-group float-left">
                        <button type="submit" class="btn btn-danger">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hierarquia de menus</h3>
            </div>
            <div class="card-body">
                Start creating your amazing application!
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
