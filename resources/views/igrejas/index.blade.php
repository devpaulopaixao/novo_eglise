@extends('layouts.site')

@section('title', 'Igrejas')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            function fnc_validate(el) {
                el.validate({
                    rules: {
                        nome: {
                            required: true
                        }
                    },
                    messages: {
                        nome: {
                            required: "Informe a descrição da igreja"
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

            $("form[id='create']").on('submit', function(e) {
                e.preventDefault();
                fnc_validate($(this));
                var formData = new FormData(this);

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('igrejas.store') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            $('#modal-create').modal('hide');
                            $("form[id='create']").validate().resetForm();
                            $("form[id='create']")[0].reset();
                            $('.igrejas').html(data.html);

                            console.log(data.html);

                            Toast.fire({
                                type: 'success',
                                title: 'Igreja cadastrada com sucesso!'
                            });
                        },
                        error: function(data) {
                            // handle error response
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao realizar o cadastro. A igreja já existe!'
                            });
                        },
                        contentType: false,
                        processData: false
                    });
                }

            });

            $("form[id='edit']").on('submit', function(e) {
                e.preventDefault();
                fnc_validate($(this));
                var formData = new FormData(this);

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('igrejas.update') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            $('#modal-edit').modal('hide');
                            $("form[id='edit']").validate().resetForm();
                            $("form[id='edit']")[0].reset();
                            $('.igrejas').html(data.html);

                            Toast.fire({
                                type: 'success',
                                title: (data.message) ? data.message :
                                    'Igreja atualizada com sucesso!'
                            });
                        },
                        error: function(data) {
                            // handle error response
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao atualizar igreja. </br>Contacte o suporte!'
                            });
                        },
                        contentType: false,
                        processData: false
                    });
                }

            });

            $('#modal-create').on('show.bs.modal', function(event) {
                $(this).validate().resetForm();
                $("form[id='create']")[0].reset();
            });

            $('#modal-edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                modal.find('.modal-body #id').val(button.data('id'));
                modal.find('.modal-body #nome').val(button.data('nome'));
                modal.find('.modal-body #sobre').val(button.data('sobre'));
                modal.find('.modal-body #telefone').val(button.data('telefone'));
                modal.find('.modal-body input[name=cep]').val(button.data('cep'));
                modal.find('.modal-body input[name=rua]').val(button.data('rua'));
                modal.find('.modal-body input[name=numero]').val(button.data('numero'));
                modal.find('.modal-body input[name=complemento]').val(button.data('complemento'));
                modal.find('.modal-body input[name=bairro]').val(button.data('bairro'));
                modal.find('.modal-body input[name=cidade]').val(button.data('cidade'));
                modal.find('.modal-body input[name=estado]').val(button.data('estado'));
            });

            $("form[id='search']").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('igrejas.fetch') }}",
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        // handle success response
                        $('.igrejas').empty().html(data.html);
                    },
                    error: function(data) {
                        // handle error response
                        Toast.fire({
                            type: 'error',
                            title: 'Erro ao pesquisar igreja. </br>Contacte o suporte!'
                        });
                    },
                    contentType: false,
                    processData: false
                });
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var row = $(this);

                Swal.fire({
                    title: 'Você tem certeza?',
                    html: 'Ao confirmar esta ação, a igreja <b>' + row.attr('data-nome') +
                        '</b> será <b>excluída permanentemente</b>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, excluir a igreja <b>' + row.attr('data-nome') + '</b>!',
                    cancelButtonText: 'Não, cancelar!'
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: '/igrejas/' + row.attr('data-id') + '/destroy',
                            type: 'GET',
                            success: function(data) {
                                // handle success response
                                $('.igrejas').empty().html(data.html);

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
                                    title: 'Erro ao excluir igreja. </br>Contacte o suporte!'
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
                    <h1><i class="nav-icon fas fa-church"></i> Igrejas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Igrejas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="post" id="search" autocomplete="off">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Pesquisar igreja">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-flat">Pesquisar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                        <i class="fas fa-plus"></i>&nbsp;Nova igreja</button>
                </div>
            </div>

            <div class="card-body pb-0 igrejas">
                @include('igrejas.pagination')
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>


    <div class="modal fade" id="modal-create" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" role="form" novalidate="novalidate" id="create" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Nova igreja</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xs-6 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nome:</strong>
                                    <input type="text" class="form-control" name="nome" id="nome"
                                        placeholder="Informe o nome da igreja" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-12">
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

    <div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" role="form" novalidate="novalidate" id="edit" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Editar igreja</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id" id="id">

                            <div class="col-xs-6 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nome:</strong>
                                    <input type="text" name="nome" id="nome" placeholder="Informe o nome da igreja"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-12 col-md-12">
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
@endsection
