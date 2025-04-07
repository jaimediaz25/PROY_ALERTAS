import { IsOptional, IsString, IsEmail, IsNumber, IsDateString } from 'class-validator';

export class UpdateUserDto {
  @IsOptional()
  @IsString()
  imagen?: string;

  @IsOptional()
  @IsString()
  nombre?: string;

  @IsOptional()
  @IsString()
  apellidos?: string;

  @IsOptional()
  @IsNumber()
  edad?: number;

  @IsOptional()
  @IsEmail()
  email?: string;

  @IsOptional()
  @IsString()
  password?: string;

  @IsOptional()
  @IsString()
  rol?: string;

  @IsOptional()
  @IsNumber()
  intentos_fallidos?: number;

  @IsOptional()
  @IsDateString()
  bloqueado_hasta?: Date;
}