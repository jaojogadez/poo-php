<?php
declare(strict_types=1);

require_once __DIR__ . '/Mochila.php';

final class Aventureiro
{
    private string $nome;
    private int $pontosVida;
    private Mochila $mochila;

    public function __construct(string $nome, int $pontosVida, Mochila $mochila)
    {
        $nome = trim($nome);

        if ($nome === '') {
            throw new InvalidArgumentException('O nome do aventureiro não pode ser vazio.');
        }
        if ($pontosVida < 0) {
            throw new InvalidArgumentException('Os pontos de vida não podem ser negativos.');
        }

        $this->nome = $nome;
        $this->pontosVida = $pontosVida;
        $this->mochila = $mochila;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPontosVida(): int
    {
        return $this->pontosVida;
    }

    /** Retorna true se coletou; false se não havia espaço. */
    public function coletar(Equipamento $equipamento): bool
    {
        if (!$this->mochila->comporta($equipamento)) {
            return false;
        }
        $this->mochila->adicionar($equipamento);
        return true;
    }

    public function descartar(string $nome): Equipamento
    {
        return $this->mochila->remover($nome);
    }

    /** @return Equipamento[] */
    public function equipamentosCarregados(): array
    {
        return $this->mochila->getEquipamentos();
    }

    public function pesoOcupado(): float
    {
        return $this->mochila->pesoOcupado();
    }

    public function espacoRestante(): float
    {
        return $this->mochila->espacoRestante();
    }

    public function valorTotal(): int
    {
        return $this->mochila->valorTotal();
    }
}