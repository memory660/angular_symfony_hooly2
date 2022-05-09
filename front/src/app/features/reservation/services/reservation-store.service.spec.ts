import { TestBed } from '@angular/core/testing';

import { ReservationStoreService } from './reservation-store.service';

describe('ReservationStoreService', () => {
  let service: ReservationStoreService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ReservationStoreService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
