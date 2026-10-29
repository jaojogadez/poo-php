<?php
declare(strict_types=1);

final class Produto
{
    private string $codigo;
    private string $nome;
    private float $preco;

    public function __construct(string $codigo, string $nome, float $preco)
    {
        $codigo = trim($codigo);
        $nome = trim($nome);

        if ($codigo === '') {
            throw new InvalidArgumentException('O código do produto não pode ser vazio.');
        }
        if ($nome === '') {
            throw new InvalidArgumentException('O nome do produto não pode ser vazio.');
        }
        if ($preco < 0) {
            throw new InvalidArgumentException('O preço não pode ser negativo.');
        }

        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->preco = $preco;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }
}