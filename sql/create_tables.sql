CREATE TABLE Kayttaja ( 
  tunnus text PRIMARY KEY, 
  nimi text NOT NULL, 
  puhnro text, 
  email text, 
  salasana text NOT NULL 
);
 
CREATE TABLE Tili ( 
  tilinumero SERIAL PRIMARY KEY, 
  saldo decimal(12,2) NOT NULL, 
  nostoraja integer, 
  siirtoraja integer, 
  kayttaja text NOT NULL, 
  FOREIGN KEY (kayttaja) REFERENCES Kayttaja (tunnus) 
);
 
CREATE TABLE Siirto ( 
  tili integer NOT NULL,
  tilitapahtuma integer NOT NULL,
  tyyppi text NOT NULL,
  FOREIGN KEY (tili) REFERENCES Tili (tilinumero),
  FOREIGN KEY (tilitapahtuma) REFERENCES Tilitapahtuma (id),\d  
  PRIMARY KEY (tili, tilitapahtuma)
);

CREATE TABLE Tilitapahtuma (
  id SERIAL PRIMARY KEY,
  ajankohta timestamp NOT NULL,  
  summa integer NOT NULL
);