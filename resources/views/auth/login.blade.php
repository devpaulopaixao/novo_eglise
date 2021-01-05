@extends('layouts.login')

@section('content')

<div class="card">

    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça o login para iniciar a sessão</p>

      <form method="POST" action="{{ route('login') }}">
      @csrf
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email">
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

        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
        <div class="input-group mb-3">
            <label style="color: red;">{{ $message }}</label>
        </div>
        @enderror

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
        </div>

      </form>

      @if (Route::has('password.request'))
      <p class="mb-1">
        <a href="{{ route('password.request') }}">Esqueci minha senha</a>
      </p>
      @endif

    </div>
  </div>

</div>
@endsection
