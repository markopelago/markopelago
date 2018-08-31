ALTER TABLE `transactions` ADD `seller_paid` SMALLINT NOT NULL AFTER `status`, ADD `seller_paid_at` DATETIME NOT NULL AFTER `seller_paid`, ADD `seller_paid_by` VARCHAR(100) NOT NULL AFTER `seller_paid_at`, ADD INDEX (`seller_paid`);


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