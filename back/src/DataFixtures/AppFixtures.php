<?php
namespace App\DataFixtures;

use App\Entity\Day;
use App\Entity\Foodtrack;
use App\Entity\Location;
use App\Entity\Society;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Location
        for ($i = 1; $i < 8; $i++) {
            $l = new Location();
            $l->setLocationNo($i);
            $manager->persist($l);
        }
        $manager->flush();
         
        // User
        $foodtrack1 = new Foodtrack();
        $foodtrack1->setUsername('foodtrack1');
        $manager->persist($foodtrack1);

        $foodtrack2 = new Foodtrack();
        $foodtrack2->setUsername('foodtrack2');
        $manager->persist($foodtrack2);

        // Society
        $society = new Society();
        $society->setName('hooly');
        $manager->persist($society);

        $society2 = new Society();
        $society2->setName('société 2');
        $manager->persist($society2);        

        // ================================================================================

/*        
        $locations =$manager->getRepository(Location::class)->findAll();

        // Day
        $day1 = $this->createDay('09-04-2022');
        $manager->persist($day1);
        $day2 = $this->createDay('27-04-2022');
        $manager->persist($day2);
        $day3 = $this->createDay('15-05-2022');
        $manager->persist($day3);          
        
        $day4 = $this->createDay('01-04-2022');
        $manager->persist($day4);  

        // Reservation
        $reservation1 = new Reservation();
        $reservation1->setDay($day1);
        $reservation1->setUser($user2);
        $reservation1->setLocation($locations[2]);
        $reservation1->setSociety($society);
        $manager->persist($reservation1);

        $reservation2 = new Reservation();
        $reservation2->setDay($day2);
        $reservation2->setUser($user2);
        $reservation2->setLocation($locations[3]);
        $reservation2->setSociety($society);
        $manager->persist($reservation2);
        
        $reservation3 = new Reservation();
        $reservation3->setDay($day3);
        $reservation3->setUser($user2);
        $reservation3->setLocation($locations[5]);
        $reservation3->setSociety($society);
        $manager->persist($reservation3);      
        
        $reservation4 = new Reservation();
        $reservation4->setDay($day4);
        $reservation4->setUser($user1);
        $reservation4->setLocation($locations[3]);
        $reservation4->setSociety($society);
        $manager->persist($reservation4);          
*/

        $manager->flush();
    }

    function createDay($dateStr) {
        $d1 = new \DateTime($dateStr);
        $result1 = $this->getResult($d1);
        $day1 = new Day();
        $day1->setDateReservation($d1);
        $day1->setWeekNo($result1['week']);
        $day1->setDateBegin(new DateTime($result1['result']['start_date']));
        $day1->setDateEnd(new DateTime($result1['result']['end_date'])); 
        return $day1;   
    }

    function getResult($date) {

        $week = date("W", strtotime($date->format('Y-m-d')));
        $year = date("o", strtotime($date->format('Y-m-d')));
        return ['result' => $this->getStartAndEndDate($week, $year), 'week' => $week, 'year' => $year];
    }

    function getStartAndEndDate($week, $year) {
        $dateTime = new \DateTime();
        $dateTime->setISODate($year, $week);
        $result['start_date'] = $dateTime->format('d-m-Y');
        $dateTime->modify('+6 days');
        $result['end_date'] = $dateTime->format('d-m-Y');
        return $result;
    }
}
