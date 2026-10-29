<?php
declare(strict_types=1);

require_once __DIR__ . '/Jogador.php';

final class Time
{
    private string $nome;
    /** @var array<int, Jogador> indexado pelo número da camisa */
    private array $jogadores = [];

    public function __construct(string $nome)
    {
        $nome = trim($nome);
        if ($nome === '') {
            throw new InvalidArgumentException('O nome do time não pode ser vazio.');
        }
        $this->nome = $nome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function cadastrarJogador(Jogador $jogador): void
    {
        $numero = $jogador->getNumeroCamisa();
        if (isset($this->jogadores[$numero])) {
            throw new DomainException("A camisa $numero já está em uso por {$this->jogadores[$numero]->getNome()}.");
        }
        $this->jogadores[$numero] = $jogador;
    }

    /** @return Jogador[] */
    public function getEscalacao(): array
    {
        $copia = $this->jogadores;
        ksort($copia);
        return array_values($copia);
    }

    public function quantidadeJogadores(): int
    {
        return count($this->jogadores);
    }

    public function buscarPorNumero(int $numero): ?Jogador
    {
        return $this->jogadores[$numero] ?? null;
    }
}