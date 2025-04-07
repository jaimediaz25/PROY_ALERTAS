import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { json, urlencoded } from 'body-parser';
import { ValidationPipe } from '@nestjs/common';
import { SwaggerModule, DocumentBuilder } from '@nestjs/swagger';

async function PsycoWax() {
  const app = await NestFactory.create(AppModule);
  
  // Configuración Swagger
  const config = new DocumentBuilder()
    .setTitle('PsycoWax Monitoring API')
    .setDescription('API para monitoreo de sensores IoT de PsycoWax')
    .setVersion('1.0')
    .addBearerAuth() // Si usas autenticación JWT
    .build();
  
  const document = SwaggerModule.createDocument(app, config);
  SwaggerModule.setup('PsycoWax/v1/api-docs', app, document);

  // Configuración existente
  app.enableCors();
  app.use(json({ limit: '100mb' }));
  app.use(urlencoded({ limit: '100mb', extended: true }));
  app.setGlobalPrefix("PsycoWax/v1");
  app.useGlobalPipes(
    new ValidationPipe({
      whitelist: true,
      forbidNonWhitelisted: true,
    })
  );

  await app.listen(3000);
  console.log(`Application is running on: ${await app.getUrl()}/PsycoWax/v1`);
}

PsycoWax();