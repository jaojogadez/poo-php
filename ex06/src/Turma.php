<?php
declare(strict_types=1);

require_once __DIR__ . '/Estudante.php';

final class Turma
{
    private const NOTA_MINIMA = 6.0;

    private string $identificacao;
    private int $capacidadeMaxima;
    /** @var array<string, Estudante> indexado pelo RA */
    private array $estudantes = [];

    public function __construct(string $identificacao, int $capacidadeMaxima)
    {
        $identificacao = trim($identificacao);
        if ($identificacao === '') {
            throw new InvalidArgumentException('A identificação da turma não pode ser vazia.');
        }
        if ($capacidadeMaxima < 1) {
            throw new InvalidArgumentException('A capacidade máxima deve ser de pelo menos 1.');
        }

        $this->identificacao = $identificacao;
        $this->capacidadeMaxima = $capacidadeMaxima;
    }

    public function getIdentificacao(): string
    {
        return $this->identificacao;
    }

    public function getCapacidadeMaxima(): int
    {
        return $this->capacidadeMaxima;
    }

    public function matricular(Estudante $estudante): void
    {
        if (isset($this->estudantes[$estudante->getRa()])) {
            throw new DomainException("O RA {$estudante->getRa()} já está matriculado.");
        }
        if (count($this->estudantes) >= $this->capacidadeMaxima) {
            throw new DomainException("A turma {$this->identificacao} está lotada.");
        }
        $this->estudantes[$estudante->getRa()] = $estudante;
    }

    /** @return Estudante[] */
    public function getEstudantes(): array
    {
        return array_values($this->estudantes);
    }

    public function quantidadeMatriculados(): int
    {
        return count($this->estudantes);
    }

    public function mediaGeral(): float
    {
        if ($this->estudantes === []) {
            return 0.0;
        }
        $soma = 0.0;
        foreach ($this->estudantes as $e) {
            $soma += $e->getNotaFinal();
        }
        return $soma / count($this->estudantes);
    }

    public function totalAprovados(): int
    {
        $total = 0;
        foreach ($this->estudantes as $e) {
            if ($e->estaAprovado(self::NOTA_MINIMA)) {
                $total++;
            }
        }
        return $total;
    }
}