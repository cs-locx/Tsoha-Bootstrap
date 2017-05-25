CREATE TABLE Kayttaja ( 
  tunnus text PRIMARY KEY, 
  nimi text NOT NULL, 
  puhnro text, 
  email text, 
  osoite text,
  salasana text NOT NULL 
);
 
CREATE TABLE Tili ( 
  tilinumero SERIAL PRIMARY KEY, 
  saldo decimal(12,2) NOT NULL, 
  nostoraja integer, 
  kayttaja text NOT NULL, 
  FOREIGN KEY (kayttaja) REFERENCES Kayttaja (tunnus) 
);
 
CREATE TABLE Tilitapahtuma ( 
  tili integer NOT NULL,
  siirto integer NOT NULL,
  tyyppi text NOT NULL,
  FOREIGN KEY (tili) REFERENCES Tili (tilinumero),
  FOREIGN KEY (siirto) REFERENCES Siirto (id),
  PRIMARY KEY (tili, tilitapahtuma)
);

CREATE TABLE Siirto (
  id SERIAL PRIMARY KEY,
  aika timestamp NOT NULL,  
  summa integer NOT NULL
);