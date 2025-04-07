import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { MongooseModule } from '@nestjs/mongoose';
import { AlertasModule } from './alertas/alertas.module'; 
import { UsersModule } from './users/users.module'; 
import { SensoresModule } from './sensors/sensores.module';
import { ReadingsModule } from './readings/reading.module';
import { User, UserSchema } from './users/schema/users.schema';
import { Sensor, SensorSchema } from './sensors/schema/sensores.schema';
import { Reading, ReadingSchema } from './readings/schema/reading.schema';
import { Alerta, AlertaSchema } from './alertas/schema/alertas.schema';


@Module({
  imports: [
    MongooseModule.forRoot("mongodb://localhost:27017/psycowax"),
    MongooseModule.forFeature([
      { name: User.name, schema: UserSchema },
      { name: Sensor.name, schema: SensorSchema },
      { name: Reading.name, schema: ReadingSchema },
      { name: Alerta.name, schema: AlertaSchema }
    ]),
    AlertasModule,UsersModule,SensoresModule,ReadingsModule,
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule {}