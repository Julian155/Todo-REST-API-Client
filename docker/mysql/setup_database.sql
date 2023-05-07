CREATE DATABASE IF NOT EXISTS parking_lot;

use parking_lot;

CREATE TABLE IF NOT EXISTS parking_spot (
    id INT PRIMARY KEY AUTO_INCREMENT,
    is_reserved CHAR(1)
);

CREATE TABLE IF NOT EXISTS long_term_parker(
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    last_name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS parker(
    id INT PRIMARY KEY AUTO_INCREMENT,
    license_plate VARCHAR(8),
    fk_long_term_parker INT,
    FOREIGN KEY (fk_long_term_parker) REFERENCES long_term_parker(id)
);

CREATE TABLE IF NOT EXISTS status(
    id INT PRIMARY KEY AUTO_INCREMENT,
    arrived_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    fk_parking_spot INT,
    FOREIGN KEY (fk_parking_spot) REFERENCES parking_spot(id),
    fk_parker INT,
    FOREIGN KEY (fk_parker) REFERENCES parker(id)
);

CREATE TABLE IF NOT EXISTS payment(
    id INT PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(4,2),
    payed CHAR(1),
    fk_long_term_parker INT,
    FOREIGN KEY (fk_long_term_parker) REFERENCES long_term_parker(id)
);

CREATE TABLE IF NOT EXISTS departure(
    id INT PRIMARY KEY AUTO_INCREMENT,
    license_plate VARCHAR(8),
    arrived_at DATETIME NOT NULL,
    departured_at DATETIME NOT NULL,
    fk_payment INT NOT NULL,
    FOREIGN KEY (fk_payment) REFERENCES payment(id)
);



