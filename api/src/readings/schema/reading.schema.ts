import { Schema, SchemaFactory, Prop } from '@nestjs/mongoose';
import { Document, Types } from 'mongoose';
import { Sensor } from '../../sensors/schema/sensores.schema'; // Importa el modelo Sensor
import * as mongoose from 'mongoose';

@Schema({
  collection: 'readings',
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
})
export class Reading extends Document {
  @Prop({
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Sensor',
    required: true
  })
  sensor_id: Types.ObjectId; // Cambiado de string a Types.ObjectId

  @Prop({ required: true })
  valor: number;
}

export const ReadingSchema = SchemaFactory.createForClass(Reading);