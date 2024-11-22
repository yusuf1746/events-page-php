<?php declare(strict_types=1);

namespace App\Controller;

use App\Core\Viewinterface;
use App\Model\EventRepository;
use App\Core\JoinValidation;
use App\Model\EventEntityManager;

session_start();

class DetailedEventController {

    public function __construct(protected ViewInterface $templateEngine) {
        $eventRepository = new EventRepository();
        $eventEntitymanager = new eventEntitymanager();
        $joinValidation = new joinValidation();

        $events = $eventRepository->findAll();
        $eventKey = $eventRepository->findById((int) $_GET["event"], true);
        $saveData = $events[$eventKey];
        
        if(!isset($saveData)) {
            return;
        }

        $userName = '';
        $loggedIn = $_SESSION['loggedIn'] ?? false;
        if($loggedIn) {
            $userName = $_SESSION['userName'] ?? '';
        }

        $event = $saveData;

        $event = $joinValidation->manageJoinEvent($event, $loggedIn ?? false, $userName, isset($_POST['login']));
        
        if (isset($_POST['logout'])) {
            $event = $joinValidation->manageleaveEvent($event, $loggedIn, $userName);
        }

        $saveData['Personen'] = $event['Personen'];
        $saveData['JoinedUsers'] = $event['JoinedUsers'];

        $eventEntitymanager->save($saveData, $eventKey);

        $event['loggedIn'] = $loggedIn;

        $templateEngine->addParameter('event.twig', $event);
    }

}