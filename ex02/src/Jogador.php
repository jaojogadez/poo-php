<?php
declare(strict_types=1);

final class Jogador
{
    private string $nome;
    private int $numeroCamisa;
    private string $posicao;

    public function __construct(string $nome, int $numeroCamisa, string $posicao)
    {
        $nome = trim($nome);
        $posicao = trim($posicao);

        if ($nome === '') {
            throw new InvalidArgumentException('O nome do jogador não pode ser vazio.');
        }
        if ($numeroCamisa < 1 || $numeroCamisa > 99) {
            throw new InvalidArgumentException('O número da camisa deve estar entre 1 e 99.');
        }
        if ($posicao === '') {
            throw new InvalidArgumentException('A posição não pode ser vazia.');
        }

        $this->nome = $nome;
        $this->numeroCamisa = $numeroCamisa;
        $this->posicao = $posicao;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getNumeroCamisa(): int
    {
        return $this->numeroCamisa;
    }

    public function getPosicao(): string
    {
        return $this->posicao;
    }
}