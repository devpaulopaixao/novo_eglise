@extends('layouts.site')

@section('title', 'Home')

@push('script')

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

    @if (\Request::session()->get('igreja_id'))
        <label>É MEMBRO</label>
    @else
        <label>NÃO É MEMBRO</label>
    @endif

</section>

@endsection
