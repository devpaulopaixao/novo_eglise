@extends('layouts.site')

@section('title', 'Perfis | Editar')

@push('script')

@endpush


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Perfil</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Perfis</li>
            <li class="breadcrumb-item active">Cadastro</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
      <!-- Default box -->
    <div class="card" >

      <div class="card-body">
        {!! Form::model($role, ['method' => 'PATCH','route' => ['perfis.update', $role->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Nome','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br/>
                    @foreach($permission as $value)
                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                    <br/>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-success">Salvar</button>
              <a type="button" href="{{route('perfis.index')}}" class="btn btn-primary">Cancelar</a>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->


  </section>

@endsection