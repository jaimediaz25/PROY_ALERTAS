import { Schema, Prop, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';

@Schema({ 
  collection: 'users',
  timestamps: {
    createdAt: 'created_at',
    updatedAt: 'updated_at'
  }
})
export class User extends Document {
  @Prop()
  imagen: string;

  @Prop({ required: true })
  nombre: string;

  @Prop({ required: true })
  apellidos: string;

  @Prop({ required: true })
  edad: number;

  @Prop({ 
    required: true, 
    unique: true,
    index: true 
  })
  email: string;

  @Prop({ required: true })
  password: string;

  @Prop({ required: true })
  rol: string;

  @Prop({ default: 0 })
  intentos_fallidos: number;

  @Prop({ default: null })
  bloqueado_hasta: Date;
}

export const UserSchema = SchemaFactory.createForClass(User);