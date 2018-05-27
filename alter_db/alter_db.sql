CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `store_id` INT(11) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL ,
  `link_marko` varchar(100) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `price` varchar(100) NOT NULL ,
  `detail` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `goods` ADD PRIMARY KEY (`id`);
ALTER TABLE `goods` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `stores` ADD PRIMARY KEY (`id`);
ALTER TABLE `stores` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  