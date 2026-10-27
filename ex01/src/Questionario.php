<?php

declare(strict_types=1);

namespace App;

class Questionario 
{
    public function __construct(
        private string $titulo,
        private array $perguntas = []
    ) {}
}