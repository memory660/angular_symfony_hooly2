<?php

// src/Validator/ContainsAlphanumericValidator.php
namespace App\Validator;

use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WeekOfDateReservationValidator extends ConstraintValidator
{

    public function __construct(private ManagerRegistry $registry, private ReservationRepository $reservationRepository, private ReservationService $reservationService) {}

    public function validate($protocol, Constraint $constraint)
    {
        $location = $protocol->getNo();
        $dateReservationStr = $protocol->getDate();
        $yearDateReservation = date("Y", strtotime($dateReservationStr));
        $dayReservation = date("W", strtotime($dateReservationStr));           
        $weekDate = $this->reservationService->getStartAndEndDate($dayReservation, $yearDateReservation);      
        $dateBegin = ($weekDate['week_start']);
        $dateEnd = ($weekDate['week_end']); 
        $dateReservation = new \DateTime($dateReservationStr); 
        $foodtrackId = $protocol->getFoodtrackId();
        $societyId = $protocol->getSocietyId();

        // l'emplacement doit être un entier
        if (!is_integer($location)) {
            $this->context->buildViolation($constraint->messageIntegerNo)
                ->atPath('no')
                ->addViolation();
        }

        // si "vendredi" il ne doit pas avoir de reservation à l'emplacement 7
        if ($location === 7 && $dayReservation == 5) {
            $this->context->buildViolation($constraint->messageLocationUnauthorized)
                ->atPath('no')
                ->addViolation();
        }

        // si l'utilisateur à déjà réservé dans la meme société ou dans une autre société
        $reservations = $this->reservationRepository->findReservationWithSameDate($foodtrackId, $dateReservation);
        if (count($reservations) > 0) {
            $this->context->buildViolation($constraint->messageReservationWithSameDate)
                ->atPath('date')
                ->addViolation();
        }

        // si l'utilisateur essait de réserver plus d'une fois par semaine 
        $reservations = $this->reservationRepository->findReservationBetweenDate($foodtrackId, $societyId, $dateBegin, $dateEnd);      
        if (count($reservations) > 0) {
            $this->context->buildViolation($constraint->messageMultipleReservation)
                ->atPath('date')
                ->addViolation();
        }        
    }   
}