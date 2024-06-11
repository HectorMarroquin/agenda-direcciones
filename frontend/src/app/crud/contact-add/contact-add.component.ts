import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ContactService } from '../../services/contacto.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-contact-add',
  templateUrl: './contact-add.component.html',
  styleUrls: ['./contact-add.component.css']
})
export class ContactAddComponent {
  contact = {
    nombre: '',
    telefonos: [{ numero: '' }],
    emails: [{ email: '' }],
    direcciones: [{ direccion: '' }],
    user_id: ''
  };

  constructor(
    private contactService: ContactService,
    private authService: AuthService,
    private router: Router
  ) {
    this.contact.user_id = this.authService.getUserId();
  }

  addTelefono(): void {
    this.contact.telefonos.push({ numero: '' });
  }

  removeTelefono(index: number): void {
    this.contact.telefonos.splice(index, 1);
  }

  addEmail(): void {
    this.contact.emails.push({ email: '' });
  }

  removeEmail(index: number): void {
    this.contact.emails.splice(index, 1);
  }

  addDireccion(): void {
    this.contact.direcciones.push({ direccion: '' });
  }

  removeDireccion(index: number): void {
    this.contact.direcciones.splice(index, 1);
  }

  onSubmit(): void {
    // Llamar al servicio para agregar el contacto
    console.log(this.contact);

    this.contactService.addContact(this.contact).subscribe(
      () => {
        console.log('Contacto agregado correctamente');
        this.router.navigate(['/crud']);
      },
      error => {
        console.error('Error al agregar el contacto', error);
      }
    );
  }
}
