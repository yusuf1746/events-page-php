<?php declare(strict_types=1);

namespace App\Core;

interface Viewinterface {

    public function addParameter(string $key, mixed $value): void;

    public function display(string $template): void;

    //public function render(string $dir, array $data = []);
    
}