<?php
declare(strict_types=1);

require_once __DIR__ . '/Estudante.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function relatorio(Estudante $e): void
{
    $ac = $e->getAcompanhamento();
    echo "{$e->getNome()} (RA {$e->getRa()}) - {$ac->getDisciplina()} ({$ac->getCargaHoraria()}h)" . PHP_EOL;
    foreach ($ac->getAtividades() as $a) {
        $nota = $a->foiAvaliada() ? number_format($a->getNota(), 1, ',', '.') : 'sem nota';
        echo "  {$a->getTitulo()}: $nota / " . number_format($a->getValorMaximo(), 1, ',', '.') . PHP_EOL;
    }
    echo "  Desempenho: " . number_format($e->desempenho() * 100, 1, ',', '.') . "%" . PHP_EOL;
    $pend = array_map(fn(Atividade $a) => $a->getTitulo(), $e->atividadesNaoAvaliadas());
    echo "  Não avaliadas: " . ($pend === [] ? '(nenhuma)' : implode(', ', $pend)) . PHP_EOL;
}

echo "=== Ex10 - Cursos e Atividades Acadêmicas ===" . PHP_EOL;

$aluno = new Estudante('Marina', '2024001', new Acompanhamento('Programação Orientada a Objetos', 80));

echo "Sem atividades:" . PHP_EOL;
relatorio($aluno);

$ac = $aluno->getAcompanhamento();
$ac->adicionarAtividade(new Atividade('Lista 1', 10.0));
$ac->adicionarAtividade(new Atividade('Prova 1', 30.0));
$ac->adicionarAtividade(new Atividade('Projeto', 20.0));

echo PHP_EOL . "Atividades cadastradas, sem notas:" . PHP_EOL;
relatorio($aluno);

$ac->registrarNota('Lista 1', 8.0);
$ac->registrarNota('Prova 1', 24.0);

echo PHP_EOL . "Após correção parcial:" . PHP_EOL;
relatorio($aluno);

echo PHP_EOL . "--- Situações inválidas ---" . PHP_EOL;
tentar('Atividade com título duplicado', fn() => $ac->adicionarAtividade(new Atividade('lista 1', 5.0)));
tentar('Nota acima do máximo', fn() => $ac->registrarNota('Projeto', 25.0));
tentar('Nota negativa', fn() => $ac->registrarNota('Projeto', -1.0));
tentar('Nota em atividade inexistente', fn() => $ac->registrarNota('Seminário', 5.0));
tentar('Atividade com valor máximo zero', fn() => new Atividade('Zerada', 0.0));
tentar('Acompanhamento com carga horária inválida', fn() => new Acompanhamento('Física', 0));