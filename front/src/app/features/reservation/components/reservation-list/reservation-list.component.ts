import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { ReservationDto } from '../../models/reservation-dto';
import { ReservationStoreService } from '../../services/reservation-store.service';

@Component({
  selector: 'app-reservation-list',
  templateUrl: './reservation-list.component.html',
  styleUrls: ['./reservation-list.component.scss']
})
export class ReservationListComponent implements OnInit {

  reservations$!: Observable<ReservationDto[]>;
  loading$: Observable<boolean>;

  constructor(private reservationStoreService: ReservationStoreService) {
    this.reservations$ = this.reservationStoreService.getReservationsObs();
    this.loading$ = this.reservationStoreService.getLoading();
  }

  ngOnInit(): void {
  }

}
