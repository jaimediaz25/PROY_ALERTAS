import { Schema, SchemaFactory, Prop } from "@nestjs/mongoose";
import { Document, Types } from "mongoose";
import { User } from "../../users/schema/users.schema"; // Asegúrate de importar el modelo User
import * as mongoose from 'mongoose';

@Schema({
  collection: "sensors",
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
})
export class Sensor extends Document {
  @Prop({
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true
  })
  user_id: Types.ObjectId; // Cambiado de string | number a Types.ObjectId

  @Prop({ required: true })
  ubicacion: string;

  @Prop({ required: true })
  tipo: string;

  @Prop({ required: true, default: true })
  activo: boolean;
}

export const SensorSchema = SchemaFactory.createForClass(Sensor);