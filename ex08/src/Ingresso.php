<?php
declare(strict_types=1);

final class Ingresso
{
    private string $espectador;
    private int $poltrona;
    private float $valorPago;

    public function __construct(string $espectador, int $poltrona, float $valorPago)
    {
        $espectador = trim($espectador);

        if ($espectador === '') {
            throw new InvalidArgumentException('O nome do espectador não pode ser vazio.');
        }
        if ($poltrona < 1) {
            throw new InvalidArgumentException('O número da poltrona deve ser positivo.');
        }
        if ($valorPago < 0) {
            throw new InvalidArgumentException('O valor pago não pode ser negativo.');
        }

        $this->espectador = $espectador;
        $this->poltrona = $poltrona;
        $this->valorPago = $valorPago;
    }

    public function getEspectador(): string
    {
        return $this->espectador;
    }

    public function getPoltrona(): int
    {
        return $this->poltrona;
    }

    public function getValorPago(): float
    {
        return $this->valorPago;
    }
}