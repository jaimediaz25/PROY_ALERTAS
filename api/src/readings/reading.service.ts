import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { CreateReadingDto } from './dto/create.reading.dto';
import { UpdateReadingDto } from './dto/update.reading.dto';
import { Reading } from './schema/reading.schema';

@Injectable()
export class ReadingsService {
  constructor(
    @InjectModel(Reading.name) private readingModel: Model<Reading>,
  ) {}

  async create(createReadingDto: CreateReadingDto): Promise<Reading> {
    const existingReading = await this.readingModel.findOne({
      sensor_id: createReadingDto.sensor_id
    }).exec();

    if (existingReading) {
      return await this.readingModel.findByIdAndUpdate(
        existingReading._id,
        {
          valor: createReadingDto.valor,
          updatedAt: new Date()
        },
        { new: true }
      ).exec();
    }
    
    const createdReading = new this.readingModel({
      ...createReadingDto,
      createdAt: new Date(),
      updatedAt: new Date()
    });
    return await createdReading.save();
  }

  async findAll(): Promise<Reading[]> {
    return await this.readingModel.find().sort({ updatedAt: -1 }).exec();
  }

  async findOne(id: string): Promise<Reading> {
    return await this.readingModel.findById(id).exec();
  }

  async findLatestBySensor(sensorId: string): Promise<Reading> {
    return await this.readingModel.findOne({ sensor_id: sensorId })
      .sort({ updatedAt: -1 })
      .exec();
  }

  async findHistoryBySensor(sensorId: string, limit = 50): Promise<Reading[]> {
    return await this.readingModel.find({ sensor_id: sensorId })
      .sort({ updatedAt: -1 })
      .limit(limit)
      .exec();
  }

  async update(id: string, updateReadingDto: UpdateReadingDto): Promise<Reading> {
    const updateData = {
      ...updateReadingDto,
      updatedAt: new Date()
    };
    
    // Evitar modificar el sensor_id
    if (updateData.sensor_id) {
      delete updateData.sensor_id;
    }

    return await this.readingModel
      .findByIdAndUpdate(id, updateData, { new: true })
      .exec();
  }

  async delete(id: string): Promise<Reading> {
    return await this.readingModel.findByIdAndDelete(id).exec();
  }

  async deleteAll(): Promise<{ deletedCount: number }> {
    const result = await this.readingModel.deleteMany({}).exec();
    return { deletedCount: result.deletedCount || 0 };
  }
}