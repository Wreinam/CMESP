@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    

    <div class="card p-4 table-responsive">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de Professores</h5>
            </div>
            <div class="text-end pt-3 pt-md-0">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaProfessor"
                    onClick="add()">
                    <span><i class="bx bx-plus me-sm-1"></i>Novo Professor</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabela-professor" class="table table-striped " style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ação</th>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>

    <div class="modal fade" id="modalNovaProfessor" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form action="javascript:void(0)" class="modal-content" method="POST" id="novaProfessorForm">
                @csrf
                <input type="hidden" id="id" class="form-control" name="id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Novo Professor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" id="nome" class="form-control" name="nome"
                                placeholder="José Arlindo da Silva" autocomplete="off">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="jose@gmail.com" autocomplete="off">
                        </div>
                        <div class="col-12 mb-3" id="divCPF">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Deixe em branco se não quiser colocar" type="text" id="cpf"
                                class="form-control" name="cpf" placeholder="000.000.000-00" autocomplete="off">
                        </div>
                        <div class="form-password-toggle col-12 mb-4" id="divSenha">
                            <label class="form-label" for="senha">Senha</label>
                            <div class="input-group input-group-merge">
                                <input data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="Recomendamos colocar uma senha fácil a primeiro momento"
                                    type="password" id="senha" class="form-control" name="senha"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Cadastrar</button>
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
        new DataTable('#tabela-professor', {
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-professores') }}",
            "columns": [{
                    data: "id",
                    name: "id"
                },
                {
                    data: "name",
                    name: "nome"
                },
                {
                    data: "email",
                    name: "email"
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

        function add() {
            $('#novaProfessorForm').trigger("reset");
            $('#id').val('');
            $("#divCPF").removeClass("d-none");
            $("#cpf").attr("required");

            $("#divSenha").removeClass("d-none");
            $("#senha").attr("required");
        }
        $('#novaProfessorForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('cadastrar-professor') }}',
                type: 'POST',
                data: formData,
                contentType: false, // Não definir o tipo de conteúdo
                processData: false,
                success: function(response) {
                    $('#tabela-professor').DataTable().draw();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Lidar com erros
                }
            });
        });


        function editFuncao(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('edit-professor') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modalNovaProfessor').modal('show');
                    $('#id').val(res.id);
                    $('#nome').val(res.name);
                    $('#email').val(res.email);

                    $("#divCPF").addClass("d-none");
                    $("#cpf").removeAttr("required");

                    $("#divSenha").addClass("d-none");
                    $("#senha").removeAttr("required");


                }
            });
        }

        function deletarFuncao(id) {
            if (confirm("Deletar Professor?") == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-professor') }}",
                    data: {
                        id: id
                    },
                    
                    success: function() {
                        $('#tabela-professor').DataTable().draw();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Lidar com erros
                    }
                });
            }
        }
    </script>
@endsection
