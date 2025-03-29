<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Últimos Valores de Sensores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #dc1515;  /* Rojo principal */
      --secondary-color: #a01010;
      --light-color: #f8f9fa;
      --dark-color: #2b2d42;
    }

    body {
      background-color: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--dark-color);
    }

    .header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 2rem 0;
      margin-bottom: 2rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 0 0 10px 10px;
    }

    .header h1 {
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .header p {
      opacity: 0.9;
      font-size: 1.1rem;
    }

    .btn-home {
      background-color: white;
      color: var(--primary-color);
      border: none;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    .btn-home:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .sensor-card {
      background: white;
      border: none;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 1.5rem;
      box-shadow: 0 6px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sensor-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px rgba(0,0,0,0.1);
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

    .sensor-body p {
      margin-bottom: 0.5rem;
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
    }
    .sensor-actions {
        margin-top: 15px;
        text-align: right;
    }
    
    .btn-edit {
        background-color: #4CAF50;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.3s;
    }
    
    .btn-edit:hover {
        background-color: #45a049;
    }
    
    .btn-edit i {
        margin-right: 5px;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
    }
    
    .btn-delete:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h1><i class="fas fa-tachometer-alt me-2"></i>Últimos Valores de Sensores</h1>
        <p>Datos actualizados en tiempo real</p>
      </div>
      <a href="{{ route('home') }}" class="btn-home mt-3 mt-md-0">
        <i class="fas fa-home"></i> INICIO
      </a>
    </div>
  </div>

  <div class="container" id="sensors-container">
    @foreach($latestReadings as $sensorData)
    <div class="sensor-card" id="sensor-{{ $sensorData['sensor_id'] }}">
      <div class="sensor-header">
        <div class="sensor-title">
          <i class="fas fa-sensor me-2"></i>Sensor: {{ $sensorData['tipo'] }} - {{ $sensorData['ubicacion'] }}
        </div>
        <div class="sensor-id">ID: {{ $sensorData['sensor_id'] }}</div>
      </div>
      <div class="sensor-body">
        <p><strong>Última Lectura:</strong> {{ $sensorData['reading']['valor'] }}</p>
        <p><strong>Fecha:</strong> {{ $sensorData['reading']['created_at'] }}</p>
      </div>
      <div class="sensor-actions">
        <a href="{{ route('sensors.edit', $sensorData['sensor_id']) }}" class="btn btn-edit">
          <i class="fas fa-edit"></i> Actualizar
        </a>
        <form action="{{ route('sensors.destroy', $sensorData['sensor_id']) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de querer eliminar este sensor?')">
            <i class="fas fa-trash-alt"></i> Eliminar
          </button>
        </form>
      </div>
    </div>
    @endforeach
  </div>

  <script>
    // Función para actualizar los datos de los sensores cada 5 segundos
    function updateLatestValues() {
      fetch("{{ route('api.latestReadings') }}")
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById('sensors-container');
          container.innerHTML = '';
          data.forEach(sensorData => {
            const sensorCard = document.createElement('div');
            sensorCard.classList.add('sensor-card');
            sensorCard.id = 'sensor-' + sensorData.sensor_id;
            sensorCard.innerHTML = `
              <div class="sensor-header">
                <div class="sensor-title">
                  <i class="fas fa-sensor me-2"></i>Sensor: ${sensorData.tipo} - ${sensorData.ubicacion}
                </div>
                <div class="sensor-id">ID: ${sensorData.sensor_id}</div>
              </div>
              <div class="sensor-body">
                <p><strong>Última Lectura:</strong> ${sensorData.reading.valor}</p>
                <p><strong>Fecha:</strong> ${sensorData.reading.created_at || sensorData.reading.registrado_en}</p>
              </div>
              <div class="sensor-actions">
                <a href="{{ route('sensors.edit', '') }}/${sensorData.sensor_id}" class="btn btn-edit">
                  <i class="fas fa-edit"></i> Actualizar
                </a>
                <form action="{{ route('sensors.destroy', '') }}/${sensorData.sensor_id}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de querer eliminar este sensor?')">
                    <i class="fas fa-trash-alt"></i> Eliminar
                  </button>
                </form>
              </div>
            `;
            container.appendChild(sensorCard);
          });
        })
        .catch(error => console.error("Error actualizando datos:", error));
    }

    // Actualiza cada 5000 ms (5 segundos)
    setInterval(updateLatestValues, 5000);
  </script>
</body>
</html>
