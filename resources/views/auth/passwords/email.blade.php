
@extends('layouts.login')

@section('content')

<div class="card">

    <div class="card-body login-card-body">
      <p class="login-box-msg">Insira seu email para recuperar a senha</p>

      @if (session('status'))
        <div class="input-group mb-3">
            <label style="color: red;">{{ session('status') }}</label>
        </div>
     @endif

      <form method="POST" action="{{ route('password.email') }}">
      @csrf
        <div class="input-group mb-3">
          <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required  placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('email')
        <div class="input-group mb-3">
            <label style="color: red;">{{ $message }}</label>
        </div>
        @enderror

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
          </div>
        </div>

      </form>

    </div>
  </div>

</div>
@endsection

