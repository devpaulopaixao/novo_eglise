@extends('layouts.site')

@section('title', 'Home')

    @push('script')
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <style>
            .btn-group-fab {
                position: fixed;
                width: 50px;
                height: auto;
                right: 20px;
                bottom: 20px;
            }

            .btn-group-fab div {
                position: relative;
                width: 100%;
                height: auto;
            }

            .btn-group-fab .btn {
                position: absolute;
                bottom: 20px;
                border-radius: 50%;
                display: block;
                margin-bottom: 4px;
                width: 40px;
                height: 40px;
                margin: 4px auto;
                font-size: 26px;
            }

            .btn-group-fab .btn-main {
                width: 80px;
                height: 80px;
                right: 50%;
                margin-right: -25px;
                border: 2px solid;
                z-index: 9;
            }

            .btn-group-fab .btn-sub {
                bottom: 0;
                z-index: 8;
                right: 50%;
                margin-right: -20px;
                -webkit-transition: all 2s;
                transition: all 0.5s;
            }

        </style>
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
            });

            $(document).on('click', '.more', function(e) {
                window.location.href = "{{route('new.product')}}";
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

        <div class="btn-group-fab" role="group" aria-label="FAB Menu">
            <div>
                <button type="button" class="btn btn-main btn-light has-tooltip more" data-placement="left" title="Menu"> <i
                        class="fa fa-plus"></i> </button>
            </div>
        </div>

    </section>

@endsection
