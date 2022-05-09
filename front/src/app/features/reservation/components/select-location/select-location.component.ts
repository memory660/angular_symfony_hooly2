import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { isMoment } from 'moment';
import { combineLatest, filter, map, Observable, switchMap } from 'rxjs';
import { DateFormDto, SocietyFormDto } from '../../models/formDto';
import { HttpService } from '../../services/http.service';

export type DataCombine = {date: DateFormDto, society: SocietyFormDto, locations: number[]};
export type DataLocation = {locationNo: number};

@Component({
  selector: 'app-select-location',
  templateUrl: './select-location.component.html',
  styleUrls: ['./select-location.component.scss']
})
export class SelectLocationComponent implements OnInit {
  @Input() dateObs$!: Observable<any>;
  @Input() societyObs$!: Observable<SocietyFormDto>;
  locationForm: FormGroup;
  locations$: Observable<number[]>;

  constructor(private formBuilder: FormBuilder, private httpService: HttpService) {
    this.locationForm = this.formBuilder.group({
      no: [{value: '', disabled: false}, Validators.required, ],
    });
    this.locations$ = httpService.getLocations();
  }

  ngOnInit(): void {
    let that = this;

    this.locations$ = combineLatest({
      society: this.societyObs$,
      date: this.dateObs$.pipe(
        filter(date => this.checkValidDate(date))
      ),
      locations: this.locations$
    }).pipe(
      filter((data: DataCombine) => data.date.date != null && data.society != null),
      switchMap(
        (data: DataCombine) => that.httpService.getReservationsFromSociety(data.society.societyId as number, data.date.date)
        .pipe(
            map((nos: DataLocation[]) => that.getArraysIntersection(data.locations, nos.map((location: DataLocation) => location.locationNo))),
        )
      )
    );
  }

  getArraysIntersection(a1: Array<number>, a2: Array<number>){
    // intersection entre tous les emplacements et les emplacements qui ont été reservés
    return a1.filter(function(n) { return a2.indexOf(n) == -1;});
  }

  createFormGroup(): FormGroup {
    return this.locationForm;
  }

  checkValidDate(date: any): boolean {
    console.log("m", date.date );
    if (isMoment(date.date) ) {
      const dateReg = /^\d{1,2}([./-])\d{1,2}\1\d{4}$/
      let dateRedef = '';
      if ( date.date._i.date) {
        dateRedef = date.date._i.date + "/" + date.date._i.month + "/" + date.date._i.year;
      } else {
        dateRedef =date.date._i;
      }
      console.log("dateRedef", dateRedef );
      if (date.date._i, dateRedef.match(dateReg)) return true;
    }
    return false;
  }
}
