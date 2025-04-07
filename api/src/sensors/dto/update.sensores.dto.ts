import { IsOptional, IsString, IsBoolean } from "class-validator";

export class UpdateSensorDto {
  @IsOptional()
  @IsString()
  user_id?: string | number;

  @IsOptional()
  @IsString()
  ubicacion?: string;

  @IsOptional()
  @IsString()
  tipo?: string;

  @IsOptional()
  @IsBoolean()
  activo?: boolean;
}