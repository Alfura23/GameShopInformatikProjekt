CREATE TABLE GameStudio 
(
    GID         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    GameStudioName        VARCHAR(255) NOT NULL,
    Adresse    VARCHAR(255) NOT NULL,
    Postleitzahl INT NOT NULL,
    Stadt VARCHAR(255),
    Ansprechpartner_Vorname VARCHAR (255) NOT NULL,
    Ansprechpartner_Nachname VARCHAR (255) NOT NULL,
    Telefonnummer INT NOT NULL,
    EMailAdresse VARCHAR(255),
    Passwort VARCHAR(255) NOT NULL
);

CREATE TABLE Game
(
    Spielname     VARCHAR(255) PRIMARY KEY,
    GameVersion  FLOAT NOT NULL,
    Preis    FLOAT,
    ReleaseDate Date,
    Bildname VARCHAR(255),
    Genre VARCHAR(255),
    FSK INT, 
    DownloadSizeGB Float,
    GameStudio INT,
    FOREIGN KEY (GameStudio) REFERENCES GameStudio(GID)
);

CREATE TABLE GameShopUser
(
    Username VARCHAR(255) PRIMARY KEY,
    EMailAdresse VARCHAR(255) NOT NULL,
    Passwort VARCHAR(255) NOT NULL,
    Geburtsdatum Date NOT NULL
);

CREATE TABLE Review
(
    RID         INT PRIMARY KEY,
    Score       INT,
    ReviewText        VARCHAR(511),
    Spielname        VARCHAR(255) NOT NULL,
    FOREIGN KEY (Spielname) REFERENCES Game(Spielname),
    Username VARCHAR(255) NOT NULL,
    FOREIGN KEY (Username) REFERENCES GameShopUser(Username)
);


CREATE TABLE entwickelt
(
    Spielname VARCHAR(255),
    GameStudio INT,
    FOREIGN KEY (Spielname) REFERENCES Game(Spielname),
    FOREIGN KEY (GameStudio) REFERENCES GameStudio(GID)
);

CREATE TABLE besitzt
(
    Username VARCHAR(255),
    Game VARCHAR(255),
    FOREIGN KEY (Username) REFERENCES GameShopUser(Username),
    FOREIGN KEY (Game) REFERENCES Game(Spielname)
);

-- Demo data for GameStudio
INSERT INTO GameStudio (GameStudioName, Adresse, Postleitzahl, Stadt, Ansprechpartner_Vorname, Ansprechpartner_Nachname, Telefonnummer, EMailAdresse, Passwort)
VALUES
    ('PixelForge Studios', 'Kreativstraße 12', 10115, 'Berlin', 'Maja', 'Klein', 304555101, 'kontakt@pixelforge.de', 'passwort123'),
    ('Skyward Interactive', 'Himmelsweg 7', 80331, 'München', 'Lukas', 'Schneider', 305555202, 'info@skyward-interactive.de', 'skyward456'),
    ('Horizon Labs', 'Innovationsring 24', 20095, 'Hamburg', 'Nina', 'Becker', 304555303, 'hello@horizonlabs.de', 'horizon789'),
    ('Odyssey Entertainment', 'Spielgasse 9', 50667, 'Köln', 'Jonas', 'Fischer', 304555404, 'support@odyssey-entertainment.de', 'odyssey987');

-- Demo data for GameShopUser
INSERT INTO GameShopUser (Username, EMailAdresse, Passwort, Geburtsdatum)
VALUES
    ('alice', 'alice@example.com', 'alicepass', '1995-04-12'),
    ('bob', 'bob@example.com', 'bobpass', '1990-08-23'),
    ('charlie', 'charlie@example.com', 'charliepass', '1988-12-03');

-- Demo data for Game
INSERT INTO Game (Spielname, GameVersion, Preis, ReleaseDate, Bildname, Genre, FSK, DownloadSizeGB, GameStudio)
VALUES
    ('Minecraft', 1.20, 26.95, '2011-11-18', 'minecraft.png', 'Sandbox', 6, 1.0, 1),
    ('Hogwarts Legacy', 1.05, 59.99, '2023-02-10', 'hogwarts-legacy.png', 'Action-Adventure', 12, 85.0, 2),
    ('Elden Ring', 1.15, 49.99, '2022-02-25', 'eldenring.png', 'RPG', 16, 58.0, 3),
    ('Portal 2', 2.80, 19.99, '2011-04-18', 'portal2.png', 'Puzzle', 12, 8.0, 4),
    ('The Legend of Zelda: Breath of the Wild', 1.01, 59.99, '2017-03-03', 'the-legend-of-zelda-botw.png', 'Adventure', 6, 13.4, 1),
    ('Cyberpunk 2077', 2.05, 39.99, '2020-12-10', 'cyberpunk-2077.png', 'RPG', 18, 70.0, 2),
    ('Hollow Knight', 1.29, 14.99, '2017-02-24', 'hollow-knight.png', 'Metroidvania', 12, 9.5, 3),
    ('GTA V', 1.55, 29.99, '2013-09-17', 'gta5.png', 'Action', 18, 80.0, 4);

-- Demo data for Review
INSERT INTO Review (RID, Score, ReviewText, Spielname, Username)
VALUES
    (1, 9, 'Unglaublich kreatives Sandbox-Erlebnis, perfekt zum Bauen und Erkunden.', 'Minecraft', 'alice'),
    (2, 8, 'Die Welt und Story sind super, auch wenn es noch kleine Bugs gibt.', 'Hogwarts Legacy', 'bob'),
    (3, 10, 'Ein Meisterwerk. Die offene Welt ist atemberaubend und herausfordernd.', 'Elden Ring', 'charlie'),
    (4, 9, 'Geniales Leveldesign und perfektes Rätsel-Gameplay.', 'Portal 2', 'alice'),
    (5, 10, 'Zeitloses Abenteuer mit wunderschöner Atmosphäre.', 'The Legend of Zelda: Breath of the Wild', 'bob'),
    (6, 7, 'Visuell stark, aber die Politur könnte besser sein.', 'Cyberpunk 2077', 'charlie'),
    (7, 9, 'Atmosphärisch stark und tolles Gameplay.', 'Hollow Knight', 'alice'),
    (8, 8, 'Offene Welt, Action und Story funktionieren sehr gut.', 'GTA V', 'bob');

-- Demo relations for entwickelt and besitzt
INSERT INTO entwickelt (Spielname, GameStudio)
VALUES
    ('Minecraft', 1),
    ('Hogwarts Legacy', 2),
    ('Elden Ring', 3),
    ('Portal 2', 4),
    ('The Legend of Zelda: Breath of the Wild', 1),
    ('Cyberpunk 2077', 2),
    ('Hollow Knight', 3),
    ('GTA V', 4);

INSERT INTO besitzt (Username, Game)
VALUES
    ('alice', 'Minecraft'),
    ('alice', 'Portal 2'),
    ('bob', 'Hogwarts Legacy'),
    ('bob', 'The Legend of Zelda: Breath of the Wild'),
    ('charlie', 'Elden Ring');
