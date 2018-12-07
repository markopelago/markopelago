ALTER TABLE `transaction_forwarder` CHANGE `markoantar_status_at` `markoantar_status1_at` DATETIME NOT NULL;
ALTER TABLE `transaction_forwarder` ADD `markoantar_status2_at` DATETIME NOT NULL AFTER `markoantar_status1_at`, ADD `markoantar_status3_at` DATETIME NOT NULL AFTER `markoantar_status2_at`, ADD `markoantar_status4_at` DATETIME NOT NULL AFTER `markoantar_status3_at`, ADD `markoantar_status5_at` DATETIME NOT NULL AFTER `markoantar_status4_at`, ADD `markoantar_status6_at` DATETIME NOT NULL AFTER `markoantar_status5_at`;



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