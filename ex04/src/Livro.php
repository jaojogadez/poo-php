<?php
declare(strict_types=1);

final class Livro
{
    private string $titulo;
    private string $autor;
    private string $isbn;
    private bool $disponivel = true;

    public function __construct(string $titulo, string $autor, string $isbn)
    {
        $titulo = trim($titulo);
        $autor = trim($autor);
        $isbn = trim($isbn);

        if ($titulo === '' || $autor === '' || $isbn === '') {
            throw new InvalidArgumentException('Título, autor e ISBN são obrigatórios.');
        }

        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function estaDisponivel(): bool
    {
        return $this->disponivel;
    }

    public function emprestar(): void
    {
        if (!$this->disponivel) {
            throw new DomainException("O livro '{$this->titulo}' já está emprestado.");
        }
        $this->disponivel = false;
    }

    public function devolver(): void
    {
        if ($this->disponivel) {
            throw new DomainException("O livro '{$this->titulo}' não está emprestado.");
        }
        $this->disponivel = true;
    }
}