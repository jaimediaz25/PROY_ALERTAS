const express = require('express');
const router = express.Router(); 
const connectDB = require('./db');
const User = require('./Models/User');
const Sensor = require('./Models/Sensor');
const Reading = require('./Models/Reading');
const Alert = require('./Models/Alert');
const { body, validationResult } = require('express-validator');

// Actualizar contraseña
router.put('/users/update-password', async (req, res) => {
  try {
    const { email, password } = req.body;
    
    const user = await User.findOne({ email });
    if (!user) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    const hashedPassword = await bcrypt.hash(password, 10);
    user.password = hashedPassword;
    await user.save();

    res.json({ message: 'Contraseña actualizada exitosamente' });

  } catch (err) {
    console.error('Error actualizando contraseña:', err);
    res.status(500).json({ error: 'Error al actualizar contraseña' });
  }
});

//Checar email
router.get('/users/check-email', async (req, res) => {
  try {
    const email = req.query.email?.toLowerCase().trim();
    
    if (!email) {
      return res.status(400).json({ error: 'Email requerido' });
    }
    const existingUser = await User.findOne({ email });
    res.json({ exists: !!existingUser });
  } catch (err) {
    console.error('Error en check-email:', err);
    res.status(500).json({ error: 'Error al verificar email' });
  }
});


// Obtener todos los usuarios
router.get('/users', async (req, res) => {
  try {
    const { search, page = 1, perPage = 10 } = req.query;
    const query = {};
    
    if (search) {
      query.$or = [
        { nombre: { $regex: search, $options: 'i' } },
        { apellidos: { $regex: search, $options: 'i' } },
        { email: { $regex: search, $options: 'i' } }
      ];
    }

    const total = await User.countDocuments(query);
    const users = await User.find(query, 'nombre apellidos edad email rol')
      .skip((page - 1) * perPage)
      .limit(perPage);

    res.json({
      data: users,
      total,
      currentPage: Number(page),
      perPage: Number(perPage),
      totalPages: Math.ceil(total / perPage)
    });
  } catch (err) {
    console.error('Error al obtener usuarios:', err);
    res.status(500).json({ error: 'Error al obtener usuarios' });
  }
});


// Obtener un usuario por ID
router.get('/users/:id', async (req, res) => {
  try {
    const user = await User.findById(req.params.id, 'nombre apellidos edad email rol imagen');
    if (!user) return res.status(404).json({ error: 'Usuario no encontrado' });
    res.json(user);
  } catch (err) {
    console.error('Error al obtener usuario:', err);
    res.status(500).json({ error: 'Error al obtener el usuario' });
  }
});


// Crear un nuevo usuario
const _ = require('lodash');
const bcrypt = require('bcrypt');
router.post('/users', async (req, res) => {
  try {
    const { nombre, apellidos, edad, email, password, rol } = req.body;
    if (!email || !password) {
      return res.status(400).json({ error: 'Email y contraseña son requeridos' });
    }
    if (!password || password.length < 8) {
      return res.status(400).json({ 
        error: 'La contraseña debe tener al menos 8 caracteres' 
      });
    }
    const existingUser = await User.findOne({ email });
    if (existingUser) {
      return res.status(409).json({ error: 'El email ya está registrado' });
    }
    const hashedPassword = await bcrypt.hash(password, 10); 

    const newUser = await User.create({
      nombre,
      apellidos,
      edad,
      email,
      rol,
      password: hashedPassword,
    });

    res.status(201).json({
      message: 'Usuario creado correctamente',
      user: _.omit(newUser.toObject(), 'password')
    });

  } catch (err) {
    console.error('Error detallado:', err);
    res.status(500).json({
      error: 'Error al registrar usuario',
      details: err.message
    });
  }
});


// Actualizar un usuario
router.put('/users/:id', async (req, res) => {
  try {
    const { nombre, apellidos, edad, email, rol, imagen} = req.body;
    
    const updatedUser = await User.findByIdAndUpdate(
      req.params.id,
      { nombre, apellidos, edad, email, rol, imagen},
      { new: true, runValidators: true } 
    );

    if (!updatedUser) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }
    
    res.json({
      message: 'Usuario actualizado correctamente',
      user: updatedUser
    });
    
  } catch (err) {
    console.error('Error detallado:', err);
    res.status(500).json({
      error: 'Error al actualizar usuario',
      details: err.message
    });
  }
});


// Eliminar un usuario
router.delete('/users/:id', async (req, res) => {
  try {
    const deletedUser = await User.findByIdAndDelete(req.params.id);
    if (!deletedUser) return res.status(404).json({ error: 'Usuario no encontrado' });
    res.json({ message: 'Usuario eliminado correctamente' });
  } catch (err) {
    console.error('Error al eliminar usuario:', err);
    res.status(500).json({ error: 'Error al eliminar usuario' });
  }
});


