import { IsNotEmpty, IsString, IsEmail, IsNumber, IsDateString, IsOptional} from 'class-validator';

export class CreateUserDto {
  @IsNotEmpty()
  @IsString()
  imagen: string;

  @IsNotEmpty()
  @IsString()
  nombre: string;

  @IsNotEmpty()
  @IsString()
  apellidos: string;

  @IsNotEmpty()
  @IsNumber()
  edad: number;

  @IsNotEmpty()
  @IsEmail()
  email: string;

  @IsNotEmpty()
  @IsString()
  password: string;

  @IsNotEmpty()
  @IsString()
  rol: string;

  @IsNumber()
  @IsOptional()
  intentos_fallidos: number;

  @IsDateString()
  @IsOptional()
  bloqueado_hasta: Date;
}