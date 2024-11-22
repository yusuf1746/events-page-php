<?php declare(strict_types=1);

namespace App\Model;

class UserRepository {
    public function findByUsername(string $findName) {
        $jsonData = $this->findAll();
        
        foreach($jsonData as $userKey => ["Name" => $Name]) {
            if($findName === $Name) return $jsonData[$userKey];
        }
        return false;
    }
    
    public function findByEmail(string $findEmail) {
        $jsonData = $this->findAll();

        foreach($jsonData as $userKey => ["Email" => $Email]) {
            if($findEmail === $Email) {
                return $jsonData[$userKey];   
            }
        }
        return false;
    }
    public function findAll(): array {
        $path = __DIR__ . '/../../users.json';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);

        return $jsonData;
    }
}
