ALTER TABLE `transactions` ADD `invoice_at` DATE NOT NULL AFTER `invoice_no`, ADD INDEX (`invoice_at`);
ALTER TABLE `transactions` ADD `po_at` DATE NOT NULL AFTER `po_no`, ADD INDEX (`po_at`);
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `messages` ADD PRIMARY KEY (`id`), ADD KEY `created_at` (`created_at`), ADD KEY `status` (`status`);
ALTER TABLE `messages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `messages` ADD `user_id_as` VARCHAR(10) NOT NULL AFTER `user_id2`, ADD `user_id2_as` VARCHAR(10) NOT NULL AFTER `user_id_as`, ADD INDEX (`user_id_as`), ADD INDEX (`user_id2_as`);
ALTER TABLE `transaction_forwarder` ADD `courier_service` VARCHAR(100) NOT NULL AFTER `name`;
ALTER TABLE `transaction_payments` CHANGE `bank` `bank_id` INT NOT NULL;
ALTER TABLE `transaction_payments` ADD `status` SMALLINT NOT NULL AFTER `transfer_at`, ADD INDEX (`status`);
INSERT INTO a_backoffice_menu (parent_id,name,url) VALUES (18,'PO','po_list.php');

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