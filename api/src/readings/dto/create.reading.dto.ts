import { IsNotEmpty, IsString, IsNumber } from 'class-validator';

export class CreateReadingDto {
  @IsNotEmpty()
  @IsString()
  sensor_id: string;

  @IsNotEmpty()
  @IsNumber()
  valor: number;
  
}