CREATE TABLE backofficers (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	name varchar(100) NOT NULL,
	phone varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id)
);
	
CREATE TABLE survey_templates (
	id int NOT NULL auto_increment,
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
	
CREATE TABLE survey_template_details (
	id int NOT NULL auto_increment,
	survey_template_id int NOT NULL,
	parent_id int NOT NULL,
	seqno int NOT NULL,
	title varchar(255) NOT NULL,
	question text NOT NULL,
	answers text NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (survey_template_id),
	INDEX (parent_id)
);
	
CREATE TABLE surveys (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	survey_template_id int NOT NULL,
	survey_name varchar(100) NOT NULL,
	surveyed_at datetime NOT NULL,
	name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	phone varchar(100) NOT NULL,
	address varchar(255) NOT NULL,
	location_id int NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id),
	INDEX (survey_template_id),
	INDEX (location_id)
);
	
CREATE TABLE survey_details (
	id int NOT NULL auto_increment,
	survey_id int NOT NULL,
	parent_id int NOT NULL,
	seqno int NOT NULL,
	title varchar(255) NOT NULL,
	question text NOT NULL,
	answers text NOT NULL,
	answer varchar(255) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (survey_id),
	INDEX (parent_id)
);
	
CREATE TABLE survey_photos (
	id int NOT NULL auto_increment,
	survey_id int NOT NULL,
	seqno int NOT NULL,
	filename varchar(255) NOT NULL,
	caption varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (survey_id)
);
	
CREATE TABLE locations (
	id int NOT NULL auto_increment,
	parent_id int NOT NULL,
	seqno int NOT NULL,
	name_id varchar(150) NOT NULL,
	name_en varchar(150) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (parent_id)
);
	

--====================================================================
CREATE TABLE promo (
	id int NOT NULL auto_increment,
	name_id varchar(150) NOT NULL,
	name_en varchar(150) NOT NULL,
	price double NOT NULL,
	disc double NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
	
CREATE TABLE units(
	id int NOT NULL auto_increment,
	name_id varchar(150) NOT NULL,
	name_en varchar(150) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);

CREATE TABLE categories(
	id int NOT NULL auto_increment,
	parent_id int NOT NULL,
	name_id varchar(255) NOT NULL,
	name_en varchar(255) NOT NULL,
	promo_id int NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (parent_id)
);

CREATE TABLE goods(
	id int NOT NULL auto_increment,
	barcode varchar(150) NOT NULL,
	seller_id int NOT NULL,
	category_ids varchar(255) NOT NULL,
	unit_id int NOT NULL,
	promo_id int NOT NULL,
	name varchar(255) NOT NULL,
	description TEXT NOT NULL,
	weight DOUBLE NOT NULL,
	dimension varchar(150) NOT NULL,
	is_new smallint NOT NULL,
	price DOUBLE NOT NULL,
	disc DOUBLE NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
	
CREATE TABLE goods_photos (
	id int NOT NULL auto_increment,
	goods_id int NOT NULL,
	seqno int NOT NULL,
	filename varchar(255) NOT NULL,
	caption varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (goods_id)
);

CREATE TABLE sellers (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	rate int NOT NULL,
	logo varchar(255) NOT NULL,
	header_image varchar(255) NOT NULL,
	name varchar(255) NOT NULL,
	description TEXT NOT NULL,
	address TEXT NOT NULL,
	location_id int NOT NULL,
	phone varchar(100) NOT NULL,
	pic varchar(100) NOT NULL,
	status smallint NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);

--====================================================================
--====================================================================
	
CREATE TABLE goods_history (
	id int NOT NULL auto_increment,
	seller_user_id int NOT NULL,
	transaction_id int NOT NULL,
	goods_id int NOT NULL,
	sku varchar(150) NOT NULL,
	in_out varchar(3) NOT NULL,
	qty double NOT NULL,
	notes text NOT NULL,
	history_at DATETIME NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (seller_user_id),
	INDEX (transaction_id),
	INDEX (goods_id),
	INDEX (sku)
);
	
ALTER TABLE a_users ADD COLUMN is_backofficer SMALLINT NOT NULL AFTER name;
ALTER TABLE a_users ADD COLUMN status SMALLINT NOT NULL AFTER is_backofficer;
ALTER TABLE a_users ADD COLUMN email_confirmed_at datetime NOT NULL AFTER status;
ALTER TABLE a_users ADD COLUMN phone varchar(100) NOT NULL AFTER email_confirmed_at;
ALTER TABLE a_users ADD COLUMN phone_confirmed_at datetime NOT NULL AFTER phone;
ALTER TABLE a_users ADD COLUMN is_taxable SMALLINT NOT NULL AFTER phone_confirmed_at;
ALTER TABLE a_users ADD COLUMN npwp varchar(100) NOT NULL AFTER is_taxable;
ALTER TABLE a_users ADD COLUMN nppkp varchar(10) NOT NULL AFTER npwp;
ALTER TABLE a_users ADD COLUMN npwp_address TEXT NOT NULL AFTER nppkp;
ALTER TABLE locations ADD COLUMN zipcode varchar(7) NOT NULL AFTER name_en;
ALTER TABLE goods ADD COLUMN availability_days int NOT NULL AFTER disc;

ALTER TABLE sellers DROP COLUMN address;
ALTER TABLE sellers DROP COLUMN location_id;
ALTER TABLE sellers DROP COLUMN phone;
ALTER TABLE sellers DROP COLUMN status;

DROP TABLE backofficers;

CREATE TABLE buyers (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	rate int NOT NULL,
	birthdate date NOT NULL,
	birthplace_id int NOT NULL,
	gender_id smallint NOT NULL,
	avatar varchar(255) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id),
	INDEX (gender_id)
);
	
CREATE TABLE user_addresses (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	default_buyer smallint NOT NULL,
	default_seller smallint NOT NULL,
	default_forwarder smallint NOT NULL,
	name varchar(100) NOT NULL,
	pic varchar(100) NOT NULL,
	phone varchar(30) NOT NULL,
	address text NOT NULL,
	location_id int NOT NULL,
	coordinate varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id)
);
	
