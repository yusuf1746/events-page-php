<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\EventEntitymanager;
use App\Model\EventRepository;
use App\Model\Event;
use App\Core\EventValidation;
use App\Core\Viewinterface;
use App\Core\JoinValidation;

session_start();

class HomeController {

    public function __construct(protected ViewInterface $templateEngine) {
        $eventRepository = new EventRepository();
        $eventEntityManager = new EventEntitymanager();
        $joinValidation = new joinValidation();
        
        $validation = new EventValidation();
        
        $jsonData = $eventRepository->findAll();
        
        if(isset($_POST["Absenden"])) {
            $event = new Event(
                $_POST["Eventname"],
                $_POST["Datum"],
                $_POST["Eventbeschreibung"],
                (int) $_POST["Maxpersonen"],
                rand(10000, 99999)
            );
        
            $eventnameError = $validation->getEventnameError($event->getEventName());
            $datumError = $validation->getDatumError($event->getDatum());
            $beschreibungError = $validation->getBeschreibungError($event->getEventbeschreibung());
            $maxpersonenError = $validation->getMaxpersonenError($event->getMaxpersonen());  
        
            if($validation->isValidEvent($event)) {
                $eventEntityManager->add(event: $event);
            }
        }
        
        $jsonData = $eventRepository->findAll();
        
        //$eventStatus = [];
        $userName = '';
        $loggedIn = $_SESSION['loggedIn'] ?? false;
        if($loggedIn) {
            $userName = $_SESSION['userName'] ?? '';
        }
        
        $logText = '';
        $loggedIn ? $logText = 'logout' : $logText = 'login';
        
        
        if(isset($_POST['logout']) && $loggedIn) {
            header('Location: index.php?page=logout');
            exit;
        }

        $events = $jsonData;
        
        foreach($jsonData as $key => ["Maxpersonen" => $maxPersonen, "Personen" => $personen]) {
            $events[$key] = $joinValidation->manageJoinEvent($jsonData[$key], $loggedIn ?? false, $userName, isset($_POST[$key]));

            $jsonData[$key]['Personen'] = $events[$key]['Personen'];
            $jsonData[$key]['JoinedUsers'] = $events[$key]['JoinedUsers'];
        }
        
        $data = [
            'eventnameError' => $eventnameError ?? "",
            'datumError' => $datumError ?? "",
            'beschreibungError' => $beschreibungError ?? "",
            'maxpersonenError' => $maxpersonenError ?? "",
            'events' => $events,
            'userName' => $userName ?? "",
            'logText' => $logText,
            'loggedIn' => $loggedIn
        ];

        $templateEngine->addParameter('home.twig', $data);
        
        $eventEntityManager->saveAll($jsonData);
    }

    /*public function manageJoinEvent(array $event, bool $loggedIn, string $userName, bool $tryingToJoin) {
        $personen = $event["Personen"];
        $maxPersonen = $event["Maxpersonen"];
        for($j = 0; $j < $personen+1; $j++){
            if($personen >= $maxPersonen) {
                $event["eventStatus"] = 0;
                break;
            }
            if(!$loggedIn || !isset($userName)) {
                if($event["eventStatus"] ?? 2 !== 0) $event["eventStatus"] = 2;
                break;
            }
            $user = $event["JoinedUsers"][$j] ?? null;
            if(isset($user) && $user === $userName ?? "") {
                $event["eventStatus"] = 1;
                break;
            }
            if(!isset($user)) {
                if($tryingToJoin) {
                    $event["Personen"]++;
                    $personen++;
                    $event["JoinedUsers"][$j] = $userName;
                    
                    $event["eventStatus"] = 1;
                    header('Location: index.php');
                    break;
                }
                else {
                    $event["eventStatus"] = 2;
                    break;
                }
            }
        }
        return $event;
    }*/
}