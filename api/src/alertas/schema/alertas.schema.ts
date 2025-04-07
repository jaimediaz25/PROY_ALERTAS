import { Schema, SchemaFactory, Prop } from '@nestjs/mongoose';
import { Document, Types } from 'mongoose';
import { Sensor } from '../../sensors/schema/sensores.schema'; // Importa el modelo Sensor
import { User } from '../../users/schema/users.schema'; // Importa el modelo User
import * as mongoose from 'mongoose';

@Schema({
  collection: 'alerts',
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
})
export class Alerta extends Document {
  @Prop({
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Sensor',
    required: true
  })
  sensor_id: Types.ObjectId; // Cambiado de string a Types.ObjectId

  @Prop({
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true
  })
  user_id: Types.ObjectId; // Cambiado de string a Types.ObjectId

  @Prop({ required: true })
  tipo_alerta: string;

  @Prop({ required: true })
  mensaje: string;

  @Prop({ default: false })
  atendida: boolean;

  @Prop({ 
    type: Date,
    default: Date.now 
  })
  generado_en: Date; // Cambiado de string a Date
}

export const AlertaSchema = SchemaFactory.createForClass(Alerta);