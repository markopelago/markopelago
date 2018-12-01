ALTER TABLE `forwarder_vehicles` ADD `is_active` SMALLINT NOT NULL AFTER `description`, ADD INDEX (`is_active`);
INSERT INTO  vehicle_types (name) VALUES ('Truck');
INSERT INTO  vehicle_types (name) VALUES ('Blind Van');
INSERT INTO  vehicle_types (name) VALUES ('Container Truck');

INSERT INTO vehicle_brands (name) VALUES ('Ashok Leyland');
INSERT INTO vehicle_brands (name) VALUES ('Asia MotorWorks');
INSERT INTO vehicle_brands (name) VALUES ('Beiqi Foton');
INSERT INTO vehicle_brands (name) VALUES ('BYD Company');
INSERT INTO vehicle_brands (name) VALUES ('Chery');
INSERT INTO vehicle_brands (name) VALUES ('Chingkangshan');
INSERT INTO vehicle_brands (name) VALUES ('Daewoo');
INSERT INTO vehicle_brands (name) VALUES ('Daihatsu');
INSERT INTO vehicle_brands (name) VALUES ('Daimler India');
INSERT INTO vehicle_brands (name) VALUES ('Dodge');
INSERT INTO vehicle_brands (name) VALUES ('Dongfeng Motor Corporation');
INSERT INTO vehicle_brands (name) VALUES ('Eicher Motors');
INSERT INTO vehicle_brands (name) VALUES ('Fargo');
INSERT INTO vehicle_brands (name) VALUES ('FAW');
INSERT INTO vehicle_brands (name) VALUES ('Force Motors');
INSERT INTO vehicle_brands (name) VALUES ('Hino Motors');
INSERT INTO vehicle_brands (name) VALUES ('Hinopak Motors');
INSERT INTO vehicle_brands (name) VALUES ('Hualing Xingma Automobile');
INSERT INTO vehicle_brands (name) VALUES ('Hyundai');
INSERT INTO vehicle_brands (name) VALUES ('Isuzu');
INSERT INTO vehicle_brands (name) VALUES ('Jianghuai Automobile');
INSERT INTO vehicle_brands (name) VALUES ('Jiaotong');
INSERT INTO vehicle_brands (name) VALUES ('Jiefang');
INSERT INTO vehicle_brands (name) VALUES ('Komatsu');
INSERT INTO vehicle_brands (name) VALUES ('Matra Fire');
INSERT INTO vehicle_brands (name) VALUES ('Mitsubishi Fuso');
INSERT INTO vehicle_brands (name) VALUES ('New Sentosa CV');
INSERT INTO vehicle_brands (name) VALUES ('Nissan Diesel');
INSERT INTO vehicle_brands (name) VALUES ('Nissian/Minsei');
INSERT INTO vehicle_brands (name) VALUES ('Perkasa Truck');
INSERT INTO vehicle_brands (name) VALUES ('Premier Automobiles');
INSERT INTO vehicle_brands (name) VALUES ('Shaanxi Automobile Group');
INSERT INTO vehicle_brands (name) VALUES ('Shacman');
INSERT INTO vehicle_brands (name) VALUES ('Sitrak');
INSERT INTO vehicle_brands (name) VALUES ('Sitom');
INSERT INTO vehicle_brands (name) VALUES ('Tata Daewoo');
INSERT INTO vehicle_brands (name) VALUES ('Tata Motors');
INSERT INTO vehicle_brands (name) VALUES ('Tata Motors Japan');
INSERT INTO vehicle_brands (name) VALUES ('TVS');
INSERT INTO vehicle_brands (name) VALUES ('Sinotruk');
INSERT INTO vehicle_brands (name) VALUES ('UD Trucks');
INSERT INTO vehicle_brands (name) VALUES ('Vehicle Factory Jabalpur');
INSERT INTO vehicle_brands (name) VALUES ('XCMG');
INSERT INTO vehicle_brands (name) VALUES ('Yuejin');
INSERT INTO vehicle_brands (name) VALUES ('Zeber Motor');
INSERT INTO vehicle_brands (name) VALUES ('Ziyang Nanjun');

CREATE TABLE forwarder_routes (
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	forwarder_id int NOT NULL,
	vehicle_id int NOT NULL,
	source_location_id int NOT NULL,
	destination_location_id int NOT NULL,
	price double NOT NULL,
	load_type_id int NOT NULL,
	is_active smallint NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	KEY user_id (user_id),
	KEY forwarder_id (forwarder_id),
	KEY vehicle_id (vehicle_id),
	KEY source_location_id (source_location_id),
	KEY destination_location_id (destination_location_id)
);

CREATE TABLE load_types (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);

INSERT INTO load_types (name) VALUES ('Food');
INSERT INTO load_types (name) VALUES ('Non Food');


rfo
	id
	user_id
rfo_details
	id
	rfo_id
rfo_respons
	id
	rfo_id
	seller_id
rfo_respon_details
	id
	rfo_respon_id
complaints
returns_trx
returns_trx_details