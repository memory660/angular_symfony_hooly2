import { ComponentFixture, TestBed } from '@angular/core/testing';
import { of } from 'rxjs';
import { reservations } from 'src/app/spec-helpers/spec-helpers';
import { ReservationDto } from '../../models/reservation-dto';
import { ReservationStoreService } from '../../services/reservation-store.service';

import { ReservationListComponent } from './reservation-list.component';

describe('ReservationListComponent', () => {
  let component: ReservationListComponent;
  let fixture: ComponentFixture<ReservationListComponent>;
  let fakeReservationStoreService: jasmine.SpyObj<ReservationStoreService>;

  beforeEach(async () => {
    fakeReservationStoreService = jasmine.createSpyObj<ReservationStoreService>('ReservationStoreService', ['getReservationsObs', 'getLoading']);
    fakeReservationStoreService.getReservationsObs.and.returnValue(of(reservations));
    fakeReservationStoreService.getLoading.and.returnValue(of(false));

    await TestBed.configureTestingModule({
      declarations: [ ReservationListComponent ],
      providers: [
        { provide: ReservationStoreService, useValue: fakeReservationStoreService },

      ],
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ReservationListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('should initialization', () => {
    component.reservations$.subscribe((res: ReservationDto[]) => {
      expect(reservations).toEqual(res);
    })
    component.loading$.subscribe((value: boolean) => {
      expect(false).toEqual(value);
    })
  });
});
