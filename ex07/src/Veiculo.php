<?php
declare(strict_types=1);

final class Veiculo
{
    private string $placa;
    private string $modelo;
    private string $proprietario;

    public function __construct(string $placa, string $modelo, string $proprietario)
    {
        $placa = self::normalizarPlaca($placa);
        $modelo = trim($modelo);
        $proprietario = trim($proprietario);

        if ($placa === '') {
            throw new InvalidArgumentException('A placa não pode ser vazia.');
        }
        if ($modelo === '') {
            throw new InvalidArgumentException('O modelo não pode ser vazio.');
        }
        if ($proprietario === '') {
            throw new InvalidArgumentException('O nome do proprietário não pode ser vazio.');
        }

        $this->placa = $placa;
        $this->modelo = $modelo;
        $this->proprietario = $proprietario;
    }

    public static function normalizarPlaca(string $placa): string
    {
        return strtoupper(str_replace(['-', ' '], '', trim($placa)));
    }

    public function getPlaca(): string
    {
        return $this->placa;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getProprietario(): string
    {
        return $this->proprietario;
    }
}