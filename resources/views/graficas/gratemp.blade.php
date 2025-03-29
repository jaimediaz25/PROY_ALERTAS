<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitor de Sensores de Temperatura</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #dc1515;  /* Rojo principal */
      --secondary-color: #a01010;
      --accent-color: #f04c4c;
      --dark-color: #2b2d42;
      --light-color: #f8f9fa;
    }
    
    body {
      background-color: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--dark-color);
    }
    
    .header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 1rem 0;
      margin-bottom: 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    
    }
    
    .header h1 {
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .header p {
      opacity: 0.9;
      font-size: 1.1rem;
    }
    
    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .sensor-card {
      background: white;
      margin-bottom: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
      border: none;
    }
    
    .sensor-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }
    
    .sensor-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .sensor-title {
      font-size: 1.3rem;
      font-weight: 600;
      margin: 0;
    }
    
    .sensor-id {
      font-size: 0.85rem;
      opacity: 0.8;
      background: rgba(255, 255, 255, 0.2);
      padding: 0.25rem 0.5rem;
      border-radius: 20px;
    }
    
    .sensor-body {
      padding: 1.5rem;
    }
    
    .chart-container {
      height: 350px;
      position: relative;
      margin-bottom: 1.5rem;
    }
    
    .stats-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }
    
    .stat-box {
      background: var(--light-color);
      border-radius: 8px;
      padding: 1rem;
      flex: 1;
      min-width: 120px;
      margin: 0.5rem;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      
      margin-bottom: 0.25rem;
    }
    
    .stat-label {
      font-size: 0.85rem;
      color: #6c757d;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .btn-home {
      background-color: white;
      color: var(--primary-color);
      border: none;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
    }
    
    .btn-home:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-home i {
      margin-right: 8px;
    }
    
    .no-data {
      text-align: center;
      padding: 2rem;
      color: #6c757d;
      font-style: italic;
    }
    
    @media (max-width: 768px) {
      .header {
        padding: 1.5rem 0;
      }
      
      .header h1 {
        font-size: 1.8rem;
      }
      
      .sensor-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .chart-container {
        height: 250px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h1><i class="fas fa-thermometer-half me-2"></i>Monitor de Sensores</h1>
          <p>Visualización en tiempo real de las lecturas de temperatura</p>
        </div>
        <a href="{{ route('home')}}" class="btn-home mt-3 mt-md-0">
          <i class="fas fa-home"></i> INICIO
        </a>
      </div>
    </div>
  </div>

  <div class="container">
    @foreach($sensors as $sensor)
    <div class="sensor-card">
      <div class="sensor-header">
        <div>
          <h2 class="sensor-title">
            <i class="fas fa-thermometer me-2"></i> {{ $sensor['tipo'] }} - {{ $sensor['ubicacion'] }}
          </h2>
          <span class="sensor-id">ID: {{ $sensor['_id'] }}</span>
        </div>
        <div>
          <span class="badge bg-light text-dark">
            <i class="fas fa-clock me-1"></i>
            @if(count($sensor['readings']) > 0)
              Última lectura: {{ end($sensor['readings'])['created_at'] }}
            @else
              Sin datos recientes
            @endif
          </span>
        </div>
      </div>
      
      <div class="sensor-body">
        <p><strong>Estado:</strong> {{ $sensor['activo'] ? 'Activo' : 'Inactivo' }}</p>
    
        <!-- Formulario para cambiar estado -->
        <form action="{{ route('sensors.updateStatus', $sensor['_id']) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="activo" value="{{ $sensor['activo'] ? 0 : 1 }}">
          <button type="submit" class="btn btn-{{ $sensor['activo'] ? 'danger' : 'success' }}">
            {{ $sensor['activo'] ? 'Desactivar' : 'Activar' }}
          </button>
        </form>
        @if(count($sensor['readings']) > 0)
        <div class="chart-container">
          <canvas id="chart-{{ $sensor['_id'] }}"></canvas>
        </div>
        <div class="stats-container">
          @php
            $values = array_column($sensor['readings'], 'valor');
            $lastValue = end($values);
            $maxValue = max($values);
            $minValue = min($values);
            $avgValue = array_sum($values) / count($values);
          @endphp
          <div class="stat-box">
            <div class="stat-value">{{ number_format($lastValue, 1) }}°C</div>
            <div class="stat-label">Actual</div>
          </div>
          <div class="stat-box">
            <div class="stat-value">{{ number_format($maxValue, 1) }}°C</div>
            <div class="stat-label">Máximo</div>
          </div>
          <div class="stat-box">
            <div class="stat-value">{{ number_format($minValue, 1) }}°C</div>
            <div class="stat-label">Mínimo</div>
          </div>
          <div class="stat-box">
            <div class="stat-value">{{ number_format($avgValue, 1) }}°C</div>
            <div class="stat-label">Promedio</div>
          </div>
        </div>
        @else
        <div class="no-data">
          <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
          <p>No hay datos disponibles para este sensor</p>
        </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <script>
    @foreach($sensors as $sensor)
    @if(count($sensor['readings']) > 0)
    const ctx{{ $sensor['_id'] }} = document.getElementById('chart-{{ $sensor['_id'] }}').getContext('2d');
    // Degradado para el área del gráfico
    const gradient{{ $sensor['_id'] }} = ctx{{ $sensor['_id'] }}.createLinearGradient(0, 0, 0, 400);
    gradient{{ $sensor['_id'] }}.addColorStop(0, 'rgba(255, 151, 0, 0.3)');
    gradient{{ $sensor['_id'] }}.addColorStop(1, 'rgba(255, 151, 0, 0)');
    
    new Chart(ctx{{ $sensor['_id'] }}, {
      type: 'line',
      data: {
        labels: {!! json_encode(array_column($sensor['readings'], 'created_at')) !!},
        datasets: [{
          label: 'Temperatura (°C)',
          data: {!! json_encode(array_column($sensor['readings'], 'valor')) !!},
          borderColor: '#ff9700',
          backgroundColor: gradient{{ $sensor['_id'] }},
          borderWidth: 3,
          pointRadius: 3,
          pointBackgroundColor: '#ff9700',
          pointHoverRadius: 5,
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              font: {
                size: 14,
                weight: '600'
              },
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 12
            },
            padding: 12,
            cornerRadius: 8,
            displayColors: false
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: {
                size: 12
              }
            },
            title: {
              display: true,
              text: 'Temperatura (°C)',
              font: {
                size: 14,
                weight: '600'
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false
            },
            ticks: {
              font: {
                size: 12
              }
            },
            title: {
              display: true,
              text: 'Fecha y Hora',
              font: {
                size: 14,
                weight: '600'
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index'
        },
        animation: {
          duration: 1000,
          easing: 'easeOutQuart'
        }
      }
    });
    @endif
    @endforeach
  </script>
</body>
</html>
