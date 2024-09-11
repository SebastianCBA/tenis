CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('M', 'F') NOT NULL,
    skill INT NOT NULL,
    strength INT NOT NULL,
    speed INT NOT NULL,
    reaction_time INT NOT NULL
);

CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('M', 'F') NOT NULL,
    winner_id INT,
    dateTournament TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (winner_id) REFERENCES players(id)
);