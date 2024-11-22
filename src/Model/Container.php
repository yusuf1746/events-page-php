<?php declare(strict_types=1);

namespace App\model;

class Container {

    protected $data = [];

    public function add($key, $data) {
        $this->data[$key] = $data;
    }

    public function getData($key) {
        return $this->data[$key];

    }
}