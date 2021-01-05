@extends('layouts.site')

@section('title', 'Perfis | Home')

@push('script')

@endpush


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Perfis</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Perfis</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
      <!-- Default box -->
    <div class="card" >
      <div class="card-header">
        <div class="card-title">

        </div>

        <div class="card-tools">
          <a type="button" class="btn btn-block btn-primary btn-sm" href="{{ route('perfis.create') }}">
            <i class="fas fa-plus"></i>&nbsp;Novo perfil
          </a>          
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-reponsive-md">
              <div style="overflow-x:auto;">
                <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="30%">Nome</th>
                    <th width="30%">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                            <div class="btn-group">
                                <a type="button" class="btn btn-warning btn-sm" href="{{ route('perfis.edit',$role->id) }}"><i class="fas fa-edit"></i></a>  
                                {!! Form::open(['method' => 'DELETE','route' => ['perfis.destroy', $role->id],'style'=>'display:inline']) !!}
                                    {{ Form::button('<i class="fa fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm'] )  }}
                                {!! Form::close() !!} 
                                </div>
                            </td>
                        </tr>
                @endforeach
                </tbody>
                </table>
             </div>
             {{ $roles->links() }}
            </div>
          </div>
        </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->


  </section>

@endsection