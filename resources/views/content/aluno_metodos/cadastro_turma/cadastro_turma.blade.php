@extends('content/dashboard/aluno/dashboards-aluno')

@section('content')
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach ($turmas as $turma)
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $turma->modalidade }}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Nível: {{ $turma->nivel }}</li>
                        <li class="list-group-item">Idade min - max: {{ $turma->idade_min_max }} anos</li>
                        <li class="list-group-item">Professor: {{ $turma->professor }}</li>
                        <li class="list-group-item">Horário: {{ $turma->horario }}</li>
                        <li class="list-group-item">Dias da semana: {{ $turma->dias_semana }}</li>
                        <li class="list-group-item">Bairro: {{ $turma->endereco->bairro }}</li>
                        <li class="list-group-item">Rua: {{ $turma->endereco->rua }}</li>
                        <li class="list-group-item">Nome do Local: {{ $turma->endereco->nome_local }}</li>

                    </ul>
                    <div class="card-body">
                        @if (isset($existeAnamnese) && $existeAnamnese == true)
                            <button type="button" class="btn btn-primary"
                                onclick="cadastrarTurma({{ $turma->id }})">Cadastrar</button>
                        @else
                        <a href="{{ route('dashboard-aluno-cadastro-anamnese') }}">
                            <button type="button" class="btn btn-danger">Clique aqui para fazer anamnese</button>
                        </a>
                        @endif

                    </div>
                    <div class="card-footer text-muted">
                        Periódo: {{ $turma->data_inicio }} até {{ $turma->data_termino }}
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if ($turmas->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-label="@lang('pagination.previous')">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $turmas->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">&laquo;</a>
                </li>
            @endif

            @foreach ($turmas->getUrlRange(1, $turmas->lastPage()) as $page => $url)
                @if ($page == $turmas->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            @if ($turmas->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $turmas->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-label="@lang('pagination.next')">&raquo;</span>
                </li>
            @endif
        </ul>

    </nav>
    <div>
        Exibindo {{ $turmas->firstItem() }} - {{ $turmas->lastItem() }} de {{ $turmas->total() }} turmas
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="mensagem" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Mensagem</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="corpoMensagem">

            </div>
        </div>
    </div>
@endsection

@section('script-da-pagina')
    <script>
        @if (isset($existeAnamnese) && $existeAnamnese == true)
            function cadastrarTurma(id) {
                $.ajax({
                    url: '{{ route('cadastrar-lista-turma') }}',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(mensagem) {
                        console.log(mensagem)
                        $("#corpoMensagem").text(mensagem.mensagem);
                        const toast = new bootstrap.Toast($('#mensagem'))
                        toast.show()
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        @endif
    </script>
@endsection
