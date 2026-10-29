<?php
declare(strict_types=1);

final class Equipamento
{
    private string $nome;
    private float $peso;
    private int $valor;

    public function __construct(string $nome, float $peso, int $valor)
    {
        $nome = trim($nome);

        if ($nome === '') {
            throw new InvalidArgumentException('O nome do equipamento não pode ser vazio.');
        }
        if ($peso < 0) {
            throw new InvalidArgumentException('O peso não pode ser negativo.');
        }
        if ($valor < 0) {
            throw new InvalidArgumentException('O valor não pode ser negativo.');
        }

        $this->nome = $nome;
        $this->peso = $peso;
        $this->valor = $valor;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function getValor(): int
    {
        return $this->valor;
    }
}