<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\EventValidation;
use App\Model\event;

class EventValidationTest extends TestCase {
   
    public function testEventValidation() {
        $eventValidation = new EventValidation();

        $event = new Event(
            "EVENT",
            "2026-11-21",
            "BESCHREIBUNG",
            5,
            rand(10000, 99999)
        );

        $this->assertTrue($eventValidation->isValidEvent($event));

        $event = new Event(
            "E",
            "2026.11.21",
            "1234",
            -1,
            rand(10000, 99999)
        );

        $this->assertFalse($eventValidation->isValidEvent($event));
    }

    public function testEventNameIsValid() {
        $event = new EventValidation();

        $valids = [
            "12345",
            "1234",
            "the quick brown fox",
            "H  A  L  L  O",
            "ツ⫷☠♛ꐡ♔.!"
        ];

        foreach($valids as $valid) {
            $this->assertEmpty($event->getEventnameError($valid));
        }

    }

    public function testEventNameIsNotValidWhenIsTooShort() {
        $event = new EventValidation();

        $tooShorts = [
            "12          ",
            "             ",
            "                          a",
            "123",
            " "
        ];

        foreach($tooShorts as $tooShort) {
            $this->assertSame($event->getEventnameError($tooShort), "* Eventname muss mehr als 3 Zeichen behalten.");
        }
    }

    public function testEventNameIsNotValidWhenIsNotSet() {
        $event = new EventValidation();

        $this->assertSame($event->getEventnameError(""), "* Eventname ist lehr.");
        $this->assertSame($event->getEventnameError(null), "* Eventname ist lehr.");
    }

    public function testEventNameIsNotValidWhenIsTooLong() {
        $event = new EventValidation();

        $this->assertSame($event->getEventnameError("the quick brown fox jumps over the lazy dog."), "* Eventname darf nicht mehr als 40 Zeichen sein.");
        $this->assertSame($event->getEventnameError("H           A           L          L          O"), "* Eventname darf nicht mehr als 40 Zeichen sein.");
    }

    public function testEventDatumIsValid() {
        $event = new EventValidation();

        //20y-m-d

        $this->assertSame($event->getDatumError("2029-05-25"), "");
        $this->assertSame($event->getDatumError("2029-10-20"), "");
    }

    public function testEventDateIsNotValidWhenIsTypedWrong() {
        $event = new EventValidation();
        
        $this->assertSame($event->getDatumError("2026-04-31"), "* datum ist entweder falsch oder benutzt die voreingestellte format nicht.");
        $this->assertSame($event->getDatumError("20-06-2024"), "* datum ist entweder falsch oder benutzt die voreingestellte format nicht.");
        $this->assertSame($event->getDatumError("2025.06.20"), "* datum ist falsch geschrieben.");
    }

    public function testEventDateIsNotValidWhenIsInPast() {
        $event = new EventValidation();
        
        $this->assertSame($event->getDatumError("2024-01-20"), "* Datum ist in vergangen heit");
        $this->assertSame($event->getDatumError("2024-06-30"), "* Datum ist in vergangen heit");
        $this->assertSame($event->getDatumError("2023-12-26"), "* Datum ist in vergangen heit");
    }

    public function testEventDateIsNotValidWhenIsNotSet() {
        $event = new EventValidation();

        $this->assertSame($event->getDatumError(null), "* Datum ist lehr.");
        $this->assertSame($event->getDatumError(""), "* Datum ist lehr.");
        $this->assertSame($event->getDatumError("      "), "* datum ist entweder falsch oder benutzt die voreingestellte format nicht.");
    }

    public function testEventDescIsValid(){
        $event = new EventValidation();

        $Valids = [
            "the quick brown fox jumps over the lazy dog.",
            "1234567",
            "123456",
            "ツツツツツツ",
            "ツ⫷☠♛ꐡ♔.!\"§$%&/()=?\/²³{[]}´^"
        ];
        
        foreach($Valids as $Valid) {
            $this->assertEmpty($event->getBeschreibungError($Valid));
        }
        
    }

    public function testEventDescIsNotValidWhenIsTooShort(){
        $event = new EventValidation();

        $tooShorts = [
            "   1234   ",
            "12345",
            "12           ",
            "               "
        ];

        foreach($tooShorts as $tooShort) {
            $this->assertSame($event->getBeschreibungError($tooShort), "* Eventbeschreibung muss mehr als 5 Zeichen behalten");
        }

    }

    public function testEventDescIsNotValidWhenIsNotSet(){
        $event = new EventValidation();

        $this->assertSame($event->getBeschreibungError(""), "* Eventbeschreibung ist lehr.");
        $this->assertSame($event->getBeschreibungError(null), "* Eventbeschreibung ist lehr.");

    }


    public function testEventMaxPeoplIsValid() {
        $event = new EventValidation();

        $ValidInts = [
            5,
            3,
            1
        ];

        foreach($ValidInts as $int) {
            $this->assertEmpty($event->getMaxpersonenError($int));
        }

    }

    public function testEventMaxPeoplIsNotValidWhenIsNotInt() {
        $event = new EventValidation();

        $NotInt = [
            "5",
            "      ",
            true,
            false,
            null,
            [[]],
            'ツ'
        ];

        foreach($NotInt as $notint) {
            $this->assertSame($event->getMaxpersonenError($notint), "* Maximale Anzahl von Personen darf nicht eine zeichen behalten.");
        }
    }

    public function testEventMaxPeoplIsNotValidWhenTooLow() {
        $event = new EventValidation();

        $Ints = [
            0,
            -1,
            -2147483648,
            -001
        ];

        foreach($Ints as $int) {
            $this->assertSame($event->getMaxpersonenError($int), "* Maximale Anzahl von Personen muss größer oder gleich wie 1 sein.");
        }
    }

}
