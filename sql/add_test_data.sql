INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana)     
VALUES ('oskajoha', 'Oskari Johansson', '12345', 'keksitty.email@nan.com', 'banaani1');

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana)
VALUES ('mikko', 'Mikko Mallikas', '54321', 'toinen.email@nan.com', 'omena1');

INSERT INTO Tili (saldo, nostoraja, kayttaja)
VALUES (2000, 100, 'oskajoha');

INSERT INTO Tili (saldo, nostoraja, kayttaja) 
VALUES (1000, 100, 'mikko');
 
INSERT INTO Tilitapahtuma (aika, summa)   
VALUES (NOW(), 20);

INSERT INTO Siirto (tili, tilitapahtuma, tyyppi)
VALUES (1, 1, 'Debet');

INSERT INTO Siirto (tili, tilitapahtuma, tyyppi)
VALUES (2, 1, 'Kredit');

UPDATE Tili
SET saldo = saldo - 20 WHERE tilinumero = 1;

UPDATE Tili
SET saldo = saldo + 20 WHERE tilinumero = 2;