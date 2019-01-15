INSERT INTO categories (id,parent_id,name_id) VALUES (51,49,'Sayur Mayur');
INSERT INTO categories (id,parent_id,name_id) VALUES (52,49,'Buah Buahan');
INSERT INTO categories (id,parent_id,name_id) VALUES (53,49,'Bumbu Dapur');
INSERT INTO categories (id,parent_id,name_id) VALUES (54,49,'Daging Sapi');
INSERT INTO categories (id,parent_id,name_id) VALUES (55,49,'Daging Ayam');
INSERT INTO categories (id,parent_id,name_id) VALUES (56,49,'Tahu/Tempe/Oncom');
INSERT INTO categories (id,parent_id,name_id) VALUES (57,49,'Bahan Kue dan Plastik Dan Kemasan');
INSERT INTO categories (id,parent_id,name_id) VALUES (58,49,'Kerupuk & Kacang Kacangan');
INSERT INTO categories (id,parent_id,name_id) VALUES (59,49,'Makanan Instan');
INSERT INTO categories (id,parent_id,name_id) VALUES (60,49,'Ikan dan Seafood');
INSERT INTO categories (id,parent_id,name_id) VALUES (61,49,'Telur');
INSERT INTO categories (id,parent_id,name_id) VALUES (62,49,'Paket Sayur');
INSERT INTO categories (id,parent_id,name_id) VALUES (63,49,'Umbi Umbian');
INSERT INTO categories (id,parent_id,name_id) VALUES (64,49,'Makanan Olahan');
INSERT INTO categories (id,parent_id,name_id) VALUES (65,49,'Jajanan Pasar');
INSERT INTO categories (id,parent_id,name_id) VALUES (66,49,'Kelontong');
INSERT INTO categories (id,parent_id,name_id) VALUES (67,49,'Kopi Teh dan Cokelat (Bubuk)');
INSERT INTO categories (id,parent_id,name_id) VALUES (68,49,'Sembako');
INSERT INTO categories (id,parent_id,name_id) VALUES (69,49,'Peralatan Ziarah');
INSERT INTO categories (id,parent_id,name_id) VALUES (70,49,'Air Kemasan');
INSERT INTO categories (id,parent_id,name_id) VALUES (71,49,'Perlengkapan Pribadi');
INSERT INTO categories (id,parent_id,name_id) VALUES (72,49,'Perlengkapan Rumah dan Dapur');
UPDATE categories SET name_en=name_id WHERE id > 50;


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