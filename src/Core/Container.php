<?php

declare(strict_types=1);

namespace App\Core;

class Container
{
    private array $objects = [];

    public function add(string $name, object $object): void
    {
        $this->objects[$name] = $object;
    }

    public function get(string $name): object
    {
        return $this->objects[$name];
    }
}