// Mostrar grafica
router.get('/users/stats/monthly', async (req, res) => {
  try {
    const stats = await User.aggregate([
      {
        $group: {
          _id: {
            year: { $year: "$created_at" },
            month: { $month: "$created_at" }
          },
          total: { $sum: 1 },
          updated: {
            $sum: {
              $cond: [{ $ne: ["$created_at", "$updated_at"] }, 1, 0]
            }
          }
        }
      },
      {
        $project: {
          _id: 0,
          year: "$_id.year",
          month: "$_id.month",
          total: 1,
          updated: 1
        }
      },
      { $sort: { year: 1, month: 1 } }
    ]);

    res.json(stats);
    
  } catch (err) {
    console.error('Error al obtener estadísticas:', err);
    res.status(500).json({ error: 'Error al obtener datos para la gráfica' });
  }
});









//Checar sensor
router.get('/sensors/check', async (req, res) => {
  try {
    const { ubicacion, tipo } = req.query;
    
    const existingSensor = await Sensor.findOne({ 
      ubicacion: ubicacion.trim(),
      tipo: tipo.trim()
    });

    res.json({ exists: !!existingSensor });
    
  } catch (err) {
    console.error('Error verificando sensor:', err);
    res.status(500).json({ error: 'Error al verificar sensor' });
  }
});

// Obtener todos los sensores
router.get('/sensors', async (req, res) => {
  try {
    const sensores = await Sensor.find();
    res.json(sensores);
  } catch (err) {
    console.error('Error al obtener sensores:', err);
    res.status(500).json({ error: 'Error al obtener sensores' });
  }
});

// Obtener un sensor por ID
router.get('/sensors/:id', async (req, res) => {
  try {
    const sensor = await Sensor.findById(req.params.id);
    if (!sensor) return res.status(404).json({ error: 'Sensor no encontrado' });
    res.json(sensor);
  } catch (err) {
    console.error('Error al obtener sensor:', err);
    res.status(500).json({ error: 'Error al obtener el sensor' });
  }
});

// Crear un nuevo sensor
router.post('/sensors', async (req, res) => {
  try {
    const { ubicacion, tipo, activo, user_id } = req.body; // Añade user_id desde el body
    const nuevoSensor = await Sensor.create({
      user_id, // Campo obligatorio
      ubicacion,
      tipo,
      activo: activo !== undefined ? activo : true,
    });
    res.status(201).json({
      message: 'Sensor creado correctamente',
      id: nuevoSensor._id
    });
  } catch (err) {
    console.error('Error al crear sensor:', err);
    res.status(500).json({ error: 'Error al crear sensor' });
  }
});

// Actualizar un sensor
router.put('/sensors/:id', async (req, res) => {
  try {
    const { ubicacion, tipo, activo, user_id } = req.body;
    const sensorActualizado = await Sensor.findByIdAndUpdate(
      req.params.id,
      { ubicacion, tipo, activo, user_id },
      { new: true }
    );
    
    if (!sensorActualizado) return res.status(404).json({ error: 'Sensor no encontrado' });
    res.json({ message: 'Sensor actualizado correctamente' });
  } catch (err) {
    console.error('Error al actualizar sensor:', err);
    res.status(500).json({ error: 'Error al actualizar sensor' });
  }
});

// Eliminar un sensor
router.delete('/sensors/:id', async (req, res) => {
  try {
    const sensorEliminado = await Sensor.findByIdAndDelete(req.params.id);
    if (!sensorEliminado) return res.status(404).json({ error: 'Sensor no encontrado' });
    res.json({ message: 'Sensor eliminado correctamente' });
  } catch (err) {
    console.error('Error al eliminar sensor:', err);
    res.status(500).json({ error: 'Error al eliminar sensor' });
  }
});

//Mostrar grafica
router.get('/sensors/stats/monthly', async (req, res) => {
  try {
    const stats = await Sensor.aggregate([
      {
        $group: {
          _id: {
            year: { $year: "$created_at" },
            month: { $month: "$created_at" }
          },
          total: { $sum: 1 },
          activos: { $sum: { $cond: [{ $eq: ["$activo", true] }, 1, 0] } },
          actualizados: { 
            $sum: { 
              $cond: [{ $ne: ["$created_at", "$updated_at"] }, 1, 0] 
            } 
          }
        }
      },
      {
        $project: {
          _id: 0,
          year: "$_id.year",
          month: "$_id.month",
          total: 1,
          activos: 1,
          actualizados: 1
        }
      },
      { $sort: { year: 1, month: 1 } }
    ]);

    res.json(stats);
    
  } catch (err) {
    console.error('Error al obtener estadísticas:', err);
    res.status(500).json({ error: 'Error al obtener datos para la gráfica' });
  }
});








