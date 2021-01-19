@extends('layouts.site')

@section('title', 'Nova igreja')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/bs-stepper.min.css') }}">
        <script src="{{ asset('plugins/bs-stepper/bs-stepper.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $("#cnpj").mask("99.999.999/9999-99");

            $('input[name="cep"]').mask('00.000-000');

            $(document).on('blur', "input[name='cep']", function() {
                var parser = /^[0-9]{8}$/;
                var cep = $(this).val().replace(/\D/g, '');

                if ((cep != '') && (parser.test(cep))) {
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("input[name='rua']").val(dados.logradouro);
                            $("input[name='complemento']").val(dados.complemento);
                            $("input[name='bairro']").val(dados.bairro);
                            $("input[name='cidade']").val(dados.localidade);
                            $("input[name='estado']").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            $("input[name='rua']").val(null);
                            $("input[name='complemento']").val(null);
                            $("input[name='bairro']").val(null);
                            $("input[name='cidade']").val(null);
                            $("input[name='estado']").val(null);
                        }
                    });
                }
            });

            // BS-Stepper Init
            document.addEventListener('DOMContentLoaded', function() {
                window.stepper = new Stepper(document.querySelector('.bs-stepper'))
            });

            (function() {
                'use strict'

                var stepperFormEl = document.querySelector('#stepperForm')
                window.stepperForm = new Stepper(stepperFormEl, {
                    linear: false,
                    animation: true
                })

                var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
                var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
                var form = stepperFormEl.querySelector('.bs-stepper-content form')

                btnNextList.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        window.stepperForm.next()
                    })
                })

                stepperFormEl.addEventListener('show.bs-stepper', function(event) {
                    form.classList.remove('was-validated')
                    var nextStep = event.detail.indexStep
                    var currentStep = nextStep

                    if (currentStep > 0) {
                        currentStep--
                    }

                    var stepperPan = stepperPanList[currentStep]
                    //validation rules
                    switch (stepperPan.getAttribute('id')) {
                        case 'test-form-1':
                            if (
                                !document.getElementById('nome').value.length ||
                                !document.getElementById('cnpj').value.length ||
                                !document.getElementById('telefone').value.length ||
                                !document.getElementById('cep').value.length ||
                                !document.getElementById('rua').value.length ||
                                !document.getElementById('numero').value.length ||
                                !document.getElementById('bairro').value.length ||
                                !document.getElementById('cidade').value.length ||
                                !document.getElementById('estado').value.length
                            ) {
                                event.preventDefault()
                                form.classList.add('was-validated')
                            }
                            break;
                        case 'test-form-2':
                            /*if(!inputPasswordForm.value.length){
                              event.preventDefault()
                              form.classList.add('was-validated')
                            }*/
                            break;
                        default:

                    }
                })
            })();

            $("form[id='create']").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                alert('Dispatch!');

                if (!$(this).valid()) {
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('igrejas.store') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            // handle success response
                            window.location.href = "{{ route('new.product') }}";
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

                <div class="mb-5 p-4 bg-white table-responsive">
                    <div id="stepperForm" class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#test-form-1">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger1"
                                    aria-controls="test-form-1">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Informações básicas</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-2">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger2"
                                    aria-controls="test-form-2">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Forma de pagamento</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-3">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3"
                                    aria-controls="test-form-3">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Cobrança</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-4">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger4"
                                    aria-controls="test-form-4">
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Termos de serviço</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-5">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger5"
                                    aria-controls="test-form-5">
                                    <span class="bs-stepper-circle">5</span>
                                    <span class="bs-stepper-label">Contratar</span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">

                            <form id="create" class="needs-validation" method="POST" onsubmit="return false"
                                action="{{ route('home.cadastrar-igreja') }}" novalidate autocomplete="off">
                                <div id="test-form-1" role="tabpanel" class="bs-stepper-pane fade"
                                    aria-labelledby="stepperFormTrigger1">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-8 col-md-12">
                                            <div class="form-group">
                                                <strong>Nome:</strong>
                                                <input type="text" class="form-control" name="nome" id="nome"
                                                    placeholder="Informe o nome da igreja" required>
                                                <div class="invalid-feedback">Informe o nome da igreja</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-8 col-md-8">
                                            <div class="form-group">
                                                <strong>Cnpj:</strong>
                                                <input type="text" class="form-control" name="cnpj" id="cnpj"
                                                    placeholder="Informe o cnpj da igreja" required>
                                                <div class="invalid-feedback">Informe o cnpj da igreja</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <strong>Telefone:</strong>
                                                <input type="text" class="form-control" name="telefone" id="telefone"
                                                    placeholder="Informe o telefone da igreja" required>
                                                <div class="invalid-feedback">Informe o telefone da igreja</div>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <strong>CEP:</strong>
                                                <input type="text" name="cep" id="cep" class="form-control" maxlength="10"
                                                    required>
                                                <div class="invalid-feedback">Informe o CEP</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-8">
                                            <div class="form-group">
                                                <strong>Rua:</strong>
                                                <input type="text" name="rua" id="rua" class="form-control" required>
                                                <div class="invalid-feedback">Informe a rua</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <strong>Número:</strong>
                                                <input type="text" name="numero" id="numero" class="form-control" required>
                                                <div class="invalid-feedback">Informe o número</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-9">
                                            <div class="form-group">
                                                <strong>Complemento:</strong>
                                                <input type="text" name="complemento" id="complemento" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Bairro:</strong>
                                                <input type="text" name="bairro" id="bairro" class="form-control" required>
                                                <div class="invalid-feedback">Informe o bairro</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Cidade:</strong>
                                                <input type="text" name="cidade" id="cidade" class="form-control" required>
                                                <div class="invalid-feedback">Informe a cidade</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <strong>UF:</strong>
                                                <input type="text" name="estado" id="estado" class="form-control"
                                                    maxlength="2" required>
                                                <div class="invalid-feedback">Informe o estado</div>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                </div>

                                <div id="test-form-2" role="tabpanel" class="bs-stepper-pane fade"
                                    aria-labelledby="stepperFormTrigger2">
                                    <!--boleto/crédito-->
                                    <div class="form-group">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="boleto" name="forma_pgto" checked/>
                                            <label for="boleto">Boleto</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="cartao" name="forma_pgto"/>
                                            <label for="cartao">Cartão</label>
                                        </div>
                                    </div>
                                    <!--boleto/crédito-->

                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.previous()">Anterior</button>
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                </div>

                                <div id="test-form-3" role="tabpanel" class="bs-stepper-pane fade text-center"
                                    aria-labelledby="stepperFormTrigger3">
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.previous()">Anterior</button>
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                </div>

                                <div id="test-form-4" role="tabpanel" class="bs-stepper-pane fade text-center"
                                    aria-labelledby="stepperFormTrigger4">
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.previous()">Anterior</button>
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                </div>

                                <div id="test-form-5" role="tabpanel" class="bs-stepper-pane fade text-center"
                                    aria-labelledby="stepperFormTrigger3">
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.previous()">Anterior</button>
                                    <button type="submit" class="btn btn-primary float-right mt-5">Submit</button>
                                </div>

                            </form>

                        </div>
                    </div>


                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
