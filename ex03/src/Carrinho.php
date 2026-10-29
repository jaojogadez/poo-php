<?php
declare(strict_types=1);

require_once __DIR__ . '/Produto.php';

final class Carrinho
{
    /** @var array<string, Produto> indexado pelo código */
    private array $itens = [];

    public function adicionar(Produto $produto): void
    {
        $codigo = $produto->getCodigo();
        if (isset($this->itens[$codigo])) {
            throw new DomainException("O produto '{$produto->getNome()}' já está no carrinho.");
        }
        $this->itens[$codigo] = $produto;
    }

    public function remover(string $codigo): void
    {
        if (!isset($this->itens[$codigo])) {
            throw new DomainException("Nenhum produto com código '$codigo' no carrinho.");
        }
        unset($this->itens[$codigo]);
    }

    /** @return Produto[] */
    public function getItens(): array
    {
        return array_values($this->itens);
    }

    public function quantidadeItens(): int
    {
        return count($this->itens);
    }

    public function total(): float
    {
        $total = 0.0;
        foreach ($this->itens as $produto) {
            $total += $produto->getPreco();
        }
        return $total;
    }
}