@extends('content/dashboard/professor/dashboards-professor')

@section('content')
    @if (isset($turmasDoProfessor))
        <div class="card mb-4">
            <h4 class="card-header">Turmas para fazer chamada
            </h4>
            <div class="card-body" id="formAnamnese">
                <h6>1. Aqui mostra todas as turmas que da aula e pode fazer a chamada.
                </h6>
                <div class="divider">
                    <div class="divider-text">Não deixe para ultima hora, faça a chamada do dia</div>
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
                                        <div class="divider-text">Veja as aulas</div>
                                    </div>
                                    <div class="pt-4">
                                        <button type="button" class="btn btn-primary me-sm-3 me-1"
                                            onclick="mostrarAulas({{ $turmaDoProfessor->id }})">Listar aulas</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="modal" tabindex="-1" id="modalAulas">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de aulas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tabela-aulas" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>

                                        <th>Dia da Aula</th>
                                        <th>Status</th>
                                        <th>Ação</th>
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
        <div class="modal" tabindex="-1" id="modalChamada">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chamada</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('efetuar-chamada') }}" method="POST">
                        @csrf
                        <input type="hidden" name="aula_id" value="" id="aulaValue">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="tabela-alunos-aula" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Foto Perfil</th>
                                            <th>Nome</th>
                                            <th>Presença</th>
                                            <th>Justificado</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="cancelarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('cancelar-chamada') }}" method="POST">
                        @csrf
                        <input type="hidden" id="cancelarAula_id" value="" name="aula_id">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelamento de Chamada</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Justifique o
                                    cancelamento:</label>
                                <textarea class="form-control" id="justificativa" rows="3" name="justificativa"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        Voçê não possui turmas para dar aula.
    @endif
@endsection

@section('script-da-pagina')
    <script>
        $(document).ready(function() {
            $('#tabela-aulas').DataTable();
        });
        $(document).ready(function() {
            $('#tabela-alunos-aula').DataTable();
        });

        function cancelarAula(idAula) {
            $('#cancelarAula_id').val(idAula);
        }

        function mostrarAulas(idTurma) {
            $.ajax({
                url: '{{ route('buscar-aulas') }}',
                type: 'POST',
                data: {
                    id: idTurma
                },
                dataType: 'json',
                success: function(response) {
                    // Atualize dinamicamente o conteúdo da tabela no modal
                    if ($.fn.DataTable.isDataTable('#tabela-aulas')) {
                        $('#tabela-aulas').DataTable().destroy();
                    }

                    // Inicializar a tabela
                    var tabela = new DataTable('#tabela-aulas', {
                        language: ptBRTranslation
                    });
                    tabela.clear().draw();
                    $.each(response, function(index, aula) {
                        const partesData = aula.data.split("-");
                        const dataFormatada = `${partesData[2]}/${partesData[1]}/${partesData[0]}`;
                        var botaoChamada = '';
                        if (aula.status === 'Aguardando') {
                            botaoChamada = `<div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" data-popper-placement="bottom-end" data-popper-reference-hidden="" data-popper-escaped="" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(262.5px, 143.5px, 0px);">
                                                    <a class="dropdown-item btn btn-primary" href="javascript:void(0);" onclick="mostrarAlunosAula(${aula.id})" ><i class="bx bx-edit-alt me-1"></i> Efetuar</a>
                                                    <button type="button" class="dropdown-item btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelarModal" onclick="cancelarAula(${aula.id})">Cancelar</button>

                                                </div>
                                            </div>`
                        } else if (aula.status === 'Cancelada') {
                            botaoChamada =
                                `<button type="button" class="btn btn-danger" disabled>Chamada Cancelada</button>
                                <button type="button" class="ms-2 btn btn-primary" onclick="mostrarAulaCancelada(${aula.id})"><i class='bx bx-show'></i></button>
                                `
                        } else {
                            botaoChamada =
                                `<button type="button" class="btn btn-primary" disabled>Chamada Feita</button>`
                        }
                        tabela.row.add([
                            dataFormatada,
                            aula.status,
                            botaoChamada,

                        ]).draw();
                    })

                    // Abra o modal
                    $('#modalAulas').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function mostrarAulaCancelada(idAula) {
            $.ajax({
                url: '{{ route('mostra-aula-cancelada') }}',
                type: 'POST',
                data: {
                    id: idAula,

                },
                dataType: 'json',

                success: function(response) {
                    $('#cancelarAula_id').val(idAula);
                    $('#justificativa').val(response.justificativa);
                    $('#cancelarModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function mostrarAlunosAula(idAula) {
            $.ajax({
                url: '{{ route('buscar-alunos-aula') }}',
                type: 'POST',
                data: {
                    id: idAula,

                },
                dataType: 'json',
                success: function(response) {
                    // Limpar e redesenhar a tabela

                    if ($.fn.DataTable.isDataTable('#tabela-alunos-aula')) {
                        $('#tabela-alunos-aula').DataTable().destroy();
                    }

                    // Inicializar a tabela
                    var tabela = new DataTable('#tabela-alunos-aula', {
                        language: ptBRTranslation
                    });
                    tabela.clear().draw();

                    $.each(response, function(index, aluno) {
                        tabela.row.add([
                            `<div class="avatar avatar-online">
                                <img src="../../../assets/img/perfil/${aluno.imagem_perfil}" onclick="zoomImage(this)" alt class="w-px-40 h-auto rounded-circle">
                                 </div>`,
                            aluno.name,
                            `<input type="hidden" name="presenca[${aluno.id}]" value="Faltou">
                            <input type="checkbox" name="presenca[${aluno.id}]" value="Presente" style="width: 20px; height: 20px;" checked>`,
                            `<input type="checkbox" name="presenca[${aluno.id}]" value="Justificado" style="width: 20px; height: 20px;">`,

                        ]).draw();
                    });

                    $('#aulaValue').val(idAula);

                    $('#modalChamada').modal('show');
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
