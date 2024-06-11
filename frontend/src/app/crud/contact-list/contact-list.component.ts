import { Component, OnInit } from '@angular/core';
import { ContactService } from '../../services/contacto.service';

@Component({
  selector: 'app-contact-list',
  templateUrl: './contact-list.component.html',
  styleUrls: ['./contact-list.component.css']
})
export class ContactListComponent implements OnInit {
  allContacts: any[] = [];
  contacts: any[] = [];
  currentPage: number = 1;
  totalPages: number = 0; // Inicializa totalPages
  itemsPerPage: number = 10;
  maxPagesToShow: number = 5; // Número máximo de páginas que se mostrarán en la paginación

  constructor(private contactService: ContactService) { }

  ngOnInit(): void {
    this.loadAllContacts();
  }

  loadAllContacts() {
    this.contactService.getAllContacts().subscribe(
      response => {
        if (response && Array.isArray(response.contactos)) {
          this.allContacts = response.contactos;
          this.totalPages = Math.ceil(this.allContacts.length / this.itemsPerPage);
          this.changePage(this.currentPage);
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
        this.loadAllContacts();
      },
      error => {
        console.error('Error al eliminar el contacto', error);
      }
    );
  }

  changePage(page: number) {

    this.currentPage = page;
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;

    const endIndex = startIndex + this.itemsPerPage;

    this.contacts = this.allContacts.slice(startIndex, endIndex);

  }

  pagesToShow(): number[] {
    const pages: number[] = [];
    const startPage = Math.max(1, this.currentPage - Math.floor(this.maxPagesToShow / 2));
    const endPage = Math.min(this.totalPages, startPage + this.maxPagesToShow - 1);


    for (let i = startPage; i <= endPage; i++) {
      pages.push(i);
    }

    return pages;
  }
}
