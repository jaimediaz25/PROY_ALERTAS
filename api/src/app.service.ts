import { Injectable } from '@nestjs/common';

//Pagina principlal de localhost:3000
 
@Injectable()
export class AppService {
  getHello(): string {
    return 'Hola PsycoWax';
  }
}
