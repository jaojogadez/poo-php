<?php
declare(strict_types=1);

final class Atividade
{
    private string $titulo;
    private float $valorMaximo;
    private ?float $nota = null;

    public function __construct(string $titulo, float $valorMaximo)
    {
        $titulo = trim($titulo);

        if ($titulo === '') {
            throw new InvalidArgumentException('O título da atividade não pode ser vazio.');
        }
        if ($valorMaximo <= 0) {
            throw new InvalidArgumentException('O valor máximo deve ser maior que zero.');
        }

        $this->titulo = $titulo;
        $this->valorMaximo = $valorMaximo;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getValorMaximo(): float
    {
        return $this->valorMaximo;
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function foiAvaliada(): bool
    {
        return $this->nota !== null;
    }

    public function registrarNota(float $nota): void
    {
        if ($nota < 0 || $nota > $this->valorMaximo) {
            throw new InvalidArgumentException(
                "A nota deve estar entre 0 e {$this->valorMaximo} para '{$this->titulo}'."
            );
        }
        $this->nota = $nota;
    }
}