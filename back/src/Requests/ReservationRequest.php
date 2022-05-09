<?php
namespace App\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;

#[AcmeAssert\WeekOfDateReservation()]
class ReservationRequest extends BaseRequest
{
    #[Type('string')]
    #[NotBlank()]
    #[Assert\Length(
        min: 10,
        max: 10,
    )]    
    protected $date;

    #[Type('integer')]
    #[Assert\Range(
        min: 1,
        max: 7,
        notInRangeMessage: 'location number must be between {{ min }} and {{ max }}',
    )] 
    protected $no;

    #[Type('integer')]
    #[NotBlank()]
    protected $societyId;
    
    #[Type('integer')]
    #[NotBlank()]
    protected $foodtrackId;   
    
    

    /**
     * Get the value of foodtrackId
     */ 
    public function getFoodtrackId()
    {
        return $this->foodtrackId;
    }

    /**
     * Set the value of foodtrackId
     *
     * @return  self
     */ 
    public function setFoodtrackId($foodtrackId)
    {
        $this->foodtrackId = $foodtrackId;

        return $this;
    }

    /**
     * Get the value of societyId
     */ 
    public function getSocietyId()
    {
        return $this->societyId;
    }

    /**
     * Set the value of societyId
     *
     * @return  self
     */ 
    public function setSocietyId($societyId)
    {
        $this->societyId = $societyId;

        return $this;
    }

    /**
     * Get the value of no
     */ 
    public function getNo()
    {
        return $this->no;
    }

    /**
     * Set the value of no
     *
     * @return  self
     */ 
    public function setNo($no)
    {
        $this->no = $no;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}