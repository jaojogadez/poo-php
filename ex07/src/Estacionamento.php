<?php
declare(strict_types=1);

require_once __DIR__ . '/Veiculo.php';

final class Estacionamento
{
    private int $capacidade;
    /** @var array<string, Veiculo> indexado pela placa */
    private array $veiculos = [];

    public function __construct(int $capacidade)
    {
        if ($capacidade < 1) {
            throw new InvalidArgumentException('A capacidade deve ser de pelo menos 1 vaga.');
        }
        $this->capacidade = $capacidade;
    }

    public function registrarEntrada(Veiculo $veiculo): void
    {
        if (isset($this->veiculos[$veiculo->getPlaca()])) {
            throw new DomainException("O veículo de placa {$veiculo->getPlaca()} já está no estacionamento.");
        }
        if ($this->vagasLivres() === 0) {
            throw new DomainException('Estacionamento lotado.');
        }
        $this->veiculos[$veiculo->getPlaca()] = $veiculo;
    }

    public function registrarSaida(string $placa): Veiculo
    {
        $placa = Veiculo::normalizarPlaca($placa);
        if (!isset($this->veiculos[$placa])) {
            throw new DomainException("Nenhum veículo registrado com a placa $placa.");
        }
        $veiculo = $this->veiculos[$placa];
        unset($this->veiculos[$placa]);
        return $veiculo;
    }

    public function buscarPorPlaca(string $placa): ?Veiculo
    {
        return $this->veiculos[Veiculo::normalizarPlaca($placa)] ?? null;
    }

    public function vagasLivres(): int
    {
        return $this->capacidade - count($this->veiculos);
    }

    public function getCapacidade(): int
    {
        return $this->capacidade;
    }

    /** @return Veiculo[] */
    public function getVeiculos(): array
    {
        return array_values($this->veiculos);
    }
}