<?php
declare(strict_types=1);

final class Missao
{
    private string $titulo;
    private string $descricao;
    private int $recompensa;
    private bool $concluida = false;

    public function __construct(string $titulo, string $descricao, int $recompensa)
    {
        $titulo = trim($titulo);
        $descricao = trim($descricao);

        if ($titulo === '') {
            throw new InvalidArgumentException('O título da missão não pode ser vazio.');
        }
        if ($descricao === '') {
            throw new InvalidArgumentException('A descrição da missão não pode ser vazia.');
        }
        if ($recompensa < 0) {
            throw new InvalidArgumentException('A recompensa não pode ser negativa.');
        }

        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->recompensa = $recompensa;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getRecompensa(): int
    {
        return $this->recompensa;
    }

    public function estaConcluida(): bool
    {
        return $this->concluida;
    }

    public function concluir(): void
    {
        if ($this->concluida) {
            throw new DomainException("A missão '{$this->titulo}' já foi concluída.");
        }
        $this->concluida = true;
    }
}