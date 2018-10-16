CREATE TABLE `apps_version` (
  `id` int(11) NOT NULL,
  `version` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `apps_version` (`id`, `version`, `xtimestamp`) VALUES (1, '10', '2018-10-05 01:19:09');
ALTER TABLE `apps_version` ADD PRIMARY KEY (`id`);
ALTER TABLE `apps_version` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` TEXT NOT NULL,
  `status` smallint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `notifications` ADD PRIMARY KEY (`id`);
ALTER TABLE `notifications` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `a_users`  ADD `app_token` VARCHAR(100) NOT NULL  AFTER `token`,ADD KEY (`app_token`);

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