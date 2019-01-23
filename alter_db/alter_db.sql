ALTER TABLE `transaction_forwarder` ADD `transaction_ids` VARCHAR(255) NOT NULL AFTER `transaction_id`, ADD `seller_id` INT NOT NULL AFTER `transaction_ids`, ADD INDEX (`transaction_ids`), ADD INDEX (`seller_id`);
ALTER TABLE `transaction_forwarder` ADD `cart_group` VARCHAR(50) NOT NULL AFTER `id`, ADD INDEX (`cart_group`);

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