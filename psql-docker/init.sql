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
    ownerID INT, --REFERENCES profile(uid)
    image_link VARCHAR(500)
);

CREATE TABLE hotel_room (
    id SERIAL PRIMARY KEY,
    description VARCHAR(100) ,
    petID INT REFERENCES pet(petID),
    condition VARCHAR(50) NOT NULL,
    image_link VARCHAR(500)
);

CREATE TABLE health_record (
    recordID SERIAL PRIMARY KEY,
  	 petID INT REFERENCES pet(petID),
    date DATE,
    time TIME,
    finished BOOL DEFAULT FALSE,
    payment  BOOL DEFAULT FALSE,
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
    finished BOOL DEFAULT FALSE,
    payment  BOOL DEFAULT FALSE,
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

CREATE TABLE hotel_record (
    recordID SERIAL PRIMARY KEY,
    petID INT REFERENCES pet(petID),
    check_in DATE,
    check_out DATE,
    finished BOOL DEFAULT FALSE,
    payment  BOOL DEFAULT FALSE,
    notes TEXT,
    --
    cost INT
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

INSERT INTO pet (name, age, gender, species, note, ownerID, image_link) VALUES
  ('Luna', 3, 'Female', 'Cat', 'Loves cuddles and chasing butterflies', 1,'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallup.net%2Fwp-content%2Fuploads%2F2019%2F09%2F110394-cats-grey-kittens-fluffy-fat-grass-animals-cat-kitten-baby-cute.jpg&f=1&nofb=1&ipt=f5ce4bdcc7ff20e99ac0497b4a3773484af28dd9ec916e6d3f576e17e0b03b10&ipo=images'),
  ('Max', 2, 'Male', 'Dog', 'Energetic Golden Retriever, enjoys walks and fetching', 2,'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.publicdomainpictures.net%2Fpictures%2F40000%2Fvelka%2Fgolden-retriever-dog-1364426710r9x.jpg&f=1&nofb=1&ipt=c92ec5b2d8089d7b3daea9e76aca31867800f85008e4c77cdbb164d1161ddd27&ipo=images'),
  ('Bubbles', 1, 'Female', 'Fish', 'Orange Betta fish, very active', 1,'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fupload.wikimedia.org%2Fwikipedia%2Fcommons%2F7%2F77%2FPuffer_Fish_DSC01257.JPG&f=1&nofb=1&ipt=6a6ec241f0c70265e57387b046185eafa54bb0d1024d85679ede30fbe412bb40&ipo=images'),
  ('Charlie', 5, 'Male', 'Parrot', 'Blue and Gold Macaw, talks a lot and loves to sing', 2,'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages.pexels.com%2Fphotos%2F1463295%2Fpexels-photo-1463295.jpeg%3Fcs%3Dsrgb%26dl%3Danimal-beautiful-bright-1463295.jpg%26fm%3Djpg&f=1&nofb=1&ipt=60844910b7df6fe46bc25a4f8cfebc12ae60d4783305169d167fd8bf09a0abd9&ipo=images'),
  ('Willow', 1, 'Female', 'Rabbit', 'Fluffy Holland Lop, loves munching on hay', 1,'https://squeaksandnibbles.com/wp-content/uploads/2018/02/dwarf-rabbit-header-696x409.jpg');

INSERT INTO service_list VALUES
  (1, 'Health Check', 'Our comprehensive health check includes a physical exam and discussing any necessary 
  next steps to keep your friend happy and healthy.', 300000), 
  (2, 'Pet Beauty', 'Pamper your pet with our full-service spa experience!  This combo includes a relaxing bath, 
  	expert grooming, and a gentle massage, leaving your pet feeling refreshed and looking their best.', 70000), 
  (3, 'Pet Hotel', 'Enjoy peace of mind while you are away with our comfortable and secure pet hotel. 
  	We offer spacious accommodations and loving care for your pet, priced at a flat rate of 200,000 VND per day, 
  	regardless of the duration of their stay.', 200000);

-- HotelRoom data
INSERT INTO hotel_room (description, condition,image_link) VALUES
('First floor to the left',  'Good','https://res.cloudinary.com/dbfuwgyr8/image/upload/v1718152782/room1_albd3i.jpg'),
('In the basement',  'Decent','https://res.cloudinary.com/dbfuwgyr8/image/upload/v1718152791/room2_to9tv7.jpg'),
('In heaven',  'Unusuable','https://res.cloudinary.com/dbfuwgyr8/image/upload/v1718152802/room3_yo2zzn.jpg');

