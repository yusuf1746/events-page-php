<?php declare(strict_types=1);

namespace App\Model;

class user  {
    public static function User(string $Name, string $Email, string $HashedPassword) {
        return new self(
            $Name,
            $Email,
            $HashedPassword
        );
    }
    public function __construct(
        private string $Name,
        private string $Email,
        private string $HashedPassword
    ) {}
    public function getName() {
        return $this->Name;
    }
    public function getEmail() {
        return $this->Email;
    }
    public function getHashedPassword() {
        return $this->HashedPassword;
    }
}