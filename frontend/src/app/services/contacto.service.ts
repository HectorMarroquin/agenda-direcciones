import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ContactService {
  private apiUrl = 'http://localhost:8000/api'; // Ajusta la URL de tu API de Laravel

  constructor(private http: HttpClient) { }

  getAllContacts() {
    const token = localStorage.getItem('access_token');

    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.get<any>(`${this.apiUrl}/contactos`, { headers }).pipe(
      catchError(error => {
        console.error('Error al obtener los contactos', error);
        return throwError(error);
      })
    );
  }

  addContact(contact: any) {
    const token = localStorage.getItem('access_token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    });

    return this.http.post<any>(`${this.apiUrl}/contactos`, contact, { headers }).pipe(
      catchError(error => {
        console.error('Error al agregar el contacto', error);
        return throwError(error);
      })
    );
  }

  updateContact(id: number, contact: any) {
    const token = localStorage.getItem('access_token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    });

    return this.http.put<any>(`${this.apiUrl}/contactos/${id}`, contact, { headers }).pipe(
      catchError(error => {
        console.error('Error al actualizar el contacto', error);
        return throwError(error);
      })
    );
  }

  deleteContact(id: number) {
    const token = localStorage.getItem('access_token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.delete<any>(`${this.apiUrl}/contactos/${id}`, { headers }).pipe(
      catchError(error => {
        console.error('Error al eliminar el contacto', error);
        return throwError(error);
      })
    );
  }
}
