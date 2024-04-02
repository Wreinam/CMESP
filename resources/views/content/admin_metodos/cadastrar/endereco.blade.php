@extends('content/dashboard/admin/dashboards-admin')

@section('content')
    

    <div class="card p-4">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabela de Endereços</h5>
            </div>
            <div class="text-end pt-3 pt-md-0">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaEndereco"
                    onClick="add()">
                    <span><i class="bx bx-plus me-sm-1"></i>Novo Endereço</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabela-endereco" class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Bairro</th>
                        <th>Rua</th>
                        <th>Nome do Local</th>
                        <th>Ação</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalNovaEndereco" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form action="javascript:void(0)" class="modal-content" method="POST" id="novaEnderecoForm">
                @csrf
                <input type="hidden" id="id" class="form-control" name="id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Novo Endereço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9 mb-3">
                            <label for="bairro" class="form-label">Bairro:</label>
                            <select class="form-select" id="bairro" name="bairro" aria-label="Bairro">
                                <option selected>Selecione o Bairro</option>
                                @foreach ($bairros as $bairro)
                                    <option value="{{ $bairro->nome }}">{{ $bairro->nome }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-3 text-end text-center align-self-center">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalNovaBairro" onClick="add()">
                                <span><i class="bx bx-plus me-sm-1"></i></span>
                            </button>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="rua" class="form-label">Rua:</label>
                            <input type="text" id="rua" class="form-control" name="rua"
                                placeholder="Jose Herculano N° 1 " autocomplete="off">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nome_local" class="form-label">Nome do Local:</label>
                            <input type="text" id="nome_local" class="form-control" name="nome_local"
                                placeholder="Ginasio Julio Cesar " autocomplete="off">
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


    <div class="modal fade" id="modalNovaBairro" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form action="javascript:void(0)" class="modal-content" method="POST" id="novaBairroForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Novo Bairro</h5>
                    <button type="button" class="btn-close" data-bs-target="#modalNovaEndereco" data-bs-toggle="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Nome do Bairro:</label>
                            <input type="text" id="nome" class="form-control" name="nome"
                                placeholder="Mareasias" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-target="#modalNovaEndereco"
                        data-bs-toggle="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" data-bs-target="#modalNovaEndereco"
                        data-bs-toggle="modal">Cadastrar</button>
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
        
        new DataTable('#tabela-endereco', {
            language: ptBRTranslation,
            processing: true,
            serverSide: true,
            "ajax": "{{ route('buscar-enderecos') }}",
            "columns": [{
                    data: "id",
                    name: "id"
                },
                {
                    data: "bairro",
                    name: "bairro"
                },
                {
                    data: "rua",
                    name: "rua"
                },
                {
                    data: "nome_local",
                    name: "nome_local"
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
            $('#novaEnderecoForm').trigger("reset");
            $('#id').val('');
        }


        $('#novaEnderecoForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('cadastrar-endereco') }}',
                type: 'POST',
                data: formData,
                contentType: false, // Não definir o tipo de conteúdo
                processData: false,
                success: function(response) {
                    $('#tabela-endereco').DataTable().draw();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Lidar com erros
                }
            });
        });
        //Cadastro de bairro
        $('#novaBairroForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('cadastrar-bairro') }}',
                type: 'POST',
                data: formData,
                contentType: false, // Não definir o tipo de conteúdo
                processData: false,
                success: function(response) {
                    var data = {!! json_encode($bairros) !!};
                    console.log(data)
                    $('#bairro').html("");
                    data.forEach(function(item) {
                        var nomeBairro = item.nome;
                        var novaOpcao = $('<option>').text(nomeBairro).attr('value',
                        nomeBairro);
                        $('#bairro').append(novaOpcao);
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Lidar com erros
                }
            });
        });


        function editFuncao(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('edit-endereco') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modalNovaEndereco').modal('show');
                    $('#id').val(res.id);
                    $('#bairro').val(res.bairro);
                    $('#rua').val(res.rua);
                    $('#nome_local').val(res.nome_local);
                }
            });
        }

        function deletarFuncao(id) {
            if (confirm("Deletar Endereco?") == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-endereco') }}",
                    data: {
                        id: id
                    },
                    success: function() {
                        $('#tabela-endereco').DataTable().draw();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Lidar com erros
                    }
                });
            }
        }
    </script>
@endsection
