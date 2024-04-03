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
                        <th>Vagas Ocupadas</th>
                        <th>Horário</th>
                        <th>Idade: Min - Max</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
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
                                        <th>Data Inscrição</th>
                                        <th>Nome Aluno</th>
                                        <th>Imagem Perfil</th>
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
    </div>
@endsection

@section('script-da-pagina')
    <script>
        new DataTable('#tabela-turma', {
            language: ptBRTranslation,
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-turmas-lista-espera') }}",
            "columns": [{
                    data: "modalidade",
                    name: "modalidade"
                },
                {
                    data: "professor_nome",
                    name: "professor_nome"
                },
                {
                    data: "quantidade_vagas",
                    name: "quantidade_vagas"
                },
                {
                    data: "quantidade_alunos",
                    name: "quantidade_alunos"
                },
                {
                    data: "horario",
                    name: "horario"
                },
                {
                    data: "idade",
                    name: "idade"
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    className: 'hide-on-print',
                    render: function(data, type, full, meta) {
                        var idDaTurma = full
                        .id; // Substitua 'id' pelo nome correto do campo de ID no seu DataTable
                        return '<button class="btn btn-primary" data-bs-target="#modalMatriculas" data-bs-toggle="modal" onclick="mostrarAlunos(' +
                            idDaTurma +
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
                url: '{{ route('buscar-lista-espera-admin') }}',
                type: 'POST',
                data: {
                    id: idTurma
                },
                dataType: 'json',
                success: function(response) {
                    var tabela = $('#tabela-lista-espera').DataTable();

                    // Verifica se o DataTable já foi inicializado
                    if (!$.fn.DataTable.isDataTable('#tabela-lista-espera')) {
                        tabela = $('#tabela-lista-espera').DataTable({
                            language: ptBRTranslation
                        });
                    } else {
                        tabela.clear().draw(); // Limpa os dados da tabela se já estiver inicializada
                    }

                    carregarAlunos(response, tabela);

                    // Abre o modal
                    $('#modalListaEspera').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function carregarAlunos(response, tabela) {
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
                ]).draw();
            });
        }
    </script>
@endsection
