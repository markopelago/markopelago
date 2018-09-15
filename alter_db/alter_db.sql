TRUNCATE TABLE categories;

INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (1,0,'Agrikultur makanan/minuman','Agrikultur makanan/minuman');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (2,0,'Bahan bangunan','Bahan bangunan');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (3,0,'Furnitur/Dekorasi','Furnitur/Dekorasi');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (4,0,'Ibu/Bayi','Ibu/Bayi');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (5,0,'Kerajinan/Sovenir','Kerajinan/Sovenir');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (6,0,'Kesehatan/Kecantikan','Kesehatan/Kecantikan');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (7,0,'Olah raga','Olah raga');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (8,0,'Otomotif','Otomotif');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (9,0,'Pakaian/Accesoris','Pakaian/Accesoris');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (10,0,'Perlengkapan/kebutuhan rumah tangga','Perlengkapan/kebutuhan rumah tangga');
INSERT INTO categories (id,parent_id,name_id,name_en) VALUES (11,0,'Produk lainnya','Produk lainnya');
                       
INSERT INTO categories (parent_id,name_id) VALUES (1,'Bahan pokok');
INSERT INTO categories (parent_id,name_id) VALUES (1,'Daging dan hidangan laut');
INSERT INTO categories (parent_id,name_id) VALUES (1,'Minuman');
INSERT INTO categories (parent_id,name_id) VALUES (1,'Bumbu dapur');
INSERT INTO categories (parent_id,name_id) VALUES (1,'Buah buahan');
INSERT INTO categories (parent_id,name_id) VALUES (1,'Sayuran');
INSERT INTO categories (parent_id,name_id) VALUES (2,'Bata');
INSERT INTO categories (parent_id,name_id) VALUES (2,'Pasir');
INSERT INTO categories (parent_id,name_id) VALUES (2,'Semen');
INSERT INTO categories (parent_id,name_id) VALUES (2,'Cat');
INSERT INTO categories (parent_id,name_id) VALUES (3,'Sofa/Kursi');
INSERT INTO categories (parent_id,name_id) VALUES (3,'Meja');
INSERT INTO categories (parent_id,name_id) VALUES (3,'lemari/rak');
INSERT INTO categories (parent_id,name_id) VALUES (3,'Accesoris/Interior');
INSERT INTO categories (parent_id,name_id) VALUES (4,'Perlengkapan bayi');
INSERT INTO categories (parent_id,name_id) VALUES (4,'Makanan bayi');
INSERT INTO categories (parent_id,name_id) VALUES (4,'Perlengkapan Ibu hamil');
INSERT INTO categories (parent_id,name_id) VALUES (5,'Kerajinan tangan');
INSERT INTO categories (parent_id,name_id) VALUES (5,'Sovenir');
INSERT INTO categories (parent_id,name_id) VALUES (6,'Kesehatan/Kecantikan');
INSERT INTO categories (parent_id,name_id) VALUES (7,'Sepak bola');
INSERT INTO categories (parent_id,name_id) VALUES (7,'Batminton');
INSERT INTO categories (parent_id,name_id) VALUES (7,'Bela diri');
INSERT INTO categories (parent_id,name_id) VALUES (7,'Renang');
INSERT INTO categories (parent_id,name_id) VALUES (7,'baseball');
INSERT INTO categories (parent_id,name_id) VALUES (7,'Panahan');
INSERT INTO categories (parent_id,name_id) VALUES (8,'Accesoris motor,mobil');
INSERT INTO categories (parent_id,name_id) VALUES (9,'Pakaian Wanita');
INSERT INTO categories (parent_id,name_id) VALUES (9,'Pakaian Pria');
INSERT INTO categories (parent_id,name_id) VALUES (9,'Pakaian Anak');
INSERT INTO categories (parent_id,name_id) VALUES (9,'Batik');
INSERT INTO categories (parent_id,name_id) VALUES (10,'Perlengkapan dapur');
INSERT INTO categories (parent_id,name_id) VALUES (10,'Perlengkapan kamar tidur');
INSERT INTO categories (parent_id,name_id) VALUES (10,'Perlengkapan kamar mandi');
INSERT INTO categories (parent_id,name_id) VALUES (10,'Keperluan rumah tangga dll');
INSERT INTO categories (parent_id,name_id) VALUES (11,'Produk lainnya');

UPDATE categories SET name_en = name_id WHERE name_en='';

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