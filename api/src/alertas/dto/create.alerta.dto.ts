import { IsNotEmpty, IsString, IsBoolean } from "class-validator";

export class CreateAlertaDto {
  @IsNotEmpty()
  @IsString()
  sensor_id: string;

  @IsNotEmpty()
  @IsString()
  user_id: string;

  @IsNotEmpty()
  @IsString()
  tipo_alerta: string;

  @IsNotEmpty()
  @IsString()
  mensaje: string;

  @IsNotEmpty()
  @IsBoolean()
  atendida: boolean;

  @IsNotEmpty()
  @IsString()
  generado_en: string;
}