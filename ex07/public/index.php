<?php
declare(strict_types=1);

require_once __DIR__ . '/Estacionamento.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

echo "=== Ex07 - Controle de Estacionamento ===" . PHP_EOL;

$e = new Estacionamento(2);
echo "Vagas livres: {$e->vagasLivres()}/{$e->getCapacidade()}" . PHP_EOL . PHP_EOL;

tentar('Entrada ABC-1234', fn() => $e->registrarEntrada(new Veiculo('ABC-1234', 'Gol', 'Maria')));
tentar('Entrada XYZ9A87', fn() => $e->registrarEntrada(new Veiculo('XYZ9A87', 'Onix', 'João')));
echo "Vagas livres: {$e->vagasLivres()}" . PHP_EOL . PHP_EOL;

echo "--- Situações inválidas ---" . PHP_EOL;
tentar('Entrada com placa repetida', fn() => $e->registrarEntrada(new Veiculo('abc1234', 'Palio', 'Pedro')));
tentar('Entrada com estacionamento lotado', fn() => $e->registrarEntrada(new Veiculo('KKK0000', 'Uno', 'Ana')));
tentar('Saída de placa inexistente', fn() => $e->registrarSaida('ZZZ9999'));
tentar('Veículo sem modelo', fn() => new Veiculo('AAA1111', '', 'Fulano'));

echo PHP_EOL . "--- Busca ---" . PHP_EOL;
$v = $e->buscarPorPlaca('xyz9a87');
echo "Placa XYZ9A87: " . ($v ? "{$v->getModelo()} de {$v->getProprietario()}" : 'não encontrado') . PHP_EOL;
$v = $e->buscarPorPlaca('NAO0000');
echo "Placa NAO0000: " . ($v ? $v->getModelo() : 'não encontrado') . PHP_EOL;

echo PHP_EOL . "--- Saída ---" . PHP_EOL;
tentar('Saída ABC-1234', fn() => $e->registrarSaida('ABC-1234'));
echo "Vagas livres: {$e->vagasLivres()}" . PHP_EOL;