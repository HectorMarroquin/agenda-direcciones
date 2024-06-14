import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'http://localhost:8000/api'; // Ajusta la URL de tu API de Laravel

  constructor(private http: HttpClient, private router: Router) { }

  login(credentials: { email: string, password: string }) {
    return this.http.post<any>(`${this.apiUrl}/login`, credentials).pipe(
      tap(response => {
        if (response && response.access_token) {
          localStorage.setItem('access_token', response.access_token);
          localStorage.setItem('user_id', response.user_id.toString()); // Guarda el ID del usuario
          this.router.navigateByUrl('/crud/'); // Redirige a la ruta de lista de contactos
        } else {
          console.error('El token de acceso no está presente en la respuesta.');
        }
      }),
      catchError(error => {
        console.error('Error en la solicitud de login', error);
        return throwError(error);
      })
    );
  }

  logout() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('user_id');
    this.router.navigateByUrl('/login'); // Redirige a la ruta de login al salir
  }

  getToken(): string {
    return localStorage.getItem('access_token') || '';
  }

  getUserId(): string {
    return localStorage.getItem('user_id') || '';
  }

  isLoggedIn(): boolean {
    return !!localStorage.getItem('access_token');
  }
}
