const mongoose = require('mongoose');

const AlertSchema = new mongoose.Schema({
  sensor_id: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Sensor',
    required: true
  },
  user_id: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true
  },
  tipo_alerta: {
    type: String,
    required: true
  },
  mensaje: {
    type: String,
    required: true
  },
  atendida: {
    type: Boolean,
    default: false
  },
  generado_en: {
    type: Date,
    default: Date.now
  }
}, {
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
});

module.exports = mongoose.model('Alert', AlertSchema);