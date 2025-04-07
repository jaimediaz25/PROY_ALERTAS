import { Injectable } from "@nestjs/common";
import { InjectModel } from "@nestjs/mongoose";
import { Model } from "mongoose";
import { CreateSensorDto } from "./dto/create.sensores.dto";
import { UpdateSensorDto } from "./dto/update.sensores.dto";
import { Sensor } from "./schema/sensores.schema"; 

@Injectable()
export class SensoresService {
  constructor(
    @InjectModel(Sensor.name) private sensorModel: Model<Sensor>,
  ) {}

  async create(createSensorDto: CreateSensorDto): Promise<Sensor> {
    const createdSensor = new this.sensorModel(createSensorDto);
    return await createdSensor.save();
  }

  async findAll(): Promise<Sensor[]> {
    return await this.sensorModel.find().exec();
  }

  async findOne(id: string): Promise<Sensor> {
    return await this.sensorModel.findById(id).exec();
  }

  async update(id: string, updateSensorDto: UpdateSensorDto): Promise<Sensor> {
    return await this.sensorModel
      .findByIdAndUpdate(id, updateSensorDto, { new: true })
      .exec();
  }

  async delete(id: string): Promise<Sensor> {
    return await this.sensorModel.findByIdAndDelete(id).exec();
  }
}