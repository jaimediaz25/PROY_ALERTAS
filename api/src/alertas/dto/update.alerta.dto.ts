import { IsOptional, IsString, IsBoolean } from "class-validator";

export class UpdateAlertaDto {
  @IsOptional()
  @IsString()
  sensor_id?: string;

  @IsOptional()
  @IsString()
  user_id?: string;

  @IsOptional()
  @IsString()
  tipo_alerta?: string;

  @IsOptional()
  @IsString()
  mensaje?: string;

  @IsOptional()
  @IsBoolean()
  atendida?: boolean;

  @IsOptional()
  @IsString()
  generado_en?: string;
}