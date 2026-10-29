<?php
declare(strict_types=1);

require_once __DIR__ . '/Pergunta.php';

final class Questionario
{
    private string $titulo;
    /** @var Pergunta[] */
    private array $perguntas = [];

    public function __construct(string $titulo)
    {
        $titulo = trim($titulo);
        if ($titulo === '') {
            throw new InvalidArgumentException('O título não pode ser vazio.');
        }
        $this->titulo = $titulo;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function adicionarPergunta(Pergunta $pergunta): void
    {
        $this->perguntas[] = $pergunta;
    }

    /** @return Pergunta[] cópia do array, na ordem de inclusão */
    public function getPerguntas(): array
    {
        return $this->perguntas;
    }

    public function totalPerguntas(): int
    {
        return count($this->perguntas);
    }
}