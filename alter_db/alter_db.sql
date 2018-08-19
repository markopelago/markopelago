CREATE TABLE bank_accounts(
	id int NOT NULL AUTO_INCREMENT,
	bank_id int NOT NULL,
	account_name varchar(100) NOT NULL,
	account_no varchar(30) NOT NULL,
	location_id int NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) DEFAULT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) DEFAULT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	KEY bank_id (bank_id)
);

INSERT INTO bank_accounts (bank_id,account_name,account_no,location_id) VALUES (1,'Markopelago','730758474',120);
INSERT INTO bank_accounts (bank_id,account_name,account_no,location_id) VALUES (2,'Markopelago','38422394839',120);
ALTER TABLE `transaction_payments` ADD `bank_account_id` INT NOT NULL AFTER `uniqcode`, ADD INDEX (`bank_account_id`);




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