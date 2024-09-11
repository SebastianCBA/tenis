<?php
class TenisMatch {
    private $player1;
    private $player2;
    private $winner;

    public function __construct(Player $player1, Player $player2) {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->winner = $this->determineWinner();
    }

    private function determineWinner() {
        $performance1 = $this->player1->calculatePerformance();
        $performance2 = $this->player2->calculatePerformance();
        $posibilities = $performance1 + $performance2;
        $winner = rand(1, $posibilities);
        return $winner >= $performance1 ? $this->player1 : $this->player2;
    }

    public function getWinner() {
        return $this->winner;
    }

    public function getPlayers() {
        return [$this->player1, $this->player2];
    }
}