// Obtener todos los readings
router.get('/readings', async (req, res) => {
  try {
    const readings = await Reading.find();
    res.json(readings);
  } catch (err) {
    console.error('Error al obtener readings:', err);
    res.status(500).json({ error: 'Error al obtener readings' });
  }
});

// Obtener un reading por ID
router.get('/readings/:id', async (req, res) => {
  try {
    const reading = await Reading.findById(req.params.id);
    if (!reading) return res.status(404).json({ error: 'Reading no encontrado' });
    res.json(reading);
  } catch (err) {
    console.error('Error al obtener reading:', err);
    res.status(500).json({ error: 'Error al obtener el reading' });
  }
});

// Crear un nuevo reading
router.post('/readings', async (req, res) => {
  try {
    const { sensor_id, valor, registrado_en } = req.body;
    
    const nuevoReading = await Reading.create({
      sensor_id,
      valor,
      registrado_en: registrado_en || new Date()
    });
    
    res.status(201).json({
      message: 'Reading creado correctamente',
      id: nuevoReading._id
    });
  } catch (err) {
    console.error('Error al crear reading:', err);
    res.status(500).json({ error: 'Error al crear reading' });
  }
});

// Actualizar un reading
router.put('/readings/:id', async (req, res) => {
  try {
    const { sensor_id, valor, registrado_en } = req.body;
    
    const readingActualizado = await Reading.findByIdAndUpdate(
      req.params.id,
      { sensor_id, valor, registrado_en },
      { new: true }
    );
    
    if (!readingActualizado) return res.status(404).json({ error: 'Reading no encontrado' });
    res.json({ message: 'Reading actualizado correctamente' });
  } catch (err) {
    console.error('Error al actualizar reading:', err);
    res.status(500).json({ error: 'Error al actualizar reading' });
  }
});

// Eliminar un reading
router.delete('/readings/:id', async (req, res) => {
  try {
    const readingEliminado = await Reading.findByIdAndDelete(req.params.id);
    if (!readingEliminado) return res.status(404).json({ error: 'Reading no encontrado' });
    res.json({ message: 'Reading eliminado correctamente' });
  } catch (err) {
    console.error('Error al eliminar reading:', err);
    res.status(500).json({ error: 'Error al eliminar reading' });
  }
});

//Mostrar la grafica
router.get('/readings/stats/monthly', async (req, res) => {
  try {
    const stats = await Reading.aggregate([
      {
        $group: {
          _id: {
            year: { $year: "$registrado_en" },
            month: { $month: "$registrado_en" }
          },
          total: { $sum: 1 },
          promedio: { $avg: "$valor" },
          maximo: { $max: "$valor" },
          minimo: { $min: "$valor" }
        }
      },
      {
        $project: {
          _id: 0,
          year: "$_id.year",
          month: "$_id.month",
          total: 1,
          promedio: { $round: ["$promedio", 2] },
          maximo: 1,
          minimo: 1
        }
      },
      { $sort: { year: 1, month: 1 } }
    ]);

    res.json(stats);
    
  } catch (err) {
    console.error('Error al obtener estadísticas:', err);
    res.status(500).json({ error: 'Error al obtener datos para la gráfica' });
  }
});






// Obtener todas las alertas
router.get('/alerts', async (req, res) => {
  try {
    const alertas = await Alert.find();
    res.json(alertas);
  } catch (err) {
    console.error('Error al obtener alertas:', err);
    res.status(500).json({ error: 'Error al obtener alertas' });
  }
});

// Obtener una alerta por ID
router.get('/alerts/:id', async (req, res) => {
  try {
    const alerta = await Alert.findById(req.params.id);
    if (!alerta) return res.status(404).json({ error: 'Alerta no encontrada' });
    res.json(alerta);
  } catch (err) {
    console.error('Error al obtener alerta:', err);
    res.status(500).json({ error: 'Error al obtener la alerta' });
  }
});

// Crear una nueva alerta
router.post('/alerts', async (req, res) => {
  try {
    const { sensor_id, user_id, tipo_alerta, mensaje, atendida, generado_en } = req.body;
    
    const nuevaAlerta = await Alert.create({
      sensor_id,
      user_id,
      tipo_alerta,
      mensaje,
      atendida: atendida || false,
      generado_en: generado_en || new Date()
    });
    
    res.status(201).json({
      message: 'Alerta creada correctamente',
      id: nuevaAlerta._id
    });
  } catch (err) {
    console.error('Error al crear alerta:', err);
    res.status(500).json({ error: 'Error al crear alerta' });
  }
});

