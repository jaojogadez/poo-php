<?php
declare(strict_types=1);

final class Estudante
{
    private string $nome;
    private string $ra;
    private float $notaFinal;

    public function __construct(string $nome, string $ra, float $notaFinal)
    {
        $nome = trim($nome);
        $ra = trim($ra);

        if ($nome === '') {
            throw new InvalidArgumentException('O nome do estudante não pode ser vazio.');
        }
        if ($ra === '') {
            throw new InvalidArgumentException('O RA não pode ser vazio.');
        }
        if ($notaFinal < 0 || $notaFinal > 10) {
            throw new InvalidArgumentException('A nota final deve estar entre 0 e 10.');
        }

        $this->nome = $nome;
        $this->ra = $ra;
        $this->notaFinal = $notaFinal;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getRa(): string
    {
        return $this->ra;
    }

    public function getNotaFinal(): float
    {
        return $this->notaFinal;
    }

    public function estaAprovado(float $notaMinima = 6.0): bool
    {
        return $this->notaFinal >= $notaMinima;
    }
}