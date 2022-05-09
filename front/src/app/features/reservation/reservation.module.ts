import {  NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReservationComponent } from './components/reservation/reservation.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {MatInputModule} from '@angular/material/input';
import {MatIconModule} from '@angular/material/icon';
import {MatSelectModule} from '@angular/material/select';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import {MatCardModule} from '@angular/material/card';
import { ReservationListComponent } from './components/reservation-list/reservation-list.component';
import { SelectSocietyComponent } from './components/select-society/select-society.component';
import { SelectUserComponent } from './components/select-user/select-user.component';
import { SelectDateComponent } from './components/select-date/select-date.component';
import { SelectLocationComponent } from './components/select-location/select-location.component';
import {MatDatepickerModule} from '@angular/material/datepicker';
import { DateAdapter, MatNativeDateModule, MAT_DATE_LOCALE } from '@angular/material/core';
import {MatButtonModule} from '@angular/material/button';
import { MAT_DATE_FORMATS } from '@angular/material/core';
import { MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS, MomentDateAdapter } from '@angular/material-moment-adapter';
import { LoadingInterceptor } from 'src/app/core/interceptors/LoadingInterceptort';

@NgModule({
  declarations: [
    ReservationComponent,
    ReservationListComponent,
    SelectSocietyComponent,
    SelectUserComponent,
    SelectDateComponent,
    SelectLocationComponent,

  ],
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,

    MatInputModule,
    MatIconModule,
    MatSelectModule,
    MatCardModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatButtonModule,
  ],
  exports: [
    ReservationComponent
  ],
  providers: [
    MatDatepickerModule,
    { provide: MAT_DATE_LOCALE, useValue: 'fr-FR' },
    {
      provide: DateAdapter,
      useClass: MomentDateAdapter,
      deps: [MAT_DATE_LOCALE, MAT_MOMENT_DATE_ADAPTER_OPTIONS],
    },
    { provide: MAT_DATE_FORMATS, useValue: MAT_MOMENT_DATE_FORMATS },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: LoadingInterceptor,
      multi: true,
    },
  ]
})
export class ReservationModule { }
