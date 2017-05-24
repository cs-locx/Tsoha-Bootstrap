INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana)     
VALUES ('oskajoha', 'Oskari Johansson', '12345', 'keksitty.email@nan.com', 'banaani1');

INSERT INTO Kayttaja (tunnus, nimi, puhnro, email, salasana)     
VALUES ('mikko', 'Mikko Mallikas', '54321', 'toinen.email@nan.com', 'omena1');

INSERT INTO Tili (saldo, nostoraja, kayttaja) 
VALUES (2000, 100, 1);

INSERT INTO Tili (saldo, nostoraja, kayttaja) 
VALUES (1000, 100, 2);
 
INSERT INTO Tilitapahtuma (summa, tyyppi)   
VALUES (-20, 'Debet');     

INSERT INTO Tilitapahtuma (summa, tyyppi)   
VALUES (20, 'Kredit');

INSERT INTO Siirto (ajankohta, tili, tilitapahtuma)
VALUES (timestamp(), 1, 1);

INSERT INTO Siirto (ajankohta, tili, tilitapahtuma)
VALUES (timestamp(), 2, 2);