<?php 

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Usuario;

echo "<h1>Exercício 01</h1>";
echo "<p>Servidor local funcionando.</p>";
echo "<p>PSR-4 configurado com sucesso!</p>";

$usuario = new Usuario("João");
echo $usuario->saudar();
