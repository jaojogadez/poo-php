<?php
declare(strict_types=1);

require_once __DIR__ . '/Livro.php';

final class Biblioteca
{
    /** @var array<string, Livro> indexado pelo ISBN */
    private array $catalogo = [];

    public function cadastrar(Livro $livro): void
    {
        $isbn = $livro->getIsbn();
        if (isset($this->catalogo[$isbn])) {
            throw new DomainException("Já existe um livro cadastrado com o ISBN $isbn.");
        }
        $this->catalogo[$isbn] = $livro;
    }

    /** @return Livro[] */
    public function getCatalogo(): array
    {
        return array_values($this->catalogo);
    }

    public function buscar(string $isbn): Livro
    {
        if (!isset($this->catalogo[$isbn])) {
            throw new DomainException("Livro com ISBN $isbn não encontrado.");
        }
        return $this->catalogo[$isbn];
    }

    public function emprestar(string $isbn): void
    {
        $this->buscar($isbn)->emprestar();
    }

    public function devolver(string $isbn): void
    {
        $this->buscar($isbn)->devolver();
    }
}