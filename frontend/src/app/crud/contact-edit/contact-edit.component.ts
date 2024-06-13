import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ContactService } from '../../services/contacto.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-contact-edit',
  templateUrl: './contact-edit.component.html',
  styleUrls: ['./contact-edit.component.css']
})
export class ContactEditComponent implements OnInit {
  contact = {
    nombre: '',
    telefonos: [{ numero: '' }],
    emails: [{ correo: '' }],
    direcciones: [{ direccion: '' }],
    user_id: ''
  };

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private contactService: ContactService,
    private authService: AuthService
  ) {
    this.contact.user_id = this.authService.getUserId();
  }

  ngOnInit(): void {
    const contactId = +this.route.snapshot.paramMap.get('id')!;
    this.getContact(contactId);
  }

  getContact(id: number): void {
    this.contactService.getContact(id).subscribe(
      data => {
        this.contact = data.contacto;
        console.log(this.contact);

      },
      error => {
        console.error('Error al obtener el contacto', error);
      }
    );
  }

  addTelefono(): void {
    this.contact.telefonos.push({ numero: '' });
  }

  removeTelefono(index: number): void {
    this.contact.telefonos.splice(index, 1);
  }

  addEmail(): void {
    this.contact.emails.push({ correo: '' });
    //console.log(this.contact);


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
    const contactId = +this.route.snapshot.paramMap.get('id')!;
    console.log(this.contact);

    this.contactService.updateContact(contactId, this.contact).subscribe(
      () => {
        console.log('Contacto actualizado correctamente');
        this.router.navigate(['/crud']);
      },
      error => {
        console.error('Error al actualizar el contacto', error);
      }
    );
  }
}
