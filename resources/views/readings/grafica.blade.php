<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Lecturas de Sensores</title>
    
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

        /* Estilo del botón "Volver" */
        .back-button {
            display: inline-block;
            background-color: #c40000;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: bold;
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
        <h2>Gráfica de Lecturas de Sensores</h2>
        <div class="graph-container">
            <h3 class="graph-title">Lecturas de Sensores Registrados por Mes</h3>
            <canvas id="readingsChart"></canvas>
        </div>

        <!-- Botón para volver a la ruta anterior -->
        <a href="javascript:history.back()" class="back-button">Volver</a>
    </div>

    <script>
        // Datos desde el controlador
        var months = @json($months);
        var totalLecturas = @json($totalLecturas);
        var promedioValores = @json($promedioValores);
        var maximos = @json($maximos);
        var minimos = @json($minimos);
    
        // Configuración del gráfico
        var ctx = document.getElementById('readingsChart').getContext('2d');
        var readingsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Total de Lecturas',
                        data: totalLecturas,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Valor Promedio',
                        data: promedioValores,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        
                    },
                    {
                        label: 'Máximo Registrado',
                        data: maximos,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        
                    },
                    {
                        label: 'Mínimo Registrado',
                        data: minimos,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        
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
                            text: 'Valores'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        
                        
                    }
                }
            }
        });
    </script>

</body>
</html>
