@extends('layouts/contentNavbarLayout')

@section('title', 'Account settings - Account')

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                        Dados Básicos</a></li>
                @if (auth()->user()->permissao === 'Aluno')
                    <li class="nav-item"><a class="nav-link" href="{{ url('pages/account-settings-notifications') }}"><i
                                class="bx bx-bell me-1"></i> Dados Responsável</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i
                                class="bx bx-link-alt me-1"></i> Dados Estudante</a></li>
                @endif
            </ul>
            <form id="formAccountSettings" action="{{ route('salvar-configuracao') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <h5 class="card-header">Detalhes do perfil</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('assets/img/perfil/' . auth()->user()->imagem_perfil) }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Enviar foto de perfil</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="imagem_perfil" class="account-file-input"
                                        accept=".png, .jpeg .jpg" hidden />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Resetar</span>
                                </button>
                                <p class="text-muted mb-0">Aceita JPG, GIF or PNG. Tamanho máximo de 1MB</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input class="form-control" type="text" id="nome" name="nome"
                                    value="{{ auth()->user()->name }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="{{ auth()->user()->email }}" placeholder="" readonly />
                            </div>
                            @if (auth()->user()->permissao === 'Aluno' && isset($user_informacao))
                                <div class="mb-3 col-md-6">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf"
                                        value="{{ auth()->user()->cpf }}" readonly />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="rg" class="form-label">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg"
                                        value="{{ $user_informacao->rg }}" readonly />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nomeMae" class="form-label">Nome da Mãe</label>
                                    <input type="text" class="form-control" id="nomeMae" name="nomeMae"
                                        value="{{ $user_informacao->nomeMae }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nomePai" class="form-label">Nome do Pai</label>
                                    <input type="text" class="form-control" id="nomePai" name="nomePai"
                                        value="{{ $user_informacao->nomePai }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="telefone">Número Telefone</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="telefone" name="telefone" class="form-control"
                                            value="{{ $user_informacao->telefone }}" placeholder="(12)00000-0000" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="telefoneEmergencia">Telefone de Emergencia</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="telefoneEmergencia" name="telefoneEmergencia"
                                            class="form-control" value="{{ $user_informacao->telefoneEmergencia }}"
                                            placeholder="(12)00000-0000" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="dataNascimento">Data de Nascimento</label>
                                    <div class="input-group input-group-merge">
                                        <input type="date" id="telefone" name="dataNascimento" class="form-control"
                                            value="{{ $user_informacao->dataNascimento }}"
                                            placeholder="(12)00000-0000" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        value="{{ $user_informacao->endereco }}" placeholder="Rua" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <select id="bairro" name="bairro" class="form-select"
                                        value="{{ $user_informacao->bairro }}">
                                        <option value="{{ $user_informacao->bairro }}">{{ $user_informacao->bairro }}
                                        </option>
                                        @foreach ($bairros as $bairro)
                                            <option value="{{ $bairro }}">{{ $bairro }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ asset('assets/img/rg_aluno/' . $user_informacao->rgFrente) }}"
                                        alt="user-avatar" class="d-block rounded" height="100" width="100"
                                        id="uploade_rg_frente" onclick="zoomImage(this)" style="cursor: pointer;
                                        transition: transform 0.3s ease-in-out;"/>

                                    <div class="button-wrapper">

                                        <label for="upload_rg_frente" class="btn btn-primary me-2 mb-4" tabindex="1">
                                            <span class="d-none d-sm-block">Escolha RG - Frente</span>

                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload_rg_frente" name="rg_aluno_frente"
                                                class="account-file-input" accept=".png, .jpeg .jpg" hidden />
                                        </label>

                                        <p class="text-muted mb-0">Aceita JPG, GIF or PNG. Tamanho máximo de 1MB</p>
                                    </div>
                                </div>


                                <div class="col-12 col-md-6 d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ asset('assets/img/rg_aluno/' . $user_informacao->rgVerso) }}"
                                        alt="user-avatar" class="d-block rounded" height="100" width="100"
                                        id="uploade_rg_verso" onclick="zoomImage(this)"  style="cursor: pointer;
                                        transition: transform 0.3s ease-in-out;"/>

                                    <div class="button-wrapper">

                                        <label for="upload_rg_verso" class="btn btn-primary me-2 mb-4" tabindex="1">
                                            <span class="d-none d-sm-block">Escolha RG - Verso</span>

                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload_rg_verso" name="rg_aluno_verso"
                                                class="account-file-input" accept=".png, .jpeg .jpg" hidden />
                                        </label>

                                        <p class="text-muted mb-0">Aceita JPG, GIF or PNG. Tamanho máximo de 1MB</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Salvar Atualização</button>
                        </div>

                    </div>
                    <!-- /Account -->
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script-da-pagina')
    <script>
        $(document).ready(function() {
            // Quando um arquivo é selecionado
            $("#upload_rg_frente").change(function() {
                // Pega o arquivo selecionado
                var file = this.files[0];

                // Verifica se um arquivo foi realmente selecionado
                if (file) {
                    // Cria um objeto URL para o arquivo
                    var imageUrl = URL.createObjectURL(file);

                    // Atualiza a imagem com o novo URL
                    $("#uploade_rg_frente").attr("src", imageUrl);
                }
            });
        });
        $(document).ready(function() {
            // Quando um arquivo é selecionado
            $("#upload_rg_verso").change(function() {
                // Pega o arquivo selecionado
                var file = this.files[0];

                // Verifica se um arquivo foi realmente selecionado
                if (file) {
                    // Cria um objeto URL para o arquivo
                    var imageUrl = URL.createObjectURL(file);

                    // Atualiza a imagem com o novo URL
                    $("#uploade_rg_verso").attr("src", imageUrl);
                }
            });
        });

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
