ALTER TABLE `a_users` ADD `marko_id` VARCHAR(100) NOT NULL AFTER `group_id`;
UPDATE a_users SET marko_id=concat(replace(name,' ','_'),'_',id);
ALTER TABLE `a_users` ADD UNIQUE(`marko_id`);



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