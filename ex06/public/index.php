<?php
declare(strict_types=1);

require_once __DIR__ . '/Turma.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

echo "=== Ex06 - Turmas Acadêmicas ===" . PHP_EOL;

$turma = new Turma('POO-2026-A', 3);
echo "Turma vazia -> média: " . number_format($turma->mediaGeral(), 2, ',', '.')
    . " | aprovados: {$turma->totalAprovados()}" . PHP_EOL . PHP_EOL;

$turma->matricular(new Estudante('Ana', '1001', 8.5));
$turma->matricular(new Estudante('Bruno', '1002', 5.5));
$turma->matricular(new Estudante('Carla', '1003', 6.0));

echo "Estudantes matriculados ({$turma->quantidadeMatriculados()}/{$turma->getCapacidadeMaxima()}):" . PHP_EOL;
foreach ($turma->getEstudantes() as $e) {
    echo "  RA {$e->getRa()} - {$e->getNome()} - nota " . number_format($e->getNotaFinal(), 1, ',', '.') . PHP_EOL;
}
echo "Média geral: " . number_format($turma->mediaGeral(), 2, ',', '.') . PHP_EOL;
echo "Aprovados (nota >= 6,0): {$turma->totalAprovados()}" . PHP_EOL . PHP_EOL;

echo "--- Situações inválidas ---" . PHP_EOL;
tentar('Matricular RA repetido', fn() => $turma->matricular(new Estudante('Ana Clone', '1001', 7.0)));
tentar('Matricular com turma lotada', fn() => $turma->matricular(new Estudante('Diego', '1004', 9.0)));
tentar('Nota maior que 10', fn() => new Estudante('Eva', '1005', 10.5));
tentar('Nota negativa', fn() => new Estudante('Fábio', '1006', -1.0));
tentar('Turma com capacidade zero', fn() => new Turma('X', 0));