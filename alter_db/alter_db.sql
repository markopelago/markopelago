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
	
CREATE TABLE goods_history(
	id int NOT NULL auto_increment,
	seller_id int NOT NULL,
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
	PRIMARY KEY (id)
);
	

buyers
	id
	user_id
	rate
	
	

	
forwarders
	id
	user_id
	is_3rd_party
	
banks
	id
	code
	name
	
regions
payment_types
return_reasons
	
transactions
	id
	invoice_no
	po_no
	seller_id
	buyer_id
transaction_details
	id
	transaction_id
	goods_id
	qty
transaction_payments
	
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