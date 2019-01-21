DROP TABLE IF EXISTS seller_is_pasar;
CREATE TABLE seller_is_pasar(
	id int NOT NULL AUTO_INCREMENT,
	seller_id int NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	UNIQUE KEY seller_id (seller_id)
);
INSERT INTO seller_is_pasar (seller_id) VALUES ('26');

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