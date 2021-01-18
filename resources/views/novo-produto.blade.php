@extends('layouts.site')

@section('title', 'Novo Produto')

    @push('script')
        <style>
            .btn-link {
                font-size: 25px !important;
                font-weight: 400;
                color: #343a40;
                text-decoration: none;
            }

            .btn-link:hover {
                color: #343a40;
                text-decoration: underline;
            }

        </style>
    @endpush


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-home"></i> Novo produto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Novo produto</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="container-fluid">
            <h2>O que você deseja?</h2>
            <div class="row">
                <div class="col-md-12">
                    <!-- Default box -->
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Criar uma igreja
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor
                                                incididunt ut labore et dolore magna aliqua. Orci dapibus ultrices in
                                                iaculis.
                                                Aliquet lectus proin nibh nisl condimentum id venenatis a condimentum. Eget
                                                aliquet
                                                nibh praesent tristique magna sit amet purus. Ac placerat vestibulum lectus
                                                mauris
                                                ultrices eros in cursus. Nibh tortor id aliquet lectus. Non curabitur
                                                gravida arcu
                                                ac tortor. Id volutpat lacus laoreet non curabitur gravida arcu ac. Aliquam
                                                nulla
                                                facilisi cras fermentum odio eu feugiat. Maecenas volutpat blandit aliquam
                                                etiam
                                                erat velit scelerisque in dictum. Integer enim neque volutpat ac tincidunt
                                                vitae
                                                semper quis. Nibh praesent tristique magna sit amet. Cursus vitae congue
                                                mauris
                                                rhoncus aenean vel. Fames ac turpis egestas maecenas pharetra convallis
                                                posuere
                                                morbi leo. Amet consectetur adipiscing elit duis tristique sollicitudin
                                                nibh. Vel
                                                risus commodo viverra maecenas accumsan lacus.
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{route('new.church')}}" class="btn btn-success float-right">Criar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        Conectar-me a uma igreja
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                Purus ut faucibus pulvinar elementum. Dictum at tempor commodo ullamcorper
                                                a. Semper auctor neque vitae tempus quam pellentesque nec. Diam maecenas
                                                ultricies mi eget. Lectus urna duis convallis convallis tellus id interdum.
                                                Rutrum quisque non tellus orci ac auctor. Purus viverra accumsan in nisl
                                                nisi scelerisque eu ultrices vitae. Faucibus turpis in eu mi bibendum neque
                                                egestas congue. Pulvinar neque laoreet suspendisse interdum consectetur
                                                libero id faucibus nisl. Cursus euismod quis viverra nibh cras pulvinar
                                                mattis nunc. Lectus magna fringilla urna porttitor rhoncus dolor. Cras
                                                adipiscing enim eu turpis egestas pretium aenean pharetra magna. Egestas sed
                                                tempus urna et pharetra pharetra massa. Eget gravida cum sociis natoque
                                                penatibus et magnis dis.
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{route('be.member')}}" class="btn btn-success float-right">Conectar-se</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>



    </section>
@endsection
