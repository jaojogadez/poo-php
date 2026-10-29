<?php
declare(strict_types=1);

require_once __DIR__ . '/RegistroMissoes.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function listar(string $rotulo, array $missoes): void
{
    echo "$rotulo:" . PHP_EOL;
    if ($missoes === []) {
        echo "  (nenhuma)" . PHP_EOL;
    }
    foreach ($missoes as $m) {
        $s = $m->estaConcluida() ? 'concluída' : 'pendente';
        echo "  {$m->getTitulo()} - {$m->getRecompensa()} moedas ($s)" . PHP_EOL;
    }
}

echo "=== Ex05 - Missões de RPG ===" . PHP_EOL;

$r = new RegistroMissoes();
$r->disponibilizar(new Missao('Caça ao Dragão', 'Derrote o dragão da montanha.', 500));
$r->disponibilizar(new Missao('Entrega de Cartas', 'Leve as cartas até a vila.', 50));
$r->disponibilizar(new Missao('Poção Rara', 'Colete 5 ervas raras.', 120));

listar('Todas as missões', $r->getMissoes());
echo "Moedas de missões concluídas (nenhuma concluída): {$r->totalMoedasConcluidas()}" . PHP_EOL . PHP_EOL;

echo "--- Conclusões ---" . PHP_EOL;
tentar('Concluir Entrega de Cartas', fn() => $r->concluir('Entrega de Cartas'));
tentar('Concluir Entrega de Cartas novamente', fn() => $r->concluir('Entrega de Cartas'));
tentar('Concluir missão inexistente', fn() => $r->concluir('Missão Fantasma'));
tentar('Cadastrar missão duplicada', fn() => $r->disponibilizar(new Missao('Poção Rara', 'Outra descrição.', 10)));
tentar('Missão com recompensa negativa', fn() => new Missao('Azarada', 'Descrição.', -10));
$r->concluir('Caça ao Dragão');

echo PHP_EOL;
listar('Pendentes', $r->getPendentes());
echo "Total de moedas das concluídas: {$r->totalMoedasConcluidas()}" . PHP_EOL;