<?php

declare(strict_types=1);

namespace App;

class Pergunta 
{
    public function __construct(
        private string $enunciado,
        private string $resposta 
    ) {}

    public function getEnunciado() : string 
    {
        return $enunciado;
    }

    public function getResposta() : string
    {
        return $resposta;
    }
}