<?php
$pdo = new PDO('mysql:host=tenis_db;dbname=tenis_db', 'tenis_user', 'tenis_password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function generateRandomName() {
    $firstNames = ['John', 'Jane', 'Alex', 'Chris', 'Katie', 'Laura', 'Mike', 'Sara'];
    $lastNames = ['Doe', 'Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller'];
    return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
}

for ($i = 0; $i < 30; $i++) {
    $stmt = $pdo->prepare("INSERT INTO players (name, gender, skill, strength, speed, reaction_time) VALUES (?, ?, ?, ?, ?, ?)");
    $name = generateRandomName();
    $gender = (rand(0, 1) === 0) ? 'M' : 'F';
    $skill = rand(1, 100);
    $strength = rand(1, 100);
    $speed = rand(1, 100);
    $reaction_time = rand(1, 100);

    $stmt->execute([$name, $gender, $skill, $strength, $speed, $reaction_time]);
}

echo "Jugadores Creados";
