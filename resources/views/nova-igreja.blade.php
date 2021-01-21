@extends('layouts.site')

@section('title', 'Nova igreja')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/bs-stepper.min.css') }}">
        <script src="{{ asset('plugins/bs-stepper/bs-stepper.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <style>
            .paymentWrap {
                padding: 50px;
            }

            .paymentWrap .paymentBtnGroup {
                max-width: 800px;
                margin: auto;
            }

            .paymentWrap .paymentBtnGroup .paymentMethod {
                padding: 80px;
                box-shadow: none;
                position: relative;
            }

            .paymentWrap .paymentBtnGroup .paymentMethod.active {
                outline: none !important;
            }

            .paymentWrap .paymentBtnGroup .paymentMethod.active .method {
                border-color: #007bff;
                outline: none !important;
                box-shadow: 0px 3px 22px 0px #7b7b7b;
            }

            .paymentWrap .paymentBtnGroup .paymentMethod .method {
                position: absolute;
                right: 0px;
                top: 3px;
                bottom: 3px;
                left: 3px;
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                border: 2px solid transparent;
                transition: all 0.5s;
            }

            .paymentWrap .paymentBtnGroup .paymentMethod .method.boleto {
                background-image: url("/img/boleto.png");
            }

            .paymentWrap .paymentBtnGroup .paymentMethod .method.cartao {
                background-image: url("/img/cartao.png");
            }

            .paymentWrap .paymentBtnGroup .paymentMethod .method:hover {
                border-color: #6610f2;
                outline: none !important;
            }

        </style>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $("#cnpj").mask("99.999.999/9999-99");
            $("#telefone").mask("(99) 99999-9999");

            $('input[name="cep"]').mask('00.000-000');

            $(document).on('change', ".htm-contrato", function() {
                let name = $(this).attr('name');
                let value = this.value;
                switch (value) {
                    case 'B':
                    $('#htm_' + name).html('boleto bancário');
                        break;
                    case 'C':
                    $('#htm_' + name).html('cartão de crédito');
                        break;                
                    default:
                    $('#htm_' + name).html(value);
                        break;
                }
            });            

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

            $(document).on('change', "input[name='flg_pgto']", function() {
                let opt = $(this).val();
                switch (opt) {
                    case 'C': //CARTÃO
                        $.ajax({
                            url: '/usuario/opcao-cartao',
                            type: 'GET',
                            success: function(data) {
                                // handle success response
                                $('#payment').empty().html(data.html);
                            },
                            error: function(data) {
                                // nothing
                            },
                            contentType: false,
                            processData: false
                        });

                        break;

                    default: //BOLETO
                        let html_boleto = "<div class='col-xs-6 col-sm-8 col-md-12'>" +
                            "<div class='form-group'>" +
                            "<strong>Endereçar o boleto à:</strong>" +
                            "<select name='titular' class='form-control'>" +
                            "<option value='J'>Igreja(CNPJ)</option>" +
                            "<option value='F'>{{ \Auth::user()->name }}</option>" +
                            "</select>" +
                            "</div>" +
                            "</div>";
                        $('#payment').empty().html(html_boleto);
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
                            //none
                            break;
                        case 'test-form-3':
                            /*if(!inputPasswordForm.value.length){
                              event.preventDefault()
                              form.classList.add('was-validated')
                            }*/
                            let opt = $('input[name="flg_pgto"]:checked').val();
                            //console.log($('input[name="flg_pgto"]:checked').val());
                            switch (opt) {
                                case 'C': //VALIDAÇÃO PARA CARTÃO
                                    if (
                                        !document.getElementById('cardname').value.length ||
                                        !document.getElementById('cardnum').value.length ||
                                        !document.getElementById('carddigito').value.length) {
                                        event.preventDefault()
                                        form.classList.add('was-validated')
                                    }
                                    break;
                                default: //VALIDAÇÃO PARA BOLETO
                                    //event.preventDefault()
                                    form.classList.add('was-validated')
                            }
                            break;
                        case 'test-form-4':
                            if (!$('#terms_accept').is(':checked')) {
                                event.preventDefault()
                                form.classList.add('was-validated')
                            }
                            //terms_accept
                            break;
                        default:

                    }
                })
            })();

            $("form[id='create']").on('submit', function(e) {
                e.preventDefault();
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
                            window.location.href = "{{ route('home') }}";
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
                                    aria-controls="test-form-1" disabled>
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Informações básicas</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-2">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger2"
                                    aria-controls="test-form-2" disabled>
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Forma de pagamento</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-3">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3"
                                    aria-controls="test-form-3" disabled>
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Cobrança</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-4">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger4"
                                    aria-controls="test-form-4" disabled>
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Termos de serviço</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-form-5">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger5"
                                    aria-controls="test-form-5" disabled>
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
                                                <input type="text" class="form-control htm-contrato" name="nome" id="nome"
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
                                                <input type="text" name="rua" id="rua" class="form-control htm-contrato" required>
                                                <div class="invalid-feedback">Informe a rua</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <strong>Número:</strong>
                                                <input type="text" name="numero" id="numero" class="form-control htm-contrato" required>
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
                                                <input type="text" name="bairro" id="bairro" class="form-control htm-contrato" required>
                                                <div class="invalid-feedback">Informe o bairro</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Cidade:</strong>
                                                <input type="text" name="cidade" id="cidade" class="form-control htm-contrato" required>
                                                <div class="invalid-feedback">Informe a cidade</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <strong>UF:</strong>
                                                <input type="text" name="estado" id="estado" class="form-control htm-contrato"
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
                                    <div class="row">
                                                <div class="paymentCont">
                                                    <div class="paymentWrap">
                                                        <div class="btn-group paymentBtnGroup btn-group-justified"
                                                            data-toggle="buttons">
                                                            <div class="col-md-4">
                                                                <label class="btn paymentMethod active">
                                                                    <div class="method boleto"></div>
                                                                    <input type="radio" name="flg_pgto" class="htm-contrato" value="B" checked>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="btn paymentMethod ml-4">
                                                                    <div class="method cartao"></div>
                                                                    <input type="radio" name="flg_pgto" class="htm-contrato" value="C">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!--<div class="form-group">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="boleto" name="flg_pgto" value="B" checked />
                                            <label for="boleto">Boleto</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="cartao" name="flg_pgto" value="C" />
                                            <label for="cartao">Cartão</label>
                                        </div>
                                    </div>-->
                                    <!--boleto/crédito-->

                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                    <button type="button" class="btn btn-primary float-right mr-2"
                                        onclick="stepperForm.previous()">Anterior</button>
                                </div>

                                <div id="test-form-3" role="tabpanel" class="bs-stepper-pane fade"
                                    aria-labelledby="stepperFormTrigger3">

                                    <div class="row" id="payment">
                                        <div class="col-xs-6 col-sm-8 col-md-12">
                                            <div class="form-group">
                                                <strong>Endereçar o boleto à:</strong>
                                                <select name="titular" class="form-control">
                                                    <option value="J">Igreja(CNPJ)</option>
                                                    <option value="F">{{ \Auth::user()->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                    <button type="button" class="btn btn-primary float-right mr-2"
                                        onclick="stepperForm.previous()">Anterior</button>
                                </div>

                                <div id="test-form-4" role="tabpanel" class="bs-stepper-pane fade"
                                    aria-labelledby="stepperFormTrigger4">

                                    <div class="row">
                                        @include('termos-eglise')
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="terms_accept" class="custom-control-input"
                                                id="terms_accept" required>
                                            <label class="custom-control-label" for="terms_accept"> Eu aceito
                                                os <a href="#">termos de
                                                    serviço</a>.</label>
                                            <div class="invalid-feedback">Leia e ceite os termos de serviço</div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="stepperForm.next()">Próximo</button>
                                    <button type="button" class="btn btn-primary float-right mr-2"
                                        onclick="stepperForm.previous()">Anterior</button>
                                </div>

                                <div id="test-form-5" role="tabpanel" class="bs-stepper-pane fade"
                                    aria-labelledby="stepperFormTrigger3">

                                    <div class="row">
                                        @include('utils.htm-contrato')
                                    </div>

                                    <button type="submit" class="btn btn-success float-right">Confirmar</button>
                                    <button type="button" class="btn btn-primary float-right mr-2"
                                        onclick="stepperForm.previous()">Anterior</button>
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
