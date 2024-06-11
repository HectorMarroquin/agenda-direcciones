import { Component, OnInit } from '@angular/core';
import { ContactService } from '../../services/contacto.service';

@Component({
  selector: 'app-contact-list',
  templateUrl: './contact-list.component.html',
  styleUrls: ['./contact-list.component.css']
})
export class ContactListComponent implements OnInit {
  contacts: any[] = [];

  constructor(private contactService: ContactService) { }

  ngOnInit(): void {
    this.loadContacts();
  }

  loadContacts() {
    this.contactService.getContacts().subscribe(
      response => {
        if (response && Array.isArray(response.contactos)) {
          this.contacts = response.contactos;
          console.log(this.contacts);
        } else {
          console.error('La respuesta de la API no contiene un array de contactos válido:', response);
        }
      },
      error => {
        console.error('Error al obtener los contactos', error);
      }
    );
  }

  deleteContact(id: number) {
    this.contactService.deleteContact(id).subscribe(
      () => {
        console.log('Contacto eliminado correctamente');
        // Vuelve a cargar la lista de contactos después de eliminar uno
        this.loadContacts();
      },
      error => {
        console.error('Error al eliminar el contacto', error);
      }
    );
  }
}