CREATE TABLE user_banks (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	default_buyer smallint NOT NULL,
	default_seller smallint NOT NULL,
	default_forwarder smallint NOT NULL,
	bank_id int NOT NULL,
	name varchar(100) NOT NULL,
	account_no varchar(30) NOT NULL,
	branch varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id),
	INDEX (bank_id)
);
	
CREATE TABLE forwarders (
	id int NOT NULL auto_increment,
	user_id int Not NULL,
	name varchar(100) Not Null,
	is_3rd_party smallint Not Null,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id),
	INDEX (is_3rd_party)
);

CREATE TABLE forwarder_vehicles (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	seqno int NOT NULL,
	is_default smallint NOT NULL,
	vehicle_type_id int NOT NULL,
	vehicle_brand_id int NOT NULL,
	dimension_load_l double NOT NULL,
	dimension_load_w double NOT NULL,
	dimension_load_h double NOT NULL,
	max_load double NOT NULL,
	nopol varchar(12) NOT NULL,
	description TEXT NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (user_id),
	INDEX (seqno),
	INDEX (vehicle_type_id),
	INDEX (vehicle_brand_id),
	INDEX (nopol)
);
	
CREATE TABLE genders (
	id smallint NOT NULL auto_increment,
	name_id varchar(100) NOT NULL,
	name_en varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
	
CREATE TABLE vehicle_brands (
	id smallint NOT NULL auto_increment,
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
	
CREATE TABLE vehicle_types (
	id smallint NOT NULL auto_increment,
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
	
CREATE TABLE banks (
	id int NOT NULL auto_increment,
	code varchar(10) NOT NULL,
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
	
CREATE TABLE payment_types (
	id int NOT NULL auto_increment,
	name_id varchar(100) NOT NULL,
	name_en varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
	
CREATE TABLE return_reasons (
	id int NOT NULL auto_increment,
	name_id varchar(100) NOT NULL,
	name_en varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
	
CREATE TABLE transactions (
	id int NOT NULL auto_increment,
	invoice_no varchar(50) NOT NULL,
	po_no varchar(50) NOT NULL,
	seller_user_id int NOT NULL,
	buyer_user_id INT NOT NULL,
	transaction_at datetime NOT NULL,
	promo_id INT NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (invoice_no),
	INDEX (po_no),
	INDEX (seller_user_id),
	INDEX (buyer_user_id)
);
	
CREATE TABLE transaction_details (
	id int NOT NULL auto_increment,
	transaction_id int NOT NULL,
	goods_id int NOT NULL,
	qty double NOT NULL,
	unit_id int NOT NULL,
	price double NOT NULL,
	promo_id int NOT NULL,
	disc double NOT NULL,
	total double NOT NULL,
	weight double NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (transaction_id),
	INDEX (goods_id),
	INDEX (promo_id)
);
	
CREATE TABLE transaction_forwarder (
	id int NOT NULL auto_increment,
	transaction_id int NOT NULL,
	forwarder_id int NOT NULL,
	forwarder_user_id int NOT NULL,
	name varchar(100) NOT NULL,
	weight double NOT NULL,
	dimension_load_l double NOT NULL,
	dimension_load_w double NOT NULL,
	dimension_load_h double NOT NULL,
	price double NOT NULL,
	promo_id int not null,
	disc double NOT NULL,
	total double NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (transaction_id),
	INDEX (forwarder_id),
	INDEX (forwarder_user_id)
);
	
CREATE TABLE transaction_payments (
	id int NOT NULL auto_increment,
	transaction_id int NOT NULL,
	payment_type_id int NOT NULL,
	name varchar(100) NOT NULL,
	total double NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	INDEX (transaction_id)
);

UPDATE  a_users SET  is_backofficer='1' WHERE  group_id >= 0;
--====================================================================
--====================================================================
--====================================================================
ALTER TABLE transactions ADD COLUMN user_address_id INT NOT NULL AFTER transaction_at;	

CREATE TABLE locations_translation (
	id int NOT NULL auto_increment,
	old_id int NOT NULL,
	new_id int NOT NULL,
	PRIMARY KEY (id)
);


INSERT INTO locations_translation VALUES 
(1,6,15191),
(2,7,8640),
(3,8,21978),
(4,9,23315),
(5,10,32572),
(6,11,25816),
(7,12,34283),
(8,13,29693),
(9,14,1),
(10,15,2032),
(11,16,35933),
(12,17,45097),
(13,18,45619),
(14,19,62576),
(15,20,63359),
(16,21,64622),
(17,22,60390),
(18,23,58709),
(19,24,54814),
(20,25,56986),
(21,26,76941),
(22,27,68218),
(23,28,72310),
(24,29,74734),
(25,30,79752),
(26,31,82410),
(27,32,319),
(28,33,29251),
(29,34,81106),
(30,35,78940),
(31,36,25326),
(32,37,71587),
(33,38,88188);

ALTER TABLE `transaction_details` ADD `notes` TEXT NOT NULL AFTER `weight`;
INSERT INTO `user_addresses` (`id`, `user_id`, `default_buyer`, `default_seller`, `default_forwarder`, `name`, `pic`, `phone`, `address`, `location_id`, `coordinate`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `xtimestamp`) VALUES (NULL, '31', '1', '1', '1', 'Rumah', 'Marisa', '081212 86 4040', 'Komplek Ciledug Indah 1 Jl. Surya V Blok B XVII No.245 RT 06/006 Pedurenan, Karang Tengah \r\nKarangtengah, Kota Tangerang, 15159 \r\nBanten ', '447', '-6.219687,106.693397', NULL, '', NULL, NULL, '', NULL, CURRENT_TIMESTAMP);
INSERT INTO `user_addresses` (`id`, `user_id`, `default_buyer`, `default_seller`, `default_forwarder`, `name`, `pic`, `phone`, `address`, `location_id`, `coordinate`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `xtimestamp`) VALUES (NULL, '31', '0', '0', '0', 'Kantor', 'Sidik', '08 1212 86 4040', 'PT. Indo Human Resource Epiwalk LT 7 Komplek Rasuna Epicentrum, Jl. H R rasuna Said, RT.2/RW.5, Karet Kuningan \r\nJakarta Selatan,   Jakarta Selatan,   12960 \r\nDKI Jakarta', '189', '-6.218208, 106.835185', NULL, '', NULL, NULL, '', NULL, CURRENT_TIMESTAMP);

ALTER TABLE goods ADD COLUMN forwarder_ids varchar(255) NOT NULL AFTER availability_days;
ALTER TABLE `goods` ADD INDEX(`forwarder_ids`);

ALTER TABLE `forwarders` ADD `rajaongkir_code` VARCHAR(100) NOT NULL AFTER `is_3rd_party`;

INSERT INTO forwarders (user_id,name,rajaongkir_code,is_3rd_party) VALUES 
(0,'Jalur Nugraha Ekakurir',lower('JNE'),1),
(0,'POS Indonesia',lower('POS'),1),
(0,'Citra Van Titipan Kilat',lower('TIKI'),1),
(0,'Priority Cargo and Package',lower('PCP'),1),
(0,'Eka Sari Lorena',lower('ESL'),1),
(0,'RPX Holding',lower('RPX'),1),
(0,'Pandu Logistics',lower('PANDU'),1),
(0,'Wahana Prestasi Logistik',lower('WAHANA'),1),
(0,'SiCepat Express',lower('SICEPAT'),1),
(0,'J&T Express',lower('J&T'),1),
(0,'Pahala Kencana Express',lower('PAHALA'),1),
(0,'Cahaya Logistik',lower('CAHAYA'),1),
(0,'SAP Express',lower('SAP'),1),
(0,'JET Express',lower('JET'),1),
(0,'Indah Logistic',lower('INDAH'),1),
(0,'Solusi Ekspres',lower('SLIS'),1),
(0,'21 Express',lower('DSE'),1),
(0,'First Logistics',lower('FIRST'),1),
(0,'Nusantara Card Semesta',lower('NCS'),1),
(0,'Star Cargo',lower('STAR'),1),
(0,'Nusantara Surya Sakti Express',lower('NSS'),1),
(0,'Expedito',lower('expedito'),1);

ALTER TABLE `transactions` ADD `status` SMALLINT NOT NULL AFTER `promo_id`;
ALTER TABLE `transactions` ADD INDEX(`status`);
ALTER TABLE `transactions` ADD `cart_group` VARCHAR(50) NOT NULL AFTER `id`, ADD INDEX (`cart_group`);
ALTER TABLE `transaction_forwarder` ADD `qty` DOUBLE NOT NULL AFTER `dimension_load_h`;

ALTER TABLE `transaction_forwarder` ADD `user_address_name` VARCHAR(100) NOT NULL AFTER `name`, ADD `user_address_pic` VARCHAR(100) NOT NULL AFTER `user_address_name`, ADD `user_address_phone` VARCHAR(30) NOT NULL AFTER `user_address_pic`, ADD `user_address` TEXT NOT NULL AFTER `user_address_phone`, ADD `user_address_location_id` INT NOT NULL AFTER `user_address`, ADD INDEX (`user_address_location_id`);
ALTER TABLE `transaction_forwarder` ADD `user_address_id` INT NOT NULL AFTER `name`, ADD INDEX (`user_address_id`);
ALTER TABLE `transaction_forwarder` ADD `user_address_coordinate` VARCHAR(100) NOT NULL AFTER `user_address_location_id`;

====================20180722===========================
ALTER TABLE `transaction_payments` CHANGE `transaction_id` `cart_group` VARCHAR(50) NOT NULL;
ALTER TABLE `transaction_payments` ADD INDEX(`cart_group`);
ALTER TABLE `transaction_payments` ADD `invoice_no` VARCHAR(50) NOT NULL AFTER `cart_group`, ADD INDEX (`invoice_no`) ;
ALTER TABLE `transaction_payments` ADD `uniqcode` DOUBLE NOT NULL AFTER `total`;
ALTER TABLE `transaction_payments` ADD `account_name` VARCHAR(100) NOT NULL AFTER `uniqcode`, ADD `account_no` VARCHAR(20) NOT NULL AFTER `account_name`, ADD `bank` VARCHAR(30) NOT NULL AFTER `account_no`, ADD `transfer_at` DATE NOT NULL AFTER `bank`;

INSERT INTO  a_backoffice_menu (id,seqno,parent_id,name,url) VALUES (18,5,0,'Finance','#');
UPDATE a_backoffice_menu SET seqno = 6 WHERE id='3';
INSERT INTO  a_backoffice_menu (id,seqno,parent_id,name,url) VALUES (19,1,18,'Invoices','invoices_list.php');


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