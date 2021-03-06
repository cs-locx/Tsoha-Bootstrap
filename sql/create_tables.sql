CREATE TABLE Kayttaja ( 
    tunnus text PRIMARY KEY, 
    nimi text NOT NULL, 
    puhnro text, 
    email text, 
    osoite text,
    salasana text NOT NULL, 
    yllapitaja boolean NOT NULL
);
 
CREATE TABLE Tili ( 
    tilinumero SERIAL PRIMARY KEY,
    siirtoraja integer, 
    kaytossa boolean NOT NULL,
    kayttaja text NOT NULL, 
    FOREIGN KEY (kayttaja) REFERENCES Kayttaja (tunnus) 
);
 
CREATE TABLE Tilisiirto (
    id SERIAL PRIMARY KEY,
    aika timestamp NOT NULL,  
    summa decimal(12,2) NOT NULL,
    lahtotili integer,
    kohdetili integer NOT NULL,
    viesti text,
    FOREIGN KEY (lahtotili) REFERENCES Tili (tilinumero),
    FOREIGN KEY (kohdetili) REFERENCES Tili (tilinumero)
);