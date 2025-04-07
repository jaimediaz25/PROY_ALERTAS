import { Module } from "@nestjs/common";
import { MongooseModule } from "@nestjs/mongoose";
import { SensoresController } from "./sensores.controller";
import { SensoresService } from "./sensores.service";
import { Sensor, SensorSchema } from "./schema/sensores.schema";

@Module({
  imports: [
    MongooseModule.forFeature([{ name: Sensor.name, schema: SensorSchema }]),
  ],
  controllers: [SensoresController],
  providers: [SensoresService],
})
export class SensoresModule {}