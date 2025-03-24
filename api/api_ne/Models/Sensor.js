const mongoose = require('mongoose');

const SensorSchema = new mongoose.Schema({
  user_id: { 
    type: mongoose.Schema.Types.ObjectId,
    ref: "User",
    required: true,
  },
  ubicacion: {
    type: String,
    required: true
  },
  tipo: {
    type: String,
    required: true
  },
  activo: {
    type: Boolean,
    required: true,
    default: true
  }
}, {
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
});

module.exports = mongoose.model('Sensor', SensorSchema);