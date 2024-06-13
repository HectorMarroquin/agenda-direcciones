import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ContactService } from '../../services/contacto.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-contact-detail',
  templateUrl: './contact-detail.component.html',
  styleUrl: './contact-detail.component.css'
})
export class ContactDetailComponent {
  contact: any = {
    nombre: '',
    telefonos: [],
    emails: [],
    direcciones: [],
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

}
