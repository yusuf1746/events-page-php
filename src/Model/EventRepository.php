<?php declare(strict_types=1);

namespace App\Model;

class EventRepository {
    public function findAll(): array {
        $path =  __DIR__ . '/../../events.json';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        
        return $jsonData;
    }
    public function findById(int $findId, bool $ReturnKey) {
        $events = $this->findAll();

        foreach($events as $key => ["id" => $id]) {
            if($findId == $id) {
                if($ReturnKey) {
                    return $key;
                } else {
                    return $events[$key];
                }
            }
        }
    }
}