<div class="modal fade" id="modal-dados-aluno" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Dados do Aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <img src="" alt="user-avatar" class="d-block rounded" height="130"
                                            width="130" id="foto_perfil" onclick="zoomImage(this)"
                                            style="cursor: pointer;
                                        transition: transform 0.3s ease-in-out;" />
                                    </div>
                                    <div class="col-md-10 col-12 row">
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome" class="form-label">Nome</label>
                                            <input class="form-control" type="text" id="nome" name="nome"
                                                value="Vazio" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome" class="form-label">Email</label>
                                            <input class="form-control-plaintext" type="text" id="email"
                                                name="nome" value="Nenhum" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome" class="form-label">CPF</label>
                                            <input class="form-control-plaintext" type="text" id="cpf"
                                                name="nome" value="000.000.000-00" readonly />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome" class="form-label">RG</label>
                                            <input class="form-control" type="text" id="rg" name="nome"
                                                value="000.000.000-0" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="idade" class="form-label">Idade</label>
                                            <input class="form-control" type="text" id="idade" value="Vazio" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome_mae" class="form-label">Nome da Mãe</label>
                                            <input class="form-control" type="text" id="nome_mae"
                                                value="Nenhum" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome_pai" class="form-label">Nome do Pai</label>
                                            <input class="form-control" type="text" id="nome_pai"
                                                value="Nenhum" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="data_nascimento" class="form-label">Data de
                                                Nascimento</label>
                                            <input class="form-control" type="date" id="data_nascimento"
                                                value="00/00/0000" />
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Contato e endereço</div>
                                    </div>

                                    <div class="mb-3 col-md-3 col-12">
                                        <label for="telefone" class="form-label">Telefone
                                        </label>
                                        <input class="form-control" type="text" id="telefone"
                                            value="(00)00000-0000" />
                                    </div>
                                    <div class="mb-3 col-md-3 col-12">
                                        <label for="telefone_emergencia" class="form-label">Telefone de Emergência
                                        </label>
                                        <input class="form-control" type="text" id="telefone_emergencia"
                                            value="(00)00000-0000" />
                                    </div>
                                    <div class="mb-3 col-md-3 col-12">
                                        <label for="bairro" class="form-label">Bairro
                                        </label>
                                        <input class="form-control" type="text" id="bairro" value="Nenhum" />
                                    </div>
                                    <div class="mb-3 col-md-3 col-12">
                                        <label for="rua" class="form-label">Endereço
                                        </label>
                                        <input class="form-control" type="text" id="endereco" value="Nenhum" />
                                    </div>

                                    <div class="row" id="div_estuda">
                                        <div class="divider">
                                            <div class="divider-text">Dados de estudante</div>
                                        </div>

                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="nome_escola" class="form-label">Nome Escola
                                            </label>
                                            <input class="form-control" type="text" id="nome_escola"
                                                value="Nenhum" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="serie" class="form-label">Série
                                            </label>
                                            <input class="form-control" type="text" id="serie"
                                                value="Nenhum" />
                                        </div>
                                        <div class="mb-3 col-md-3 col-12">
                                            <label for="periodo" class="form-label">Período
                                            </label>
                                            <input class="form-control" type="text" id="periodo"
                                                value="Nenhum" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-align-document">
                            <div class="row">
                                <div class="mb-3 col-12 col-md-3">
                                    <label for="uploade_rg_frente" class="form-label">FOTO RG - FRENTE</label>
                                    <img src="" alt="user-avatar" class="d-block rounded" height="130"
                                        width="130" id="rg_aluno_frente" onclick="zoomImage(this)"
                                        style="cursor: pointer;
                                transition: transform 0.3s ease-in-out;" />
                                </div>
                                <div class="mb-3 col-12 col-md-3">
                                    <label for="uploade_rg_frente" class="form-label">FOTO RG - VERSO</label>
                                    <img src="" alt="user-avatar" class="d-block rounded" height="130"
                                        width="130" id="rg_aluno_verso" onclick="zoomImage(this)"
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
                                    <input class="form-control" type="text" id="cardiaco"
                                        value="Nenhum problema" />
                                </div>

                                <div class="mb-3 col-md-3 col-12">
                                    <label for="alergias" class="form-label">Alergias
                                    </label>
                                    <input class="form-control" type="text" id="alergias"
                                        value="Nenhuma alergia" />
                                </div>

                                <div class="mb-3 col-md-3 col-12">
                                    <label for="osse" class="form-label">Problemas articulares, musculares ou
                                        ósseo
                                    </label>
                                    <input class="form-control" type="text" id="osseo"
                                        value="Nenhum problema" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="doenca" class="form-label">Doença
                                    </label>
                                    <input class="form-control" type="text" id="doenca"
                                        value="Nenhuma doença" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="tratamento" class="form-label">Sob Tratamento
                                    </label>
                                    <input class="form-control" type="text" id="tratamento"
                                        value="Nenhum tratamento" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="medicamento" class="form-label">Toma medicamento
                                    </label>
                                    <input class="form-control" type="text" id="medicamento"
                                        value="Nenhum medicamento" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="fumante" class="form-label">Fumante?
                                    </label>
                                    <input class="form-control" type="text" id="fumante" value="Não" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="diabetico" class="form-label">Diabético?
                                    </label>
                                    <input class="form-control" type="text" id="diabetico" value="Não" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="insulina" class="form-label">Toma Insulina?
                                    </label>
                                    <input class="form-control" type="text" id="insulina" value="Não" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="pressao" class="form-label">Pressão
                                    </label>
                                    <input class="form-control" type="text" id="pressao" value="Normal" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="nadar" class="form-label">Sabe nadar?
                                    </label>
                                    <input class="form-control" type="text" id="nadar" value="Não" />
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-align-messages">
                            <div class="mb-3 row">
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="grau_parentesco" class="form-label">Grau de parentesco
                                    </label>
                                    <input class="form-control" type="text" id="grau_parentesco"
                                        value="Nenhum" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="nome_responsavel" class="form-label">Nome do responsavel
                                    </label>
                                    <input class="form-control" type="text" id="nome_responsavel"
                                        value="Vazio" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="cpf_responsavel" class="form-label">CPF do responsavel
                                    </label>
                                    <input class="form-control" type="text" id="cpf_responsavel"
                                        value="D00.000.000-00" />
                                </div>
                                <div class="mb-3 col-md-3 col-12">
                                    <label for="rg_responsavel" class="form-label">RG do responsavel
                                    </label>
                                    <input class="form-control" type="text" id="rg_responsavel"
                                        value="D00.000.000-00" />
                                </div>
                                <div class="mb-3 col-12 col-md-4">
                                    <label for="rg_responsavel_frente" class="form-label">FOTO RG RESPONSAVEL -
                                        FRENTE</label>
                                    <img src="" alt="user-avatar" class="d-block rounded" height="130"
                                        width="130" id="rg_responsavel_frente" onclick="zoomImage(this)"
                                        style="cursor: pointer;
                                    transition: transform 0.3s ease-in-out;" />
                                </div>
                                <div class="mb-3 col-12 col-md-4">
                                    <label for="rg_responsavel_verso" class="form-label">FOTO RG RESPONSAVEL -
                                        VERSO</label>
                                    <img src="" alt="user-avatar" class="d-block rounded" height="130"
                                        width="130" id="rg_responsavel_verso" onclick="zoomImage(this)"
                                        style="cursor: pointer;
                                    transition: transform 0.3s ease-in-out;" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="resetarSenhaBTN" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<i class='bx bxs-radiation' ></i> <span>Reseta para a data de aniversário sem barras.</span>">RESETAR SENHA</button>
                <div class="ms-auto">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<i class='bx bx-bell bx-xs' ></i> <span>Não funcionando</span>">Salvar Mudanças</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
