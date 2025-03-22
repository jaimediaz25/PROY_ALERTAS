<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Alertas</title>
    
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
        <h2>Distribución de Alertas por Tipo</h2>
        <div class="graph-container">
            <h3 class="graph-title">Total general por tipo de alerta</h3>
            <canvas id="alertsChart"></canvas>
        </div>
        <a href="javascript:history.back()" class="back-button">Volver</a>
    </div>

    <script>
        // Datos desde el controlador
        const months = @json($months);
        const totalAlertas = @json($totalAlertas);
        const atendidasCounts = @json($atendidasCounts);
        const tiposData = @json($tiposData);

        // Configurar colores para datasets
        const colorPalette = [
            { bg: 'rgba(54, 162, 235, 0.2)', border: 'rgba(54, 162, 235, 1)' },  // Azul
            { bg: 'rgba(255, 99, 132, 0.2)', border: 'rgba(255, 99, 132, 1)' },  // Rojo
            { bg: 'rgba(75, 192, 192, 0.2)', border: 'rgba(75, 192, 192, 1)' },  // Verde
            { bg: 'rgba(153, 102, 255, 0.2)', border: 'rgba(153, 102, 255, 1)' } // Morado
        ];

        // Crear datasets dinámicos
        const datasets = [
            {
                label: 'Total de Alertas',
                data: totalAlertas,
                backgroundColor: colorPalette[0].bg,
                borderColor: colorPalette[0].border,
                borderWidth: 1
            },
            {
                label: 'Alertas Atendidas',
                data: atendidasCounts,
                backgroundColor: colorPalette[1].bg,
                borderColor: colorPalette[1].border,
                borderWidth: 1
            }
        ];

        // Agregar tipos como datasets adicionales
        Object.entries(tiposData).forEach(([tipo, datos], index) => {
            datasets.push({
                label: `Tipo: ${tipo}`,
                data: datos,
                backgroundColor: colorPalette[(index + 2) % colorPalette.length].bg,
                borderColor: colorPalette[(index + 2) % colorPalette.length].border,
                borderWidth: 1
            });
        });

        // Crear gráfica
        const ctx = document.getElementById('alertsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Alertas',
                            font: { size: 14 }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses',
                            font: { size: 14 }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { size: 12 } }
                    },
                    tooltip: {
                        
                    }
                }
            }
        });
    </script>

</body>
</html>