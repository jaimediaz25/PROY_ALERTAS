// routes.js
const express = require('express');
const router = express.Router();
const connection = require('./db');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');

const JWT_SECRET = 'secreto_super_seguro';

// Registro de usuario
router.post('/register', async (req, res) => {
    const { nombre, apellidos, edad, email, password } = req.body;
    const hashedPassword = await bcrypt.hash(password, 10);

    connection.query('INSERT INTO users (nombre, apellidos, edad, email, password) VALUES (?, ?, ?, ?, ?)',
        [nombre, apellidos, edad, email, hashedPassword],
        (err, result) => {
            if (err) {
                console.error('Error al registrar:', err);
                return res.status(500).json({ error: 'Error al registrar' });
            }
            res.status(201).json({ message: 'Registrado correctamente' });
        }
    );
});

// Login de usuario con bloqueo tras 3 intentos fallidos
router.post('/login', async (req, res) => {
    const { email, password } = req.body;

    connection.query('SELECT * FROM users WHERE email = ?', [email], async (err, results) => {
        if (err) return res.status(500).json({ error: 'Error al buscar usuario' });

        if (results.length === 0) return res.status(404).json({ error: 'Usuario no encontrado' });

        const user = results[0];

        // Verificar si el usuario está bloqueado
        if (user.bloqueado_hasta && new Date(user.bloqueado_hasta) > new Date()) {
            return res.status(403).json({ error: 'Cuenta bloqueada. Intente más tarde.' });
        }

        const passwordMatch = await bcrypt.compare(password, user.password);

        if (!passwordMatch) {
            let intentos = user.intentos_fallidos + 1;
            let bloqueado_hasta = intentos >= 3 ? new Date(Date.now() + 5 * 60000) : null;

            connection.query('UPDATE users SET intentos_fallidos = ?, bloqueado_hasta = ? WHERE email = ?',
                [intentos, bloqueado_hasta, email]);

            return res.status(401).json({ error: 'Credenciales incorrectas' });
        }

        // Resetear intentos fallidos
        connection.query('UPDATE users SET intentos_fallidos = 0, bloqueado_hasta = NULL WHERE email = ?', [email]);

        const token = jwt.sign({ id: user.id, email: user.email, rol: user.rol }, JWT_SECRET, { expiresIn: '1h' });

        res.json({ message: 'Login exitoso', token });
    });
});

// Restablecer contraseña
router.post('/reset-password', (req, res) => {
    const { email, newPassword } = req.body;
    const hashedPassword = bcrypt.hashSync(newPassword, 10);

    connection.query('UPDATE users SET password = ? WHERE email = ?', [hashedPassword, email], (err, result) => {
        if (err) return res.status(500).json({ error: 'Error al actualizar contraseña' });
        if (result.affectedRows === 0) return res.status(404).json({ error: 'Correo no encontrado' });

        res.json({ message: 'Contraseña actualizada correctamente' });
    });
});

// Obtener todos los usuarios
router.get('/users', (req, res) => {
  connection.query('SELECT id, nombre, apellidos, edad, email, rol FROM users', (err, results) => {
      if (err) {
          console.error('Error al obtener usuarios:', err);
          return res.status(500).json({ error: 'Error al obtener usuarios' });
      }
      res.json(results);
  });
});

// Obtener un usuario por ID
router.get('/users/:id', (req, res) => {
  const { id } = req.params;
  connection.query('SELECT id, nombre, apellidos, edad, email, rol FROM users WHERE id = ?', [id], (err, results) => {
      if (err) return res.status(500).json({ error: 'Error al obtener el usuario' });
      if (results.length === 0) return res.status(404).json({ error: 'Usuario no encontrado' });
      res.json(results[0]);
  });
});

// Crear un nuevo usuario
router.post('/users', async (req, res) => {
  const { nombre, apellidos, edad, email, password, rol } = req.body;
  const hashedPassword = await bcrypt.hash(password, 10);

  connection.query('INSERT INTO users (nombre, apellidos, edad, email, password, rol) VALUES (?, ?, ?, ?, ?, ?)',
      [nombre, apellidos, edad, email, hashedPassword, rol],
      (err, result) => {
          if (err) {
              console.error('Error al registrar usuario:', err);
              return res.status(500).json({ error: 'Error al registrar usuario' });
          }
          res.status(201).json({ message: 'Usuario creado correctamente' });
      }
  );
});

// Actualizar un usuario
router.put('/users/:id', (req, res) => {
  const { nombre, apellidos, edad, email, rol } = req.body;
  
  connection.query(
      'UPDATE users SET nombre = ?, apellidos = ?, edad = ?, email = ?, rol = ? WHERE id = ?',
      [nombre, apellidos, edad, email, rol, req.params.id],
      (err, result) => {
          if (err) return res.status(500).json({ error: 'Error al actualizar usuario' });
          if (result.affectedRows === 0) return res.status(404).json({ error: 'Usuario no encontrado' });

          res.json({ message: 'Usuario actualizado correctamente' });
      }
  );
});

// Eliminar un usuario
router.delete('/users/:id', (req, res) => {
  const { id } = req.params;
  connection.query('DELETE FROM users WHERE id = ?', [id], (err, result) => {
      if (err) return res.status(500).json({ error: 'Error al eliminar usuario' });
      if (result.affectedRows === 0) return res.status(404).json({ error: 'Usuario no encontrado' });

      res.json({ message: 'Usuario eliminado correctamente' });
  });
});

module.exports = router;















/*
// Obtener todos los registros
router.get('/registros', (req, res) => {
  connection.query('SELECT * FROM tb_alumnos', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/registros/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM tb_alumnos WHERE id_alumno = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/registros', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO tb_alumnos SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/registros/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  delete datosActualizados._token;
  delete datosActualizados._method;
  connection.query('UPDATE tb_alumnos SET ? WHERE id_alumno = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/registros/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM tb_alumnos WHERE id_alumno = ?', [id], (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    // Verificar si se eliminó algún registro
    if (results.affectedRows === 0) {
      return res.status(404).json({ error: 'Registro no encontrado' });
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});


// Obtener todos los registros de dos tablas
router.get('/datos', (req, res) => {
  connection.query('SELECT car.id_carrera AS id, car.nombre AS carrera, gru.nombre AS grupo ' +
    'FROM tb_carrera AS car, tb_grupos AS gru ' +
    'WHERE car.id_carrera=gru.id_carrera', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

*/


































































/*
// Obtener todos los registros
router.get('/universidades', (req, res) => {
  connection.query('SELECT * FROM tb_universidades', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/universidades/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM tb_universidades WHERE id_uni = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

















// Obtener todos los registros
router.get('/carreras', (req, res) => {
  connection.query('SELECT * FROM tb_carreras', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/carreras/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM tb_carreras WHERE id_carrera = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});













// Obtener todos los registros
router.get('/grupos', (req, res) => {
  connection.query('SELECT * FROM tb_grupos', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/grupos/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM tb_grupos WHERE id_grupo = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});


module.exports = router;


*/
