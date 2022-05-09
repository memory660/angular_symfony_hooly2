<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayRepository::class)]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateReservation;

    #[ORM\Column(type: 'integer')]
    private $weekNo;

    #[ORM\Column(type: 'date')]
    private $dateBegin;

    #[ORM\Column(type: 'date')]
    private $dateEnd;

    #[ORM\OneToMany(mappedBy: 'day', targetEntity: Reservation::class)]
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getWeekNo(): ?int
    {
        return $this->weekNo;
    }

    public function setWeekNo(int $weekNo): self
    {
        $this->weekNo = $weekNo;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setDay($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getDay() === $this) {
                $reservation->setDay(null);
            }
        }

        return $this;
    }
}
