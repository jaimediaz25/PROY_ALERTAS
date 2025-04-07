import { Controller, Get } from '@nestjs/common';
import { Post, Put, Delete, Query, Param, Body, Res, HttpStatus } from '@nestjs/common';
import { AppService } from './app.service';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import * as bcrypt from 'bcrypt';
import { Response } from 'express';
import { omit } from 'lodash';
import { Alerta } from './alertas/schema/alertas.schema'; 
import { User } from './users/schema/users.schema'; 
import { Sensor } from './sensors/schema/sensores.schema';
import { Reading } from './readings/schema/reading.schema';
import * as mongoose from 'mongoose';
import { isValidObjectId } from 'mongoose';


@Controller()
export class AppController {
  constructor(
    @InjectModel(User.name) private userModel: Model<User>,
    @InjectModel(Sensor.name) private sensorModel: Model<Sensor>,
    @InjectModel(Reading.name) private readingModel: Model<Reading>,
    @InjectModel(Alerta.name) private alertModel: Model<Alerta>,
    private readonly appService: AppService
  ) {}


  //muestra la ruta web dentro de get(/hello)
  @Get()
  getHello(): string {
    return this.appService.getHello();
  }

  @Get('sensorsxuserxx')
  async getSensorsByUser(
    @Query() query: { user_id: string; tipo?: string },
    @Res() res: Response
  ) {
    try {
      const { user_id, tipo } = query;
      if (!user_id) {
        return res.status(400).json({ error: 'Se requiere el user_id' });
      }
      const filter = {
        user_id,
        ...(tipo && { tipo: new RegExp(tipo, 'i') })
      };
      const sensors = await this.sensorModel.find(filter)
        .select('_id ubicacion tipo activo created_at')
        .sort({ created_at: -1 })
        .exec();
      if (sensors.length === 0) {
        return res.status(404).json({ message: 'No se encontraron sensores' });
      }
      res.json(sensors);
    } catch (err) {
      console.error('Error en /sensorsxuser:', err);
      res.status(500).json({
        error: 'Error al obtener sensores',
        detalle: err.message
      });
    }
  }

