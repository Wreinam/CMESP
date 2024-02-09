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
                            @if (isset($quantidadeAlunosNaListaEspera) && !empty($quantidadeAlunosNaListaEspera))
                                @foreach ($quantidadeAlunosNaListaEspera as $turma)
                                    <div class="alert alert-primary alert-dismissible" role="alert">
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">{{$turma->nome}} | {{$turma->horario}}</h6>
                                        <p class="mb-0">Total de alunos na lista de espera: {{$turma->quantidade_alunos_lista_espera}} </p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <p class="mb-4">Nenhuma mensagem de aviso!</p>
                            @endif


                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">Enviar Mensagem</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left d-none d-md-inline">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/prof.png') }}" height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
