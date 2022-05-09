import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Observable } from 'rxjs';
import { HttpService } from '../../services/http.service';
import { ReservationStoreService } from '../../services/reservation-store.service';

@Component({
  selector: 'app-select-foodtrack',
  templateUrl: './select-foodtrack.component.html',
  styleUrls: ['./select-foodtrack.component.scss']
})
export class SelectFoodtrackComponent implements OnInit {
  foodtrackForm!: FormGroup;
  foodtracks$!: Observable<any>;

  constructor(private formBuilder: FormBuilder, private httpService: HttpService, private reservationStoreService: ReservationStoreService) {
    this.foodtrackForm = this.formBuilder.group({
      foodtrackId: ['', Validators.required],
    });
    this.foodtracks$ = httpService.getFoodtracks();
  }

  ngOnInit(): void {
  }

  public createFormGroup(): FormGroup {
    return this.foodtrackForm;
  }

}
