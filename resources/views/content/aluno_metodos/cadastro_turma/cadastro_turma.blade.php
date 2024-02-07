@extends('content/dashboard/aluno/dashboards-aluno')

@section('content')
    <div class="mb-3 mx-auto justify-content-start row row-cols-md-4">
        <div class="col-12">
            <label for="exampleFormControlSelect1" class="form-label">Bairro</label>
            <select class="form-select" id="bairroSelect" onchange="filtrarTurma(this.value,modalidadeSelect.value, professorSelect.value)"
                aria-label="Default select example">
                <option value="" selected>Todos</option>
                @foreach ($bairros as $bairro)
                    <option value="{{ $bairro->nome }}">{{ $bairro->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label for="exampleFormControlSelect1" class="form-label">Modalidade</label>
            <select class="form-select" id="modalidadeSelect" aria-label="Default select example"
                onchange="filtrarTurma(bairroSelect.value,this.value, professorSelect.value)">
                <option value="" selected>Todas</option>
                @foreach ($modalidades as $modalidade)
                    <option value="{{ $modalidade->id }}">{{ $modalidade->nome }}</option>
                @endforeach
            </select>
            
        </div>
        <div class="col-12">
            <label for="exampleFormControlSelect1" class="form-label">Professor</label>
            <select class="form-select" id="professorSelect" aria-label="Default select example"
                onchange="filtrarTurma(bairroSelect.value,modalidadeSelect.value, this.value)">
                <option value="" selected>Todos</option>
                
                @foreach ($professores as $professor)

                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4" id="divTurmas">

        @foreach ($turmas as $turma)
            <div class="col">
                <div class="card text-center mx-auto" style="width: 18rem;">
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
                </div>

            </div>
        @endforeach
    </div>
    {{-- <nav aria-label="Page navigation">
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
    </div> --}}
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

        function filtrarTurma(bairro, modalidade, professor) {
            $.ajax({
                url: '{{ route('filtrar-turmas') }}',
                type: 'POST',
                data: {
                    bairro: bairro,
                    modalidade: modalidade,
                    professor:professor,
                },
                success: function(response) {
                    document.getElementById('divTurmas').innerHTML = '';
                    response.turmaFiltrada.forEach(element => {
                        console.log(element);
                        
                        // Adicionar cada elemento à div (substitua 'seuConteudo' pelo que você deseja exibir)
                        document.getElementById('divTurmas').innerHTML += `<div class="col">
                <div class="card text-center mx-auto" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">${element.modalidade.nome}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Nível: ${element.nivel}</li>
                        <li class="list-group-item">Idade min - max: ${element.idade_min_max} anos</li>
                        <li class="list-group-item">Professor: ${element.professor.name}</li>
                        <li class="list-group-item">Horário: ${element.horario}</li>
                        <li class="list-group-item">Dias da semana: ${element.dias_semana}</li>
                        <li class="list-group-item">Bairro: ${element.endereco.bairro}</li>
                        <li class="list-group-item">Rua: ${element.endereco.rua}</li>
                        <li class="list-group-item">Nome do Local: ${element.endereco.nome_local}</li>

                    </ul>
                    <div class="card-body">
                        @if (isset($existeAnamnese) && $existeAnamnese == true)
                            <button type="button" class="btn btn-primary"
                                onclick="cadastrarTurma(${element.id})">Cadastrar</button>
                        @else
                            <a href="{{ route('dashboard-aluno-cadastro-anamnese') }}">
                                <button type="button" class="btn btn-danger">Clique aqui para fazer anamnese</button>
                            </a>
                        @endif

                    </div>
                </div>

            </div>`;
                    });
                    console.log(response);

                },
                error: function(error) {
                    console.log(error);
                }
            });

        }
    </script>
@endsection
