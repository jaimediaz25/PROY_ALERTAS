import { IsOptional, IsString, IsNumber } from 'class-validator';

export class UpdateReadingDto {
  @IsOptional()
  @IsString()
  sensor_id?: string;

  @IsOptional()
  @IsNumber()
  valor?: number;

}