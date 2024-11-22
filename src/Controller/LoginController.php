<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\UserRepository;
use App\Core\Viewinterface;

session_start();

class LoginController {

    public function __construct(protected ViewInterface $templateEngine) {
        $emailError = '';
        $passwortError = '';
        
        if(isset($_POST["Login"])) {
            $email = $_POST["Email"] ?? "";
            $passwort = $_POST["Passwort"] ?? "";
        
            if(empty(trim($passwort))) $passwortError = "* Passwort ist lehr.";
            if(empty(trim($email))) $emailError = "* Email ist lehr.";
        
            $userRepository = new UserRepository();
        
            $user = $userRepository->findByEmail($email);
        
            if($user !== false) {
                if(password_verify($passwort, $user["HashedPasswort"])) {
                    session_regenerate_id();
                    $_SESSION['userName'] = $user["Name"];
                    $_SESSION['loggedIn'] = true;
                } else {
                    $passwortError = "* Falsche passwort.";
                }
            } else {
                $emailError = "* Falsche email!";
            }
        }
        
        $data = [
            'emailError' => $emailError ?? '',
            'passwortError' => $passwortError ?? '',
        ];

        $templateEngine->addParameter('login.twig', $data);
        
        if(isset($_POST["Login"]) && $emailError === '' && $passwortError === '') {
            header('Location: index.php');
            exit;
        }   
    }
}