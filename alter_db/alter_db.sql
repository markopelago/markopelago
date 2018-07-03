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
	
ALTER TABLE a_users ADD COLUMN status SMALLINT NOT NULL AFTER name;
ALTER TABLE a_users ADD COLUMN email_confirmed_at datetime NOT NULL AFTER status;
ALTER TABLE a_users ADD COLUMN phone varchar(100) NOT NULL AFTER email_confirmed_at;
ALTER TABLE a_users ADD COLUMN phone_confirmed_at datetime NOT NULL AFTER phone;
ALTER TABLE a_users ADD COLUMN is_taxable SMALLINT NOT NULL AFTER phone_confirmed_at;
ALTER TABLE a_users ADD COLUMN npwp varchar(100) NOT NULL AFTER is_taxable;
ALTER TABLE a_users ADD COLUMN nppkp varchar(10)) NOT NULL AFTER npwp;
ALTER TABLE a_users ADD COLUMN npwp_address TEXT NOT NULL AFTER nppkp;
ALTER TABLE locations ADD COLUMN zipcode varchar(7) NOT NULL AFTER name_en;
ALTER TABLE goods ADD COLUMN availability_days int NOT NULL AFTER disc;

ALTER TABLE sellers DROP COLUMN address;
ALTER TABLE sellers DROP COLUMN location_id;
ALTER TABLE sellers DROP COLUMN phone;
ALTER TABLE sellers DROP COLUMN status;
ALTER TABLE backofficers DROP COLUMN phone;

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
	promo_id
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
--====================================================================
	
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