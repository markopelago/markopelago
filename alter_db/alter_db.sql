DROP TABLE IF EXISTS `mail_queue`;
CREATE TABLE `mail_queue` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `address` text NOT NULL,
  `body` text NOT NULL,
  `replyto` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `mail_queue` ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`);
ALTER TABLE `mail_queue` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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