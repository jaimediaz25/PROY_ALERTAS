import { IsNotEmpty, IsString, IsBoolean } from "class-validator";

export class CreateSensorDto {
  @IsNotEmpty()
  @IsString()
  user_id?: string | number;

  @IsNotEmpty()
  @IsString()
  ubicacion: string;

  @IsNotEmpty()
  @IsString()
  tipo: string;

  @IsNotEmpty()
  @IsBoolean()
  activo: boolean;
}