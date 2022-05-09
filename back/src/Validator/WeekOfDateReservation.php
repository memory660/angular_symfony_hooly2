<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class WeekOfDateReservation extends Constraint
{
    public $messageLocationUnauthorized = 'location 7 is not allowed on Friday.';
    public $messageIntegerNo = 'The location must be an integer.';
    public $messageReservationWithSameDate = 'at this date, this foodtrack has already booked with company.';
    public $messageMultipleReservation = 'this foodtrack on this date has already booked in the week on this company.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

 
}