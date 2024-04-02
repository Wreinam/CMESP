@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    <div class="card p-4">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de Turmas</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabela-turma" class="table table-striped " style="width:100%;">
                <thead>
                    <tr>
                        <th>Modalidade</th>
                        <th>Professor</th>
                        <th>Quantidade Vagas</th>
                        <th>Nível</th>
                        <th>Dias da Semana</th>
                        <th>Horário</th>
                        <th>Idade: Min - Max</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal" tabindex="-1" id="modalMatriculas">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de alunos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tabela-matriculas" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nome Aluno</th>
                                        <th>Faltas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-da-pagina')
    <script>
        new DataTable('#tabela-turma', {
            language: ptBRTranslation,
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-turmas') }}",
            "columns": [{
                    data: "nome",
                    name: "nome"
                },
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "quantidade_vagas",
                    name: "quantidade_vagas"
                },
                {
                    data: "nivel",
                    name: "nivel"
                },
                {
                    data: "dias_semana",
                    name: "dias_semana",
                    render: function(data, type, full, meta) {

                        return data.replace(/[\[\]"']+/g, '');
                    }
                },
                {
                    data: "horario",
                    name: "horario"
                },
                {
                    data: "idade_min_max",
                    name: "idade_min_max"
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    className: 'hide-on-print',
                    render: function(data, type, full, meta) {
                        var idDaTurma = full.id; // Substitua 'id' pelo nome correto do campo de ID no seu DataTable
                        return '<button class="btn btn-primary" data-bs-target="#modalMatriculas" data-bs-toggle="modal" onclick="mostrarAlunos(' + idDaTurma+
                            ')">Ver</button>';
                    }
                },

            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        function mostrarAlunos(idTurma) {
            $.ajax({
                url: '{{ route('buscar-matriculas-admin') }}',
                type: 'POST',
                data: {
                    id: idTurma
                },
                dataType: 'json',
                success: function(response) {
                    // Atualize dinamicamente o conteúdo da tabela no modal
                    var tabela = $('#tabela-matriculas').DataTable({
                        language: ptBRTranslation,
                    });
                    tabela.clear().draw();
                    $.each(response, function(index, aluno) {
                        tabela.row.add([
                            aluno.name,
                            aluno.faltas,
                            aluno.status,
                        ]).draw();
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
