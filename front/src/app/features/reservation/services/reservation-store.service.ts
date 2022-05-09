import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { ReservationDto } from '../models/reservation-dto';

@Injectable({
  providedIn: 'root'
})
export class ReservationStoreService {

  reservation$ = new BehaviorSubject<ReservationDto[]>([]);
  loading$ = new BehaviorSubject<boolean>(false);

  emitLoading(value: boolean) {
    this.loading$.next(value);
  }

  getLoading(): Observable<boolean> {
    return this.loading$.asObservable();
  }

  emitReservations(reservations: ReservationDto[]) {
    this.reservation$.next(reservations);
  }

  getReservationsObs(): Observable<ReservationDto[]> {
    return this.reservation$.asObservable();
  }
}
