<?php
declare(strict_types=1);

require_once __DIR__ . '/Ingresso.php';

final class Sessao
{
    private string $filme;
    private int $totalPoltronas;
    /** @var array<int, Ingresso> indexado pelo número da poltrona */
    private array $ingressos = [];

    public function __construct(string $filme, int $totalPoltronas)
    {
        $filme = trim($filme);
        if ($filme === '') {
            throw new InvalidArgumentException('O nome do filme não pode ser vazio.');
        }
        if ($totalPoltronas < 1) {
            throw new InvalidArgumentException('A sessão precisa de pelo menos 1 poltrona.');
        }

        $this->filme = $filme;
        $this->totalPoltronas = $totalPoltronas;
    }

    public function getFilme(): string
    {
        return $this->filme;
    }

    public function getTotalPoltronas(): int
    {
        return $this->totalPoltronas;
    }

    public function venderIngresso(Ingresso $ingresso): void
    {
        $poltrona = $ingresso->getPoltrona();

        if ($poltrona > $this->totalPoltronas) {
            throw new DomainException("A poltrona $poltrona não existe (total: {$this->totalPoltronas}).");
        }
        if (isset($this->ingressos[$poltrona])) {
            throw new DomainException("A poltrona $poltrona já está ocupada.");
        }
        $this->ingressos[$poltrona] = $ingresso;
    }

    /** @return int[] números das poltronas ocupadas, em ordem */
    public function poltronasOcupadas(): array
    {
        $ocupadas = array_keys($this->ingressos);
        sort($ocupadas);
        return $ocupadas;
    }

    public function poltronasDisponiveis(): int
    {
        return $this->totalPoltronas - count($this->ingressos);
    }

    public function ingressosVendidos(): int
    {
        return count($this->ingressos);
    }

    public function arrecadacaoTotal(): float
    {
        $total = 0.0;
        foreach ($this->ingressos as $i) {
            $total += $i->getValorPago();
        }
        return $total;
    }
}