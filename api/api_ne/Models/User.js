const mongoose = require('mongoose');
const UserSchema = new mongoose.Schema({
  imagen: String,
  nombre: {
    type: String,
    required: true
  },
  apellidos: {
    type: String,
    required: true
  },
  edad: {
    type: Number,
    required: true
  },
  email: {
    type: String,
    required: true,
    unique: true
  },
  password: {
    type: String,
    required: true
  },
  rol: {
    type: String,
    required: true
  },
  intentos_fallidos: {
    type: Number,
    default: 0
  },
  bloqueado_hasta: {
    type: Date,
    default: null
  }
  }, {
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
});

module.exports = mongoose.model('User', UserSchema);