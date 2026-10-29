<?php
declare(strict_types=1);

require_once __DIR__ . '/Acompanhamento.php';

final class Estudante
{
    private string $nome;
    private string $ra;
    private Acompanhamento $acompanhamento;

    public function __construct(string $nome, string $ra, Acompanhamento $acompanhamento)
    {
        $nome = trim($nome);
        $ra = trim($ra);

        if ($nome === '') {
            throw new InvalidArgumentException('O nome do estudante não pode ser vazio.');
        }
        if ($ra === '') {
            throw new InvalidArgumentException('O RA não pode ser vazio.');
        }

        $this->nome = $nome;
        $this->ra = $ra;
        $this->acompanhamento = $acompanhamento;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getRa(): string
    {
        return $this->ra;
    }

    public function getAcompanhamento(): Acompanhamento
    {
        return $this->acompanhamento;
    }

    public function desempenho(): float
    {
        return $this->acompanhamento->desempenho();
    }

    /** @return Atividade[] */
    public function atividadesNaoAvaliadas(): array
    {
        return $this->acompanhamento->getNaoAvaliadas();
    }
}