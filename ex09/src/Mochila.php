<?php
declare(strict_types=1);

require_once __DIR__ . '/Equipamento.php';

final class Mochila
{
    private float $capacidadeMaxima;
    /** @var Equipamento[] */
    private array $equipamentos = [];

    public function __construct(float $capacidadeMaxima)
    {
        if ($capacidadeMaxima <= 0) {
            throw new InvalidArgumentException('A capacidade da mochila deve ser maior que zero.');
        }
        $this->capacidadeMaxima = $capacidadeMaxima;
    }

    public function getCapacidadeMaxima(): float
    {
        return $this->capacidadeMaxima;
    }

    public function pesoOcupado(): float
    {
        $peso = 0.0;
        foreach ($this->equipamentos as $e) {
            $peso += $e->getPeso();
        }
        return $peso;
    }

    public function espacoRestante(): float
    {
        return $this->capacidadeMaxima - $this->pesoOcupado();
    }

    public function valorTotal(): int
    {
        $total = 0;
        foreach ($this->equipamentos as $e) {
            $total += $e->getValor();
        }
        return $total;
    }

    public function comporta(Equipamento $equipamento): bool
    {
        return $equipamento->getPeso() <= $this->espacoRestante();
    }

    public function adicionar(Equipamento $equipamento): void
    {
        if (!$this->comporta($equipamento)) {
            throw new DomainException(
                "Sem espaço para '{$equipamento->getNome()}' (peso {$equipamento->getPeso()}, restante {$this->espacoRestante()})."
            );
        }
        $this->equipamentos[] = $equipamento;
    }

    public function remover(string $nome): Equipamento
    {
        foreach ($this->equipamentos as $indice => $e) {
            if (mb_strtolower($e->getNome()) === mb_strtolower(trim($nome))) {
                unset($this->equipamentos[$indice]);
                $this->equipamentos = array_values($this->equipamentos);
                return $e;
            }
        }
        throw new DomainException("Não existe '$nome' na mochila.");
    }

    /** @return Equipamento[] */
    public function getEquipamentos(): array
    {
        return $this->equipamentos;
    }
}