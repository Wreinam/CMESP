@extends('content/dashboard/professor/dashboards-professor')

@section('content')
    @if (isset($turmasDoProfessor))
        <div class="card mb-4">
            <h4 class="card-header">Ver dados dos seus alunos.
            </h4>
            <div class="card-body" id="formAnamnese">
                <input type="hidden" name="_token" value="7h3l1gOwGiQuuzwqL6GaZThQd9zXmKF3OsbkjAWe"> <input type="hidden"
                    value="5" name="id">
                <h6>1. Aqui mostra as turmas que da aula.

                </h6>
                <div class="divider">
                    <div class="divider-text">Veja as informações necessárias</div>
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
                                            data-bs-target="#modalListaEspera" data-bs-toggle="modal"
                                            onclick="mostrarAlunos({{ $turmaDoProfessor->id }})">Listar alunos</button>
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
                        <h5 class="modal-title">Lita de alunos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tabela-matriculas" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nome Aluno</th>
                                        <th>Faltas</th>
                                        <th>Status</th>
                                        <th>Ações</th>
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


        <div class="modal fade " id="modalDadosAluno" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content" style="background-color: #f5f5f9;">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-target="#modalListaEspera" data-bs-toggle="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="nav-align-top ">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-home">Dados do aluno</button>
                                </li>
                                <li class="nav-item" id="div_anamense">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-profile">Anamnese</button>
                                </li>
                                <li class="nav-item" id="div_responsavel">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-messages">Dados do responsável</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-align-document">Documentos</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-top-align-home">
                                    <div class="mb-3 row">
                                        <!-- Dados do responsavel -->
                                        <div class="row">

                                            <div class="mb-3 col-12 col-md-2">
                                                <label for="uploade_rg_frente" class="form-label">Foto de perfil</label>
                                                <img src="" alt="user-avatar" class="d-block rounded"
                                                    height="130" width="130" id="foto_perfil"
                                                    onclick="zoomImage(this)"
                                                    style="cursor: pointer;
                                                    transition: transform 0.3s ease-in-out;" />
                                            </div>
                                            <div class="col-md-10 col-12 row">
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome" class="form-label">Nome</label>
                                                    <input class="form-control-plaintext" type="text" id="nome"
                                                        name="nome" value="Renan Vinicius dos Santos Ribeiro"
                                                        readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome" class="form-label">Email</label>
                                                    <input class="form-control-plaintext" type="text" id="email"
                                                        name="nome" value="aluno@aluno.com" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome" class="form-label">CPF</label>
                                                    <input class="form-control-plaintext" type="text" id="cpf"
                                                        name="nome" value="000.000.000-00" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome" class="form-label">RG</label>
                                                    <input class="form-control-plaintext" type="text" id="rg"
                                                        name="nome" value="000.000.000-0" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="idade" class="form-label">Idade</label>
                                                    <input class="form-control-plaintext" type="text" id="idade"
                                                        value="10 anos" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome_mae" class="form-label">Nome da Mãe</label>
                                                    <input class="form-control-plaintext" type="text" id="nome_mae"
                                                        value="Daniela Moreira dos Santos" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome_pai" class="form-label">Nome do Pai</label>
                                                    <input class="form-control-plaintext" type="text" id="nome_pai"
                                                        value="Renato Moreira dos Santos" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="data_nascimento" class="form-label">Data de
                                                        Nascimento</label>
                                                    <input class="form-control-plaintext" type="date"
                                                        id="data_nascimento" value="00/00/0000" readonly />
                                                </div>
                                            </div>
                                            <div class="divider">
                                                <div class="divider-text">Contato e endereço</div>
                                            </div>

                                            <div class="mb-3 col-md-3 col-12">
                                                <label for="telefone" class="form-label">Telefone
                                                </label>
                                                <input class="form-control-plaintext" type="text" id="telefone"
                                                    value="(12)99792-5669" readonly />
                                            </div>
                                            <div class="mb-3 col-md-3 col-12">
                                                <label for="telefone_emergencia" class="form-label">Telefone de Emergência
                                                </label>
                                                <input class="form-control-plaintext" type="text"
                                                    id="telefone_emergencia" value="(12)99792-5669" readonly />
                                            </div>
                                            <div class="mb-3 col-md-3 col-12">
                                                <label for="bairro" class="form-label">Bairro
                                                </label>
                                                <input class="form-control-plaintext" type="text" id="bairro"
                                                    value="(12)99792-5669" readonly />
                                            </div>
                                            <div class="mb-3 col-md-3 col-12">
                                                <label for="rua" class="form-label">Endereço
                                                </label>
                                                <input class="form-control-plaintext" type="text" id="rua"
                                                    value="23 de Março " readonly />
                                            </div>

                                            <div class="row" id="div_estuda">
                                                <div class="divider">
                                                    <div class="divider-text">Dados de estudante</div>
                                                </div>

                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="nome_escola" class="form-label">Nome Escola
                                                    </label>
                                                    <input class="form-control-plaintext" type="text" id="nome_escola"
                                                        value="Edna Nogueira Ferraz" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="serie" class="form-label">Série
                                                    </label>
                                                    <input class="form-control-plaintext" type="text" id="serie"
                                                        value="1ºSérie" readonly />
                                                </div>
                                                <div class="mb-3 col-md-3 col-12">
                                                    <label for="periodo" class="form-label">Período
                                                    </label>
                                                    <input class="form-control-plaintext" type="text" id="periodo"
                                                        value="Manhã" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-top-align-document">
                                    <div class="row">
                                        <div class="mb-3 col-12 col-md-3">
                                            <label for="uploade_rg_frente" class="form-label">FOTO RG - FRENTE</label>
                                            <img src="https://i.pinimg.com/736x/cd/44/b5/cd44b51a80fe8dd141de1be25b76be84.jpg"
                                                alt="user-avatar" class="d-block rounded" height="130" width="130"
                                                id="rg_aluno_frente" onclick="zoomImage(this)"
                                                style="cursor: pointer;
                                            transition: transform 0.3s ease-in-out;" />
                                        </div>
                                        <div class="mb-3 col-12 col-md-3">
                                            <label for="uploade_rg_frente" class="form-label">FOTO RG - VERSO</label>
                                            <img src="https://i.pinimg.com/736x/cd/44/b5/cd44b51a80fe8dd141de1be25b76be84.jpg"
                                                alt="user-avatar" class="d-block rounded" height="130" width="130"
                                                id="rg_aluno_verso" onclick="zoomImage(this)"
                                                style="cursor: pointer;
                                                transition: transform 0.3s ease-in-out;" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-top-align-profile">
                                    <div class="mb-3 row">
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="cardiaco" class="form-label">Problemas Cardíacos
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="cardiaco"
                                                value="Nenhum problema" readonly />
                                        </div>

                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="alergias" class="form-label">Alergias
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="alergias"
                                                value="Nenhuma alergia" readonly />
                                        </div>

                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="osse" class="form-label">Problemas articulares, musculares ou
                                                ósseo
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="osseo"
                                                value="Nenhum problema" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="doenca" class="form-label">Doença
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="doenca"
                                                value="Nenhuma doença" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="tratamento" class="form-label">Sob Tratamento
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="tratamento"
                                                value="Nenhum tratamento" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="medicamento" class="form-label">Toma medicamento
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="medicamento"
                                                value="Nenhum medicamento" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="fumante" class="form-label">Fumante?
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="fumante"
                                                value="Não" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="diabetico" class="form-label">Diabético?
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="diabetico"
                                                value="Não" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="insulina" class="form-label">Toma Insulina?
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="insulina"
                                                value="Não" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="pressao" class="form-label">Pressão
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="pressao"
                                                value="Normal" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nadar" class="form-label">Sabe nadar?
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="nadar"
                                                value="Não" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-top-align-messages">
                                    <div class="mb-3 row">
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="grau_parentesco" class="form-label">Grau de parentesco
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="grau_parentesco"
                                                value="Mãe" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome_responsavel" class="form-label">Nome do responsavel
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="nome_responsavel"
                                                value="Daniela Moreira dos Santos" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="cpf_responsavel" class="form-label">CPF do responsavel
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="cpf_responsavel"
                                                value="D00.000.000-00" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="rg_responsavel" class="form-label">RG do responsavel
                                            </label>
                                            <input class="form-control-plaintext" type="text" id="rg_responsavel"
                                                value="D00.000.000-00" readonly />
                                        </div>
                                        <div class="mb-3 col-12 col-md-4">
                                            <label for="rg_responsavel_frente" class="form-label">FOTO RG RESPONSAVEL -
                                                FRENTE</label>
                                            <img src="https://i.pinimg.com/736x/cd/44/b5/cd44b51a80fe8dd141de1be25b76be84.jpg"
                                                alt="user-avatar" class="d-block rounded" height="130" width="130"
                                                id="rg_responsavel_frente" onclick="zoomImage(this)"
                                                style="cursor: pointer;
                                                transition: transform 0.3s ease-in-out;" />
                                        </div>
                                        <div class="mb-3 col-12 col-md-4">
                                            <label for="rg_responsavel_verso" class="form-label">FOTO RG RESPONSAVEL -
                                                VERSO</label>
                                            <img src="https://i.pinimg.com/736x/cd/44/b5/cd44b51a80fe8dd141de1be25b76be84.jpg"
                                                alt="user-avatar" class="d-block rounded" height="130" width="130"
                                                id="rg_responsavel_verso" onclick="zoomImage(this)"
                                                style="cursor: pointer;
                                                transition: transform 0.3s ease-in-out;" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#modalListaEspera"
                            data-bs-toggle="modal">Voltar</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        Voçê nao possuir turmas.
    @endif
