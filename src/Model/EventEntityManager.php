<?php declare(strict_types=1);

namespace App\Model;

class EventEntityManager {
    public function saveAll(array $events) {
        $jsonString = json_encode($events, JSON_PRETTY_PRINT);

        $path =  __DIR__ . '/../../events.json';
        $fp = fopen($path, 'w+');
        fwrite($fp, $jsonString);
        fclose($fp);
    }

    public function save(array $event, $key) {
        $repository = new EventRepository();
        $jsonData = $repository->findAll();


        $jsonData[$key] = $event;

        $this->saveAll($jsonData);
    }

    public function add(Event $event) {
        $repository = new EventRepository();
        $jsonData = $repository->findAll();


        $jsonData[] = [
            "Eventname" => $event->getEventName(),
            "Datum" => $event->getDatum(),
            "Eventbeschreibung" => $event->getEventbeschreibung(),
            "Maxpersonen" => $event->getMaxpersonen(),
            "Personen" => 0,
            "JoinedUsers" => [],
            "id" => $event->getId()
        ];

        $this->saveAll($jsonData);
    }
}