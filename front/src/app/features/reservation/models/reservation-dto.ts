import { DayDto } from "./day-dto";
import { FoodtrackDto } from "./foodtrack-dto";
import { LocationDto } from "./location-dto";
import { SocietyDto } from "./society-dto";


export interface ReservationDto {
  id?: number;
  day: DayDto;
  location: LocationDto;
  society: SocietyDto;
  foodtrack: FoodtrackDto;
}