@endsection

@section('script-da-pagina')
    <script>
        $(document).ready(function() {
            $('#tabelaAlunos').DataTable();
        });

        function mostrarAlunos(idTurma) {
            $.ajax({
                url: '{{ route('buscar-matriculas') }}',
                type: 'POST',
                data: {
                    id: idTurma
                },
                dataType: 'json',
                success: function(response) {
                    // Atualize dinamicamente o conteúdo da tabela no modal
                    var tabela = $('#tabela-matriculas').DataTable();
                    tabela.clear().draw();
                    $.each(response, function(index, aluno) {
                        tabela.row.add([
                            aluno.aluno_id,
                            aluno.name,
                            aluno.faltas,
                            aluno.status,
                            `<button type="button" class="btn btn-primary" data-bs-target="#modalDadosAluno" data-bs-toggle="modal" onclick="verAluno(${aluno.aluno_id})">Informações</button>
                            <button type="button" class="btn btn-danger" onclick="desmatricularAluno(${aluno.id})"><i class='bx bx-x'></i></button>`
                        ]).draw();
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function desmatricularAluno(idAluno) {
            $.ajax({
                url: '{{ route('desmatricular-aluno') }}',
                type: 'POST',
                data: {
                    id: idAluno,
                },
                dataType: 'json',
                success: function(response) {
                    var tabela = $('#tabela-matriculas').DataTable();
                    tabela.clear().draw();
                    $.each(response, function(index, aluno) {
                        tabela.row.add([
                            aluno.aluno_id,
                            aluno.name,
                            aluno.faltas,
                            aluno.status,
                            `<button type="button" class="btn btn-primary" data-bs-target="#modalDadosAluno" data-bs-toggle="modal" onclick="verAluno(${aluno.aluno_id})">Informações</button>
                            <button type="button" class="btn btn-danger" onclick="desmatricularAluno(${aluno.id})"><i class='bx bx-x'></i></button>`
                        ]).draw();
                    })

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function verAluno(idAluno) {
            $.ajax({
                url: '{{ route('buscar-aluno') }}',
                type: 'POST',
                data: {
                    id: idAluno,
                },
                dataType: 'json',
                success: function(response) {
                    $('#foto_perfil').attr('src', '../../../assets/img/perfil/' + response.imagem_perfil);
                    $('#rg_aluno_frente').attr('src', '../../../assets/img/rg_aluno/' + response.user_informacoe
                        .rgFrente);
                    $('#rg_aluno_verso').attr('src', '../../../assets/img/rg_aluno/' + response.user_informacoe
                        .rgVerso);


                    $('#nome').val(response.name);
                    $('#email').val(response.email);
                    $('#cpf').val(response.cpf);
                    $('#rg').val(response.user_informacoe.rg);
                    $('#idade').val(response.user_informacoe.idade);
                    $('#data_nascimento').val(response.user_informacoe.dataNascimento);
                    $('#nome_mae').val(response.user_informacoe.nomeMae);
                    $('#nome_pai').val(response.user_informacoe.nomePai);
                    $('#telefone').val(response.user_informacoe.telefone);
                    $('#telefone_emergencia').val(response.user_informacoe.telefoneEmergencia);
                    $('#bairro').val(response.user_informacoe.bairro);
                    $('#endereco').val(response.user_informacoe.endereco);

                    if (response.user_estuda !== null && response.user_estuda !== undefined) {
                        //Caso ele estude
                        $('#nome_escola').val(response.user_estuda.nomeEscola);
                        $('#serie').val(response.user_estuda.serie);
                        $('#periodo').val(response.user_estuda.periodo);
                        $('#div_estuda').removeClass('d-none');

                    } else {
                        $('#div_estuda').addClass('d-none');
                    }
                    if (response.user_anamnese !== null && response.user_anamnese !== undefined) {
                        //Anamnese
                        $('#cardiaco').val(JSON.parse(response.user_anamnese.cardiaco) === null ?
                            'Nenhum problema' : JSON.parse(response.user_anamnese.cardiaco));
                        $('#alergia').val(JSON.parse(response.user_anamnese.alergia) === null ?
                            'Nenhuma alergia' :
                            JSON.parse(response.user_anamnese.alergia));
                        $('#osseo').val(JSON.parse(response.user_anamnese.osseo) === null ? 'Nenhum problema' :
                            JSON
                            .parse(response.user_anamnese.osseo));
                        $('#doenca').val(JSON.parse(response.user_anamnese.doenca) === null ? 'Nenhuma doença' :
                            JSON.parse(response.user_anamnese.doenca));
                        $('#tratamento').val(JSON.parse(response.user_anamnese.tratamento) === null ?
                            'Nenhum tratamento' : JSON.parse(response.user_anamnese.tratamento));
                        $('#medicamento').val(JSON.parse(response.user_anamnese.medicamento) === null ?
                            'Nenhum medicamento' : JSON.parse(response.user_anamnese.medicamento));
                        $('#fumante').val(response.user_anamnese.fumante);
                        $('#diabetico').val(response.user_anamnese.diabetico);
                        $('#insulina').val(response.user_anamnese.insulina);
                        $('#pressao').val(response.user_anamnese.pressao);
                        $('#nadar').val(response.user_anamnese.nadar);
                        $('#div_anamnese').removeClass('d-none');
                    } else {
                        $('#div_anamense').addClass('d-none');
                    }



                    if (response.responsavel_dados !== null && response.responsavel_dados !== undefined) {
                        //Caso ele seja menos de idade
                        console.log(response)
                        $('#grau_parentesco').val(response.responsavel_dados.grauParentesco);
                        $('#nome_responsavel').val(response.responsavel_dados.nomeResponsavel);
                        $('#cpf_responsavel').val(response.responsavel_dados.cpfResponsavel);
                        $('#rg_responsavel').val(response.responsavel_dados.rgResponsavel);
                        $('#rg_responsavel_frente').attr('src', '../../../assets/img/rg_responsavel/' + response
                            .responsavel_dados.rgFrenteResponsavel);
                        $('#rg_responsavel_verso').attr('src', '../../../assets/img/rg_responsavel/' + response
                            .responsavel_dados.rgVersoResponsavel);
                        $('#div_responsavel').removeClass('d-none');

                    } else {
                        $('#div_responsavel').addClass('d-none');
                    }

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function zoomImage(img) {

            if (img.style.transform === 'scale(2)') {
                img.style.transform = 'scale(1)';
                img.style.zIndex = 'auto';
            } else {

                img.style.transform = 'scale(2)';
                img.style.zIndex = '1081';
            }
        }
    </script>
@endsection
