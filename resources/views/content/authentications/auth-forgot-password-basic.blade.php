@extends('layouts/blankLayout')

@section('title', 'Esqueceu a senha')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Forgot Password -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',['width'=>25,'withbg' => "#696cff"])</span>
              <span class="demo text-body fw-bolder fs-3">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Esqueceu a senha? 🔒</h4>
          <p class="mb-4">Digite seu email e mandaremos instruções para redefinir a senha.</p>
          <form id="formAuthentication" class="mb-3" action="javascript:void(0)" method="GET">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Digite seu email" autofocus>
            </div>
            <button class="btn btn-primary d-grid w-100">Envial link para resetar</button>
          </form>
          <div class="text-center">
            <a href="/login" class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
              Voltar para login
            </a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