  // Obtener lecturas de un sensor
  @Get('readingsxuserxx')
  async getReadingsByUser(
    @Query() query: { sensor_id: string; limit?: string },
    @Res() res: Response,
  ) {
    try {
      const { sensor_id, limit = '50' } = query;
      const readings = await this.readingModel
        .find({ sensor_id })
        .sort({ created_at: -1 })
        .limit(parseInt(limit))
        .select('valor created_at')
        .lean();
      return res.json(readings);
    } catch (err) {
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR)
        .json({ error: 'Error obteniendo lecturas' });
    }
  }

  // Actualizar contraseña de usuario
  @Put('usersxx/update-password')
  async updatePassword(
    @Body() body: { email: string; password: string },
    @Res() res: Response,
  ) {
    try {
      const { email, password } = body;
      const user = await this.userModel.findOne({ email });
      if (!user) {
        return res.status(HttpStatus.NOT_FOUND)
          .json({ error: 'Usuario no encontrado' });
      }
      const hashedPassword = await bcrypt.hash(password, 10);
      user.password = hashedPassword;
      await user.save();
      return res.json({ message: 'Contraseña actualizada exitosamente' });
    } catch (err) {
      console.error('Error actualizando contraseña:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR)
        .json({ error: 'Error al actualizar contraseña' });
    }
  }

  // Checar email
  @Get('usersxx/check-email')
  async checkEmail(
    @Query('email') email: string,
    @Res() res: Response,
  ) {
    try {
      const cleanEmail = email?.toLowerCase().trim();
      if (!cleanEmail) {
        return res
          .status(HttpStatus.BAD_REQUEST)
          .json({ error: 'Email requerido' });
      }
      const existingUser = await this.userModel.findOne({ email: cleanEmail });
      return res.json({ exists: !!existingUser });
    } catch (err) {
      console.error('Error en check-email:', err);
      return res
        .status(HttpStatus.INTERNAL_SERVER_ERROR)
        .json({ error: 'Error al verificar email' });
    }
  }

  // Obtener todos los usuarios
  @Get('usersxx')
  async getUsers(
    @Query() query: { search?: string; page?: string; perPage?: string },
    @Res() res: Response,
  ) {
    try {
      const { search, page = '1', perPage = '10' } = query;
      const queryObj: any = {};

      if (search) {
        queryObj.$or = [
          { nombre: { $regex: search, $options: 'i' } },
          { apellidos: { $regex: search, $options: 'i' } },
          { email: { $regex: search, $options: 'i' } },
        ];
      }

      const pageNum = parseInt(page, 10);
      const perPageNum = parseInt(perPage, 10);

      const total = await this.userModel.countDocuments(queryObj);
      const users = await this.userModel
        .find(queryObj, 'nombre apellidos edad email rol')
        .skip((pageNum - 1) * perPageNum)
        .limit(perPageNum);

      return res.json({
        data: users,
        total,
        currentPage: pageNum,
        perPage: perPageNum,
        totalPages: Math.ceil(total / perPageNum),
      });
    } catch (err) {
      console.error('Error al obtener usuarios:', err);
      return res
        .status(HttpStatus.INTERNAL_SERVER_ERROR)
        .json({ error: 'Error al obtener usuarios' });
    }
  }

  // Obtener un usuario por ID
  @Get('usersxx/:id')
  async getUserById(@Param('id') id: string, @Res() res: Response) {
    try {
      const user = await this.userModel.findById(id, 'nombre apellidos edad email rol imagen');
      if (!user) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Usuario no encontrado' });
      }
      return res.json(user);
    } catch (err) {
      console.error('Error al obtener usuario:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener el usuario' });
    }
  }

  // Crear un nuevo usuario
  @Post('usersxx')
  async createUser(@Body() body: any, @Res() res: Response) {
    try {
      const { nombre, apellidos, edad, email, password, rol } = body;
      
      if (!email || !password) {
        return res.status(HttpStatus.BAD_REQUEST).json({ error: 'Email y contraseña son requeridos' });
      }
      
      if (password.length < 8) {
        return res.status(HttpStatus.BAD_REQUEST).json({
          error: 'La contraseña debe tener al menos 8 caracteres'
        });
      }
      
      const existingUser = await this.userModel.findOne({ email });
      if (existingUser) {
        return res.status(HttpStatus.CONFLICT).json({ error: 'El email ya está registrado' });
      }
      
      const hashedPassword = await bcrypt.hash(password, 10);
      const newUser = await this.userModel.create({
        nombre,
        apellidos,
        edad,
        email,
        rol,
        password: hashedPassword,
      });

      return res.status(HttpStatus.CREATED).json({
        message: 'Usuario creado correctamente',
        user: omit(newUser.toObject(), 'password'),
      });
    } catch (err) {
      console.error('Error detallado:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({
        error: 'Error al registrar usuario',
        details: err.message,
      });
    }
  }

  // Actualizar un usuario
  @Put('usersxx/:id')
  async updateUser(
    @Param('id') id: string,
    @Body() body: { nombre?: string; apellidos?: string; edad?: number; email?: string; rol?: string; imagen?: string },
    @Res() res: Response,
  ) {
    try {
      const { nombre, apellidos, edad, email, rol, imagen } = body;
      const updatedUser = await this.userModel.findByIdAndUpdate(
        id,
        { nombre, apellidos, edad, email, rol, imagen },
        { new: true, runValidators: true },
      );
      if (!updatedUser) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Usuario no encontrado' });
      }
      return res.json({
        message: 'Usuario actualizado correctamente',
        user: updatedUser,
      });
    } catch (err) {
      console.error('Error detallado:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({
        error: 'Error al actualizar usuario',
        details: err.message,
      });
    }
  }

  // Eliminar un usuario
  @Delete('usersxx/:id')
  async deleteUser(
    @Param('id') id: string,
    @Res() res: Response,
  ) {
    try {
      const deletedUser = await this.userModel.findByIdAndDelete(id);
      if (!deletedUser) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Usuario no encontrado' });
      }
      return res.json({ message: 'Usuario eliminado correctamente' });
    } catch (err) {
      console.error('Error al eliminar usuario:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al eliminar usuario' });
    }
  }

  // Mostrar gráfica de estadísticas mensuales de usuarios
  @Get('usersxx/stats/monthly')
  async getUsersStats(@Res() res: Response) {
    try {
      const stats = await this.userModel.aggregate([
        {
          $group: {
            _id: {
              year: { $year: "$created_at" },
              month: { $month: "$created_at" }
            },
            total: { $sum: 1 },
            updated: {
              $sum: {
                $cond: [{ $ne: ["$created_at", "$updated_at"] }, 1, 0]
              }
            }
          }
        },
        {
          $project: {
            _id: 0,
            year: "$_id.year",
            month: "$_id.month",
            total: 1,
            updated: 1
          }
        },
        { $sort: { year: 1, month: 1 } }
      ]);
      return res.json(stats);
    } catch (err) {
      console.error('Error al obtener estadísticas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener datos para la gráfica' });
    }
  }

  // Checar sensor
  @Get('sensorsxx/check')
  async checkSensor(
    @Query() query: { ubicacion: string; tipo: string },
    @Res() res: Response,
  ) {
    try {
      const { ubicacion, tipo } = query;
      if (!ubicacion || !tipo) {
        return res.status(HttpStatus.BAD_REQUEST).json({ error: 'Se requieren ubicacion y tipo' });
      }
      const existingSensor = await this.sensorModel.findOne({
        ubicacion: ubicacion.trim(),
        tipo: tipo.trim()
      });
      return res.json({ exists: !!existingSensor });
    } catch (err) {
      console.error('Error verificando sensor:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al verificar sensor' });
    }
  }

  // Obtener todos los sensores
  @Get('sensorsxx')
  async getAllSensors(@Res() res: Response) {
    try {
      const sensores = await this.sensorModel.find();
      return res.json(sensores);
    } catch (err) {
      console.error('Error al obtener sensores:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener sensores' });
    }
  }

  // Obtener un sensor por ID
  @Get('sensorsxx/:id')
  async getSensorById(@Param('id') id: string, @Res() res: Response) {
    try {
      const sensor = await this.sensorModel.findById(id);
      if (!sensor) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Sensor no encontrado' });
      }
      return res.json(sensor);
    } catch (err) {
      console.error('Error al obtener sensor:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener el sensor' });
    }
  }

  // Crear un nuevo sensor
  @Post('sensorsxx')
  async createSensor(
    @Body() body: { ubicacion: string; tipo: string; activo?: boolean; user_id },
    @Res() res: Response,
  ) {
    try {
      const { ubicacion, tipo, activo, user_id } = body;
      const nuevoSensor = await this.sensorModel.create({
        user_id, // Campo obligatorio
        ubicacion,
        tipo,
        activo: activo !== undefined ? activo : true,
      });
      return res.status(HttpStatus.CREATED).json({
        message: 'Sensor creado correctamente',
        id: nuevoSensor._id,
      });
    } catch (err) {
      console.error('Error al crear sensor:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al crear sensor' });
    }
  }

  // Actualizar un sensor
  @Put('sensorsxx/:id')
  async updateSensor(
    @Param('id') id: string,
    @Body() body: { ubicacion?: string; tipo?: string; activo?: boolean; user_id?: string },
    @Res() res: Response,
  ) {
    try {
      const { ubicacion, tipo, activo, user_id } = body;
      const sensorActualizado = await this.sensorModel.findByIdAndUpdate(
        id,
        { ubicacion, tipo, activo, user_id },
        { new: true },
      );
      if (!sensorActualizado) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Sensor no encontrado' });
      }
      return res.json({ message: 'Sensor actualizado correctamente' });
    } catch (err) {
      console.error('Error al actualizar sensor:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al actualizar sensor' });
    }
  }

  // Eliminar un sensor
  @Delete('sensorsxx/:id')
  async deleteSensor(
    @Param('id') id: string,
    @Res() res: Response,
  ) {
    try {
      const sensorEliminado = await this.sensorModel.findByIdAndDelete(id);
      if (!sensorEliminado) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Sensor no encontrado' });
      }
      return res.json({ message: 'Sensor eliminado correctamente' });
    } catch (err) {
      console.error('Error al eliminar sensor:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al eliminar sensor' });
    }
  }

  // Mostrar gráfica de estadísticas mensuales de sensores
  @Get('sensorsxx/stats/monthly')
  async getSensorsStats(@Res() res: Response) {
    try {
      const stats = await this.sensorModel.aggregate([
        {
          $group: {
            _id: {
              year: { $year: "$created_at" },
              month: { $month: "$created_at" },
            },
            total: { $sum: 1 },
            activos: { $sum: { $cond: [{ $eq: ["$activo", true] }, 1, 0] } },
            actualizados: { 
              $sum: { 
                $cond: [{ $ne: ["$created_at", "$updated_at"] }, 1, 0],
              },
            },
          },
        },
        {
          $project: {
            _id: 0,
            year: "$_id.year",
            month: "$_id.month",
            total: 1,
            activos: 1,
            actualizados: 1,
          },
        },
        { $sort: { year: 1, month: 1 } },
      ]);
      return res.json(stats);
    } catch (err) {
      console.error('Error al obtener estadísticas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener datos para la gráfica' });
    }
  }

  // Obtener todos los readings
  @Get('readingsxx')
  async getAllReadings(@Res() res: Response) {
    try {
      const readings = await this.readingModel.find();
      return res.json(readings);
    } catch (err) {
      console.error('Error al obtener readings:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener readings' });
    }
  }

  // Obtener un reading por ID
  @Get('readingsxx/:id')
  async getReadingById(@Param('id') id: string, @Res() res: Response) {
    try {
      const reading = await this.readingModel.findById(id);
      if (!reading) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Reading no encontrado' });
      }
      return res.json(reading);
    } catch (err) {
      console.error('Error al obtener reading:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener el reading' });
    }
  }

  // Crear un nuevo reading con generación de alertas
  @Post('readingsxx')
  async createReading(
    @Body() body: { sensor_id: string; valor: number },
    @Res() res: Response,
  ) {
    // Configuración de umbrales para cada tipo de sensor
    const UMBRALES = {
      Humo: {
        ALTA: 2500,
        MEDIA: 1500,
        BAJA: 300,
      },
      Temperatura: {
        ALTA: 45,
        MEDIA: 35,
        BAJA: 25,
      },
    };

    try {
      const { sensor_id, valor } = body;
      
      if (!sensor_id || valor === undefined) {
        return res.status(HttpStatus.BAD_REQUEST).json({ error: 'Datos incompletos' });
      }
      
      const sensor = await this.sensorModel.findById(sensor_id);
      if (!sensor) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Sensor no encontrado' });
      }
      if (!sensor.activo) {
        return res.status(HttpStatus.OK).json({ message: 'Sensor inactivo' });
      }
      
      const nuevoReading = await this.readingModel.create({ sensor_id, valor });
      
      // Generar alerta si corresponde
      const umbrales = UMBRALES[sensor.tipo];
      if (umbrales) {
        let tipo_alerta: string = null;
        let mensaje = '';
        
        if (valor >= umbrales.ALTA) {
          tipo_alerta = 'ALTA';
          mensaje = `${sensor.tipo} crítico: ${valor} (Supera ${umbrales.ALTA})`;
        } else if (valor >= umbrales.MEDIA) {
          tipo_alerta = 'MEDIA';
          mensaje = `${sensor.tipo} elevado: ${valor} (Supera ${umbrales.MEDIA})`;
        } else if (valor >= umbrales.BAJA) {
          tipo_alerta = 'BAJA';
          mensaje = `${sensor.tipo} anormal: ${valor} (Supera ${umbrales.BAJA})`;
        }
        
        if (tipo_alerta) {
          await this.alertModel.create({
            sensor_id,
            user_id: sensor.user_id, // Asume que el sensor tiene relación con usuario
            tipo_alerta,
            mensaje,
            atendida: false,
            generado_en: new Date(),
          });
        }
      }
      
      return res.status(HttpStatus.CREATED).json({
        message: 'Reading creado correctamente',
        id: nuevoReading._id,
      });
    } catch (err) {
      console.error('Error al crear reading:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al crear reading' });
    }
  }

  // Actualizar un reading
  @Put('readingsxx/:id')
  async updateReading(
    @Param('id') id: string,
    @Body() body: { sensor_id: string; valor: number },
    @Res() res: Response,
  ) {
    try {
      const { sensor_id, valor } = body;
      const updatedReading = await this.readingModel.findByIdAndUpdate(
        id,
        { sensor_id, valor },
        { new: true },
      );
      if (!updatedReading) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Reading no encontrado' });
      }
      return res.json({ message: 'Reading actualizado correctamente' });
    } catch (err) {
      console.error('Error al actualizar reading:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al actualizar reading' });
    }
  }

  // Eliminar un reading
  @Delete('readingsxx/:id')
  async deleteReading(
    @Param('id') id: string,
    @Res() res: Response,
  ) {
    try {
      const deletedReading = await this.readingModel.findByIdAndDelete(id);
      if (!deletedReading) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Reading no encontrado' });
      }
      return res.json({ message: 'Reading eliminado correctamente' });
    } catch (err) {
      console.error('Error al eliminar reading:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al eliminar reading' });
    }
  }

  // Mostrar la gráfica de estadísticas mensuales de readings
  @Get('readingsxx/stats/monthly')
  async getReadingsStats(@Res() res: Response) {
    try {
      const stats = await this.readingModel.aggregate([
        {
          $group: {
            _id: {
              year: { $year: "$created_at" },
              month: { $month: "$created_at" },
            },
            total: { $sum: 1 },
            promedio: { $avg: "$valor" },
            maximo: { $max: "$valor" },
            minimo: { $min: "$valor" },
          },
        },
        {
          $project: {
            _id: 0,
            year: "$_id.year",
            month: "$_id.month",
            total: 1,
            promedio: { $round: ["$promedio", 2] },
            maximo: 1,
            minimo: 1,
          },
        },
        { $sort: { year: 1, month: 1 } },
      ]);
      return res.json(stats);
    } catch (err) {
      console.error('Error al obtener estadísticas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener datos para la gráfica' });
    }
  }

  // Obtener el último valor registrado para cada sensor del usuario
  @Get('latestReadingsxx')
  async getLatestReadings(@Query('user_id') userId: string, @Res() res: Response) {
    try {
      if (!userId) {
        return res.status(HttpStatus.BAD_REQUEST).json({ error: 'Se requiere el user_id' });
      }

      const sensors = await this.sensorModel.find({ user_id: userId });
      if (!sensors.length) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'No se encontraron sensores para este usuario' });
      }

      const latestReadings = await Promise.all(
        sensors.map(async (sensor) => {
          const reading = await this.readingModel.findOne({ sensor_id: sensor._id })
            .sort({ created_at: -1 })
            .lean();

          if (reading) {
            return {
              sensor_id: sensor._id,
              tipo: sensor.tipo,
              ubicacion: sensor.ubicacion,
              reading: reading,
            };
          }
        }),
      );

      // Filtramos los sensores que no tienen lectura
      return res.json(latestReadings.filter((item) => item !== undefined));
    } catch (err) {
      console.error('Error al obtener las últimas lecturas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener lecturas' });
    }
  }

  // Obtener todas las alertas
  @Get('alertsxx')
  async getAllAlerts(@Res() res: Response) {
    try {
      const alertas = await this.alertModel.find();
      return res.json(alertas);
    } catch (err) {
      console.error('Error al obtener alertas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener alertas' });
    }
  }

  // Obtener alertas no atendidas del usuario actual
  @Get('alertsxx/unacknowledged')
  async getUnacknowledgedAlerts(@Query('user_id') userId: string, @Res() res: Response) {
    try {
      if (!userId) {
        return res.status(HttpStatus.BAD_REQUEST).json({ error: 'user_id es requerido' });
      }

      const alerts = await this.alertModel.find({
        user_id: new mongoose.Types.ObjectId(userId), // Conversión necesaria
        tipo_alerta: 'ALTA',
        atendida: false,
      }).lean(); // Retorna objetos JSON simples

      return res.json(alerts);
    } catch (err) {
      console.error('Error obteniendo alertas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error obteniendo alertas' });
    }
  }

  // Actualizar estado de alerta
  @Put('alertsxx/:id/attend')
  async updateAlertStatus(
    @Param('id') id: string,
    @Body('atendida') atendida: boolean,
    @Res() res: Response,
  ) {
    try {
      const alert = await this.alertModel.findByIdAndUpdate(
        id,
        { atendida },
        { new: true },
      );

      if (!alert) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Alerta no encontrada' });
      }

      return res.json({ message: 'Alerta actualizada', alert });
    } catch (err) {
      console.error('Error actualizando alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error actualizando alerta' });
    }
  }

  // Obtener una alerta por ID
  @Get('alertsxx/:id')
  async getAlertById(@Param('id') id: string, @Res() res: Response) {
    try {
      const alerta = await this.alertModel.findById(id);
      if (!alerta) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Alerta no encontrada' });
      }
      return res.json(alerta);
    } catch (err) {
      console.error('Error al obtener alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener la alerta' });
    }
  }

  // Crear una nueva alerta
  @Post('alertsxx')
  async createAlert(@Body() body: any, @Res() res: Response) {
    try {
      const { sensor_id, user_id, tipo_alerta, mensaje, atendida, generado_en } = body;

      const nuevaAlerta = await this.alertModel.create({
        sensor_id,
        user_id,
        tipo_alerta,
        mensaje,
        atendida: atendida || false,
        generado_en: generado_en || new Date(),
      });

      return res.status(HttpStatus.CREATED).json({
        message: 'Alerta creada correctamente',
        id: nuevaAlerta._id,
      });
    } catch (err) {
      console.error('Error al crear alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al crear alerta' });
    }
  }

  // Actualizar una alerta
  @Put('alertsxx/:id')
  async updateAlert(@Param('id') id: string, @Body() body: any, @Res() res: Response) {
    try {
      const { sensor_id, user_id, tipo_alerta, mensaje, atendida, generado_en } = body;

      const alertaActualizada = await this.alertModel.findByIdAndUpdate(
        id,
        { sensor_id, user_id, tipo_alerta, mensaje, atendida, generado_en },
        { new: true },
      );

      if (!alertaActualizada) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Alerta no encontrada' });
      }

      return res.json({ message: 'Alerta actualizada correctamente' });
    } catch (err) {
      console.error('Error al actualizar alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al actualizar alerta' });
    }
  }

  // Eliminar una alerta
  @Delete('alertsxx/:id')
  async deleteAlert(@Param('id') id: string, @Res() res: Response) {
    try {
      const alertaEliminada = await this.alertModel.findByIdAndDelete(id);
      if (!alertaEliminada) {
        return res.status(HttpStatus.NOT_FOUND).json({ error: 'Alerta no encontrada' });
      }
      return res.json({ message: 'Alerta eliminada correctamente' });
    } catch (err) {
      console.error('Error al eliminar alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al eliminar alerta' });
    }
  }

  // Mostrar gráfica de alertas mensuales
  @Get('alertsxx/stats/monthly')
  async getAlertsStats(@Res() res: Response) {
    try {
      const stats = await this.alertModel.aggregate([
        {
          $group: {
            _id: {
              year: { $year: "$generado_en" },
              month: { $month: "$generado_en" }
            },
            total: { $sum: 1 },
            atendidas: { $sum: { $cond: [{ $eq: ["$atendida", true] }, 1, 0] } },
            tipos: { 
              $push: "$tipo_alerta" 
            }
          }
        },
        {
          $project: {
            _id: 0,
            year: "$_id.year",
            month: "$_id.month",
            total: 1,
            atendidas: 1,
            tipos: 1
          }
        },
        { $sort: { year: 1, month: 1 } }
      ]);

      const processedStats = stats.map(stat => ({
        ...stat,
        tipos: stat.tipos.reduce((acc, tipo) => {
          acc[tipo] = (acc[tipo] || 0) + 1;
          return acc;
        }, {})
      }));

      return res.json(processedStats);
      
    } catch (err) {
      console.error('Error al obtener estadísticas:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al obtener datos para la gráfica' });
    }
  }

  // Checar IDs válidos
  @Get('alertsxx/check')
  async checkAlert(
    @Query('sensor_id') sensor_id: string,
    @Query('user_id') user_id: string,
    @Query('generado_en') generado_en: string,
    @Res() res: Response
  ) {
    try {
      const existingAlert = await this.alertModel.findOne({
        sensor_id,
        user_id,
        generado_en: new Date(generado_en),
      });

      return res.json({ exists: !!existingAlert });
    } catch (err) {
      console.error('Error verificando alerta:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al verificar alerta' });
    }
  }

  // Login de usuario
  @Post('authxx/login')
  async login(@Body() body: { email: string; password: string }, @Res() res: Response) {
    try {
      const { email, password } = body;
      const user = await this.userModel
        .findOne({ email })
        .select('+password +intentos_fallidos +bloqueado_hasta');

      if (!user) {
        return res.status(HttpStatus.UNAUTHORIZED).json({ error: 'Credenciales incorrectas' });
      }

      if (user.bloqueado_hasta && user.bloqueado_hasta > new Date()) {
        return res.status(HttpStatus.FORBIDDEN).json({
          error: `Cuenta bloqueada. Intente nuevamente después de ${user.bloqueado_hasta.toLocaleTimeString()}`,
        });
      }

      const isMatch = await bcrypt.compare(password, user.password);
      if (!isMatch) {
        user.intentos_fallidos = (user.intentos_fallidos || 0) + 1;
        if (user.intentos_fallidos >= 3) {
          user.bloqueado_hasta = new Date(Date.now() + 5 * 60 * 1000); // Bloquear por 5 minutos
        }

        await user.save();

        return res.status(HttpStatus.UNAUTHORIZED).json({
          error:
            user.intentos_fallidos >= 3
              ? `Cuenta bloqueada por 5 minutos`
              : `Credenciales incorrectas (Intentos restantes: ${3 - user.intentos_fallidos})`,
        });
      }

      user.intentos_fallidos = 0;
      user.bloqueado_hasta = null;
      await user.save();

      return res.json({
        success: true,
        user: omit(user.toObject(), ['password', 'intentos_fallidos', 'bloqueado_hasta']),
      });
    } catch (err) {
      console.error('Error en login:', err);
      return res.status(HttpStatus.INTERNAL_SERVER_ERROR).json({ error: 'Error al iniciar sesión' });
    }
  }

}