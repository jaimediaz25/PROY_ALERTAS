import { Controller, Get,Post,Body,Param,Put,Delete,} from "@nestjs/common";
  import { AlertasService } from "./alertas.service";
  import { CreateAlertaDto } from "./dto/create.alerta.dto"; 
  import { UpdateAlertaDto } from "./dto/update.alerta.dto";
  
  @Controller("alerts")
  export class AlertasController {
    constructor(private readonly alertasService: AlertasService) {}
  
    @Post()
    async create(@Body() createAlertaDto: CreateAlertaDto) {
      return this.alertasService.create(createAlertaDto);
    }
  
    @Get()
    async findAll() {
      return this.alertasService.findAll();
    }
  
    @Get(":id")
    async findOne(@Param("id") id: string) {
      return this.alertasService.findOne(id);
    }
  
    @Put(":id")
    async update(
      @Param("id") id: string,
      @Body() updateAlertaDto: UpdateAlertaDto,
    ) {
      return this.alertasService.update(id, updateAlertaDto);
    }
  
    @Delete(":id")
    async delete(@Param("id") id: string) {
      return this.alertasService.delete(id);
    }
  }