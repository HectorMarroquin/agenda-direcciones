import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class MessageHandlingService {
  MessageHandlingService(errors: any, errors1: { nombre: string; telefonos: string[]; emails: string[]; direcciones: string[]; }) {
    throw new Error('Method not implemented.');
  }

  constructor() { }

  handleErrors(errors: any, componentErrors: any): void {
    for (const field in errors) {
      if (errors.hasOwnProperty(field)) {
        const arrayFields = errors[field][0].split('.');
        const messageError = `${arrayFields[0]} ${parseInt(arrayFields[1], 10) + 1}: ${arrayFields[2]}`;

        if (field === 'nombre') {
          componentErrors.nombre = errors[field][0];
        } else if (field.startsWith('telefonos')) {
          const index = parseInt(field.split('.')[1], 10);
          componentErrors.telefonos[index] = messageError;
        } else if (field.startsWith('emails')) {
          const index = parseInt(field.split('.')[1], 10);
          componentErrors.emails[index] = messageError;
        } else if (field.startsWith('direcciones')) {
          const index = parseInt(field.split('.')[1], 10);
          componentErrors.direcciones[index] = messageError;
        }
      }
    }
  }
}
