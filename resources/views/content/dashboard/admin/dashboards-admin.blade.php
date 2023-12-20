@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bem-vindo {{ auth()->user()->name }}! 🎉</h5>
                            <p class="mb-4">Nenhuma mensagem de aviso!</p>

                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">Enviar Mensagem</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 order-1">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-user bx-sm"></i>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">Ver mais</a>
                                    </div>
                                </div>
                            </div>
                            <span>Total de matrículas</span>
                            <h3 class="card-title mb-2">{{ isset($totalMatriculas) ? $totalMatriculas : '0' }}</h3>
                            <small class="text-success fw-semibold">Alunos</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-user-check bx-sm"></i>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard-admin-relatorios-demanda') }}">Ver mais</a>
                                    </div>
                                </div>
                            </div>
                            <span>Demanda</span>
                            <h3 class="card-title text-nowrap mb-1">{{ isset($demanda) ? $demanda : '0' }}</h3>
                            <small class="text-danger fw-semibold">Aguardando vagas</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">Ver mais</a>
                                    </div>
                                </div>
                            </div>
                            <span>Total de alunos</span>
                            <h3 class="card-title mb-2">{{ isset($totalUsuarios) ? $totalUsuarios : '0' }}</h3>
                            <small class="text-success fw-semibold">Usuários</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class='bx bxs-group'></i>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">Ver mais</a>
                                    </div>
                                </div>
                            </div>
                            <span>Idosos</span>
                            <h3 class="card-title text-nowrap mb-1">{{ isset($totalIdosos) ? $totalIdosos : '0' }}</h3>
                            <small class="text-success fw-semibold">Alunos 60+</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-success">
                                      <i class='bx bxs-group'></i>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">Ver mais</a>
                                    </div>
                                </div>
                            </div>
                            <span>Crianças</span>
                            <h3 class="card-title mb-2">{{ isset($totalCriancas) ? $totalCriancas : '0' }}</h3>
                            <small class="text-success fw-semibold">Alunos SUB-14</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->

        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">

            </div>
        </div>
    </div>


@endsection
