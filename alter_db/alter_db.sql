ALTER TABLE `transaction_details` ADD `is_reviewed` SMALLINT NOT NULL AFTER `notes`, ADD `review_at` DATETIME NOT NULL AFTER `is_reviewed`, ADD `review_level` INT NOT NULL AFTER `review_at`, ADD `review_description` TEXT NOT NULL AFTER `review_level`, ADD INDEX (`is_reviewed`);
ALTER TABLE `transaction_details` ADD `review_id_read` SMALLINT NOT NULL AFTER `review_description`, ADD `review_read_at` DATETIME NOT NULL AFTER `review_id_read`, ADD INDEX (`review_id_read`);


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