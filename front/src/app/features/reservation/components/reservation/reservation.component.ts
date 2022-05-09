import { ChangeDetectorRef, Component, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { dateInputsHaveChanged } from '@angular/material/datepicker/datepicker-input-base';
import { combineLatest, combineLatestWith, Observable, Subscription, tap } from 'rxjs';
import { ReservationSave } from '../../models/reservation-save';
import { SocietyDto } from '../../models/society-dto';
import { HttpService } from '../../services/http.service';
import { ReservationStoreService } from '../../services/reservation-store.service';
import { SelectDateComponent } from '../select-date/select-date.component';
import { SelectLocationComponent } from '../select-location/select-location.component';
import { SelectSocietyComponent } from '../select-society/select-society.component';
import { SelectUserComponent } from '../select-user/select-user.component';

type reservationFormType = {society: any, user: any, no: any, date: any};

@Component({
  selector: 'app-reservation',
  templateUrl: './reservation.component.html',
  styleUrls: ['./reservation.component.scss']
})
export class ReservationComponent implements OnInit, OnDestroy {
  @ViewChild(SelectSocietyComponent, { static: true }) public selectSocietyComponent!: SelectSocietyComponent;
  @ViewChild(SelectUserComponent, { static: true }) public selectUserComponent!: SelectUserComponent;
  @ViewChild(SelectDateComponent, { static: true }) public selectDateComponent!: SelectDateComponent;
  @ViewChild(SelectLocationComponent, { static: true }) public selectLocationComponent!: SelectLocationComponent;

  reservations$!: Observable<any>;
  reservationForm!: FormGroup;
  loading$: Observable<boolean>;
  loading = false;
  sub!: Subscription;
  subLoading!: Subscription;

  constructor(private httpService: HttpService, private reservationStoreService: ReservationStoreService, private formBuilder: FormBuilder, private cd: ChangeDetectorRef) {
    this.reservations$ = this.reservationStoreService.getReservationsObs();
    this.loading$ = this.reservationStoreService.getLoading();
  }

  ngOnInit(): void {
    // définition du formulaire
    this.reservationForm = this.formBuilder.group({
      society: this.selectSocietyComponent.createFormGroup(),
      user: this.selectUserComponent.createFormGroup(),
      date: this.selectDateComponent.createFormGroup(),
      no: this.selectLocationComponent.createFormGroup(),
    })
    // écoute la sélection de l'utilisateur (foodtrack) et de la société, si ok, charge les réservations
    this.sub = this.reservationForm.controls['user'].valueChanges
    .pipe(
      combineLatestWith(this.reservationForm.controls['society'].valueChanges)
    ).subscribe((data: {userId: number, societyId: number}[]) => {
      this.resetControls();
      this.httpService.setReservations(data[0].userId,  data[1].societyId);
    })
    // écoute si il y a un chargement de données provenant de l'api
    this.subLoading = this.reservationStoreService.getLoading().subscribe((loading: boolean) => {
      this.loading = loading;
      this.cd.detectChanges();
    });
    //
    //
  }

  onRegister() {
    // procédure d'enregistrement d'une réservation
    if (this.reservationForm.valid) {
      // formatter le formulaire dans un format adapté pour l'envoi à l'api
      const reservationConv = this.conv(this.reservationForm.value);

      // enregistrer la reservation dans l'api
      this.httpService.saveReservations(reservationConv).subscribe(
        () => {
          // après l'enregistrement, éfface les 2 champs date et emplacement
          this.resetControls();
          // recharge les nouvelles reservations
          this.httpService.setReservations(reservationConv.foodtrackId, reservationConv.societyId);
      });
    }
  }

  resetControls() {
    this.reservationForm.controls['date'].reset();
    this.reservationForm.controls['no'].reset();
  }

  conv(values: reservationFormType): ReservationSave {
    const date = new Date(this.reservationForm.value.date.date);
    const dateConv = new Date(date.setDate(date.getDate() + 1)).toISOString().slice(0, 10);
    return {date: dateConv, no: values.no.no, societyId: values.society.societyId, foodtrackId: values.user.userId} as ReservationSave;
  }

  ngOnDestroy(): void {
    this.sub.unsubscribe();
    this.subLoading.unsubscribe();
  }
}
