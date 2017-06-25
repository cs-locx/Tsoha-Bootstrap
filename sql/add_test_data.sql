INSERT INTO Kayttaja (tunnus, nimi, salasana, yllapitaja)     
VALUES ('admin', 'admin', 'admin', true);

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana, osoite, yllapitaja)     
VALUES ('oskajoha', 'Oskari Johansson', '12345', 'keksitty.email@nan.com', 'banaani1', 'Mysteeritie 123', false);

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana, osoite, yllapitaja)
VALUES ('mikko', 'Mikko Mallikas', '54321', 'toinen.email@nan.com', 'omena1', 'Mysteeritie 125', false);

INSERT INTO Tili (siirtoraja, kayttaja, kaytossa)
VALUES (200, 'oskajoha', true);

INSERT INTO Tilisiirto (aika, summa, kohdetili, viesti)   
VALUES (NOW(), 2000, 1, 'Tili avattu saldolla 2000,00€');

INSERT INTO Tili (siirtoraja, kayttaja, kaytossa) 
VALUES (100, 'mikko', true);
 
INSERT INTO Tilisiirto (aika, summa, kohdetili, viesti)   
VALUES (NOW(), 1000, 2, 'Tili avattu saldolla 1000,00€');

INSERT INTO Tilisiirto (aika, summa, lahtotili, kohdetili, viesti)   
VALUES (NOW(), 20, 1, 2, 'Laina Mikolle');

INSERT INTO Tilisiirto (aika, summa, lahtotili, kohdetili, viesti)   
VALUES (NOW(), 30, 2, 1, 'Laina takaisin korkoineen Oskarille');