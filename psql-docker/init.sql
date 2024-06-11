SET client_encoding = 'UTF8';
CREATE EXTENSION IF NOT EXISTS pgcrypto;
CREATE EXTENSION IF NOT EXISTS unaccent;

CREATE TABLE owner_login (
    email VARCHAR(50) PRIMARY KEY,
    pwd VARCHAR(100) NOT NULL
);

CREATE TABLE clinic_login (
    email VARCHAR(50) PRIMARY KEY,
    pwd VARCHAR(100) NOT NULL,
    is_admin BOOL DEFAULT FALSE
);

CREATE TABLE profile (
    uid SERIAL PRIMARY KEY,
    name VARCHAR(30),
    email VARCHAR(50) NOT NULL,
    phone CHAR(12),
    rank VARCHAR(10)
);

-- Why we want to remove pets
-- 1. Wrong add pet. In this case, completely delete is ok though ...
-- 2. 6ft under. Pet clinic still want to save record in other tables.
-- 3. Change owner. Pet clinic still want to save record in other tables.
-- petID is foreign key in many tables
-- So delete record was not-so-good choice
-- if we want to delete pet from an user, simply set ownerID to nil
CREATE TABLE pet (	
    petID SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    age INT DEFAULT 0,
    gender VARCHAR(10),
    species VARCHAR(20),
    note VARCHAR(500),
    ownerID INT --REFERENCES profile(uid)
);

CREATE TABLE health_record (
    recordID SERIAL PRIMARY KEY,
  	 petID INT REFERENCES pet(petID),
    date DATE,
    time TIME,
    -- for staff
    veterinarian VARCHAR(50),		-- ten bac si
    med_instruction TEXT,			-- vd: berberin sang + toi, decolgen ... 
    diet_instructions TEXT, 		-- an nhieu rau xanh, uong it cola
    additional_instructions TEXT,	-- optional
    -- 
    cost INT	-- this cost does not refer to cost in service_list, as cost never changing
);

CREATE TABLE beauty_service (
    serviceID SERIAL PRIMARY KEY,
    petID INT REFERENCES pet(petID),
    date DATE,
    time TIME,
    -- for staff
    service_type VARCHAR(100),	
    service_provider VARCHAR(50),
    notes TEXT,
    --
    cost INT
);

CREATE TABLE service_list (
    sid SERIAL PRIMARY KEY,
    service_name VARCHAR(50) NOT NULL,
    description TEXT,
    cost INT DEFAULT 50000
);

INSERT INTO owner_login VALUES ('nguyenhuuduc2109@gmail.com', '88888888');
INSERT INTO owner_login VALUES ('litteboy@gmail.com', '66666666');

INSERT INTO clinic_login VALUES ('admin@clinic.com', 'admin1', TRUE);
INSERT INTO clinic_login VALUES ('khoa@hust.vn', 'khoahocba');

INSERT INTO profile(name,email,phone,rank) VALUES ('Ng Huu Duc', 'nguyenhuuduc2109@gmail.com', '+84388889999', 'owner');
INSERT INTO profile(email, rank) VALUES ('litteboy@gmail.com','owner');

INSERT INTO profile(name, email,rank) VALUES
  ('Admin', 'admin@clinic.com', 'manager'),
  ('Khoa-san', 'khoa@hust.vn', 'staff');

INSERT INTO pet (name, age, gender, species, note, ownerID) VALUES
  ('Luna', 3, 'Female', 'Cat', 'Loves cuddles and chasing butterflies', 1),
  ('Max', 2, 'Male', 'Dog', 'Energetic Golden Retriever, enjoys walks and fetching', 2),
  ('Bubbles', 1, 'Female', 'Fish', 'Orange Betta fish, very active', 1),
  ('Charlie', 5, 'Male', 'Parrot', 'Blue and Gold Macaw, talks a lot and loves to sing', 2),
  ('Willow', 1, 'Female', 'Rabbit', 'Fluffy Holland Lop, loves munching on hay', 1);

INSERT INTO service_list VALUES
  (1, 'Health Check', 'Our comprehensive health check includes a physical exam and discussing any necessary 
  next steps to keep your friend happy and healthy.', 300000), 
  (2, 'Pet Beauty', 'Pamper your pet with our full-service spa experience!  This combo includes a relaxing bath, 
  	expert grooming, and a gentle massage, leaving your pet feeling refreshed and looking their best.', 70000), 
  (3, 'Pet Hotel', 'Enjoy peace of mind while you are away with our comfortable and secure pet hotel. 
  	We offer spacious accommodations and loving care for your pet, priced at a flat rate of 200,000 VND per day, 
  	regardless of the duration of their stay.', 200000);

