@extends('layouts.temp')

@section('title', 'Registre-se')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script>
            $('input[name="cpf"]').mask('000.000.000-00', {
                reverse: true
            });
            $('input[name="cell"]').mask('(000) 00000-0000');
            $('input[name="phone"]').mask('(000) 00000-0000');

            $(function() {
                $.validator.setDefaults({
                    submitHandler: function(ev) {
                        ev.preventDefault();
                    }
                });
                $('#frm').validate({
                    rules: {
                        'name': {
                            required: true,
                        },
                        'email': {
                            required: true,
                            email: true,
                        },
                        'cpf': {
                            required: true
                        },
                        'cep': {
                            required: true
                        },
                        'rua': {
                            required: true
                        },
                        'numero': {
                            required: true
                        },
                        'bairro': {
                            required: true
                        },
                        'cidade': {
                            required: true
                        },
                        'estado': {
                            required: true
                        },
                        'senha': {
                            required: true
                        },
                        'confirmacao': {
                            required: true,
                            equalTo : "#senha"
                        },
                        'terms_accept': {
                            required: true
                        },
                    },
                    messages: {
                        'name': {
                            required: "Insira o seu nome"
                        },
                        'email': {
                            required: "Informe o seu email",
                            email: "Informe um email válido"
                        },
                        'cpf': {
                            required: "Informe o seu cpf"
                        },
                        'cep': {
                            required: "Informe o seu CEP"
                        },
                        'rua': {
                            required: "Informe o nome da rua"
                        },
                        'numero': {
                            required: "Informe o n° do imóvel"
                        },
                        'bairro': {
                            required: "Informe o nome do bairro"
                        },
                        'cidade': {
                            required: "Informe o nome da cidade"
                        },
                        'estado': {
                            required: "Informe a UF"
                        },
                        'senha': {
                            required: "Informe a senha"
                        },
                        'confirmacao': {
                            required: "Confirme a senha",
                            equalTo: "A confirmação está diferente da senha"
                        },
                        'terms_accept': "Leia e aceite os termos de serviço"
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
    <div class="row">
        <div class="col-md-12">

            <div class="container-fluid pt-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <form method="POST" action="{{ route('registrar') }}" novalidate="novalidate"
                                    autocomplete="off" id="frm">
                                    @csrf
                                    <div class="card-header">Formulário de registro</div>

                                    <div class="card-body">

                                        @if ($errors->all())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-hidden="true">×</button>
                                                    <i class="icon fas fa-ban"></i>
                                                    {{ $error }}
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="row">
                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Nome:</strong>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Email:</strong>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <strong>Cpf:</strong>
                                                    <input type="text" name="cpf" class="form-control"
                                                        value="{{ old('cpf') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <strong>Sexo:</strong>
                                                    <select name="genre" class="form-control">
                                                        <option value="">Selecione</option>
                                                        <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>
                                                            Feminino
                                                        </option>
                                                        <option value="M" {{ old('genre') == 'M' ? 'selected' : '' }}>
                                                            Masculino</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <strong>Celular:</strong>
                                                    <input type="text" name="cell" class="form-control"
                                                        value="{{ old('cell') }}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                          <x-endereco />

                                          <div class="col-xs-6 col-sm-12 col-md-5">
                                              <div class="form-group">
                                                  <strong>Senha:</strong>
                                                  <input type="password" name="senha" id="senha" class="form-control" autocomplete="off">
                                              </div>
                                          </div>
                                          <div class="col-xs-6 col-sm-12 col-md-5">
                                              <div class="form-group">
                                                  <strong>Confirmar senha:</strong>
                                                  <input type="password" name="confirmacao" class="form-control" autocomplete="off">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="terms_accept"
                                                            class="custom-control-input" id="terms_accept">
                                                        <label class="custom-control-label" for="terms_accept"> Eu aceito
                                                            os <a href="#" data-toggle="modal"
                                                                data-target="#modal-terms">termos de serviço</a>.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="float-left">
                                                <button type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- start terms -->
    <div class="modal fade" id="modal-terms" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Termos de serviço</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-6 col-sm-12 col-md-12">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua. Blandit libero volutpat sed cras ornare arcu dui vivamus.
                                Eget
                                magna fermentum iaculis eu non diam phasellus vestibulum lorem. Risus commodo viverra
                                maecenas
                                accumsan lacus. Maecenas accumsan lacus vel facilisis. Est ullamcorper eget nulla facilisi
                                etiam. Ligula ullamcorper malesuada proin libero nunc consequat. Sollicitudin tempor id eu
                                nisl
                                nunc. Arcu vitae elementum curabitur vitae nunc sed velit dignissim. Nisi porta lorem mollis
                                aliquam ut porttitor leo a diam. Dolor sit amet consectetur adipiscing elit ut aliquam
                                purus.
                                Scelerisque eu ultrices vitae auctor eu augue ut lectus. Nunc lobortis mattis aliquam
                                faucibus
                                purus.
                            </p>

                            <p>
                                Id neque aliquam vestibulum morbi blandit. Scelerisque fermentum dui faucibus in ornare quam
                                viverra. Pellentesque id nibh tortor id. Est ultricies integer quis auctor elit. Ut diam
                                quam
                                nulla porttitor massa. Facilisis mauris sit amet massa vitae. Viverra aliquet eget sit amet
                                tellus cras adipiscing enim eu. Fringilla phasellus faucibus scelerisque eleifend donec
                                pretium.
                                Auctor neque vitae tempus quam. Adipiscing at in tellus integer feugiat scelerisque varius
                                morbi
                                enim. Massa tempor nec feugiat nisl pretium fusce id. Amet est placerat in egestas erat
                                imperdiet sed euismod nisi. Ut placerat orci nulla pellentesque dignissim. Elementum tempus
                                egestas sed sed risus pretium quam vulputate dignissim. Egestas diam in arcu cursus euismod
                                quis. Fermentum et sollicitudin ac orci phasellus egestas tellus rutrum tellus. In hac
                                habitasse
                                platea dictumst vestibulum rhoncus est pellentesque elit. Eleifend quam adipiscing vitae
                                proin
                                sagittis nisl rhoncus mattis.
                            </p>

                            <p>
                                Condimentum lacinia quis vel eros donec ac odio. Felis donec et odio pellentesque diam
                                volutpat
                                commodo. Pulvinar etiam non quam lacus suspendisse. Integer vitae justo eget magna
                                fermentum.
                                Auctor eu augue ut lectus arcu bibendum at varius vel. Egestas sed sed risus pretium quam
                                vulputate dignissim. Praesent tristique magna sit amet purus gravida quis blandit. Diam ut
                                venenatis tellus in. Consequat nisl vel pretium lectus quam id leo in vitae. Egestas
                                maecenas
                                pharetra convallis posuere morbi leo urna molestie at. Eget aliquet nibh praesent tristique
                                magna sit amet purus. Amet consectetur adipiscing elit pellentesque habitant morbi
                                tristique. Id
                                donec ultrices tincidunt arcu non sodales neque sodales. Venenatis a condimentum vitae
                                sapien
                                pellentesque habitant.
                            </p>

                            <p>
                                Velit dignissim sodales ut eu sem integer vitae. Curabitur vitae nunc sed velit dignissim
                                sodales ut. Lorem donec massa sapien faucibus. Mauris cursus mattis molestie a. Tellus orci
                                ac
                                auctor augue mauris augue neque gravida. Ipsum dolor sit amet consectetur adipiscing elit
                                duis
                                tristique. Massa ultricies mi quis hendrerit dolor. Cursus turpis massa tincidunt dui ut
                                ornare.
                                Pulvinar neque laoreet suspendisse interdum consectetur libero id faucibus. Interdum varius
                                sit
                                amet mattis vulputate enim nulla aliquet porttitor. Cras adipiscing enim eu turpis egestas
                                pretium.
                            </p>

                            <p>
                                Id porta nibh venenatis cras sed felis eget velit. Lacus sed turpis tincidunt id aliquet
                                risus
                                feugiat. Vulputate odio ut enim blandit volutpat. Sit amet aliquam id diam. Vel quam
                                elementum
                                pulvinar etiam non quam. Egestas congue quisque egestas diam in arcu. Hac habitasse platea
                                dictumst quisque sagittis purus sit amet. Enim tortor at auctor urna nunc id cursus metus.
                                Odio
                                ut sem nulla pharetra diam sit amet nisl. Platea dictumst vestibulum rhoncus est
                                pellentesque
                                elit. Ornare quam viverra orci sagittis. Vel facilisis volutpat est velit egestas dui id
                                ornare.
                            </p>

                            <p>
                                Et tortor consequat id porta nibh venenatis cras sed. Nisl tincidunt eget nullam non nisi
                                est
                                sit amet facilisis. Et ligula ullamcorper malesuada proin libero nunc. Suspendisse potenti
                                nullam ac tortor. Feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper.
                                Elementum facilisis leo vel fringilla est ullamcorper. Ut faucibus pulvinar elementum
                                integer.
                                In egestas erat imperdiet sed euismod. Quis ipsum suspendisse ultrices gravida dictum fusce
                                ut
                                placerat. Tellus orci ac auctor augue mauris augue. Eget duis at tellus at urna condimentum
                                mattis pellentesque. Ultrices neque ornare aenean euismod elementum nisi quis eleifend. A
                                arcu
                                cursus vitae congue mauris rhoncus aenean vel elit. Eros in cursus turpis massa tincidunt.
                                Diam
                                vulputate ut pharetra sit amet aliquam id diam maecenas. Luctus venenatis lectus magna
                                fringilla
                                urna.
                            </p>

                            <p>
                                Vulputate odio ut enim blandit. Euismod in pellentesque massa placerat duis ultricies. Erat
                                nam
                                at lectus urna duis convallis convallis. Ligula ullamcorper malesuada proin libero nunc
                                consequat interdum varius sit. Sed risus ultricies tristique nulla aliquet enim tortor at
                                auctor. Sagittis vitae et leo duis. Varius vel pharetra vel turpis nunc eget. Magna
                                fermentum
                                iaculis eu non diam phasellus. Scelerisque mauris pellentesque pulvinar pellentesque
                                habitant
                                morbi tristique senectus. Feugiat in ante metus dictum. Diam ut venenatis tellus in metus
                                vulputate eu scelerisque felis. Sapien faucibus et molestie ac. Aliquet nec ullamcorper sit
                                amet.
                            </p>

                            <p>
                                Eu facilisis sed odio morbi quis commodo odio aenean sed. Ultricies tristique nulla aliquet
                                enim
                                tortor at. In dictum non consectetur a erat nam at lectus. Neque viverra justo nec ultrices.
                                Aliquam eleifend mi in nulla posuere. Mattis enim ut tellus elementum sagittis vitae. Mauris
                                a
                                diam maecenas sed enim ut sem viverra. Sollicitudin nibh sit amet commodo. Sed tempus urna
                                et
                                pharetra pharetra massa massa ultricies mi. Enim praesent elementum facilisis leo vel
                                fringilla
                                est ullamcorper eget. Ut sem nulla pharetra diam sit amet nisl suscipit adipiscing. Dis
                                parturient montes nascetur ridiculus mus mauris. Duis ultricies lacus sed turpis tincidunt
                                id
                                aliquet. Id leo in vitae turpis massa sed.
                            </p>

                            <p>
                                Magna fringilla urna porttitor rhoncus dolor purus non. Congue quisque egestas diam in.
                                Faucibus
                                scelerisque eleifend donec pretium vulputate sapien nec. A iaculis at erat pellentesque.
                                Cursus
                                in hac habitasse platea dictumst quisque sagittis purus sit. Gravida in fermentum et
                                sollicitudin ac orci phasellus. Placerat duis ultricies lacus sed turpis tincidunt id
                                aliquet.
                                Habitant morbi tristique senectus et netus et. Quis blandit turpis cursus in hac habitasse
                                platea. Etiam tempor orci eu lobortis elementum. Eu turpis egestas pretium aenean pharetra.
                                Massa placerat duis ultricies lacus sed turpis tincidunt. In metus vulputate eu scelerisque
                                felis. Purus semper eget duis at tellus at urna condimentum. Neque viverra justo nec
                                ultrices
                                dui sapien eget mi. Egestas erat imperdiet sed euismod nisi porta lorem. Massa eget egestas
                                purus viverra.
                            </p>

                            <p>
                                Feugiat nibh sed pulvinar proin gravida hendrerit lectus. Ac tincidunt vitae semper quis
                                lectus
                                nulla at. Eros in cursus turpis massa tincidunt dui. Velit euismod in pellentesque massa
                                placerat. Nisi vitae suscipit tellus mauris. Aliquet bibendum enim facilisis gravida neque
                                convallis a cras. Fames ac turpis egestas integer eget aliquet. Sed turpis tincidunt id
                                aliquet
                                risus feugiat in ante. Nunc congue nisi vitae suscipit tellus mauris a diam. Mus mauris
                                vitae
                                ultricies leo integer malesuada nunc. Duis tristique sollicitudin nibh sit amet commodo
                                nulla
                                facilisi nullam. Integer malesuada nunc vel risus commodo viverra maecenas. Augue mauris
                                augue
                                neque gravida. Lacus vestibulum sed arcu non odio euismod lacinia.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group botao float-right" role="group">
                        <button type="button" class="btn btn-sm btn-primary badge-pill" data-dismiss="modal">
                            <i class="fas fa-times"></i>&nbsp;Fechar
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end terms -->
@endsection
