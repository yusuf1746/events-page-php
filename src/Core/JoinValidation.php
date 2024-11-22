<?php declare(strict_types=1);

namespace App\Core;

class JoinValidation {
    public function manageJoinEvent(array $event, bool $loggedIn, string $userName, bool $tryingToJoin) {
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
                    break;
                }
                else {
                    $event["eventStatus"] = 2;
                    break;
                }
            }
        }
        return $event;
    }

    public function manageleaveEvent(array $event, bool $loggedIn, string $userName) {
        $JoinedUsers = $event["JoinedUsers"];
        if(!$loggedIn || !isset($userName)) {
            return $event;
        }
        foreach($JoinedUsers as $key => $person) {
            if($person === $userName) {
                $event["Personen"]--;
                unset($event["JoinedUsers"][$key]);
                    
                $event["eventStatus"] = 2;
                break;
            }
        }
        return $event;
    }
}

