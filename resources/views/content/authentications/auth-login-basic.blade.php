@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              <span class="demo text-body fw-bolder fs-3">{{config('variables.templateName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Bem vindo ao {{config('variables.templateName')}}! 👋</h4>
          <p class="mb-4">Por-Favor faça login</p>
          @if ($mensagem = Session::get('Erro'))
          {{$mensagem}}
              
          @endif
          @if($errors->any())
            @foreach ($errors->all() as $error)
                {{$error}}<br>
            @endforeach
          @endif

          <form id="formAuthentication" class="mb-3" action="/logar" method="POST">
            @csrf
            <div class="mb-3">
              <label for="usuario" class="form-label">Email ou CPF</label>
              <input type="text" class="form-control" id="email" name="usuario" placeholder="Coloque seu email ou CPF" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Senha</label>
                <a href="/forgot-password">
                  <small>Esqueceu a senha?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Relembrar senha
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
            </div>
          </form>

          <p class="text-center">
            <span>Deseja praticar esportes?</span>
            <a href="\register">
              <span>Crie uma conta</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
