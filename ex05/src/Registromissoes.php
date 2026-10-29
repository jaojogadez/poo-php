<?php
declare(strict_types=1);

require_once __DIR__ . '/Missao.php';

final class RegistroMissoes
{
    /** @var array<string, Missao> indexado pelo título (minúsculo) */
    private array $missoes = [];

    public function disponibilizar(Missao $missao): void
    {
        $chave = mb_strtolower($missao->getTitulo());
        if (isset($this->missoes[$chave])) {
            throw new DomainException("Já existe uma missão chamada '{$missao->getTitulo()}'.");
        }
        $this->missoes[$chave] = $missao;
    }

    public function concluir(string $titulo): void
    {
        $chave = mb_strtolower(trim($titulo));
        if (!isset($this->missoes[$chave])) {
            throw new DomainException("Missão '$titulo' não encontrada.");
        }
        $this->missoes[$chave]->concluir();
    }

    /** @return Missao[] */
    public function getMissoes(): array
    {
        return array_values($this->missoes);
    }

    /** @return Missao[] */
    public function getPendentes(): array
    {
        return array_values(array_filter(
            $this->missoes,
            fn(Missao $m) => !$m->estaConcluida()
        ));
    }

    public function totalMoedasConcluidas(): int
    {
        $total = 0;
        foreach ($this->missoes as $m) {
            if ($m->estaConcluida()) {
                $total += $m->getRecompensa();
            }
        }
        return $total;
    }
}