// Actualizar una alerta
router.put('/alerts/:id', async (req, res) => {
  try {
    const { sensor_id, user_id, tipo_alerta, mensaje, atendida, generado_en } = req.body;
    
    const alertaActualizada = await Alert.findByIdAndUpdate(
      req.params.id,
      {
        sensor_id,
        user_id,
        tipo_alerta,
        mensaje,
        atendida,
        generado_en
      },
      { new: true }
    );
    
    if (!alertaActualizada) return res.status(404).json({ error: 'Alerta no encontrada' });
    res.json({ message: 'Alerta actualizada correctamente' });
  } catch (err) {
    console.error('Error al actualizar alerta:', err);
    res.status(500).json({ error: 'Error al actualizar alerta' });
  }
});

// Eliminar una alerta
router.delete('/alerts/:id', async (req, res) => {
  try {
    const alertaEliminada = await Alert.findByIdAndDelete(req.params.id);
    if (!alertaEliminada) return res.status(404).json({ error: 'Alerta no encontrada' });
    res.json({ message: 'Alerta eliminada correctamente' });
  } catch (err) {
    console.error('Error al eliminar alerta:', err);
    res.status(500).json({ error: 'Error al eliminar alerta' });
  }
});


//Mostrar grafica
router.get('/alerts/stats/monthly', async (req, res) => {
  try {
    const stats = await Alert.aggregate([
      {
        $group: {
          _id: {
            year: { $year: "$generado_en" },
            month: { $month: "$generado_en" }
          },
          total: { $sum: 1 },
          atendidas: { $sum: { $cond: [{ $eq: ["$atendida", true] }, 1, 0] } },
          tipos: { 
            $push: "$tipo_alerta" 
          }
        }
      },
      {
        $project: {
          _id: 0,
          year: "$_id.year",
          month: "$_id.month",
          total: 1,
          atendidas: 1,
          tipos: 1
        }
      },
      { $sort: { year: 1, month: 1 } }
    ]);

    const processedStats = stats.map(stat => ({
      ...stat,
      tipos: stat.tipos.reduce((acc, tipo) => {
        acc[tipo] = (acc[tipo] || 0) + 1;
        return acc;
      }, {})
    }));

    res.json(processedStats);
    
  } catch (err) {
    console.error('Error al obtener estadísticas:', err);
    res.status(500).json({ error: 'Error al obtener datos para la gráfica' });
  }
});


//Checar ids validos
router.get('/alerts/check', async (req, res) => {
  try {
    const { sensor_id, user_id, generado_en } = req.query;
    
    const existingAlert = await Alert.findOne({
      sensor_id: new mongoose.Types.ObjectId(sensor_id),
      user_id: new mongoose.Types.ObjectId(user_id),
      generado_en: new Date(generado_en)
    });

    res.json({ exists: !!existingAlert });
    
  } catch (err) {
    console.error('Error verificando alerta:', err);
    res.status(500).json({ error: 'Error al verificar alerta' });
  }
});



// Login de usuario
router.post('/auth/login', async (req, res) => {
  try {
    const { email, password } = req.body;
    const user = await User.findOne({ email })
      .select('+password +intentos_fallidos +bloqueado_hasta');

    if (!user) {
      return res.status(401).json({ error: 'Credenciales incorrectas' });
    }

    if (user.bloqueado_hasta && user.bloqueado_hasta > new Date()) {
      return res.status(403).json({ 
        error: `Cuenta bloqueada. Intente nuevamente después de ${user.bloqueado_hasta.toLocaleTimeString()}`
      });
    }

    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
      user.intentos_fallidos = (user.intentos_fallidos || 0) + 1;
      if (user.intentos_fallidos >= 3) {
        user.bloqueado_hasta = new Date(Date.now() + 5 * 60 * 1000); 
      }
      
      await user.save();
      
      return res.status(401).json({ 
        error: user.intentos_fallidos >= 3 
          ? `Cuenta bloqueada por 5 minutos` 
          : `Credenciales incorrectas (Intentos restantes: ${3 - user.intentos_fallidos})`
      });
    }
    user.intentos_fallidos = 0;
    user.bloqueado_hasta = null;
    await user.save();

    res.json({
      success: true,
      user: _.omit(user.toObject(), ['password', 'intentos_fallidos', 'bloqueado_hasta'])
    });

  } catch (err) {
    console.error('Error en login:', err);
    res.status(500).json({ error: 'Error al iniciar sesión' });
  }
});



module.exports = router;