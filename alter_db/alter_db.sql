ALTER TABLE `goods` ADD `is_displayed` SMALLINT NOT NULL AFTER `forwarder_ids`, ADD INDEX (`is_displayed`);
UPDATE goods SET is_displayed='1';
	
CREATE TABLE `goods_liked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `goods_liked` ADD UNIQUE( `goods_id`, `user_id`);

CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) DEFAULT NULL,
  `name_id` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `colors` ADD UNIQUE(`code`);

INSERT INTO colors (code,name_id,name_en) VALUES ('ffffff','Putih','White');
INSERT INTO colors (code,name_id,name_en) VALUES ('000000','Hitam','Black');
INSERT INTO colors (code,name_id,name_en) VALUES ('0000ff','Biru','Blue');
INSERT INTO colors (code,name_id,name_en) VALUES ('00ff00','Lime','Lime');
INSERT INTO colors (code,name_id,name_en) VALUES ('00ffff','Aqua','Aqua');
INSERT INTO colors (code,name_id,name_en) VALUES ('ff0000','Merah','Red');
INSERT INTO colors (code,name_id,name_en) VALUES ('ff00ff','Fuchsia','Fuchsia');
INSERT INTO colors (code,name_id,name_en) VALUES ('ffff00','Kuning','Yellow');
INSERT INTO colors (code,name_id,name_en) VALUES ('000080','Navy','Navy');
INSERT INTO colors (code,name_id,name_en) VALUES ('008000','Hijau','Green');
INSERT INTO colors (code,name_id,name_en) VALUES ('008080','Teal','Teal');
INSERT INTO colors (code,name_id,name_en) VALUES ('800000','Maroon','Maroon');
INSERT INTO colors (code,name_id,name_en) VALUES ('800080','Ungu','Purple');
INSERT INTO colors (code,name_id,name_en) VALUES ('808000','Olive','Olive');
INSERT INTO colors (code,name_id,name_en) VALUES ('808080','Abu-abu','Gray');
INSERT INTO colors (code,name_id,name_en) VALUES ('c0c0c0','Perak','Silver');

ALTER TABLE `goods` ADD `color_ids` VARCHAR(255) NOT NULL AFTER `category_ids`, ADD INDEX (`color_ids`);
ALTER TABLE `goods` ADD INDEX( `category_ids`);

CREATE TABLE `goods_viewed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `goods_viewed` ADD UNIQUE( `goods_id`, `user_id`);




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