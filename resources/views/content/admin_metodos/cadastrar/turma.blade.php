@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    <div class="card p-4">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de Turmas</h5>
            </div>
            <div class="text-end pt-3 pt-md-0">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaTurma"
                    onClick="add()">
                    <span><i class="bx bx-plus me-sm-1"></i>Nova Turma</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabela-turma" class="table table-striped " style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
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

    </div>

    <div class="modal fade" id="modalNovaTurma" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="javascript:void(0)" class="modal-content" method="POST" id="novaTurmaForm">
                @csrf
                <input type="hidden" id="id" class="form-control" name="id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Nova Turma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="modalidade" class="form-label">Modalidade:</label>
                            <select id="modalidade" class="form-control" name="modalidade" required>
                                <option value="" disabled selected hidden>Escolha a modalidade</option>
                                @foreach ($dadosModalidades as $modalidade)
                                    <option value="{{ $modalidade->id }}">{{ $modalidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="professor" class="form-label">Professor:</label>
                            <select id="professor" class="form-control" name="professor" required>
                                <option value="" disabled selected hidden>Escolha o professor</option>
                                @foreach ($dadosProfessores as $professor)
                                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="endereco" class="form-label">Endereço:</label>
                            <select id="endereco" class="form-control" name="endereco" required>
                                <option value="" disabled selected hidden>Escolha o endereço</option>
                                @foreach ($dadosEnderecos as $endereco)
                                    <option value="{{ $endereco->id }}">Bairro: {{ $endereco->bairro }} | Rua:
                                        {{ $endereco->rua }} | Nome do local:
                                        {{ $endereco->nome_local }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6 col-12 mb-4">
                            <label for="dateRangePicker" class="form-label">Periodo de Aulas</label>
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <input type="date" id="data_inicio" name="data_inicio" placeholder="DD/MM/YYYY"
                                    class="form-control" required>
                                <span class="input-group-text">até</span>
                                <input type="date" id="data_termino" name="data_termino" placeholder="DD/MM/YYYY"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2 col-5 mb-3">
                            <label for="idade_min" class="form-label">Idade Minima:</label>
                            <input type="number" id="idade_min" class="form-control" name="idade_min" required>
                        </div>

                        <label class="col-2 text-center align-self-center">Até</label>

                        <div class="col-md-2 col-5 mb-3">
                            <label for="idade_max" class="form-label">Idade Máxima:</label>
                            <input type="number" id="idade_max" class="form-control" name="idade_max" required>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2 col-5 mb-3 align-self-center">
                            <label for="horario_inicio" class="form-label">Horário início:</label>
                            <input type="time" id="horario_inicio" class="form-control" name="horario_inicio"
                                required>
                        </div>

                        <label class="col-1 text-center align-self-center">Até</label>

                        <div class="col-md-2 col-5 mb-3">
                            <label for="horario_termino" class="form-label">Horário término:</label>
                            <input type="time" id="horario_termino" class="form-control" name="horario_termino"
                                required>
                        </div>

                        <div class="col-md-6 col-12 mb-4">
                            <label for="dateRangePicker" class="form-label">Dias da semana</label>
                            <div>
                                <input type="checkbox" value="Domingo" class="btn-check" id="dia[0]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[0]">Dom</label>

                                <input type="checkbox" value="Segunda-feira" class="btn-check" id="dia[1]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[1]">Seg</label>

                                <input type="checkbox" value="Terca-feira" class="btn-check" id="dia[2]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[2]">Ter</label>

                                <input type="checkbox" value="Quarta-feira" class="btn-check" id="dia[3]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[3]">Qua</label>

                                <input type="checkbox" value="Quinta-feira" class="btn-check" id="dia[4]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[4]">Qui</label>

                                <input type="checkbox" value="Sexta-feira" class="btn-check" id="dia[5]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[5]">Sex</label>

                                <input type="checkbox" value="Sabado" class="btn-check" id="dia[6]"
                                    name="dia_semana[]" autocomplete="off">
                                <label class="btn btn-outline-primary" for="dia[6]">Sáb</label>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="nivel" class="form-label">Nivél:</label>
                            <select id="nivel" class="form-control" name="nivel" required>
                                <option value="" disabled selected hidden>Escolha o nivél</option>
                                <option value="Iniciante">Iniciante</option>
                                <option value="Intermediario">Intermediário</option>
                                <option value="Avancado">Avançado</option>
                                <option value="Treinamento">Treinamento</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="quantidade_vagas" class="form-label">Quantidade de vagas:</label>
                            <input type="number" id="quantidade_vagas" class="form-control" name="quantidade_vagas"
                                required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script-da-pagina')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        new DataTable('#tabela-turma', {
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-turmas') }}",
            "columnDefs": [{
                "targets": 5,
                "render": function(data, type, row) {
                    const parser = new DOMParser();
                    const decoded = parser.parseFromString(`"<root>${data}</root>"`,
                        'text/html').body.textContent;
                    const resultado = decoded.replace(/"|[\[\]]|-feira/g, ' ');
                    return resultado;
                }
            }, ],
            "columns": [{
                    data: "id",
                    name: "id"
                },
                {
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
                    name: "dias_semana"
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
                    className: 'hide-on-print'
                },

            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]


        });

        function add() {
            $('#novaTurmaForm').trigger("reset");
            $('#id').val('');
        }

        $('#novaTurmaForm').submit(function(e) {
            $('#modalNovaTurma').modal('hide');
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('cadastrar-turma') }}',
                type: 'POST',
                data: formData,
                contentType: false, // Não definir o tipo de conteúdo
                processData: false,
                success: function(response) {
                    $('#tabela-turma').DataTable().draw();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Lidar com erros
                }
            });
        });


        function editFuncao(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('edit-turma') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modalNovaTurma').modal('show');
                    $('#id').val(res.id);
                    $('#modalidade').val(res.modalidade_id);
                    $('#professor').val(res.professor_id);
                    $('#endereco').val(res.endereco_id);
                    $('#data_inicio').val(res.data_inicio);
                    $('#data_termino').val(res.data_termino);
                    $('#idade_min').val(res.idade_min_max.split(" - ")[0]);
                    $('#idade_max').val(res.idade_min_max.split(" - ")[1]);
                    $('#horario_inicio').val(res.horario.split(" ás ")[0]);
                    $('#horario_termino').val(res.horario.split(" ás ")[1]);
                    $('input[name="dia_semana[]"]').each(function() {
                        if (JSON.parse(res.dias_semana).includes($(this).val())) {
                            $(this).prop('checked', true);
                        }
                    });
                    $('#nivel').val(res.nivel);
                    $('#quantidade_vagas').val(res.quantidade_vagas);
                }
            });
        }

        function deletarFuncao(id) {
            if (confirm("Deletar Turma?") == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-turma') }}",
                    data: {
                        id: id
                    },
                    success: function() {
                        $('#tabela-turma').DataTable().draw();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Lidar com erros
                    }
                });
            }
        }
    </script>
@endsection
