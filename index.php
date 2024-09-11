<?php

require 'vendor/autoload.php';

require_once 'Player.php';
require_once 'TenisMatch.php';
require_once 'Tournament.php';

use Slim\Factory\AppFactory;


$pdo = new PDO('mysql:host=db;dbname=tenis_db', 'tenis_user', 'tenis_password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response, $args) {
    $response->getBody()->write("Bienvenidos al torneo de tenis");
    return $response;
});

$app->post('/tournament', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    $type = $data['type'];
    if (!in_array($type, ['M', 'F'])) {
        $response->getBody()->write('EL tipo de torneo solo puede ser F o M y hemos recibido:'. $type);
        return $response->withStatus(400);
    }

    global $pdo;

    $statement = $pdo->query("SELECT * FROM players WHERE gender = '".$type."'");
    $players = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    $playerObjects = [];
    foreach ($players as $player) {
        $playerObjects[] = new Player($player['id'], $player['name'], $player['gender'], $player['skill'], $player['strength'], $player['speed'], $player['reaction_time']);
    }
    
    $n = count($playerObjects);
    $powerOfTwo = 1;
    while ($powerOfTwo * 2 <= $n) {
        $powerOfTwo *= 2;
    }
    
    $randomKeys = array_rand($playerObjects, $powerOfTwo);

    $randomPlayers = [];
    foreach ($randomKeys as $key) {
        $randomPlayers[] = $playerObjects[$key];
    }    

    $tournament = new Tournament($randomPlayers, $type);
    $winner = $tournament->runTournament();

    $winnerId = $winner->getId();
    $stmt = $pdo->prepare("INSERT INTO tournaments (type, winner_id) VALUES (?, ?)");
    $stmt->execute([$type, $winnerId]);


    $responseData = [
        'tournamentId' => $pdo->lastInsertId(),
        'winner' => $winner->getName()];

    $response->getBody()->write(json_encode($responseData));
    return $response->withHeader('Content-Type', 'application/json');

});

$app->get('/tournament/{id}', function ($request, $response, $args) {
    global $pdo;
    
    $id = $args['id'];

    $stmt = $pdo->prepare("SELECT t.id, t.type, t.dateTournament, p.name AS winner_name 
                           FROM tournaments t 
                           LEFT JOIN players p ON t.winner_id = p.id 
                           WHERE t.id = ?");
    $stmt->execute([$id]);
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tournament) {
        $responseData = [
            'tournamentId' => $tournament['id'],
            'date' => $tournament['dateTournament'],
            'type' => $tournament['type'],
            'winner' => $tournament['winner_name']
        ];
        
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'No encontramos el torneo']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
});


$app->run();
