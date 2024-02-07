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
            <div class="modal-dialog modal-lg">
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
        Voç^ê nao possuir turmas para dar aula.
    @endif
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
                    $.each(response, function(index, aluno) {
                        tabela.row.add([aluno.name,
                            `<div class="avatar">
                                <img src="../../../assets/img/perfil/${aluno.imagem_perfil}" onclick="zoomImage(this)" alt class="w-px-40 h-auto rounded-circle">
                                 </div>`,
                            `<button type="button" class="btn btn-primary" onclick="aprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Aprovar</button>
                            <button type="button" class="btn btn-danger" onclick="desaprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Desaprovar</button>
                            `
                        ]).draw();
                    })

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

                    $.each(response, function(index, aluno) {
                        tabela.row.add([aluno.name,
                            `<div class="avatar">
                                <img src="../../../assets/img/perfil/${aluno.imagem_perfil}" onclick="zoomImage(this)" alt class="w-px-40 h-auto rounded-circle">
                                 </div>`,
                            `<button type="button" class="btn btn-primary" onclick="aprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Aprovar</button>
                            <button type="button" class="btn btn-danger" onclick="desaprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Desaprovar</button>
                            `
                        ]).draw();
                    });
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

                    $.each(response, function(index, aluno) {
                        tabela.row.add([aluno.name,
                            `<div class="avatar">
                                <img src="../../../assets/img/perfil/${aluno.imagem_perfil}" onclick="zoomImage(this)" alt class="w-px-40 h-auto rounded-circle">
                                 </div>`,
                            `<button type="button" class="btn btn-primary" onclick="aprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Aprovar</button>
                            <button type="button" class="btn btn-danger" onclick="desaprovarAluno(${aluno.pivot.aluno_id},${aluno.pivot.turma_id})">Desaprovar</button>
                            `
                        ]).draw();
                    });
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
    </script>
@endsection
