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
    .native-alert {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10000;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    width: 400px;
    max-width: 90%;
    font-family: system-ui, -apple-system, sans-serif;
}

.native-alert-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
}

.native-alert-content {
    padding: 20px;
    display: flex;
    gap: 15px;
}

.native-alert-icon {
    font-size: 2em;
    margin-top: 5px;
}

.native-alert-text {
    flex: 1;
}

.native-alert-text h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.2em;
}

.native-alert-text p {
    margin: 0 0 15px 0;
    color: #666;
    line-height: 1.5;
}

.native-alert-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.native-btn {
    padding: 8px 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.9em;
    transition: all 0.2s;
}

.native-btn-attend {
    background: #007AFF;
    color: white;
    border-color: #007AFF;
}

.native-btn-attend:hover {
    background: #0063CC;
}

.native-btn-ignore {
    background: #f0f0f0;
    color: #333;
}

.native-btn-ignore:hover {
    background: #e0e0e0;
}

.native-alert-error {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #ff4444;
    color: white;
    padding: 15px 20px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: system-ui, -apple-system, sans-serif;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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

  <script>
    // Variables globales para rutas y seguridad
    const EDIT_ROUTE_TEMPLATE = "{{ route('sensors.edit', ':id') }}";
    const DESTROY_ROUTE_TEMPLATE = "{{ route('sensors.destroy', ':id') }}";
    // Actualiza la constante ALERTS_ROUTE
const ALERTS_ROUTE = "{{ route('api.alerts.unacknowledged') }}?user_id={{ auth()->id() }}";
    const ATTEND_ALERT_TEMPLATE = "{{ route('api.alerts.attend', ':id') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    let processedAlerts = new Set();
  </script>

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
    // Función para actualizar los sensores
    function updateLatestValues() {
      fetch("{{ route('api.latestReadings') }}")
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById('sensors-container');
          container.innerHTML = '';
          
          data.forEach(sensorData => {
            const editRoute = EDIT_ROUTE_TEMPLATE.replace(':id', sensorData.sensor_id);
            const destroyRoute = DESTROY_ROUTE_TEMPLATE.replace(':id', sensorData.sensor_id);

            const sensorCard = document.createElement('div');
            sensorCard.classList.add('sensor-card');
            sensorCard.id = `sensor-${sensorData.sensor_id}`;
            
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
                <a href="${editRoute}" class="btn btn-edit">
                  <i class="fas fa-edit"></i> Actualizar
                </a>
                <form action="${destroyRoute}" method="POST" class="d-inline">
                  <input type="hidden" name="_token" value="${CSRF_TOKEN}">
                  <input type="hidden" name="_method" value="DELETE">
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

    // Función para manejar alertas
    async function checkAlerts() {
    try {
        const response = await fetch(ALERTS_ROUTE);
        
        // Verificar estado de la respuesta
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status} - ${errorText}`);
        }
        
        const alerts = await response.json();
        console.log('Alertas recibidas:', alerts); // Debug
        
        // Filtrar solo alertas no procesadas y tipo ALTA
        const nuevasAlertas = alerts.filter(alert => 
            alert.tipo_alerta === 'ALTA' && 
            !processedAlerts.has(alert._id)
        );

        nuevasAlertas.forEach(alert => {
            processedAlerts.add(alert._id);
            this.mostrarAlertaUI(alert);
        });
    } catch (error) {
        console.error('Error en el sistema de alertas:', error);
        this.mostrarErrorAlerta(error.message);
    }
}

// Nueva función para mostrar alertas en UI
function mostrarAlertaUI(alert) {
    const sensores = Array.from(document.querySelectorAll('.sensor-card'));
    const sensor = sensores.find(s => s.id === `sensor-${alert.sensor_id}`);
    
    let ubicacion = 'Ubicación desconocida';
    if (sensor) {
        const titulo = sensor.querySelector('.sensor-title').textContent;
        ubicacion = titulo.split(' - ')[1].trim();
    }

    // Formatear la fecha correctamente
    const fechaAlerta = new Date(alert.created_at);
    const opcionesHora = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZone: 'America/Mexico_City' // Cambia esto a tu zona horaria
    };
    const opcionesFecha = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    };
    
    const horaLocal = fechaAlerta.toLocaleTimeString('es-MX', opcionesHora);
    const fechaLocal = fechaAlerta.toLocaleDateString('es-MX', opcionesFecha);

    const dialog = document.createElement('div');
    dialog.className = 'native-alert';
    dialog.innerHTML = `
        <div class="native-alert-content">
            <div class="native-alert-icon">⚠️</div>
            <div class="native-alert-text">
                <h3>Alerta ${alert.tipo_alerta} - Sensor ${alert.sensor_id}</h3>
                <p>${alert.mensaje}</p>
                <p class="sensor-location">📍 ${ubicacion}</p>
                <br>
                <br>
                <p class="alert-time">🕒 ${fechaLocal} ${horaLocal}</p>
                <div class="native-alert-buttons">
                    <button class="native-btn native-btn-ignore">Ignorar</button>
                    <button class="native-btn native-btn-attend">Atender</button>
                </div>
            </div>
        </div>
    `;

    const backdrop = document.createElement('div');
    backdrop.className = 'native-alert-backdrop';
    
    dialog.querySelector('.native-btn-attend').onclick = () => {
        atenderAlerta(alert._id, true);
        document.body.removeChild(backdrop);
        document.body.removeChild(dialog);
    };
    
    dialog.querySelector('.native-btn-ignore').onclick = () => {
        atenderAlerta(alert._id, false);
        document.body.removeChild(backdrop);
        document.body.removeChild(dialog);
    };

    document.body.appendChild(backdrop);
    document.body.appendChild(dialog);
}

// Función para manejar la respuesta del usuario
function atenderAlerta(alertId, atendida) {
    const attendRoute = ATTEND_ALERT_TEMPLATE.replace(':id', alertId);
    
    fetch(attendRoute, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({ atendida })
    })
    .then(response => {
        if (!response.ok) throw new Error('Error en respuesta del servidor');
        // Remover la alerta de la UI
        document.querySelectorAll('.alert-card').forEach(card => {
            if (card.dataset.alertId === alertId) card.remove();
        });
    })
    .catch(error => {
        console.error('Error actualizando alerta:', error);
        mostrarErrorAlerta(error.message);
    });
}

// Función para mostrar errores
function mostrarErrorAlerta(mensaje) {
    const errorDialog = document.createElement('div');
    errorDialog.className = 'native-alert-error';
    errorDialog.innerHTML = `
        <div class="native-alert-content">
            <div class="native-alert-icon">❌</div>
            <div class="native-alert-text">
                <p>${mensaje}</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(errorDialog);
    setTimeout(() => errorDialog.remove(), 3000);
}

    // Función combinada de actualización
    function refreshData() {
      updateLatestValues();
      checkAlerts();
    }

    // Configurar intervalos
    setInterval(refreshData, 5000);
    // Ejecutar inmediatamente al cargar
    document.addEventListener('DOMContentLoaded', refreshData);
  </script>
  
</body>
</html>
