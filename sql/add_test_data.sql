INSERT INTO Kayttaja (tunnus, nimi, salasana, yllapitaja)     
VALUES ('admin', 'admin', 'admin', true);

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana, osoite, yllapitaja)     
VALUES ('oskajoha', 'Oskari Johansson', '12345', 'keksitty.email@nan.com', 'banaani1', 'Mysteeritie 123', false);

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana, osoite, yllapitaja)
VALUES ('mikko', 'Mikko Mallikas', '54321', 'toinen.email@nan.com', 'omena1', 'Mysteeritie 125', false);

INSERT INTO Tili (saldo, siirtoraja, kayttaja)
VALUES (2000, 100, 'oskajoha');

INSERT INTO Tili (saldo, siirtoraja, kayttaja) 
VALUES (1000, 100, 'mikko');
 
INSERT INTO Siirto (aika, summa)   
VALUES (NOW(), 20);

INSERT INTO Tilitapahtuma (tili, siirto, tyyppi)
VALUES (1, 1, 'Debet');

INSERT INTO Tilitapahtuma (tili, siirto, tyyppi)
VALUES (2, 1, 'Kredit');

UPDATE Tili
SET saldo = saldo - 20 WHERE tilinumero = 1;

UPDATE Tili
SET saldo = saldo + 20 WHERE tilinumero = 2;