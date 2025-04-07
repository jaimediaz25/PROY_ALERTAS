import { Injectable } from "@nestjs/common";
import { InjectModel } from "@nestjs/mongoose";
import { Model } from "mongoose";
import { CreateAlertaDto } from "./dto/create.alerta.dto"; 
import { UpdateAlertaDto } from "./dto/update.alerta.dto";
import { Alerta } from "./schema/alertas.schema";

@Injectable()
export class AlertasService {
  constructor(
    @InjectModel(Alerta.name) private alertaModel: Model<Alerta>,
  ) {}

  async create(createAlertaDto: CreateAlertaDto): Promise<Alerta> {
    const createdAlerta = new this.alertaModel(createAlertaDto);
    return await createdAlerta.save();
  }

  async findAll(): Promise<Alerta[]> {
    return await this.alertaModel.find().exec();
  }

  async findOne(id: string): Promise<Alerta> {
    return await this.alertaModel.findById(id).exec();
  }

  async update(id: string, updateAlertaDto: UpdateAlertaDto): Promise<Alerta> {
    return await this.alertaModel
      .findByIdAndUpdate(id, updateAlertaDto, { new: true })
      .exec();
  }

  async delete(id: string): Promise<Alerta> {
    return await this.alertaModel.findByIdAndDelete(id).exec();
  }
}