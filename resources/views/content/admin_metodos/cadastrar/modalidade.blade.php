@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    

    <div class="card p-4">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de Modalidades</h5>
            </div>
            <div class="text-end pt-3 pt-md-0">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaModalidade"
                    onClick="add()">
                    <span><i class="bx bx-plus me-sm-1"></i>Nova Modalidade</span>
                </button>
            </div>
        </div>
        <table id="tabela-modalidade" class="table table-striped " style="width:100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Ação</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="modalNovaModalidade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form action="javascript:void(0)" class="modal-content" method="POST" id="novaModalidadeForm">
                @csrf
                <input type="hidden" id="id" class="form-control" name="id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Nova Modalidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Nome:</label>
                            <input type="text" id="nome" class="form-control" name="nome"
                                placeholder="Futebol">
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
        new DataTable('#tabela-modalidade', {
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-modalidades') }}",
            "columns": [{
                    data: "id",
                    name: "id"
                },
                {
                    data: "nome",
                    name: "nome"
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
            $('#novaModalidadeForm').trigger("reset");
            $('#id').val('');
        }
        $('#novaModalidadeForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('cadastrar-modalidade') }}',
                type: 'POST',
                data: formData,
                contentType: false, // Não definir o tipo de conteúdo
                processData: false,
                success: function(response) {
                    $('#tabela-modalidade').DataTable().draw();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Lidar com erros
                }
            });
        });


        function editFuncao(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('edit-modalidade') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modalNovaModalidade').modal('show');
                    $('#id').val(res.id);
                    $('#nome').val(res.nome);
                }
            });
        }

        function deletarFuncao(id) {
            if (confirm("Deletar Modalidade?") == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-modalidade') }}",
                    data: {
                        id: id
                    },
                    success: function() {
                        $('#tabela-modalidade').DataTable().draw();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Lidar com erros
                    }
                });
            }
        }
    </script>
@endsection
