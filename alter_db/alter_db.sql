DROP TABLE IF EXISTS sms_queue;
CREATE TABLE sms_queue(
	id int NOT NULL AUTO_INCREMENT,
	msisdn varchar(50) NOT NULL,
	message TEXT NOT NULL,
	xstatus smallint NOT NULL,
	sent_at datetime DEFAULT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	KEY xstatus (xstatus)
);
ALTER TABLE `sms_queue` CHANGE `xstatus` `xstatus` SMALLINT(6) NOT NULL DEFAULT '0';

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