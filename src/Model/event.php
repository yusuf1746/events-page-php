<?php declare(strict_types=1);

namespace App\Model;

class event  {
    public static function Event(string $Eventname, string $Datum, string $Eventbeschreibung, int $Maxpersonen, int $id) {
        return new self(
            $Eventname,
            $Datum,
            $Eventbeschreibung,
            $Maxpersonen,
            $id
        );
    }
    public function __construct(
        private string $Eventname,
        private string $Datum,
        private string $Eventbeschreibung,
        private int $Maxpersonen,
        private int $id
    ) {}
    public function getEventName() {
        return $this->Eventname;
    }
    public function getDatum() {
        return $this->Datum;
    }
    public function getEventbeschreibung() {
        return $this->Eventbeschreibung;
    }
    public function getMaxpersonen() {
        return $this->Maxpersonen;
    }
    public function getId() {
        return $this->id;
    }
}