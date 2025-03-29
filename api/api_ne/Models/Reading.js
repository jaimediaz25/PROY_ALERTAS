const mongoose = require('mongoose');

const ReadingSchema = new mongoose.Schema({
  sensor_id: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Sensor',
    required: true
  },
  valor: {
    type: Number,
    required: true
  },
}, {
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
});

module.exports = mongoose.model('Reading', ReadingSchema);