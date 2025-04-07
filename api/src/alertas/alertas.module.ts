import { Module } from "@nestjs/common";
import { MongooseModule } from "@nestjs/mongoose";
import { AlertasController } from "./alertas.controller";
import { AlertasService } from "./alertas.service";
import { Alerta, AlertaSchema } from "./schema/alertas.schema";

@Module({
  imports: [
    MongooseModule.forFeature([{ name: Alerta.name, schema: AlertaSchema }]),
  ],
  controllers: [AlertasController],
  providers: [AlertasService],
})
export class AlertasModule {}