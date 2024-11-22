<?php declare(strict_types=1);

use App\Core\View;
use PHPUnit\Framework\TestCase;
use App\Controller\DetailedEventController;
use App\Model\event;

class DetailedEventControllerTest extends TestCase {

    public function testReturnWhenNoEventsFound(): void {
        $view = new View();
        $DetailedEventController = new DetailedEventController($view);

        $_SESSION['loggedIn'] = false;

        $data = $view->getData('event.twig');

        $this->assertNull($data['loggedIn']);
    }

    public function testManageLeaveEvent(): void {

        $_SESSION['loggedIn'] = false;

        $_POST['Logout'] = true;

        $view = new View();
        $DetailedEventController = new DetailedEventController($view);

        $data = $view->getData('event.twig');

        $this->assertNull($data['loggedIn']);
    }

}