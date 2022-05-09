import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ReservationStoreService } from '../../services/reservation-store.service';
import { MAT_DATE_FORMATS } from '@angular/material/core';
import { ReservationDto } from '../../models/reservation-dto';
import { combineLatest, Observable, Subscription, tap } from 'rxjs';
import { SocietyDto } from '../../models/society-dto';
import { SocietyFormDto } from '../../models/formDto';
import { CombineDate } from '../../models/combine';

export const MY_DATE_FORMATS = {
    parse: {
      dateInput: 'DD/MM/YYYY',
    },
    display: {
      dateInput: 'DD/MM/YYYY',
      monthYearLabel: 'MMMM YYYY',
      dateA11yLabel: 'LL',
      monthYearA11yLabel: 'MMMM YYYY'
    },
};

@Component({
  selector: 'app-select-date',
  templateUrl: './select-date.component.html',
  styleUrls: ['./select-date.component.scss'],
  providers: [
    { provide: MAT_DATE_FORMATS, useValue: MY_DATE_FORMATS }
  ]
})
export class SelectDateComponent implements OnInit, OnDestroy {
  @Input() societyObs$!: Observable<SocietyFormDto>;
  minDate!: Date;
  maxDate!: Date;
  datesRejectedArr = <string[]>[];
  dateForm: FormGroup;
  sub!: Subscription;
  mix$!: Observable<any>;

  constructor(private formBuilder: FormBuilder, private reservationStoreService: ReservationStoreService) {
    this.dateForm = this.formBuilder.group({
      date: ['', Validators.required],
    });
    this.calculateDates();
  }

  ngOnInit(): void {
    this.mix$ = combineLatest({
      society: this.societyObs$,
      reservations: this.reservationStoreService.getReservationsObs()
    });

    this.sub = this.mix$.subscribe((data: CombineDate) => {
      this.datesRejectedArr = this.createDatesRejectedArr(data);
    })
  }


  calculateDates() {
    this.minDate = new Date(this.now().setDate(this.now().getDate() + 1));
    this.maxDate = new Date(this.now().setDate(this.now().getDate() + 365));
  }

  createDatesRejectedArr(data: CombineDate): string[] {
    let datesRejectedArr: string[] = [];
    data.reservations.forEach((reservation: ReservationDto) => {
      if (reservation.society.id === data.society.societyId) {
        const dateStart = new Date(reservation.day.dateBegin.date);
        const dateEnd = new Date(reservation.day.dateEnd.date);
        datesRejectedArr.push(...this.getDatesInRange(dateStart, dateEnd));
      } else {
        const dates = [];
        dates.push(new Date(reservation.day.dateReservation.date).toISOString().slice(0, 10));
        datesRejectedArr.push(...dates);
      }
    });

    return datesRejectedArr;
  }

  createFormGroup(): FormGroup {
    return this.dateForm;
  }

  myFilter = (d: Date | null): boolean => {
    const day = (d || this.now()).toISOString().slice(0, 10);
    return !this.datesRejectedArr.some(v => day === v);
  };

  getDatesInRange(startDate: Date, endDate: Date) {
    const date = new Date(startDate.getTime());
    const dates = [];

    while (date <= endDate) {
      let d = new Date(date).toISOString().slice(0, 10);
      dates.push(d);
      date.setDate(date.getDate() + 1);
    }

    return dates;
  }

  now(): Date  {
    return new Date();
  }

  ngOnDestroy(): void {
    if (this.sub) this.sub.unsubscribe();
  }
}
