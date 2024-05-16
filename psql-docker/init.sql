SET client_encoding = 'UTF8';
CREATE EXTENSION IF NOT EXISTS pgcrypto;
CREATE EXTENSION IF NOT EXISTS unaccent;

CREATE TABLE owner_login (
    email VARCHAR(50) PRIMARY KEY,
    pwd VARCHAR(100) NOT NULL
    --salt VARCHAR(100)
);

CREATE TABLE clinic_login (
    email VARCHAR(50) PRIMARY KEY,
    pwd VARCHAR(100) NOT NULL
    --salt VARCHAR(100)
);

CREATE TABLE owner (
    ownerID SERIAL PRIMARY KEY,
    name VARCHAR(30),
    email VARCHAR(50) NOT NULl REFERENCES owner_login(email),
    phone CHAR(11)
);

CREATE TABLE staff (
    staffID SERIAL PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL REFERENCES clinic_login(email)
    
);

CREATE TABLE pet (
    petID SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    age INT DEFAULT 0,
    gender VARCHAR(10),
    species VARCHAR(20),
    notes VARCHAR(500),
    ownerID INT REFERENCES Owner(ownerID)
);

INSERT INTO owner_login VALUES ('nguyenhuuduc2109@gmail.com', '88888888');
INSERT INTO owner_login VALUES ('litteboy@gmail.com', '66666666');

INSERT INTO owner(name, email) VALUES ('Ng Huu Duc', 'nguyenhuuduc2109@gmail.com');
INSERT INTO owner(email) VALUES ('litteboy@gmail.com');

INSERT INTO pet (name, age, gender, species, notes, ownerID) VALUES
  ('Luna', 3, 'Female', 'Cat', 'Loves cuddles and chasing butterflies', 1),
  ('Max', 2, 'Male', 'Dog', 'Energetic Golden Retriever, enjoys walks and fetching', 2),
  ('Bubbles', 1, 'Female', 'Fish', 'Orange Betta fish, very active', 3),
  ('Charlie', 5, 'Male', 'Parrot', 'Blue and Gold Macaw, talks a lot and loves to sing', 4),
  ('Willow', 1, 'Female', 'Rabbit', 'Fluffy Holland Lop, loves munching on hay', 1);


INSERT INTO clinic_login VALUES ('admin@clinic.com', 'admin1');
INSERT INTO staff(name, email) VALUES ('Admin', 'admin@clinic.com');
