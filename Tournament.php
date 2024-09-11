<?php
class Tournament {
    private $players;
    private $gender;

    public function __construct(array $players, $gender) {
        $this->players = $players;
        $this->gender = $gender;
    }

    public function runTournament() {
        $rounds = [];

        // Verificamos que la cantidad de jugadores sea una potencia de 2
        if (log(count($this->players), 2) != intval(log(count($this->players), 2))) {
            throw new Exception('La cantidad de jugadores debe ser una potencia de 2.');
        }

        $players = $this->players;

        $rounds[] = $players; // Primera ronda
        // Continuamos organizando las rondas hasta que quede un ganador
        while (count($players) > 1) {
            $players = $this->playRound($players);
            $rounds[] = $players;
        }
        // Retornamos el ganador final
        return $players[0];
    }

    // Simular una ronda de partidos
    private function playRound(array $players) {
        $winners = [];
        // Emparejamos jugadores de 2 en 2
        if (count($players) > 1) {
            for ($i = 0; $i < count($players); $i += 2) {
                if (isset($players[$i]) && isset($players[$i + 1])) {
                    $match = new TenisMatch($players[$i], $players[$i + 1]);
                    $winners[] = $match->getWinner();
                }
            }
        }    
        return $winners;
    }

    public function getGender() {
        return $this->gender;
    }    
}
