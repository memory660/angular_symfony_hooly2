<?php
namespace App\Service;

use App\Entity\Day;
use App\Entity\Reservation;
use App\Repository\DayRepository;
use App\Repository\FoodtrackRepository;
use App\Repository\LocationRepository;
use App\Repository\ReservationRepository;
use App\Repository\SocietyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReservationService
{

    public function __construct(
         private ManagerRegistry $registry,
         private ReservationRepository $reservationRepository,
         private DayRepository $dayRepository,
         private SocietyRepository $societyRepository,            
         private LocationRepository $locationRepository,  
         private FoodtrackRepository $foodtrackRepository,      
         private ValidatorInterface $validator     
    ) 
    { }

    function createReservation($reservationRequest) {
        $entityManager = $this->registry->getManager();
        // Day
        $dateReservation = new \DateTime($reservationRequest->date);
        $day = new Day();
        $day->setDateReservation($dateReservation);
        $day->setWeekNo($dateReservation->format("W"));
        $weekDate = $this->getStartAndEndDate($day->getWeekNo(),$dateReservation->format("Y"));
        $day->setDateBegin(new \DateTime($weekDate['week_start']));
        $day->setDateEnd(new \DateTime($weekDate['week_end']));        
        $entityManager->persist($day);

        // Location
        $location = $this->locationRepository->findOneByLocationNo($reservationRequest->no);
        // Society
        $society = $this->societyRepository->findOneById($reservationRequest->societyId);
        // foodtrack
        $foodtrack = $this->foodtrackRepository->findOneById($reservationRequest->foodtrackId);

        // Reservation
        $reservation = new Reservation();
        $reservation->setDay($day);
        $reservation->setLocation($location);        
        $reservation->setSociety($society);    
        $reservation->setFoodtrack($foodtrack);  
        $entityManager->persist($reservation);

        $entityManager->flush();    
        
        return $reservation;
    }

    function getStartAndEndDate($week, $year) {
        $dto = new \DateTime();
        $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
        $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
        return $ret;
    }    

    function checkAlreadyExist($reservationRequest) {
        return $this->reservationRepository->findReservationBy($reservationRequest);
    }

    function checkDataRequest() {
        // voir le validator : WeekOfDateReservationValidator
        $errors = $this->validator->validate($this);
        $messages = ['message' => 'validation_failed', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }
    
        return $messages;
    }
}