@extends('content/dashboard/professor/dashboards-professor')

@section('content')
    @if (isset($turmasDoProfessor))
        <div class="card mb-4">
            <h4 class="card-header">Turmas em que você deve aprovar os alunos
            </h4>
            <div class="card-body" id="formAnamnese">
                <input type="hidden" name="_token" value="7h3l1gOwGiQuuzwqL6GaZThQd9zXmKF3OsbkjAWe"> <input type="hidden"
                    value="5" name="id">
                <h6>1. Aqui mostra suas turmas e a lista de espera de cada uma delas.

                </h6>
                <div class="divider">
                    <div class="divider-text">Não coloque mais do que a quantidade de vagas</div>
                </div>
                <div class="row g-3">
                    @foreach ($turmasDoProfessor as $turmaDoProfessor)
                        <div class="col-12 col-md-4 mb-5">
                            <div class="card shadow-none bg-transparent border border-primary">
                                <div class="card-header">{{ $turmaDoProfessor->idade_min_max }} anos</div>
                                <div class="card-body text-primary">
                                    <h5 class="card-title">{{ $turmaDoProfessor->modalidade->nome }}</h5>
                                    <p class="card-text">Nível: {{ $turmaDoProfessor->nivel }}</p>
                                    <p class="card-text">Dias da semana:
                                        {{ implode(' , ', json_decode($turmaDoProfessor->dias_semana)) }}</p>
                                    <p class="card-text">Horário: {{ $turmaDoProfessor->horario }}</p>
                                    <div class="divider">
                                        <div class="divider-text">Veja os alunos</div>
                                    </div>
                                    <div class="pt-4">
                                        <button type="button" class="btn btn-primary me-sm-3 me-1"
                                            onclick="mostrarAlunos({{ $turmaDoProfessor->id }})">Ver</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="modal" tabindex="-1" id="modalListaEspera">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de espera</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tabela-lista-espera" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Data Inscricão</th>
                                        <th>Nome Aluno</th>
                                        <th>Imagem Perfil</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        Você não possui turmas para dar aula.
    @endif

    <div class="modal fade" id="dadosAluno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Dados Básicos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="nome" class="form-label">Nome
                            </label>
                            <input class="form-control-plaintext" type="text" id="nome" value="Nome" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="nome" class="form-label">Idade
                            </label>
                            <input class="form-control-plaintext" type="text" id="idade" value="Idade" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="nome" class="form-label">Telefone
                            </label>
                            <input class="form-control-plaintext" type="text" id="telefone" value="Telefone" readonly />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#modalListaEspera"
                        data-bs-toggle="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-da-pagina')
    <script>
        $(document).ready(function() {
            $('#tabelaAlunos').DataTable();
        });

        function mostrarAlunos(idTurma) {
            $.ajax({
                url: '{{ route('buscar-lista-espera') }}',
                type: 'POST',
                data: {
                    id: idTurma
                },
                dataType: 'json',
                success: function(response) {
                    // Atualize dinamicamente o conteúdo da tabela no modal
                    var tabela = $('#tabela-lista-espera').DataTable();
                    tabela.clear().draw();


                    carregarAlunos(response, tabela);


                    // Abra o modal
                    $('#modalListaEspera').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function aprovarAluno(idAluno, idTurma) {
            $.ajax({
                url: '{{ route('aprovar-aluno') }}',
                type: 'POST',
                data: {
                    idAluno: idAluno,
                    idTurma: idTurma,
                },
                dataType: 'json',
                success: function(response) {
                    // Limpar e redesenhar a tabela
                    var tabela = $('#tabela-lista-espera').DataTable();
                    tabela.clear().draw();

                    carregarAlunos(response, tabela);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function desaprovarAluno(idAluno, idTurma) {
            $.ajax({
                url: '{{ route('desaprovar-aluno') }}',
                type: 'POST',
                data: {
                    idAluno: idAluno,
                    idTurma: idTurma,
                },
                dataType: 'json',
                success: function(response) {
                    // Limpar e redesenhar a tabela
                    var tabela = $('#tabela-lista-espera').DataTable();
                    tabela.clear().draw();

                    carregarAlunos(response, tabela);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function buscarAluno(idAluno) {
            $.ajax({
                url: '{{ route('buscar-aluno') }}',
                type: 'POST',
                data: {
                    id: idAluno,
                },
                dataType: 'json',
                success: function(response) {
                    $('#nome').val(response.name);
                    $('#idade').val(response.user_informacoe.idade);
                    $('#telefone').val(response.user_informacoe.telefone);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function zoomImage(img) {

            if (img.style.transform === 'scale(4)') {
                img.style.transform = 'scale(1)';
                img.style.zIndex = 'auto';
            } else {

                img.style.transform = 'scale(4)';
                img.style.zIndex = '1081';
            }
        }

        function carregarAlunos(response, tabela){
            $.each(response, function(index, aluno) {
                        // Verifica se 'created_at' é nulo
                        if (aluno.created_at === null) {
                            // Gera aleatoriamente uma data dentro de até 1 mês atrás
                            const umMesAtras = new Date();
                            umMesAtras.setMonth(umMesAtras.getMonth() - 1);
                            const dataAleatoria = new Date(umMesAtras.getTime() + Math.random() * (
                                new Date() - umMesAtras.getTime()));

                            // Formata a data para incluir o dia, mês e horário
                            aluno.created_at = dataAleatoria.toLocaleString();
                        } else {
                            const dataOriginal = new Date(aluno.created_at);
                            aluno.created_at = dataOriginal.toLocaleString();
                        }

                        tabela.row.add([
                            aluno.created_at, // Utiliza a data formatada ou aleatória
                            aluno.name,
                            `<div class="avatar">
                            <img src="../../../assets/img/perfil/${aluno.imagem_perfil}" onclick="zoomImage(this)" alt class="w-px-40 h-auto rounded-circle">
                            </div>`,
                            `<button type="button" class="btn btn-primary" onclick="aprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">
                                <i class="bx bx-user-check bx-sm"></i>
                            </button>
                            <button type="button" class="btn btn-danger" onclick="desaprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">
                                <i class='bx bxs-user-x bx-sm'></i>
                            </button>
                            <button type="button" class="btn btn-info" data-bs-target="#dadosAluno" data-bs-toggle="modal" onclick="buscarAluno(${aluno.pivot.aluno_id})">
                                <i class='bx bx-info-circle bx-sm'></i>
                            </button>`
                        ]).draw();
                    });
        }
    </script>
@endsection
