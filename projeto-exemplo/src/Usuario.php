<?php

declare(strict_types=1);

namespace App;

class Usuario 
{
    public function __construct(
        private string $nome 
    ) {}

    public function saudar() : string 
    {
        return "Olá, {$this->nome}! O autoload via PSR-4 funcionou perfeitamente";
    }
}