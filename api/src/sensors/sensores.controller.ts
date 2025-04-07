import { Controller, Get, Post, Body, Param, Put, Delete } from "@nestjs/common";
import { SensoresService } from "./sensores.service";
import { CreateSensorDto } from "./dto/create.sensores.dto";
import { UpdateSensorDto } from "./dto/update.sensores.dto";

@Controller("sensors")
export class SensoresController {
  constructor(private readonly sensoresService: SensoresService) {}

  @Post()
  async create(@Body() createSensorDto: CreateSensorDto) {
    return this.sensoresService.create(createSensorDto);
  }

  @Get()
  async findAll() {
    return this.sensoresService.findAll();
  }

  @Get(":id")
  async findOne(@Param("id") id: string) {
    return this.sensoresService.findOne(id);
  }

  @Put(":id")
  async update(
    @Param("id") id: string,
    @Body() updateSensorDto: UpdateSensorDto,
  ) {
    return this.sensoresService.update(id, updateSensorDto);
  }

  @Delete(":id")
  async delete(@Param("id") id: string) {
    return this.sensoresService.delete(id);
  }
}