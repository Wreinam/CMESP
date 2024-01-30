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
            "ajax": "{{ route('buscar-alunos') }}",
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
                    console.log(response)
                    $('#resetarSenhaBTN').on("click", function() {
                        resetarSenha(response.id);
                    });

                    $('#foto_perfil').attr('src', '../../../assets/img/perfil/' + response.imagem_perfil);
                    $('#rg_aluno_frente').attr('src', '../../../assets/img/rg_aluno/' + response.user_informacoe
                        .rgFrente);
                    $('#rg_aluno_verso').attr('src', '../../../assets/img/rg_aluno/' + response.user_informacoe
                        .rgVerso);


                    $('#nome').val(response.name);
                    $('#email').val(response.email);
                    $('#cpf').val(response.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'));
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
