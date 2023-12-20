@extends('content/dashboard/aluno/dashboards-aluno')

@section('content')
    @if (session('Mensagem'))
        <div class="modal" id="modalMensagem" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mensagem</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">
                            <p class="fs-5 text-black">{{ session('Mensagem') }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-4">
        <h4 class="card-header">Anamnese do aluno</h4>
        <form class="card-body" id="formAnamnese" action="{{ route('cadastrar-anamnese') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ isset($anamnese) ? $anamnese->id : '' }}" name="id">
            <h6>1. Lembre-se é importante colocar as informações certas para que o professor saiba da sua situação.</h6>
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label  fs-6" for="cardiaco">Algum Problema Cardíaco? - Deixe o campo em branco se não
                        tiver</label>
                    <div class="position-relative">
                        <select class="multiple-cardiaco select2 form-select form-control" id="cardiaco" name="cardiaco[]"
                            multiple="multiple">
                            @foreach (['Alergias a medicamentos como antibióticos', 'Rinite alérgica', 'Asma', 'Alergias a picadas de insetos como pernilongos', 'Alergias alimentares'] as $opcao)
                                @php
                                    $opcaoSelecionada = isset($anamnese->cardiaco) && in_array($opcao, $anamnese->cardiaco);
                                @endphp
                                <option value="{{ $opcao }}" {{ $opcaoSelecionada ? 'selected' : '' }}>
                                    {{ $opcao }}</option>
                            @endforeach

                            @if (isset($anamnese->cardiaco))
                                @foreach ($anamnese->cardiaco as $item)
                                    @if (
                                        !in_array($item, [
                                            'Alergias a medicamentos como antibióticos',
                                            'Rinite alérgica',
                                            'Asma',
                                            'Alergias a picadas de insetos como pernilongos',
                                            'Alergias alimentares',
                                        ]))
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label fs-6" for="alergia">Alguma Alergia? - Deixe o campo em branco se não tiver</label>
                    <div class="position-relative">
                        <select class="multiple-alergia select2 form-select form-control" id="alergia" name="alergia[]"
                            multiple="multiple">
                            @foreach (['Alergias a medicamentos como antibióticos', 'Rinite alérgica', 'Asma', 'Alergias a picadas de insetos como pernilongos', 'Alergias alimentares'] as $opcao)
                                @php
                                    $opcaoSelecionada = isset($anamnese->alergia) && in_array($opcao, $anamnese->alergia);
                                @endphp
                                <option value="{{ $opcao }}" {{ $opcaoSelecionada ? 'selected' : '' }}>
                                    {{ $opcao }}</option>
                            @endforeach

                            @if (isset($anamnese->alergia))
                                @foreach ($anamnese->alergia as $item)
                                    @if (
                                        !in_array($item, [
                                            'Alergias a medicamentos como antibióticos',
                                            'Rinite alérgica',
                                            'Asma',
                                            'Alergias a picadas de insetos como pernilongos',
                                            'Alergias alimentares',
                                        ]))
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label fs-6" for="osseo">Algum PROBLEMA ARTICULAR, MUSCULAR OU ÓSSEO? - Deixe o campo em
                        branco se não tiver</label>
                    <div class="position-relative">
                        <select class="multiple-osseo select2 form-select form-control" id="osseo" name="osseo[]"
                            multiple="multiple">
                            @foreach (['Alergias a medicamentos como antibióticos', 'Rinite alérgica', 'Asma', 'Alergias a picadas de insetos como pernilongos', 'Alergias alimentares'] as $opcao)
                                @php
                                    $opcaoSelecionada = isset($anamnese->osseo) && in_array($opcao, $anamnese->osseo);
                                @endphp
                                <option value="{{ $opcao }}" {{ $opcaoSelecionada ? 'selected' : '' }}>
                                    {{ $opcao }}</option>
                            @endforeach

                            @if (isset($anamnese->osseo))
                                @foreach ($anamnese->osseo as $item)
                                    @if (
                                        !in_array($item, [
                                            'Alergias a medicamentos como antibióticos',
                                            'Rinite alérgica',
                                            'Asma',
                                            'Alergias a picadas de insetos como pernilongos',
                                            'Alergias alimentares',
                                        ]))
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>




            </div>
            <div class="divider">
                <div class="divider-text">Descritiva</div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12">
                    <label class="form-label fs-6" for="doenca">TEM ALGUMA DOENÇA? - Deixe o campo em branco se não
                        tiver</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="doenca" name="doenca" placeholder="Explique">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label fs-6" for="tratamento">ESTÁ SOB TRATAMENTO? - Deixe o campo em branco se não
                        tiver</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="tratamento" name="tratamento" placeholder="Explique">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label fs-6" for="medicamento">TOMA ALGUM MEDICAMENTO? - Deixe o campo em branco se
                        não
                        tiver</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="medicamento" name="medicamento"
                            placeholder="Explique">
                    </div>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">Escolhas</div>
            </div>
            <div class="row">
                <div class="col-md-4 col-6 mb-4">
                    <small class="text-black fs-6 d-block">É FUMANTE?</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="fumante" id="fuamnte1" value="Sim" />
                        <label class="form-check-label" for="fumante1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fumante" id="fumante2" value="Não"
                            checked />
                        <label class="form-check-label" for="fumante2">Não</label>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-4">
                    <small class="text-black fs-6 d-block">É DIABÉTICO?</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="diabetico" id="diabetico1"
                            value="Sim" />
                        <label class="form-check-label" for="diabetico1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="diabetico" id="diabetico2" value="Não"
                            checked />
                        <label class="form-check-label" for="diabetico2">Não</label>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-4">
                    <small class="text-black fs-6 d-block">TOMA INSULINA?</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="insulina" id="insulina1" value="Sim" />
                        <label class="form-check-label" for="insulina1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insulina" id="insulina2" value="Não"
                            checked />
                        <label class="form-check-label" for="insulina2">Não</label>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-4">
                    <small class="text-black fs-6 d-block">SUA PRESSÃO ARTERIAL É?</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="pressao" id="pressao1" value="Normal"
                            checked />
                        <label class="form-check-label" for="pressao1">Normal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pressao" id="pressao2" value="Alta" />
                        <label class="form-check-label" for="pressao2">Alta</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pressao" id="pressao3" value="Baixa" />
                        <label class="form-check-label" for="pressao3">Baixa</label>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-4">
                    <small class="text-black fs-6 d-block">SABE NADAR?</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="nadar" id="nadar1" value="Sim"
                            checked />
                        <label class="form-check-label" for="pressao1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nadar" id="nadar2" value="Não" />
                        <label class="form-check-label" for="nadar2">Não</label>
                    </div>
                </div>
            </div>

            @if (!isset($anamnese))
                <hr class="my-4 mx-n4">
                <h6>2. Termo de consentimento livre e esclarecido.</h6>
                <p>ASSUMO TOTAL RESPONSABILIDADE SOBRE AS MINHAS CONDIÇÕES FÍSICAS DE SAÚDE OU DO(A) MENOR QUE ESTOU
                    RESPONSÁVEL
                    NESTA FICHA, PARA A PRÁTICA DA MODALIDADE ACIMA ESCOLHIDA. AUTORIZO O (A) PROFESSOR (A) A PRESCREVER AS
                    ATIVIDADES FÍSICAS PERTINENTES À AULA MINISTRADA E ESTOU CIENTE DOS RISCOS QUE ENVOLVEM A PRÁTICA
                    ESPORTIVA.
                </p>

                <p>OBS: O ALUNO OU RESPONSÁVEL FOI INFORMADO DE QUE PRECISA ENTREGAR O ATESTADO MÉDICO PARA O PROFESSOR PARA
                    INICIAR SUA AULA.</p>

                TERMO DE AUTORIZAÇÃO
                <p> O ENVIO DE INFORMAÇÕES ATUALIZADAS DA PREFEITURA NOS TELEFONES, EMAIL E PÁGINAS DAS REDES SOCIAIS,
                    ASSIM COMO O USO DE MINHA IMAGEM EM FOTOS OU FILME, SEM FINALIDADE COMERCIAL. A PRESENTE AUTORIZAÇÃO É
                    CONCEDIDA
                    A TÍTULO GRATUITO, ABRANGENDO O USO DA IMAGEM ACIMA MENCIONADA EM TODO TERRITÓRIO NACIONAL E NO
                    EXTERIOR.
                    AUTORIZO TAMBÉM CONTATO DA PREFEITURA DE SÃO SEBASTIÃO SOBRE PESQUISA DE SATISFAÇÃO, E TAMBÉM O CONTATO
                    DA
                    SECRETARIA DE ESPORTES - SEESP E DOS PROFESSORES SOBRE AS AULAS E ASSUNTOS PERTINENTES.</p>

                <div class="row g-3 mt-2">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                            <label class="form-check-label" for="invalidCheck">
                                Estou de acordo com os termos e condições.
                            </label>
                            <div class="invalid-feedback">
                                Precisa marcar essa caixa para.
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="divider">
                <div class="divider-text">Botões</div>
            </div>
            <div class="pt-4">
                <button type="submit"
                    class="btn btn-primary me-sm-3 me-1">{{ isset($anamnese) ? 'Atualizar' : 'Enviar' }}
                    Anamnese</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-toggle="tooltip" data-bs-offset="0,4"
                    data-bs-placement="right" data-bs-html="true"
                    title="<i class='bx bx-trending-up bx-xs' ></i> <span>Reseta o formulário</span>">Cancelar</button>
            </div>
        </form>
    </div>
@endsection

@section('script-da-pagina')
    <script>
        @if (session('Mensagem'))
            $(document).ready(function() {
                $('#modalMensagem').modal('show');
            });
        @endif

        @if ($anamnese)
            $('#doenca').val({!! json_encode($anamnese->doenca) !!});
            $('#tratamento').val({!! json_encode($anamnese->tratamento) !!});
            $('#medicamento').val({!! json_encode($anamnese->medicamento) !!});
            $('input[name="fumante"][value="' + {!! json_encode($anamnese->fumante) !!} + '"]').prop('checked', true);
            $('input[name="diabetico"][value="' + {!! json_encode($anamnese->diabetico) !!} + '"]').prop('checked', true);
            $('input[name="insulina"][value="' + {!! json_encode($anamnese->insulina) !!} + '"]').prop('checked', true);
            $('input[name="pressao"][value="' + {!! json_encode($anamnese->pressao) !!} + '"]').prop('checked', true);
            $('input[name="nadar"][value="' + {!! json_encode($anamnese->nadar) !!} + '"]').prop('checked', true);
        @endif

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

            $('.multiple-cardiaco').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Selecione na lista, se dentre as opções não estiver a sua, ESCREVA.'
            });
        });

        $(document).ready(function() {
            $('.multiple-alergia').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Selecione na lista, se dentre as opções não estiver a sua, ESCREVA.',
            });
        });

        $(document).ready(function() {
            $('.multiple-osseo').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Selecione na lista, se dentre as opções não estiver a sua, ESCREVA.',
            });
        });
    </script>
@endsection
