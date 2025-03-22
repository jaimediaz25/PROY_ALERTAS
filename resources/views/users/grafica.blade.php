<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Usuarios Registrados y Actualizados por Mes</title>
    
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
            font-size: 1.1rem;
            font-weight: bold;
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
        <h2>Gráfica de Usuarios Registrados y Actualizados por Mes</h2>
        <div class="graph-container">
            <h3 class="graph-title">Usuarios Registrados y Actualizados por Mes</h3>
            <canvas id="usersChart"></canvas>
        </div>

        <!-- Botón para volver a la ruta anterior -->
        <a href="javascript:history.back()" class="back-button">Volver</a>
    </div>

    <script>
        // Obtener los datos enviados desde el controlador
        var months = @json($months); // Nombres de los meses
        var userCounts = @json($userCounts); // Conteo de usuarios registrados
        var updatedCounts = @json($updatedCounts); // Conteo de usuarios actualizados

        // Crear el gráfico
        var ctx = document.getElementById('usersChart').getContext('2d');
        var usersChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: months, // Meses (formato "Mes Año")
                datasets: [
                    {
                        label: 'Usuarios Registrados',
                        data: userCounts, // Conteo de usuarios registrados
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de las barras
                        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
                        borderWidth: 1
                    },
                    {
                        label: 'Usuarios Actualizados',
                        data: updatedCounts, // Conteo de usuarios actualizados
                        backgroundColor: 'rgba(0, 255, 0, 0.2)', /* Color verde */
                        borderColor: 'rgba(0, 255, 0, 1)', /* Color verde */
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        },
                        title: {
                            display: true,
                            text: 'Cantidad de Usuarios',
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: '#555',
                        titleColor: '#fff',
                        bodyColor: '#fff',
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
