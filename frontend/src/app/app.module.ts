import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ContactListComponent } from './crud/contact-list/contact-list.component';
import { ContactAddComponent } from './crud/contact-add/contact-add.component';
import { ContactEditComponent } from './crud/contact-edit/contact-edit.component';
import { ContactDetailComponent } from './crud/contact-detail/contact-detail.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from './guards/auth.guard'; // Agrega este guard

@NgModule({
  declarations: [
    AppComponent,
    ContactListComponent,
    ContactAddComponent,
    ContactEditComponent,
    ContactDetailComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule
  ],
  providers: [AuthGuard], // Agrega AuthGuard como provider
  bootstrap: [AppComponent]
})
export class AppModule { }
