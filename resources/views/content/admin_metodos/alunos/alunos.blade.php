@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    <div class="card p-4">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de alunos</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabela-dados-alunos" class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Matriculas</th>
                        <th>Lista de espera</th>
                        <th>Ação</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('content/admin_metodos/alunos/modal-dados-aluno')


    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:200000;">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        new DataTable('#tabela-dados-alunos', {
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-alunos-admin') }}",
            "columns": [{
                    data: "name",
                    name: "name"
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data: "cpf",
                    name: "cpf",
                    render: function(data, type, full, meta) {
                        // Formatação do CPF
                        return data.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                    }
                },
                {
                    data: "matriculas_quantidade",
                    name: "matriculas_quantidade",
                    render: function(data, type, full, meta) {
                        // Formatação do CPF
                        return data + " Turmas";
                    }
                },
                {
                    data: "lista_espera_quantidade",
                    name: "lista_espera_quantidade",
                    render: function(data, type, full, meta) {
                        // Formatação do CPF
                        return data + " Listas";
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },

            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]


        });

        function editFuncao(id) {
            $('#modal-dados-aluno').modal('show');
            $.ajax({
                url: '{{ route('buscar-dados-aluno') }}',
                type: 'POST',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(response) {

                    alunoDados = response.aluno;
                    matriculas = response.matriculas;
                    listaEspera = response.listaEspera;
                    console.log(listaEspera)
                    $('#resetarSenhaBTN').on("click", function() {
                        resetarSenha(alunoDados.id);
                    });

                    $('#foto_perfil').attr('src', '../../../assets/img/perfil/' + alunoDados.imagem_perfil);
                    $('#rg_aluno_frente').attr('src', '../../../assets/img/rg_aluno/' + alunoDados
                        .user_informacoe
                        .rgFrente);
                    $('#rg_aluno_verso').attr('src', '../../../assets/img/rg_aluno/' + alunoDados
                        .user_informacoe
                        .rgVerso);


                    $('#nome').val(alunoDados.name);
                    $('#email').val(alunoDados.email);
                    $('#cpf').val(alunoDados.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'));
                    $('#rg').val(alunoDados.user_informacoe.rg);
                    $('#idade').val(alunoDados.user_informacoe.idade);
                    $('#data_nascimento').val(alunoDados.user_informacoe.dataNascimento);
                    $('#nome_mae').val(alunoDados.user_informacoe.nomeMae);
                    $('#nome_pai').val(alunoDados.user_informacoe.nomePai);
                    $('#telefone').val(alunoDados.user_informacoe.telefone);
                    $('#telefone_emergencia').val(alunoDados.user_informacoe.telefoneEmergencia);
                    $('#bairro').val(alunoDados.user_informacoe.bairro);
                    $('#endereco').val(alunoDados.user_informacoe.endereco);

                    if (alunoDados.user_estuda !== null && alunoDados.user_estuda !== undefined) {
                        //Caso ele estude
                        $('#nome_escola').val(alunoDados.user_estuda.nomeEscola);
                        $('#serie').val(alunoDados.user_estuda.serie);
                        $('#periodo').val(alunoDados.user_estuda.periodo);
                        $('#div_estuda').removeClass('d-none');

                    } else {
                        $('#div_estuda').addClass('d-none');
                    }
                    if (alunoDados.user_anamnese !== null && alunoDados.user_anamnese !== undefined) {
                        //Anamnese
                        $('#cardiaco').val(JSON.parse(alunoDados.user_anamnese.cardiaco) === null ?
                            'Nenhum problema' : JSON.parse(alunoDados.user_anamnese.cardiaco));
                        $('#alergia').val(JSON.parse(alunoDados.user_anamnese.alergia) === null ?
                            'Nenhuma alergia' :
                            JSON.parse(alunoDados.user_anamnese.alergia));
                        $('#osseo').val(JSON.parse(alunoDados.user_anamnese.osseo) === null ?
                            'Nenhum problema' :
                            JSON
                            .parse(alunoDados.user_anamnese.osseo));
                        $('#doenca').val(JSON.parse(alunoDados.user_anamnese.doenca) === null ?
                            'Nenhuma doença' :
                            JSON.parse(alunoDados.user_anamnese.doenca));
                        $('#tratamento').val(JSON.parse(alunoDados.user_anamnese.tratamento) === null ?
                            'Nenhum tratamento' : JSON.parse(alunoDados.user_anamnese.tratamento));
                        $('#medicamento').val(JSON.parse(alunoDados.user_anamnese.medicamento) === null ?
                            'Nenhum medicamento' : JSON.parse(alunoDados.user_anamnese.medicamento));
                        $('#fumante').val(alunoDados.user_anamnese.fumante);
                        $('#diabetico').val(alunoDados.user_anamnese.diabetico);
                        $('#insulina').val(alunoDados.user_anamnese.insulina);
                        $('#pressao').val(alunoDados.user_anamnese.pressao);
                        $('#nadar').val(alunoDados.user_anamnese.nadar);
                        $('#div_anamnese').removeClass('d-none');
                    } else {
                        $('#div_anamense').addClass('d-none');
                    }



                    if (alunoDados.responsavel_dados !== null && alunoDados.responsavel_dados !== undefined) {
                        //Caso ele seja menos de idade
                        console.log(alunoDados)
                        $('#grau_parentesco').val(alunoDados.responsavel_dados.grauParentesco);
                        $('#nome_responsavel').val(alunoDados.responsavel_dados.nomeResponsavel);
                        $('#cpf_responsavel').val(alunoDados.responsavel_dados.cpfResponsavel);
                        $('#rg_responsavel').val(alunoDados.responsavel_dados.rgResponsavel);
                        $('#rg_responsavel_frente').attr('src', '../../../assets/img/rg_responsavel/' +
                            alunoDados
                            .responsavel_dados.rgFrenteResponsavel);
                        $('#rg_responsavel_verso').attr('src', '../../../assets/img/rg_responsavel/' +
                            alunoDados
                            .responsavel_dados.rgVersoResponsavel);
                        $('#div_responsavel').removeClass('d-none');

                    } else {
                        $('#div_responsavel').addClass('d-none');
                    }

                    if (matriculas.length) {
                        $('#div_matriculas_colunas').html(''); // Limpa o conteúdo existente
                        matriculas.forEach(element => {
                            // Acumula os elementos em uma variável
                            let cardElement = `
                                <div class="col-12 col-md-4 mb-1">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-header mb-0">${element.turma.idade_min_max} anos</div>
                                        <div class="card-body text-primary">
                                            <h5 class="card-title">${element.turma.modalidade.nome}</h5>
                                            <p class="card-text mb-1">Nível: ${element.turma.nivel}</p>
                                            <p class="card-text mb-1">Dias da Semana: ${element.turma.dias_semana.replace(/[\[\]"]+/g, '')}</p>
                                            <p class="card-text mb-1">Horário: ${element.turma.horario}</p>
                                            <p class="card-text mb-1">Faltas: ${element.faltas}</p>
                                            <p class="card-text mb-1">Status: ${element.status}</p>
                                            <p class="card-text mb-1">Bairro: ${element.turma.endereco.bairro}</p>
                                            <p class="card-text mb-1">Professor: ${element.turma.professor.name}</p>
                                        </div>
                                    </div>
                                </div>`;
                            // Adiciona o elemento acumulado à div_matriculas_colunas
                            $('#div_matriculas_colunas').append(cardElement);
                        });

                        $('#div_matriculas').removeClass('d-none');
                    } else {
                        $('#div_matriculas_colunas').html('');
                        $('#div_matriculas').addClass('d-none');
                    }

                    if (listaEspera.length) {
                        $('#div_listaEspera_colunas').html(''); // Limpa o conteúdo existente
                        listaEspera.forEach(element => {
                            // Acumula os elementos em uma variável
                            let cardElement = `
                                <div class="col-12 col-md-4 mb-1">
                                    <div class="card shadow-none bg-transparent border border-primary">
                                        <div class="card-header mb-0">${element.idade_min_max} anos</div>
                                        <div class="card-body text-primary">
                                            <h5 class="card-title">${element.modalidade.nome}</h5>
                                            <p class="card-text mb-1">Nível: ${element.nivel}</p>
                                            <p class="card-text mb-1">Dias da Semana: ${element.dias_semana.replace(/[\[\]"]+/g, '')}</p>
                                            <p class="card-text mb-1">Horário: ${element.horario}</p>
                                            <p class="card-text mb-1">Bairro: ${element.endereco.bairro}</p>
                                            <p class="card-text mb-1">Professor: ${element.professor.name}</p>
                                        </div>
                                    </div>
                                </div>`;
                            // Adiciona o elemento acumulado à div_matriculas_colunas
                            $('#div_listaEspera_colunas').append(cardElement);
                        });
                        $('#div_listaEspera').removeClass('d-none');
                    } else {
                        $('#div_listaEspera_colunas').html('');
                        $('#div_listaEspera').addClass('d-none');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        }

        function resetarSenha(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('resetar-senha') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#corpoMensagem").text(response.mensagem);
                    const toast = new bootstrap.Toast($('#mensagem'))
                    toast.show()

                },
                error: function(error) {
                    console.error("Erro ao resetar senha:", error);
                }
            });
        }
    </script>
@endsection
