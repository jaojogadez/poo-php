<?php
declare(strict_types=1);

require_once __DIR__ . '/Biblioteca.php';

function tentar(string $descricao, callable $acao): void
{
    try {
        $acao();
        echo "[permitido] $descricao" . PHP_EOL;
    } catch (Throwable $e) {
        echo "[bloqueado] $descricao -> " . $e->getMessage() . PHP_EOL;
    }
}

function catalogo(Biblioteca $b): void
{
    foreach ($b->getCatalogo() as $l) {
        $status = $l->estaDisponivel() ? 'disponível' : 'emprestado';
        echo "  {$l->getIsbn()} | {$l->getTitulo()} ({$l->getAutor()}) - $status" . PHP_EOL;
    }
}

echo "=== Ex04 - Biblioteca Universitária ===" . PHP_EOL;

$b = new Biblioteca();
$b->cadastrar(new Livro('Clean Code', 'Robert C. Martin', '9780132350884'));
$b->cadastrar(new Livro('Design Patterns', 'Erich Gamma', '9780201633610'));
$b->cadastrar(new Livro('Refactoring', 'Martin Fowler', '9780134757599'));

echo "Catálogo inicial:" . PHP_EOL;
catalogo($b);

echo PHP_EOL . "--- Empréstimos e devoluções ---" . PHP_EOL;
tentar('Emprestar Clean Code', fn() => $b->emprestar('9780132350884'));
tentar('Emprestar Clean Code de novo', fn() => $b->emprestar('9780132350884'));
tentar('Devolver Clean Code', fn() => $b->devolver('9780132350884'));
tentar('Devolver livro que já está disponível', fn() => $b->devolver('9780132350884'));
tentar('Emprestar ISBN inexistente', fn() => $b->emprestar('0000000000000'));
tentar('Cadastrar ISBN duplicado', fn() => $b->cadastrar(new Livro('Outro título', 'Outro autor', '9780201633610')));
tentar('Livro sem autor', fn() => new Livro('Sem autor', '', '123'));

$b->emprestar('9780134757599');
echo PHP_EOL . "Catálogo final:" . PHP_EOL;
catalogo($b);