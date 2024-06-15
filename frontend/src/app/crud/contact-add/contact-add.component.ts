import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ContactService } from '../../services/contacto.service';
import { AuthService } from '../../services/auth.service';
import { MessageHandlingService } from '../../services/message-handling.service';

@Component({
  selector: 'app-contact-add',
  templateUrl: './contact-add.component.html',
  styleUrls: ['./contact-add.component.css']
})
export class ContactAddComponent {
  contact = {
    nombre: '',
    telefonos: [{ numero: '' }],
    emails: [{ correo: '' }],
    direcciones: [{ direccion: '' }],
    user_id: ''
  };

  errors = {
    nombre: '',
    telefonos: [] as string[],
    emails: [] as string[],
    direcciones: [] as string[]
  };

  constructor(
    private contactService: ContactService,
    private authService: AuthService,
    private router: Router,
    private errorHandlingService: MessageHandlingService
  ) {
    this.contact.user_id = this.authService.getUserId();
  }

  addTelefono(): void {
    this.contact.telefonos.push({ numero: '' });
    this.errors.telefonos.push(''); // No more error here
  }

  removeTelefono(index: number): void {
    this.contact.telefonos.splice(index, 1);
    this.errors.telefonos.splice(index, 1);
  }

  addEmail(): void {
    this.contact.emails.push({ correo: '' });
    this.errors.emails.push(''); // No more error here
  }

  removeEmail(index: number): void {
    this.contact.emails.splice(index, 1);
    this.errors.emails.splice(index, 1);
  }

  addDireccion(): void {
    this.contact.direcciones.push({ direccion: '' });
    this.errors.direcciones.push(''); // No more error here
  }

  removeDireccion(index: number): void {
    this.contact.direcciones.splice(index, 1);
    this.errors.direcciones.splice(index, 1);
  }

  onSubmit(): void {
    this.contactService.addContact(this.contact).subscribe(
      () => {
        console.log('Contacto agregado correctamente');
        this.router.navigate(['/crud']);
      },
      error => {
        console.error('Error al agregar el contacto', error);
        this.errorHandlingService.handleErrors(error.error.errors, this.errors);
      }
    );
  }
}
