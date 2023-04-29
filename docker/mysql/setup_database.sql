CREATE DATABASE IF NOT EXISTS Parkhaus;

use Parkhaus;

CREATE TABLE IF NOT EXISTS Parkplatz (
    ID INT PRIMARY KEY,
    Reserviert CHAR(1)
);

CREATE TABLE IF NOT EXISTS Dauerparker(
    ID INT PRIMARY KEY,
    Vorname VARCHAR(255),
    Nachname VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Parker(
    ID INT PRIMARY KEY,
    Kennzeichen VARCHAR(8),
    Dauerparker_ID int,
    FOREIGN KEY (Dauerparker_ID) REFERENCES Dauerparker(ID)
);

CREATE TABLE IF NOT EXISTS Status(
    ID INT PRIMARY KEY,
    Einfahrtzeit DATETIME,
    Ausfahrtzeit DATETIME,
    Parkplatz_ID int,
    FOREIGN KEY (Parkplatz_ID) REFERENCES Parkplatz(ID),
    Parker_ID int,
    FOREIGN KEY (Parker_ID) REFERENCES Parker(ID)
);

CREATE TABLE IF NOT EXISTS Logs(
    ID INT PRIMARY KEY,
    Kennzeichen VARCHAR(8),
    Dauerparker_ID int,
    FOREIGN KEY (Dauerparker_ID) REFERENCES Dauerparker(ID),
    Einfahrtzeit DATETIME,
    Ausfahrtzeit DATETIME,
    Bezahlt BOOLEAN
);
