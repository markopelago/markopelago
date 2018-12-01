ALTER TABLE `goods` ADD `self_pickup` SMALLINT NOT NULL AFTER `forwarder_ids`, ADD `pickup_location_id` INT NOT NULL AFTER `self_pickup`, ADD INDEX (`self_pickup`), ADD INDEX (`pickup_location_id`);

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