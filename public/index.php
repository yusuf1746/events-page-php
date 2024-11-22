<?php declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\RegistrationController;
use App\Controller\DetailedEventController;
use App\Core\View;

require_once __DIR__ . '/../vendor/autoload.php';

if(!isset($_GET["page"]) && !isset($_GET["event"])) {
    $twig = new View();
    $HomeController = new HomeController($twig);
    echo $twig->display('home.twig');
    return;
}
if(isset($_GET["event"])) {
    $twig = new View();
    $event = new DetailedEventController($twig);

    echo $twig->display('event.twig');
    return;
}
if($_GET["page"] === "login") {
    $twig = new View();
    $login = new LoginController($twig);

    echo $twig->display('login.twig');
    return;
}
if($_GET["page"] === "registrierung") {
    $twig = new View();
    $register = new RegistrationController($twig);

    echo $twig->display('registration.twig');
    return;
}
if($_GET["page"] === "logout") {
    include __DIR__ .'/../src/Controller/LogoutController.php';
    return;
}