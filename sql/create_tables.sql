CREATE TABLE Kayttaja ( 
  tunnus text PRIMARY KEY, 
  nimi text NOT NULL, 
  puhnro text, 
  email text, 
  salasana text NOT NULL 
); 
 
CREATE TABLE Tili ( 
  tilinumero SERIAL PRIMARY KEY, 
  saldo money NOT NULL, 
  nostoraja integer, 
  siirtoraja integer, 
  kayttaja text NOT NULL, 
  FOREIGN KEY (kayttaja) REFERENCES Kayttaja (tunnus) 
); 
 
CREATE TABLE Siirto ( 
  ajankohta timestamp NOT NULL, 
  tili integer NOT NULL,
  tilitapahtuma integer NOT NULL,
  FOREIGN KEY (tili) REFERENCES Tili (tilinumero) ,
  FOREIGN KEY (tilitapahtuma) REFERENCES Tilitapahtuma (id) 
); 

CREATE TABLE Tilitapahtuma (
  id integer PRIMARY KEY, 
  summa integer NOT NULL, 
  tyyppi text NOT NULL
);