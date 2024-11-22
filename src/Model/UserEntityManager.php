<?php declare(strict_types=1);

namespace App\Model;

class UserEntityManager {
    public function save(User $user) {
        $userRepository = new UserRepository();
        $jsonData = $userRepository->findAll();
        $path = __DIR__ . '/../../users.json';
        $jsonUsers = [];

        $userArray = [
            "Name" => $user->getName(),
            "Email" => $user->getEmail(),
            "HashedPasswort" => $user->getHashedPassword()
        ];

        for($i = 0; $i < count($jsonData)+1; $i++) {
            if(key_exists($i, $jsonData)) {
                $jsonUsers[$i] = $jsonData[$i];
            } else {
                $jsonUsers[$i] = $userArray;
                break;
            }
        }

        $jsonString = json_encode($jsonUsers, JSON_PRETTY_PRINT);
        $fp = fopen($path, 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
    }
}