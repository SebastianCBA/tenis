<?php
// Incluir las clases necesarias
require_once 'Player.php';
require_once 'TenisMatch.php';
require_once 'Tournament.php';

// Aquí puedes crear jugadores manualmente o desde una fuente de datos externa
$players = [
    new Player("Roger Federer", "M", 90, 85, 88, 80),
    new Player("Rafael Nadal", "M", 89, 90, 86, 85),
    new Player("Serena Williams", "F", 92, 84, 87, 83),
    new Player("Maria Sharapova", "F", 85, 80, 84, 82),
    // ... más jugadores
];

// Ejecutar torneo masculino
$tournament = new Tournament($players, 'M');
$maleWinner = $tournament->runTournament();
echo "El ganador del torneo masculino es: " . $maleWinner->getName() . PHP_EOL;

// Ejecutar torneo femenino
$tournament = new Tournament($players, 'F');
$femaleWinner = $tournament->runTournament();
echo "La ganadora del torneo femenino es: " . $femaleWinner->getName() . PHP_EOL;
