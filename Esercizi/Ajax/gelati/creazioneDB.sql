CREATE DATABASE gelati
USE gelati;

CREATE TABLE IF NOT EXISTS gelati (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nome            VARCHAR(100)  NOT NULL,
    data_produzione DATE          NOT NULL,
    data_scadenza   DATE          NOT NULL,
    quantita        INT           NOT NULL,
    produttore      VARCHAR(100)  NOT NULL
);

INSERT INTO gelati (nome, data_produzione, data_scadenza, quantita, produttore) VALUES
    ('gelato',                 '2026-03-11','2026-06-15',18,'luxardo'),
    ('yogurt',                 '2026-01-05','2026-04-12',14,'gourmet'),
    ('mandorla',               '2026-02-22','2026-05-28',10,'dolcevita'),
    ('frutto della passione',  '2026-01-30','2026-05-10', 7,'gelatoitalia'),
    ('pistacchio',             '2025-12-08','2026-03-05',13,'gelateriaartigiana'),
    ('cocco',                  '2026-02-17','2026-06-01', 9,'tropicagel'),
    ('banana',                 '2026-03-13','2026-06-18',12,'sunnyside'),
    ('zabaione',               '2026-01-02','2026-03-30',11,'dolcevita'),
    ('ricotta e fichi',        '2026-02-26','2026-05-15', 5,'gelateriaartigiana'),
    ('mango',                  '2026-01-19','2026-04-24', 8,'gelatoitalia'),
    ('cacao',                  '2025-11-07','2026-02-20',16,'chocolat'),
    ('lamponi',                '2026-02-14','2026-05-22', 7,'gelatoitalia'),
    ('cannella',               '2025-12-28','2026-03-10', 9,'spicesgel'),
    ('pompelmo',               '2026-03-10','2026-06-19',11,'citrusgel'),
    ('cioccolato al latte',    '2026-01-04','2026-04-12',15,'chocolat'),
    ('vaniglia fior di latte', '2026-02-21','2026-05-27',10,'gelateriaartigiana'),
    ('mascarpone e limone',    '2026-01-12','2026-04-08', 8,'dolcevita');
