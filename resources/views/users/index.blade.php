@extends('layouts.site')

@section('title', 'Usuários | Home')

@push('script')

@endpush


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Usuários</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Usuários</li>
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
          <a type="button" class="btn btn-block btn-primary btn-sm" href="{{ route('usuarios.create') }}">
            <i class="fas fa-plus"></i>&nbsp;Novo Usuário
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
                    <th width="30%">Email</th>
                    <th width="15%">Perfis</th>
                    <th width="10%">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                            </td>
                            <td>
                            <div class="btn-group">
                                <a type="button" class="btn btn-warning btn-sm" href="{{ route('usuarios.edit',$user->id) }}"><i class="fas fa-edit"></i></a>  
                                {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {{ Form::button('<i class="fa fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm'] )  }}
                                {!! Form::close() !!} 
                                </div>
                            </td>
                        </tr>
                @endforeach
                </tbody>
                </table>
             </div>
             {{ $data->links() }}
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