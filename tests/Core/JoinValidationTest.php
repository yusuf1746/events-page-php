<?php declare(strict_types=1);

use App\Core\View;
use PHPUnit\Framework\TestCase;
use App\Controller\HomeController;
use App\Core\JoinValidation;

class JoinValidationTest extends TestCase {

    public function testJoinEventIsInvalidWhenJoiningTheSameEvent() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 1"
            ],
            "id" => 42451
        ];

        $outputEvent = $joinValidation->manageJoinEvent($event, true, 'Account 1', true);

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 1"
            ],
            "id" => 42451,
            "eventStatus" => 1
            
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testJoinEventIsValidWhenJoinNotJoinedEvent() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ],
            "id" => 52324
        ];

        $outputEvent = $joinValidation->manageJoinEvent($event, true, 'Account 1', true);

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 1"
            ],
            "id" => 52324,
            "eventStatus" => 1
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testJoinEventIsInvalidWhenNotJoining() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ]
        ];

        $outputEvent = $joinValidation->manageJoinEvent($event, true, 'Account 1', false);

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ],
            "eventStatus" => 2
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testJoinEventIsInvalidWhenNotloggedIn() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ]
        ];

        $outputEvent = $joinValidation->manageJoinEvent($event, false, 'Account 1', false);

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ],
            "eventStatus" => 2
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testJoinEventIsInvalidWhenNoSeatLeft() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 3"
            ]
        ];

        $outputEvent = $joinValidation->manageJoinEvent($event, true, 'Account 1', false);

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 3"
            ],
            "eventStatus" => 0
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testleaveEventIsValid() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 3"
            ]
        ];

        $outputEvent = $joinValidation->manageLeaveEvent($event, true, 'Account 3');

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 1,
            "JoinedUsers" => [
                "Account 2"
            ],
            "eventStatus" => 2
        ];

        $this->assertSame($outputEvent, $event2);
    }

    public function testleaveEventIsInvalidWhenNotLoggedIn() {
        $joinValidation = new JoinValidation();
        
        $event = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 3"
            ]
        ];

        $outputEvent = $joinValidation->manageLeaveEvent($event, false, 'Account 3');

        $event2 = [
            "Eventname" => "EVENT",
            "Datum" => "2024-11-28",
            "Eventbeschreibung" => "asdsdasdasdasd",
            "Maxpersonen" => 2,
            "Personen" => 2,
            "JoinedUsers" => [
                "Account 2",
                "Account 3"
            ]
        ];


        $this->assertSame($outputEvent, $event2);
    }

}