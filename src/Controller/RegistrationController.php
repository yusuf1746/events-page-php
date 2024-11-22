<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\UserEntityManager;
use App\Model\UserRepository;
use App\Model\User;
use App\Core\Viewinterface;

session_start();

class RegistrationController {

    public function __construct(protected ViewInterface $templateEngine) {
        $userRepository = new UserRepository();
        $userEntityManager = new UserEntityManager();

        $nameError = "";
        $emailError = "";
        $passwortError = "";
        $passwort2Error = "";
        
        if(isset($_POST["Register"])) {
            $name = $_POST["BenutzerName"] ?? "";
            $email = $_POST["Email"] ?? "";
            $passwort = $_POST["Passwort"] ?? "";
            $passwort2 = $_POST["Passwort2"] ?? "";
        
            if($userRepository->findByUsername($name) !== false) $nameError = "* Diese Benutzer Name wurde bereits genommen.";
            if($userRepository->findByEmail($email) !== false) $emailError = "* Diese Email wurde bereits genommen.";
        
            if(strlen(trim($name)) < 3) $nameError = "* Benutzer Name darf nicht kürzer als 3 Zeichen sein.";
            if(strlen(trim($name)) > 16) $nameError = "* Benutzer Name darf nicht länger als 16 Zeichen sein.";
            if(empty($name)) $nameError = "* Benutzer Name ist gebraucht.";
        
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailError = "* Email ist flasch.";
            if(empty($email)) $emailError = "* Email ist gebraucht.";
        
            $lowerCase = '/[a-z]/';
            $upperCase = '/[A-Z]/';
            $nummer = '/[0-9]/';
            $characteren = '/[^A-Za-z0-9]/';
            
            if($passwort !== trim($passwort)) $passwortError = "* Passwort darf keine Lehrzeichen behalten.";
            if(!preg_match($lowerCase, $passwort)) $passwortError = "* Passwort muss mindestens ein Kleinbuchstabe behalten.";
            if(!preg_match($upperCase, $passwort)) $passwortError = "* Passwort muss mindestens ein Großbuchstabe behalten.";
            if(!preg_match($nummer, $passwort)) $passwortError = "* Passwort muss mindestens eine Nummer behalten.";
            if(!preg_match($characteren, $passwort)) $passwortError = "* Passwort muss mindestens eine Special Charater behalten.";
            if(!strlen($passwort) >= 8 || empty($passwort)) $passwortError = "* Passwort muss eine mindestlänge von 8 haben.";
        
            if($passwort !== $passwort2) $passwort2Error = "* Passwörtern sind nicht gleich.";
            
            if($nameError === "" && $emailError === "" && $passwortError === "" && $passwort2Error === "") {
                $user = new User(
                    $_POST["BenutzerName"], 
                    $_POST["Email"], 
                    password_hash($_POST["Passwort"], PASSWORD_DEFAULT)
                );
            
                $userEntityManager->save($user);
            
                session_regenerate_id();
                $_SESSION['userName'] = $_POST["BenutzerName"];
                $_SESSION['loggedIn'] = true;
            
                header('Location: index.php');
                exit;
            }
        }
        
        $data = [
            'nameError' => $nameError ?? "",
            'emailError' => $emailError ?? "",
            'passwortError' => $passwortError ?? "",
            'passwort2Error' => $passwort2Error ?? ""
        ];

        $templateEngine->addParameter('registration.twig', $data);
    }

}