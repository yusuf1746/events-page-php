<?php declare(strict_types=1);

namespace App\Core;

use App\Model\Event;

class EventValidation {
    public function getEventnameError($eventname) {
        $eventnameError = "";

        if(is_string($eventname)) {
            if(strlen(trim($eventname)) <= 3) $eventnameError = "* Eventname muss mehr als 3 Zeichen behalten.";
            if(strlen(trim($eventname)) > 40) $eventnameError = "* Eventname darf nicht mehr als 40 Zeichen sein.";
        }
        else {
            $eventnameError = "* Eventname musst eine text sein.";
        }
        if(empty($eventname)) $eventnameError = "* Eventname ist lehr.";

        return $eventnameError ?? "";
    }

    public function getDatumError($datum) {
        $datumError = "";
        
        if(date("20y-m-d") > $datum) $datumError = "* Datum ist in vergangen heit";
        if(empty($datum)) $datumError = "* Datum ist lehr.";
        else {
            $time = strtotime($datum);
            if(!$time) $datumError = "* datum ist falsch geschrieben.";
            else {
                $CorrectDate = date('Y-m-d', $time);
                if($datum !== $CorrectDate) $datumError = "* datum ist entweder falsch oder benutzt die voreingestellte format nicht.";
            }
        }

        return $datumError ?? "";
    }

    public function getBeschreibungError($beschreibung) {
        $beschreibungError = "";
        if(is_string($beschreibung)) {
            if(strlen(trim($beschreibung)) <= 5) $beschreibungError = "* Eventbeschreibung muss mehr als 5 Zeichen behalten";
        }
        else {
            $beschreibungError = "* Eventbeschreibung musst eine text sein.";
        }
        if(empty($beschreibung)) $beschreibungError = "* Eventbeschreibung ist lehr.";

        return $beschreibungError ?? "";
    }

    public function getMaxpersonenError($maxpersonen) {
        $maxpersonenError = "";

        if(is_int($maxpersonen)) {
            if(empty($maxpersonen)) $maxpersonenError = "* Maximale Anzahl von Personen ist lehr.";
            if($maxpersonen < 1) $maxpersonenError = "* Maximale Anzahl von Personen muss größer oder gleich wie 1 sein.";
            if($maxpersonen > 100) $maxpersonenError = "* Maximale Anzahl von Personen darf nicht mehr als 100 sein.";
        } else {
            $maxpersonenError = "* Maximale Anzahl von Personen darf nicht eine zeichen behalten.";
        }

        return $maxpersonenError ?? "";
    }

    public function isValidEvent(Event $event) {
        //$validation = new EventValidation();

        if($this->getEventnameError($event->getEventName()) === "" 
            && $this->getDatumError($event->getDatum()) === "" 
            && $this->getBeschreibungError($event->getEventbeschreibung()) === "" 
            && $this->getMaxpersonenError($event->getMaxpersonen()) === ""
        ) {
            return true;
        } else {
            return false;
        }
    }

}