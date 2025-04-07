import { Controller, Get, Post, Body, Param, Put, Delete, Query } from '@nestjs/common';
import { ReadingsService } from './reading.service';
import { CreateReadingDto } from './dto/create.reading.dto';
import { UpdateReadingDto } from './dto/update.reading.dto';
import { ApiTags, ApiOperation, ApiResponse, ApiParam, ApiQuery } from '@nestjs/swagger';

@ApiTags('Lecturas de Sensores')
@Controller('readings')
export class ReadingsController {
  constructor(private readonly readingsService: ReadingsService) {}

  @Post()
  @ApiOperation({ summary: 'Crear nueva lectura' })
  @ApiResponse({ status: 201, description: 'Lectura creada exitosamente' })
  @ApiResponse({ status: 400, description: 'Datos inválidos' })
  async create(@Body() createReadingDto: CreateReadingDto) {
    return this.readingsService.create(createReadingDto);
  }

  @Get()
  @ApiOperation({ summary: 'Obtener todas las lecturas' })
  @ApiResponse({ status: 200, description: 'Lista de lecturas' })
  async findAll() {
    return this.readingsService.findAll();
  }

  @Get('sensor/:sensorId')
  @ApiOperation({ summary: 'Obtener última lectura de un sensor' })
  @ApiParam({ name: 'sensorId', description: 'ID del sensor' })
  @ApiResponse({ status: 200, description: 'Última lectura del sensor' })
  @ApiResponse({ status: 404, description: 'Sensor no encontrado' })
  async findBySensor(@Param('sensorId') sensorId: string) {
    return this.readingsService.findLatestBySensor(sensorId);
  }

  @Get('sensor/:sensorId/history')
  @ApiOperation({ summary: 'Obtener historial de lecturas de un sensor' })
  @ApiParam({ name: 'sensorId', description: 'ID del sensor' })
  @ApiQuery({ name: 'limit', required: false, type: Number })
  @ApiResponse({ status: 200, description: 'Historial de lecturas' })
  async findHistoryBySensor(
    @Param('sensorId') sensorId: string,
    @Query('limit') limit: number = 50
  ) {
    return this.readingsService.findHistoryBySensor(sensorId, limit);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Obtener lectura por ID' })
  @ApiParam({ name: 'id', description: 'ID de la lectura' })
  @ApiResponse({ status: 200, description: 'Lectura encontrada' })
  @ApiResponse({ status: 404, description: 'Lectura no encontrada' })
  async findOne(@Param('id') id: string) {
    return this.readingsService.findOne(id);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Actualizar lectura' })
  @ApiParam({ name: 'id', description: 'ID de la lectura' })
  @ApiResponse({ status: 200, description: 'Lectura actualizada' })
  @ApiResponse({ status: 404, description: 'Lectura no encontrada' })
  async update(
    @Param('id') id: string,
    @Body() updateReadingDto: UpdateReadingDto
  ) {
    return this.readingsService.update(id, updateReadingDto);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Eliminar lectura' })
  @ApiParam({ name: 'id', description: 'ID de la lectura' })
  @ApiResponse({ status: 200, description: 'Lectura eliminada' })
  @ApiResponse({ status: 404, description: 'Lectura no encontrada' })
  async delete(@Param('id') id: string) {
    return this.readingsService.delete(id);
  }

  @Delete()
  @ApiOperation({ summary: 'Eliminar todas las lecturas (solo desarrollo)' })
  @ApiResponse({ status: 200, description: 'Todas las lecturas eliminadas' })
  async deleteAll() {
    return this.readingsService.deleteAll();
  }
  
}