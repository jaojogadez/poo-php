<?php
declare(strict_types=1);

final class Pergunta
{
    private string $enunciado;
    private string $respostaEsperada;

    public function __construct(string $enunciado, string $respostaEsperada)
    {
        $enunciado = trim($enunciado);
        $respostaEsperada = trim($respostaEsperada);

        if ($enunciado === '') {
            throw new InvalidArgumentException('O enunciado não pode ser vazio.');
        }
        if ($respostaEsperada === '') {
            throw new InvalidArgumentException('A resposta esperada não pode ser vazia.');
        }

        $this->enunciado = $enunciado;
        $this->respostaEsperada = $respostaEsperada;
    }

    public function getEnunciado(): string
    {
        return $this->enunciado;
    }

    public function getRespostaEsperada(): string
    {
        return $this->respostaEsperada;
    }
}