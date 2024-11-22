<?php declare(strict_types=1);

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View implements ViewInterface {
    private $twig;
    private $data;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function addParameter(string $key, mixed $value): void {
        $this->data[$key] = $value;
    }

    public function display(string $template): void {
        echo $this->twig->render($template, $this->data[$template]);
    }

    public function getData($key) {
        return $this->data[$key];
    }

    /*public function render(string $dir, array $data = []): string {
        return $this->twig->render($dir, $data);
    }*/
}