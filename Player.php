<?php
class Player {
    private $id;
    private $name;
    private $gender; // 'M' para masculino, 'F' para femenino
    private $skill;
    private $strength;
    private $speed;
    private $reactionTime;

    public function __construct($id, $name, $gender, $skill, $strength, $speed, $reactionTime) {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->skill = $skill;
        $this->strength = $strength;
        $this->speed = $speed;
        $this->reactionTime = $reactionTime;
    }

    public function getId() {
        return $this->id;
    }


    public function getName() {
        return $this->name;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getSkill() {
        return $this->skill;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getReactionTime() {
        return $this->reactionTime;
    }

    public function calculatePerformance() {
        if($this->gender == 'F')
            {
                return round($this->skill * 0.4 + $this->strength * 0.3 + $this->speed * 0.2 - $this->reactionTime * 0.1,0);
            }
            else
            {
                return round($this->skill * 0.5 + $this->strength * 0.3 + $this->speed * 0.2,0);
            }            
    }
}