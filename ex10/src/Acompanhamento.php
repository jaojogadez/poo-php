<?php
declare(strict_types=1);

require_once __DIR__ . '/Atividade.php';

final class Acompanhamento
{
    private string $disciplina;
    private int $cargaHoraria;
    /** @var array<string, Atividade> indexado pelo título (minúsculo) */
    private array $atividades = [];

    public function __construct(string $disciplina, int $cargaHoraria)
    {
        $disciplina = trim($disciplina);

        if ($disciplina === '') {
            throw new InvalidArgumentException('O nome da disciplina não pode ser vazio.');
        }
        if ($cargaHoraria <= 0) {
            throw new InvalidArgumentException('A carga horária deve ser maior que zero.');
        }

        $this->disciplina = $disciplina;
        $this->cargaHoraria = $cargaHoraria;
    }

    public function getDisciplina(): string
    {
        return $this->disciplina;
    }

    public function getCargaHoraria(): int
    {
        return $this->cargaHoraria;
    }

    public function adicionarAtividade(Atividade $atividade): void
    {
        $chave = mb_strtolower($atividade->getTitulo());
        if (isset($this->atividades[$chave])) {
            throw new DomainException("Já existe uma atividade chamada '{$atividade->getTitulo()}'.");
        }
        $this->atividades[$chave] = $atividade;
    }

    public function registrarNota(string $titulo, float $nota): void
    {
        $chave = mb_strtolower(trim($titulo));
        if (!isset($this->atividades[$chave])) {
            throw new DomainException("Atividade '$titulo' não encontrada.");
        }
        $this->atividades[$chave]->registrarNota($nota);
    }

    /** @return Atividade[] */
    public function getAtividades(): array
    {
        return array_values($this->atividades);
    }

    /** @return Atividade[] */
    public function getNaoAvaliadas(): array
    {
        return array_values(array_filter(
            $this->atividades,
            fn(Atividade $a) => !$a->foiAvaliada()
        ));
    }

    /** Razão entre pontos obtidos e pontos máximos (0.0 a 1.0). */
    public function desempenho(): float
    {
        $obtido = 0.0;
        $maximo = 0.0;
        foreach ($this->atividades as $a) {
            $obtido += $a->getNota() ?? 0.0;
            $maximo += $a->getValorMaximo();
        }
        if ($maximo === 0.0) {
            return 0.0;
        }
        return $obtido / $maximo;
    }
}