<?php

namespace App\Controller;

use App\Repository\FoodtrackRepository;
use App\Repository\LocationRepository;
use App\Repository\ReservationRepository;
use App\Repository\SocietyRepository;
use App\Requests\ReservationRequest;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/data')]
class DataController extends AbstractController
{

    #[Route('/reservations', name: 'app_reservations_register', methods: 'POST')]
    public function reservationsRegister(
        ReservationRequest $request, 
        ReservationService $reservationService   
    ): Response
    {     
        // vérifications:
        //      - vérifier que les données reçu de la requete sont dans un bon format    
        //      - si "vendredi" il ne doit pas avoir de reservation possible à l'emplacement 7   
        //      - si l'utilisateur à déjà réservé dans une autre société 
        //      - si l'utilisateur essait de réserver plus d'une fois par semaine dans la meme société                    
        $messages = $reservationService->checkDataRequest();
        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages);
            $response->send();
            exit;
        }

        $dataRequest = json_decode($request->getRequest()->getContent());
        $reservation = $reservationService->createReservation($dataRequest);

        return $this->json($reservation);
    }

    #[Route('/locations', name: 'app_locations', methods: 'GET')]
    public function locations(LocationRepository $locationRepository): Response
    {     
        $locations = $locationRepository->findAllLocations();

        if (!$locations) {
            return $this->json('Les emplacements sont manquants !', 404);
        }

        $arr = [];
        foreach($locations as $key => $value) {
            $arr[$key] = $value['locationNo'];
        }

        // si vendredi, on supprime le dernier emplacement
        if (date("w") == 5) {   // 5: vendredi
            array_pop($arr);
        }

        return $this->json($arr);
    }

    #[Route('/reservations-society/{societyId}/{date}', name: 'app_reservations_society', methods: 'GET')]
    public function reservationsFromSociety(ReservationRepository $reservationRepository, int $societyId, string $date): Response
    {     
        $nos = $reservationRepository->findFromSociety($societyId, $date);

        if (date("w", strtotime($date)) == "04" && !in_array(7, $nos)) {
            $nos[] = ["locationNo" => 7];
        };   

        return $this->json($nos);
    }

    #[Route('/reservations/{foodtrackId}/{societyId}', name: 'app_reservations', methods: 'GET')]
    public function reservations(ReservationRepository $reservationRepository, int $foodtrackId, int $societyId): Response
    {     
        $reservations = $reservationRepository->findByDate($foodtrackId, $societyId);

        if (!$reservations) {
            return $this->json([]);
        }

        return $this->json($reservations);
    }

    #[Route('/societies', name: 'app_societies', methods: 'GET')]
    public function societies(SocietyRepository $societyRepository): Response
    {     
        $societies = $societyRepository->findSocieties();

        if (!$societies) {
            return $this->json('No societies found', 404);
        }

        return $this->json($societies);
    }   
    
    #[Route('/foodtracks', name: 'app_foodtracks', methods: 'GET')]
    public function foodtracks(FoodtrackRepository $foodtrackRepository): Response
    {     
        $foodtracks = $foodtrackRepository->findFoodtracks();

        if (!$foodtracks) {
            return $this->json('No foodtracks found', 404);
        }

        return $this->json($foodtracks);
    }        
}
