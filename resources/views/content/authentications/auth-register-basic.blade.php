@extends('layouts/blankLayout')

@section('title', 'Registrar-se')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection


@section('content')
    <div class="container">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body text-center">
                    <!-- /Logo -->
                    <h4 class="mb-2">Pratique esportes.</h4>
                    <p class="mb-4">Formulário de cadastro de aluno</p>
                    <form id="formAuthentication" class="mb-3" action="{{ route('registrar-aluno') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="container text-start">
                            <div class="row align-items-start" id="divResponsavel">
                                <div class="divider">
                                    <div class="divider-text fs-5">Informações pessoais do responsável</div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="parentesco" class="form-label">Grau de parentesco com o aluno</label>
                                    <select id="parentesco" name="parentesco" class="form-select">
                                        <option>Selecione o grau de parentesco</option>
                                        <option value="Pai">Pai</option>
                                        <option value="Mae">Mãe</option>
                                        <option value="Irmao">Irmão ou Irmã</option>
                                        <option value="Avo">Avó ou Avô</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="nome_responsavel" class="form-label">Nome do responsável</label>
                                    <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel"
                                        placeholder="Nome do responsável" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="cpf_responsável" class="form-label">CPF do responsável</label>
                                    <input type="text" class="form-control" onchange="validarCPF(this.value)"
                                        id="cpf_responsavel" name="cpf_responsavel" placeholder="000.000.000-00" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_responsável" class="form-label">RG do responsável</label>
                                    <input type="text" class="form-control" id="rg_responsavel" name="rg_responsavel"
                                        placeholder="00.000.000-0" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_responsavel_frente" class="form-label">RG responsável - Frente</label>
                                    <input type="file" class="form-control" id="rg_responsavel_frente"
                                        name="rg_responsavel_frente" accept=".png, .jpeg .jpg" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_responsavel_verso" class="form-label">RG responsável - Verso</label>
                                    <input type="file" class="form-control" id="rg_responsavel_verso"
                                        name="rg_responsavel_verso" accept=".png, .jpeg .jpg" autofocus>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="divider">
                                    <div class="divider-text fs-5">Informações pessoais do aluno</div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="nome_aluno" class="form-label">Nome do aluno</label>
                                    <input type="text" class="form-control" id="nome_aluno" name="nome_aluno"
                                        placeholder="Nome do aluno" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="nome_mae" class="form-label">Nome da mãe</label>
                                    <input type="text" class="form-control" id="nome_mae" name="nome_mae"
                                        placeholder="Nome da mãe do aluno" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="nome_pai" class="form-label">Nome do pai</label>
                                    <input type="text" class="form-control" id="nome_pai" name="nome_pai"
                                        placeholder="Nome do pai do aluno" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="data_nascimeto" class="form-label">Data de nascimento do aluno</label>
                                    <input type="date" class="form-control" id="data_nascimento"
                                        name="data_nascimento" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="cpf_aluno" class="form-label">CPF do aluno</label>
                                    <input type="text" class="form-control" id="cpf_aluno" name="cpf_aluno"
                                        placeholder="000.000.000-00" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_aluno" class="form-label">RG do aluno</label>
                                    <input type="text" class="form-control" id="rg_aluno" name="rg_aluno"
                                        placeholder="00.000.000-0" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_aluno_frente" class="form-label">RG aluno - Frente</label>
                                    <input type="file" class="form-control" id="rg_aluno_frente"
                                        name="rg_aluno_frente" accept=".png, .jpeg .jpg" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="rg_aluno_verso" class="form-label">RG aluno - Verso</label>
                                    <input type="file" class="form-control" id="rg_aluno_verso" name="rg_aluno_verso"
                                        accept=".png, .jpeg .jpg" autofocus required>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="divider">
                                    <div class="divider-text fs-5">Informações de contato e endereço do aluno</div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="telefone_aluno" class="form-label">Telefone do aluno</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                        placeholder="Telefone do aluno" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="telefone_emergencia" class="form-label">Telefone de emergência</label>
                                    <input type="text" class="form-control" id="telefone_emergencia"
                                        name="telefone_emergencia" placeholder="Telefone de emergência" autofocus
                                        required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="email_aluno" class="form-label">E-mail do aluno</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="EX:. aluno@aluno.com" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="endereco_aluno" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        placeholder="EX:. 23 de Março" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero"
                                        placeholder="Digite o número" autofocus required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-4">
                                    <label for="bairro" class="form-label">Bairro onde mora</label>
                                    <select id="bairro" name="bairro" class="form-select">
                                        <option>Bairro</option>
                                        @foreach ($bairros as $bairro)
                                            <option value="{{ $bairro }}">{{ $bairro }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-start" id="divEstuda">
                                <div class="divider">
                                    <div class="divider-text fs-5">Informações escolares</div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <label for="nome_escola" class="form-label">Nome da escola</label>
                                    <input type="text" class="form-control" id="nome_escola" name="nome_escola"
                                        placeholder="Nome da escola" autofocus>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <label for="serie" class="form-label">Qual série?</label>
                                    <select id="serie" name="serie" class="form-select">
                                        <option value="">Selecione a série</option>
                                        <option value="1°Série">1°Série</option>
                                        <option value="2°Série">2°Série</option>
                                        <option value="3°Série">3°Série</option>
                                        <option value="4°Série">4°Série</option>
                                        <option value="5°Série">5°Série</option>
                                        <option value="6°Série">6°Série</option>
                                        <option value="7°Série">7°Série</option>
                                        <option value="8°Série">8°Série</option>
                                        <option value="9°Série">9°Série</option>
                                        <option value="1°Ano">1°Ano</option>
                                        <option value="2°Ano">2°Ano</option>
                                        <option value="3°Ano">3°Ano</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <label for="periodo" class="form-label">Período</label>
                                    <select id="periodo" name="periodo" class="form-select">
                                        <option value="">Período</option>
                                        <option value="Manhã">Manhã</option>
                                        <option value="Tarde">Tarde</option>
                                        <option value="Noite">Noite</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="divider">
                                    <div class="divider-text fs-5">Senha</div>
                                </div>
                                <div class="form-password-toggle col-12 col-md-6 col-lg-4 mb-4">
                                    <label class="form-label" for="password">Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="form-password-toggle col-12 col-md-6 col-lg-4 mb-4">
                                    <label class="form-label" for="password_confirmation">Confirme a senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password_confirmation" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="estudaInput" id="estudaInput" value="false">
                        <input type="hidden" name="maiorIdadeInput" id="maiorIdadeInput" value="false">
                        <button type="submit" class="btn btn-primary w-25 self-align-center" style="min-width: 200px">
                            Cadastrar-se
                        </button>
                    </form>
                    <p class="text-center">
                        <span>Já possui uma conta?</span>
                        <a href="\login">
                            <span>Então entre aqui</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
    </div>
    <div class="modal fade show" id="modalPergunta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mb-4 text-dark">
                        <label for="telefone_aluno" class="form-label text-dark fs-5 me-5">Você é maior de
                            idade?</label></br>

                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="maiorIdade" id="maiorSim"
                                value="sim" />
                            <label class="form-check-label" for="maiorSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="maiorIdade" id="maiorNao"
                                value="nao" checked />
                            <label class="form-check-label" for="maiorNao">Não</label>
                        </div>

                    </div>
                    <div class="text-dark">
                        <label for="telefone_aluno" class="form-label text-dark fs-5 me-5">Você é estudante?</label></br>

                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="estuda" id="estudanteSim"
                                value="sim" />
                            <label class="form-check-label" for="estudanteSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="estuda" id="estudanteNao"
                                value="nao" checked />
                            <label class="form-check-label" for="estudanteNao">Não</label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="carregarDivs()">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="modalErros" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Erros no cadastro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            $(document).ready(function() {
                @if ($errors->any())
                    $('#modalErros').modal('show');
                @endif
                $('#modalPergunta').modal('show');
            });
        };

        function carregarDivs() {
            // Obtém o elemento correto pelo nome
            var maiorIdadeElement = document.getElementsByName("maiorIdade")[0];

            // Verifica se o valor do elemento é igual a "sim"
            if (maiorIdadeElement.checked) {
                document.getElementById("divResponsavel").classList.add("d-none");
                document.getElementById("maiorIdadeInput").value = "true";
            } else {
                document.getElementById("divResponsavel").classList.remove("d-none");
            }

            // Obtém o elemento correto pelo nome
            var estudaElement = document.getElementsByName("estuda")[0];

            // Verifica se o valor do elemento é igual a "sim"
            if (estudaElement.checked) {
                document.getElementById("divEstuda").classList.remove("d-none");
                document.getElementById("estudaInput").value = "true";
            } else {
                document.getElementById("divEstuda").classList.add("d-none");
            }
        }




        function formatarCPF(inputId) {
            let input = document.getElementById(inputId);

            input.addEventListener('input', function(event) {
                let value = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                if (value.length > 11) {
                    value = value.slice(0, 11); // Limita o comprimento a 11 dígitos
                }

                // Formata o CPF
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

                event.target.value = value;
            });
        }

        // Aplicar a função aos elementos desejados
        formatarCPF('cpf_responsavel');
        formatarCPF('cpf_aluno');

        function formatarRG(inputId) {
            let input = document.getElementById(inputId);

            input.addEventListener('input', function(event) {
                let value = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                // Formata o RG com pontos e traço
                value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');

                event.target.value = value;
            });
        }

        // Aplicar a função aos elementos desejados
        formatarRG('rg_responsavel');
        formatarRG('rg_aluno');

        function formatarTelefone(inputId) {
            let input = document.getElementById(inputId);

            input.addEventListener('input', function(event) {
                let value = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                // Formata o telefone com parênteses e traço
                if (value.length === 11) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (value.length === 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }

                event.target.value = value;
            });
        }

        // Aplicar a função aos elementos desejados
        formatarTelefone('telefone');
        formatarTelefone('telefone_emergencia');

        document.getElementById('numero').addEventListener('input', function(event) {
            let inputValue = event.target.value;

            // Remove todos os não dígitos
            let numericValue = inputValue.replace(/\D/g, '');

            // Adiciona "N°" ao início do valor numérico
            event.target.value = "N°" + numericValue;
        });
        document.getElementById('data_nascimento').addEventListener('input', function(event) {
            let inputData = event.target.value;

            // Obter a data atual
            let dataAtual = new Date();
            let anoAtual = dataAtual.getFullYear();
            let mesAtual = String(dataAtual.getMonth() + 1).padStart(2, '0');
            let diaAtual = String(dataAtual.getDate()).padStart(2, '0');

            let dataAtualFormatada = `${anoAtual}-${mesAtual}-${diaAtual}`;

            if (inputData > dataAtualFormatada) {
                alert('Por favor, selecione uma data até o dia atual.');
                event.target.value = 00 / 00 / 0000;
            }
        });
    </script>
@endsection
