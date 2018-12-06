ALTER TABLE `transaction_forwarder` ADD `markoantar_status` INT NOT NULL AFTER `receipt_at`, ADD INDEX (`markoantar_status`);
ALTER TABLE `transaction_forwarder` ADD `markoantar_status_at` DATETIME NOT NULL AFTER `markoantar_status`;


CREATE TABLE transaction_statuses (
	id int(11) NOT NULL AUTO_INCREMENT,
	name_id varchar(100) NOT NULL,
	name_en varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
INSERT INTO transaction_statuses (id,name_id,name_en) VALUES 
('9','Keranjang','Cart'),
('1','Checkout Pembelian','Purchase Checkout'),
('2','Tunggu verifikasi pembayaran','Waiting payment verification'),
('3','Pembayaran terverifikasi','Payment verified'),
('4','Pemesanan dalam proses','Order in process'),
('5','Pemesanan dalam pengiriman','Order in delivery'),
('6','Barang Diterima','Received'),
('7','Transaksi Selesai','Transaction Done');
UPDATE transaction_statuses set id='0' where id='9';


CREATE TABLE markoantar_statuses (
	id int(11) NOT NULL AUTO_INCREMENT,
	name_id varchar(100) NOT NULL,
	name_en varchar(100) NOT NULL,
	created_at datetime DEFAULT NULL,
	created_by varchar(100) NOT NULL,
	created_ip varchar(20) DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	updated_by varchar(100) NOT NULL,
	updated_ip varchar(20) DEFAULT NULL,
	xtimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
INSERT INTO markoantar_statuses (id,name_id,name_en) VALUES 
('1','Barang siap di jemput','Goods ready to pick up'),
('2','Menjemput barang','Picking up goods'),
('3','Barang diantar','Delivering goods'),
('4','Barang sampai tujuan','Goods arrived'),
('5','Menuju ke pool armada','Heading to vehicle`s homebase'),
('6','Sampai di pool armada','Arrived at vehicle`s homebase');



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