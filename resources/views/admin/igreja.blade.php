@extends('layouts.site')

@section('title', 'Project Manager | Home')

    @push('script')
        <link rel="stylesheet" href="{{ asset('plugins/treeview/treeview.css') }}">
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            function menu_validate(el) {
                el.validate({
                    rules: {
                        titulo: {
                            required: true
                        },
                        ordem: {
                            required: true
                        }
                    },
                    messages: {
                        titulo: {
                            required: "Informe o título do menu"
                        },
                        ordem: {
                            required: "Informe"
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
            }

            $("form[id='create-menu']").on('submit', function(e) {
                e.preventDefault();
                menu_validate($(this));
                var formData = new FormData(this);

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('menus.create') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            $('#modal-create-menu').modal('hide');
                            $("form[id='create-menu']").validate().resetForm();
                            $("form[id='create-menu']")[0].reset();
                            $('.site-menu').html(data.html);

                            Toast.fire({
                                type: 'success',
                                title: 'Menu cadastrado com sucesso!'
                            });
                        },
                        error: function(data) {
                            // handle error response
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao cadastrar o menu. Contacte o suporte!'
                            });
                        },
                        contentType: false,
                        processData: false
                    });
                }
            });

            $("form[id='create-submenu']").on('submit', function(e) {
                e.preventDefault();
                menu_validate($(this));
                var formData = new FormData(this);

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('menus.create') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            $('#modal-create-submenu').modal('hide');
                            $("form[id='create-submenu']").validate().resetForm();
                            $("form[id='create-submenu']")[0].reset();
                            $('.site-menu').html(data.html);

                            Toast.fire({
                                type: 'success',
                                title: 'Menu cadastrado com sucesso!'
                            });
                        },
                        error: function(data) {
                            // handle error response
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao cadastrar o menu. Contacte o suporte!'
                            });
                        },
                        contentType: false,
                        processData: false
                    });
                }
            });

            $("form[id='edit-menu']").on('submit', function(e) {
                e.preventDefault();
                menu_validate($(this));
                var formData = new FormData(this);

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('menus.update') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            $('#modal-edit-menu').modal('hide');
                            $("form[id='edit-menu']").validate().resetForm();
                            $("form[id='edit-menu']")[0].reset();
                            $('.site-menu').html(data.html);

                            Toast.fire({
                                type: 'success',
                                title: 'Menu atualizado com sucesso!'
                            });
                        },
                        error: function(data) {
                            // handle error response
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao atualizar o menu. Contacte o suporte!'
                            });
                        },
                        contentType: false,
                        processData: false
                    });
                }
            });

            $('#modal-create-menu').on('show.bs.modal', function(event) {
                $(this).validate().resetForm();
                $("form[id='create-menu']")[0].reset();
            });

            $('#modal-edit-menu').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                modal.find('.modal-body input[name=id]').val(button.data('id'));
                modal.find('.modal-body input[name=titulo]').val(button.data('titulo'));
                modal.find('.modal-body input[name=ordem]').val(button.data('ordem'));
                modal.find('.modal-body input[name=url]').val(button.data('url'));
            });

            $('#modal-create-submenu').on('show.bs.modal', function(event) {
                $(this).validate().resetForm();
                $("form[id='create-submenu']")[0].reset();

                var button = $(event.relatedTarget);
                var modal = $(this);
                modal.find('.modal-body input[name=menu_id]').val(button.data('id'));
            });

            $('#modal-edit-submenu').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                modal.find('.modal-body input[name=id]').val(button.data('id'));
                modal.find('.modal-body input[name=menu_id]').val(button.data('menu_id'));
                modal.find('.modal-body input[name=titulo]').val(button.data('titulo'));
                modal.find('.modal-body input[name=ordem]').val(button.data('ordem'));
                modal.find('.modal-body input[name=url]').val(button.data('url'));
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var row = $(this);

                Swal.fire({
                    title: 'Você tem certeza?',
                    html: 'Ao confirmar esta ação, o menu <b>' + row.attr('data-titulo') +
                        '</b> será <b>excluído permanentemente</b>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, excluir o menu <b>' + row.attr('data-titulo') + '</b>!',
                    cancelButtonText: 'Não, cancelar!'
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: '/menus/' + row.attr('data-id') + '/destroy',
                            type: 'GET',
                            success: function(data) {
                                // handle success response
                                $('.site-menu').html(data.html);

                                Toast.fire({
                                    type: 'success',
                                    title: (data.message) ? data.message :
                                        'Atributo excluído com sucesso!'
                                });
                            },
                            error: function(data) {
                                // handle error response
                                //console.log(response.data);
                                Toast.fire({
                                    type: 'error',
                                    title: 'Erro ao excluir o menu. </br>Contacte o suporte!'
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
                <div class="row">
                    <div class="col-md-12 site-menu">
                        @include('admin.menu-tree-eglise')
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>

    <!-- start create menu -->
    <div class="modal fade" id="modal-create-menu" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" role="form" novalidate="novalidate" id="create-menu" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Novo menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xs-6 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Titulo:</strong>
                                    <input type="text" class="form-control" name="titulo"
                                        placeholder="Informe o título do menu" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <strong>Link:</strong>
                                    <input type="text" class="form-control" name="url" placeholder="Informe o link do menu">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <strong>Ordem:</strong>
                                    <input type="text" class="form-control" name="ordem">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group botao float-right" role="group">
                            <button type="button" class="btn btn-sm btn-danger badge-pill" data-dismiss="modal">
                                <i class="fas fa-times"></i>&nbsp;Cancelar
                            </button>
                        </div>
                        <div class="btn-group botao float-right" role="group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary badge-pill">
                                <i class="far fa-save"></i>&nbsp;Salvar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end create menu -->

    <!-- start edit menu -->
    <div class="modal fade" id="modal-edit-menu" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" role="form" novalidate="novalidate" id="edit-menu" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Editar menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id">

                            <div class="col-xs-6 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Titulo:</strong>
                                    <input type="text" class="form-control" name="titulo"
                                        placeholder="Informe o título do menu" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <strong>Link:</strong>
                                    <input type="text" class="form-control" name="url" placeholder="Informe o link do menu">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <strong>Ordem:</strong>
                                    <input type="text" class="form-control" name="ordem">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group botao float-right" role="group">
                            <button type="button" class="btn btn-sm btn-danger badge-pill" data-dismiss="modal">
                                <i class="fas fa-times"></i>&nbsp;Cancelar
                            </button>
                        </div>
                        <div class="btn-group botao float-right" role="group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary badge-pill">
                                <i class="far fa-save"></i>&nbsp;Salvar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end edit menu -->

    <!-- start create submenu -->
    <div class="modal fade" id="modal-create-submenu" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" role="form" novalidate="novalidate" id="create-submenu" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Novo submenu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="menu_id">

                            <div class="col-xs-6 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Titulo:</strong>
                                    <input type="text" class="form-control" name="titulo"
                                        placeholder="Informe o título do submenu" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <strong>Link:</strong>
                                    <input type="text" class="form-control" name="url" placeholder="Informe o link do submenu">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <strong>Ordem:</strong>
                                    <input type="text" class="form-control" name="ordem">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group botao float-right" role="group">
                            <button type="button" class="btn btn-sm btn-danger badge-pill" data-dismiss="modal">
                                <i class="fas fa-times"></i>&nbsp;Cancelar
                            </button>
                        </div>
                        <div class="btn-group botao float-right" role="group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary badge-pill">
                                <i class="far fa-save"></i>&nbsp;Salvar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end create submenu -->
@endsection
