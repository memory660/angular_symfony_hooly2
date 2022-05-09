import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Observable } from 'rxjs';
import { HttpService } from '../../services/http.service';
import { ReservationStoreService } from '../../services/reservation-store.service';

@Component({
  selector: 'app-select-user',
  templateUrl: './select-user.component.html',
  styleUrls: ['./select-user.component.scss']
})
export class SelectUserComponent implements OnInit {
  userForm!: FormGroup;
  users$!: Observable<any>;

  constructor(private formBuilder: FormBuilder, private httpService: HttpService, private reservationStoreService: ReservationStoreService) {
    this.userForm = this.formBuilder.group({
      userId: ['', Validators.required],
    });
    this.users$ = httpService.getFoodtracks();
  }

  ngOnInit(): void {
  }

  public createFormGroup(): FormGroup {
    return this.userForm;
  }

}
