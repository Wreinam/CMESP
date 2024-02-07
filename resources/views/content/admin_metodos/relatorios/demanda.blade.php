@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@section('content')
    <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <div>
          <h5 class="card-title mb-0">Relatório</h5>
          <small class="text-muted">Demanda de alunos por bairros e modalidades</small>
        </div>
      </div>
      <div class="card-body">
        <div id="chart"></div>
      </div>
    </div>
  </div>
@endsection

@section('script-da-pagina')
    <script>
        function fetchData() {
            $.ajax({
                url: "{{ route('quantidadeDemandaPorBairroModalidade') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let modalidadesSet = new Set(); // Conjunto para armazenar as modalidades únicas
                    data.forEach(item => {
                        modalidadesSet.add(item.modalidade);
                    });

                    let modalidades = Array.from(modalidadesSet);
                    let dadosParaApexCharts = [];

                    // Inicializa um objeto para rastrear os dados já preenchidos
                    let dadosPreenchidos = {};

                    data.forEach(item => {
                        let bairro = item.bairro;
                        let quantidadeAlunos = item.quantidade_alunos_demanda;

                        // Verifica se o bairro já existe no array de dados
                        let bairroExistente = dadosParaApexCharts.find(dados => dados.name === bairro);

                        if (!dadosPreenchidos[bairro]) {
                            dadosPreenchidos[bairro] = {};
                        }

                        if (!bairroExistente) {
                            // Se o bairro não existe, cria um novo registro
                            let novoRegistro = {
                                name: bairro,
                                data: Array.from({
                                    length: modalidades.length
                                }, () => 0),
                            };

                            // Preenche a quantidadeAlunos para a modalidade atual
                            let modalidadeIndex = modalidades.indexOf(item.modalidade);
                            novoRegistro.data[modalidadeIndex] = quantidadeAlunos;

                            dadosParaApexCharts.push(novoRegistro);
                            dadosPreenchidos[bairro][item.modalidade] = true;
                        } else {
                            // Se o bairro já existe, verifica se os dados foram preenchidos para a modalidade atual
                            if (!dadosPreenchidos[bairro][item.modalidade]) {
                                let modalidadeIndex = modalidades.indexOf(item.modalidade);
                                bairroExistente.data[modalidadeIndex] = quantidadeAlunos;
                                dadosPreenchidos[bairro][item.modalidade] = true;
                            }
                        }
                    });

                    var options = {
                        series: dadosParaApexCharts,
                        chart: {
                            type: 'bar',
                            height: 350,
                            stacked: true,
                            toolbar: {
                                show: true
                            },
                            zoom: {
                                enabled: true
                            }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -10,
                                    offsetY: 0
                                }
                            }
                        }],
                        title: {
                            text: ''
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                borderRadius: 10,
                                dataLabels: {
                                    total: {
                                        enabled: true,
                                        style: {
                                            fontSize: '13px',
                                            fontWeight: 900
                                        }
                                    }
                                }
                            },
                        },
                        xaxis: {
                            type: 'category',
                            categories: modalidades,
                        },
                        legend: {
                            position: 'right',
                            offsetY: 40
                        },
                        fill: {
                            opacity: 1
                        }
                    };

                    // Agora 'options' contém a configuração do gráfico com os dados da sua requisição AJAX
                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                },
                error: function(error) {
                    console.log('Erro ao obter dados:', error);
                }
            });
        }

        // Chame a função fetchData() quando a página estiver pronta

        $(document).ready(function() {
            fetchData();
        });
    </script>


@endsection
