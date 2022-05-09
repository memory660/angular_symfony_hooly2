import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ReservationModule } from './features/reservation/reservation.module';
import { NoopAnimationsModule } from '@angular/platform-browser/animations';
import { MatSelectModule } from '@angular/material/select';
import { MAT_DATE_FORMATS } from '@angular/material/core';



@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReservationModule,
    NoopAnimationsModule,
    MatSelectModule
  ],
  providers: [

  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
