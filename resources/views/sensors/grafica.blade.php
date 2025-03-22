<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Sensores Registrados por Mes</title>
    
    <!-- Importar Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            max-width: 700px; /* Hacer el contenedor más pequeño */
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .graph-container {
            text-align: center;
            margin-top: 40px;
        }

        canvas {
            max-width: 100%;
            height: 400px;
        }

        .graph-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #555;
        }

        .back-button {
            display: inline-block;
            background-color: #c40000;
            color: white;
            padding: 10px 20px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #a30000;
            color: black;
            transform: scale(1.1);
            box-shadow: 0 0 1px #c40000, 0 0 3px #c40000, 0 0 6px #c40000;
        }

        .back-button:focus {
            outline: none;
        }
    </style>

    <!-- Cargar Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="container">
        <h2>Gráfica de Sensores</h2>
        <div class="graph-container">
            <h3 class="graph-title">Registros y Actualizaciones Mensuales</h3>
            <canvas id="sensorsChart"></canvas>
        </div>

        <!-- Botón para volver a la ruta anterior -->
        <a href="javascript:history.back()" class="back-button">Volver</a>
    </div>

    <script>
        // Datos actualizados desde el controlador
        var months = @json($months);
        var sensorCounts = @json($sensorCounts);
        var activeCounts = @json($activeCounts);
        var updatedCounts = @json($updatedCounts);

        var ctx = document.getElementById('sensorsChart').getContext('2d');
        var sensorsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Sensores Registrados',
                        data: sensorCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sensores Activos',
                        data: activeCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sensores Actualizados',
                        data: updatedCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Sensores',
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        // Se eliminan 'mode' e 'intersect' para mostrar sólo la data del dataset sobre el que se posa el cursor
                        backgroundColor: '#555',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                family: "'Roboto', sans-serif"
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
