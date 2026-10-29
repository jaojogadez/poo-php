<?php
declare(strict_types=1);

require_once __DIR__ . '/Aventureiro.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function status(Aventureiro $a): void
{
    echo "  Itens: ";
    $nomes = array_map(fn(Equipamento $e) => $e->getNome(), $a->equipamentosCarregados());
    echo ($nomes === [] ? '(vazia)' : implode(', ', $nomes)) . PHP_EOL;
    echo "  Peso ocupado: {$a->pesoOcupado()} | Espaço restante: {$a->espacoRestante()} | Valor total: {$a->valorTotal()} moedas" . PHP_EOL;
}

echo "=== Ex09 - Aventureiro e Inventário ===" . PHP_EOL;

$heroi = new Aventureiro('Aragorn', 100, new Mochila(20.0));
echo "{$heroi->getNome()} (vida {$heroi->getPontosVida()}) - mochila vazia:" . PHP_EOL;
status($heroi);

echo PHP_EOL . "--- Coleta ---" . PHP_EOL;
$itens = [
    new Equipamento('Espada', 8.0, 150),
    new Equipamento('Escudo', 7.0, 120),
    new Equipamento('Tocha', 1.5, 5),
    new Equipamento('Armadura Pesada', 15.0, 500),
];
foreach ($itens as $item) {
    $ok = $heroi->coletar($item);
    echo ($ok ? '[coletado] ' : '[sem espaço] ') . $item->getNome() . PHP_EOL;
}
status($heroi);

echo PHP_EOL . "--- Descarte ---" . PHP_EOL;
tentar('Descartar Escudo', fn() => $heroi->descartar('Escudo'));
tentar('Descartar Escudo de novo (inexistente)', fn() => $heroi->descartar('Escudo'));
status($heroi);

echo PHP_EOL . "Tentando coletar a Armadura Pesada novamente: "
    . ($heroi->coletar($itens[3]) ? 'coletada' : 'sem espaço') . PHP_EOL;

echo PHP_EOL . "--- Situações inválidas ---" . PHP_EOL;
tentar('Equipamento com peso negativo', fn() => new Equipamento('Pena', -1.0, 1));
tentar('Equipamento com valor negativo', fn() => new Equipamento('Pedra', 1.0, -1));
tentar('Mochila com capacidade zero', fn() => new Mochila(0));
tentar('Aventureiro com vida negativa', fn() => new Aventureiro('Zumbi', -5, new Mochila(5.0)));