import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { finalize, Observable } from "rxjs";
import { ReservationStoreService } from "src/app/features/reservation/services/reservation-store.service";

@Injectable()
export class LoadingInterceptor implements HttpInterceptor {
  constructor(private reservationStoreService: ReservationStoreService) {}

  intercept(
request: HttpRequest<unknown>,
next: HttpHandler
): Observable<HttpEvent<unknown>> {
    this.reservationStoreService.emitLoading(true);
    return next.handle(request).pipe(
      finalize(() => {
        this.reservationStoreService.emitLoading(false);
      })
    );
  }
}
