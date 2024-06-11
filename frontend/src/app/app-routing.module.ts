// app-routing.module.ts

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ContactListComponent } from './crud/contact-list/contact-list.component';
import { ContactAddComponent } from './crud/contact-add/contact-add.component';
import { ContactEditComponent } from './crud/contact-edit/contact-edit.component';
import { ContactDetailComponent } from './crud/contact-detail/contact-detail.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from './guards/auth.guard'; // Asegúrate de crear este guard

const routes: Routes = [
  { path: '', redirectTo: '/login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'crud', component: ContactListComponent, canActivate: [AuthGuard] },
  { path: 'crud/add', component: ContactAddComponent, canActivate: [AuthGuard] },
  { path: 'crud/edit/:id', component: ContactEditComponent, canActivate: [AuthGuard] },
  { path: 'crud/detail/:id', component: ContactDetailComponent, canActivate: [AuthGuard] },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
