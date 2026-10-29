<?php
declare(strict_types=1);

require_once __DIR__ . '/Time.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

echo "=== Ex02 - Escalação de um Time ===" . PHP_EOL;

$time = new Time('Atlético POO');
$time->cadastrarJogador(new Jogador('Carlos', 1, 'Goleiro'));
$time->cadastrarJogador(new Jogador('Bruno', 4, 'Zagueiro'));
$time->cadastrarJogador(new Jogador('Diego', 10, 'Meia'));

echo "Escalação do {$time->getNome()}:" . PHP_EOL;
foreach ($time->getEscalacao() as $j) {
    echo "  #{$j->getNumeroCamisa()} {$j->getNome()} ({$j->getPosicao()})" . PHP_EOL;
}
echo "Quantidade de jogadores: {$time->quantidadeJogadores()}" . PHP_EOL;

$achado = $time->buscarPorNumero(10);
echo "Camisa 10: " . ($achado ? $achado->getNome() : 'não encontrado') . PHP_EOL;
$naoAchado = $time->buscarPorNumero(77);
echo "Camisa 77: " . ($naoAchado ? $naoAchado->getNome() : 'não encontrado') . PHP_EOL . PHP_EOL;

echo "--- Situações inválidas ---" . PHP_EOL;
tentar('Camisa repetida (10)', fn() => $time->cadastrarJogador(new Jogador('Eduardo', 10, 'Atacante')));
tentar('Camisa fora do intervalo (0)', fn() => new Jogador('Fábio', 0, 'Lateral'));
tentar('Jogador sem nome', fn() => new Jogador('', 9, 'Atacante'));
tentar('Jogador sem posição', fn() => new Jogador('Gabriel', 9, ''));
echo "Quantidade final: {$time->quantidadeJogadores()}" . PHP_EOL;