<?php
declare(strict_types=1);

require_once __DIR__ . '/Carrinho.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function moeda(float $v): string
{
    return 'R$ ' . number_format($v, 2, ',', '.');
}

function listar(Carrinho $c): void
{
    if ($c->quantidadeItens() === 0) {
        echo "  (carrinho vazio)" . PHP_EOL;
    }
    foreach ($c->getItens() as $p) {
        echo "  [{$p->getCodigo()}] {$p->getNome()} - " . moeda($p->getPreco()) . PHP_EOL;
    }
    echo "  Total: " . moeda($c->total()) . PHP_EOL;
}

echo "=== Ex03 - Carrinho de Compras ===" . PHP_EOL;

$carrinho = new Carrinho();
echo "Carrinho vazio:" . PHP_EOL;
listar($carrinho);

$teclado = new Produto('P001', 'Teclado', 150.00);
$mouse = new Produto('P002', 'Mouse', 80.50);
$monitor = new Produto('P003', 'Monitor', 900.00);

$carrinho->adicionar($teclado);
$carrinho->adicionar($mouse);
$carrinho->adicionar($monitor);
echo PHP_EOL . "Após adicionar 3 produtos:" . PHP_EOL;
listar($carrinho);

echo PHP_EOL . "--- Situações inválidas ---" . PHP_EOL;
tentar('Adicionar o mesmo produto novamente', fn() => $carrinho->adicionar($mouse));
tentar('Produto com preço negativo', fn() => new Produto('P999', 'Defeituoso', -5.0));
tentar('Remover produto inexistente', fn() => $carrinho->remover('P404'));

echo PHP_EOL . "--- Remoção ---" . PHP_EOL;
$carrinho->remover('P003');
listar($carrinho);