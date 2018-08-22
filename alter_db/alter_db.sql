ALTER TABLE `transaction_forwarder` ADD `receipt_no` VARCHAR(100) NOT NULL AFTER `total`, ADD INDEX (`receipt_no`);
ALTER TABLE `transaction_forwarder` ADD `receipt_at` datetime NOT NULL AFTER `receipt_no`, ADD INDEX (`receipt_at`);

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