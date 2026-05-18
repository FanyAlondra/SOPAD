@extends('cpanel.plantilla')

@section('title','Inicio')

@section('content')

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid mt-4">

    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-11 col-md-12">

            {{-- Bienvenida --}}
            <div class="hero-section rounded-3 text-center mb-4 p-4">
                <h1 class="display-5 fw-bold">
                    Bienvenido al Sistema SOPAD
                </h1>
            </div>

            {{-- GRÁFICA ORIGINAL --}}
            <div class="card shadow-lg mb-4">

                <div class="card-header text-white text-center"
                     style="background-color:#1F364A">

                    <h4 class="mb-0">
                        Gráfica de Materia Prima
                    </h4>

                </div>

                <div class="card-body">

                    <div style="height:400px;">
                        <canvas id="graficaMateriaPrima"></canvas>
                    </div>

                </div>

            </div>


            {{-- NUEVA GRÁFICA --}}
            <div class="card shadow-lg">

                <div class="card-header text-white text-center"
                     style="background-color:#386173">

                    <h4 class="mb-0">
                        Clustering de Proyectos Financieros
                    </h4>

                </div>

                <div class="card-body">

                    <div style="height:450px;">
                        <canvas id="graficaClusters"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

//////////////////////////////////////////////////////
// GRÁFICA ORIGINAL
//////////////////////////////////////////////////////

const ctx1 = document.getElementById('graficaMateriaPrima');

new Chart(ctx1, {

    type: 'bar',

    data: {

        labels: @json($nombres),

        datasets: [{

            label: 'Cantidad total',

            data: @json($totales),

            backgroundColor: [
                '#386173',
                '#1F364A',
                '#386173',
                '#1F364A',
                '#386173',
                '#1F364A'
            ],

            borderColor: '#1F364A',

            borderWidth: 2

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        scales: {

            x: {

                ticks: {
                    color: '#1F364A'
                },

                grid: {
                    color: '#E5E5E5'
                }

            },

            y: {

                beginAtZero: true,

                ticks: {
                    stepSize: 10,
                    color: '#1F364A'
                },

                grid: {
                    color: '#E5E5E5'
                }

            }

        }

    }

});



//////////////////////////////////////////////////////
// CLUSTERING FINANCIERO
//////////////////////////////////////////////////////

const datos = [

    {
        x: 10000,
        y: 20,
        nombre: 'Proyecto A',
        cluster: 0
    },

    {
        x: 15000,
        y: 35,
        nombre: 'Proyecto B',
        cluster: 1
    },

    {
        x: 20000,
        y: 40,
        nombre: 'Proyecto C',
        cluster: 2
    },

    {
        x: 25000,
        y: 50,
        nombre: 'Proyecto D',
        cluster: 0
    },

    {
        x: 30000,
        y: 60,
        nombre: 'Proyecto E',
        cluster: 1
    }

];


// Colores
const colores = [
    '#386173',
    '#B8D67A',
    '#1F364A'
];


// Crear datasets
const datasets = [0,1,2].map(cluster => ({

    label: 'Cluster ' + cluster,

    data: datos
        .filter(item => item.cluster === cluster)
        .map(item => ({
            x: item.x,
            y: item.y,
            nombre: item.nombre
        })),

    backgroundColor: colores[cluster],

    borderColor: colores[cluster],

    pointRadius: 8

}));


const ctx2 = document.getElementById('graficaClusters');


new Chart(ctx2, {

    type: 'scatter',

    data: {
        datasets: datasets
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                position: 'top'
            },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return (
                            context.raw.nombre +
                            ' | Inversión: $' + context.raw.x +
                            ' | ROI: ' + context.raw.y + '%'
                        );

                    }

                }

            }

        },

        scales: {

            x: {

                title: {
                    display: true,
                    text: 'Inversión'
                },

                ticks: {
                    color: '#1F364A'
                },

                grid: {
                    color: '#E5E5E5'
                }

            },

            y: {

                title: {
                    display: true,
                    text: 'ROI (%)'
                },

                beginAtZero: true,

                ticks: {
                    color: '#1F364A'
                },

                grid: {
                    color: '#E5E5E5'
                }

            }

        }

    }

});

</script>

@endsection