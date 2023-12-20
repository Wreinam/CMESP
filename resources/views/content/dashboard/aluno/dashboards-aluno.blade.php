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
                            <img src="{{ asset('assets/img/illustrations/alunos.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($existeAnamnese) && !$existeAnamnese)
        <div class="alert alert-danger" role="alert">
            Atenção para se cadastrar em uma turma você deve concluir sua anamnese!!!
            <a href="{{ route('dashboard-aluno-cadastro-anamnese') }}">
                <button type="button" class="btn btn-danger">Clique aqui</button>
            </a>
        </div>
    @else
        @if ((isset($matriculas) && !$matriculas->isEmpty()) || (isset($turmasListaEspera) && !$turmasListaEspera->isEmpty()))
            @if (isset($matriculas) && !$matriculas->isEmpty())
                <div class="card mb-4">
                    <h4 class="card-header">Matriculas</h4>
                    <div class="card-body">
                        <h6>1. Lembre-se de nunca faltar as aulas</h6>
                        <div class="divider">
                            <div class="divider-text">Suas matriculas</div>
                        </div>
                        <div class="row g-3">
                            @foreach ($matriculas as $matricula)
                                <div class="col-12 col-md-4 mb-5">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-header">{{ $matricula->turma->idade_min_max }} anos</div>
                                        <div class="card-body text-primary">
                                            <h5 class="card-title">{{ $matricula->turma->modalidade->nome }}</h5>
                                            <p class="card-text">Nível: {{ $matricula->turma->nivel }}</p>
                                            <p class="card-text">Dias da Semana:
                                                {{ implode(' , ', json_decode($matricula->turma->dias_semana)) }}</p>
                                            <p class="card-text">Horário: {{ $matricula->turma->horario }}</p>
                                            <p class="card-text">Faltas: {{ $matricula->faltas }}</p>
                                            <p class="card-text">Status: {{ $matricula->status }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($turmasListaEspera) && !$turmasListaEspera->isEmpty())
                <div class="card mb-4">
                    <h4 class="card-header">Esperando aprovação da Secretaria de Esportes</h4>
                    <div class="card-body">
                        <input type="hidden" name="_token" value="7h3l1gOwGiQuuzwqL6GaZThQd9zXmKF3OsbkjAWe"> <input
                            type="hidden" value="5" name="id">
                        <h6>1. Lembre-se de sempre manter os dados atualizados, a secretaria entrará em contato por email ou
                            por
                            telefone.</h6>
                        <div class="divider">
                            <div class="divider-text">Suas inscrições esperando aprovação</div>
                        </div>
                        <div class="row g-3">
                            @foreach ($turmasListaEspera as $turmaListaEspera)
                                <div class="col-12 col-md-4 mb-5">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-header">{{ $turmaListaEspera->idade_min_max }} anos</div>
                                        <div class="card-body text-primary">
                                            <h5 class="card-title">{{ $turmaListaEspera->modalidade->nome }}</h5>
                                            <p class="card-text">Nível: {{ $turmaListaEspera->nivel }}</p>
                                            <p class="card-text">Dias da Semana:
                                                {{ implode(' , ', json_decode($turmaListaEspera->dias_semana)) }}</p>
                                            <p class="card-text">Horário: {{ $turmaListaEspera->horario }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                Cadastre-se em alguma turma!!
                <a href="{{ route('dashboard-aluno-cadastro-turma') }}">
                    <button type="button" class="btn btn-danger">Clique aqui</button>
                </a>
            </div>
        @endif


    @endif
@endsection

@section('script-da-pagina')

@endsection
