<?php
declare(strict_types=1);

require_once __DIR__ . '/Sessao.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function resumo(Sessao $s): void
{
    $ocupadas = $s->poltronasOcupadas();
    echo "  Ocupadas: " . ($ocupadas === [] ? '(nenhuma)' : implode(', ', $ocupadas)) . PHP_EOL;
    echo "  Disponíveis: {$s->poltronasDisponiveis()} | Vendidos: {$s->ingressosVendidos()}" . PHP_EOL;
    echo "  Arrecadação: R$ " . number_format($s->arrecadacaoTotal(), 2, ',', '.') . PHP_EOL;
}

echo "=== Ex08 - Reservas de Cinema ===" . PHP_EOL;

$s = new Sessao('Interestelar', 5);
echo "Sessão recém-criada ({$s->getFilme()}):" . PHP_EOL;
resumo($s);

echo PHP_EOL . "--- Vendas ---" . PHP_EOL;
tentar('Vender poltrona 1 para Ana', fn() => $s->venderIngresso(new Ingresso('Ana', 1, 30.00)));
tentar('Vender poltrona 3 para Bruno', fn() => $s->venderIngresso(new Ingresso('Bruno', 3, 30.00)));
tentar('Vender poltrona 1 para Carla (ocupada)', fn() => $s->venderIngresso(new Ingresso('Carla', 1, 30.00)));
tentar('Vender poltrona 9 (inexistente)', fn() => $s->venderIngresso(new Ingresso('Diego', 9, 30.00)));
tentar('Vender poltrona 0', fn() => $s->venderIngresso(new Ingresso('Eva', 0, 30.00)));
tentar('Ingresso com valor negativo', fn() => new Ingresso('Fábio', 2, -10.0));
tentar('Ingresso sem nome', fn() => new Ingresso('', 2, 30.0));

echo PHP_EOL . "Situação final:" . PHP_EOL;
resumo($s);