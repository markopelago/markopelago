<?php
class Vocabulary{
	protected $locale;
	public function __construct($locale){
		$this->locale = $locale;
	}
	
	public function capitalize($words){
		$words = strtolower($words);
		$arr = explode(" ",$words);
		$return = "";
		foreach($arr as $word){ $return .= strtoupper(substr($word,0,1)).substr($word,1)." "; }
		return $return;
	}
	
	public function w($index){ return $this->words($index); }
	
	public function words($index){
		$l = "en";
		$arr[$l]["search"] 										= "Search";
		$arr[$l]["please_type_your_serach"] 					= "Please type your serach";
		$arr[$l]["categories"] 									= "Categories";
		$arr[$l]["allcategories"] 								= "All Categories";
		$arr[$l]["yes"] 										= "Yes";
		$arr[$l]["no"] 											= "No";
		$arr[$l]["cancel"] 										= "Cancel";
		$arr[$l]["close"] 										= "Close";
		$arr[$l]["at"] 											= "at";
		$arr[$l]["send"] 										= "Send";
		$arr[$l]["more"] 										= "More";
		$arr[$l]["show_advanced_search"] 						= "Show Advanced Search";
		$arr[$l]["hide_advanced_search"] 						= "Hide Advanced Search";
		$arr[$l]["hello"] 										= "Hello";
		$arr[$l]["username"] 									= "Username";
		$arr[$l]["signin"] 										= "Sign In";
		$arr[$l]["signout"] 									= "Sign Out";
		$arr[$l]["signup"] 										= "Sign Up";
		$arr[$l]["starts_here"] 								= "Your Journey Starts Here";
		$arr[$l]["fullname"]	 								= "Full Name";
		$arr[$l]["email"]	 									= "E-mail";
		$arr[$l]["address"]										= "Address";
		$arr[$l]["birth_at"]									= "Birth Date";
		$arr[$l]["birth_place"]									= "Birth Place";
		$arr[$l]["email_address"]								= "E-mail Address";
		$arr[$l]["password"]									= "Password";
		$arr[$l]["forgot_password"]								= "Forgot Password";
		$arr[$l]["reset_password_instruction"]					= "Reset Password Instruction";
		$arr[$l]["reset_password_instruction_sent"]				= "Reset password instruction has been sent, please check Your email";
		$arr[$l]["request_reset_password"]						= "Please enter your email address that is already registered in markopelago.com and we'll send you instruction on how to reset your password";
		$arr[$l]["request_reset_password_token_expired"]		= "This reset password instruction has expired, make sure this link from the newest email or request reset password instruction again";
		$arr[$l]["email_confirmation_token_expired"]			= "This email confirmation link has expired, please contact cs@markopelago.com";
		$arr[$l]["email_confirmation_failed"]					= "Email confirmation failed, please contact cs@markopelago.com";
		$arr[$l]["email_confirmed"]								= "Thank You, Your email confirmation was success.";
		$arr[$l]["your_email_not_exist"]						= "Your email address is not registered at markopelago.com";
		$arr[$l]["please_relogin"]								= "Please re-login";
		$arr[$l]["oldpassword"]									= "Old Password";
		$arr[$l]["newpassword"]									= "New Password";
		$arr[$l]["repassword"]									= "Retype Password";
		$arr[$l]["minimum_6_characters"]						= "Minimum 6 characters";
		$arr[$l]["password_error"]								= "Password Invalid";
		$arr[$l]["email_invalid"]								= "Email Invalid";
		$arr[$l]["email_already_in_use"]						= "Email is already in use. please choose another one";
		$arr[$l]["range_characters"]							= "6-8 characters";
		$arr[$l]["by_signing_up_i_agree_to"]					= "By Signing Up, I agree to markopelago's";
		$arr[$l]["terms_and_conditions"]						= "Terms and Conditions";
		$arr[$l]["terms_and_conditions_agreed"]					= "Yes, I agree to the <a class=\"scroll-link\" href=\"javascript:loadInfo('terms_and_conditions');\">Terms and Conditions</a> that apply at Markopelago.com";
		$arr[$l]["and"]											= "and";
		$arr[$l]["or"]											= "or";
		$arr[$l]["privacy_policy"]								= "Privacy Policy";
		$arr[$l]["keyword"]										= "Keyword";
		$arr[$l]["news"]										= "News";
		$arr[$l]["show_all"]									= "Show All";
		$arr[$l]["signup"]										= "Sign Up";
		$arr[$l]["my_dashboard"]								= "My Dashboard";
		$arr[$l]["dashboard"]									= "Dashboard";
		$arr[$l]["back_to_dashboard"]							= "Back to Dashboard";
		$arr[$l]["signin_success"]								= "Sign In Success";
		$arr[$l]["signup_success"]								= "Congratulations, You have successfully registered at markopelago.com";
		$arr[$l]["error_wrong_username_password"]				= "Sign In failed, wrong username and/or password, Please try again!";
		$arr[$l]["connect_socially_with_us"]					= "Connect socially with us";
		$arr[$l]["links"]										= "Links";
		$arr[$l]["contact_us"]									= "Contact Us";
		$arr[$l]["about"]										= "About";
		$arr[$l]["contact"]										= "Contact";
		$arr[$l]["message"]										= "Message";
		$arr[$l]["send_message_to_seller"]						= "Send message to seller";
		$arr[$l]["register_as"]									= "Register as";
		$arr[$l]["register"]									= "Register";
		$arr[$l]["seller"]										= "Seller";
		$arr[$l]["about_seller"]								= "About Seller";
		$arr[$l]["buyer"]										= "Buyer";
		$arr[$l]["forwarder"]									= "Forwarder";
		$arr[$l]["profile"]										= "Profile";
		$arr[$l]["nationality"]									= "Nationality";
		$arr[$l]["location"]									= "Location";
		$arr[$l]["save"]										= "Save";
		$arr[$l]["add"]											= "Add";
		$arr[$l]["edit"]										= "Edit";
		$arr[$l]["view"]										= "View";
		$arr[$l]["view_detail"]									= "View Detail";
		$arr[$l]["delete"]										= "Delete";
		$arr[$l]["data_not_found"]								= "Data not found";
		$arr[$l]["no_photo_found"]								= "No photo found";
		$arr[$l]["message_not_found"]							= "Message not found";
		$arr[$l]["gender"]										= "Gender";
		$arr[$l]["applicants"]									= "Applicants";
		$arr[$l]["you_have_to_login_first"]						= "You have to log in first";
		$arr[$l]["hot_products"]								= "Hot Products";
		$arr[$l]["newest_goods"]								= "Newest Goods";
		$arr[$l]["best_selling_goods"]							= "Best selling goods";
		$arr[$l]["recommended_goods"]							= "Recommended Goods";
		$arr[$l]["recommended_sellers"]							= "Recommended Sellers";
		$arr[$l]["view_all"]									= "View All";
		$arr[$l]["register_as_seller"]							= "Register as Seller";
		$arr[$l]["register_as_buyer"]							= "Register as Buyer";
		$arr[$l]["register_as_forwarder"]						= "Register as Forwarder";
		$arr[$l]["change_password"]								= "Change Password";
		$arr[$l]["change_password_success"]						= "Change Password Success";
		$arr[$l]["change_password_failed"]						= "Change Password Failed";
		$arr[$l]["survey"]										= "Survey";
		$arr[$l]["seller_survey"]								= "Seller Survey";
		$arr[$l]["forwarder_survey"]							= "Forwarder Survey";
		$arr[$l]["add_seller_survey"]							= "Add Seller Survey";
		$arr[$l]["add_forwarder_survey"]						= "Add Forwarder Survey";
		$arr[$l]["edit_seller_survey"]							= "Edit Seller Survey";
		$arr[$l]["edit_forwarder_survey"]						= "Edit Forwarder Survey";
		$arr[$l]["my_survey_histories"]							= "My Survey Histories";
		$arr[$l]["name"]										= "Name";
		$arr[$l]["phone"]										= "Phone";
		$arr[$l]["survey_date"]									= "Survey Date";
		$arr[$l]["coordinate"]									= "Coordinate";
		$arr[$l]["get_coordinate"]								= "Get Coordinate";
		$arr[$l]["next"]										= "Next";
		$arr[$l]["back"]										= "Back";
		$arr[$l]["surveyed_at"]									= "Surveyed At";
		$arr[$l]["upload_photo"]								= "Upload Photo";
		$arr[$l]["take_photo"]									= "Take Photo";
		$arr[$l]["finish"]										= "Finish";
		$arr[$l]["are_you_sure_delete_photo"]					= "Are you sure want to delete this photo?";
		$arr[$l]["update_photo_caption_success"]				= "Photo's caption updated successfully";
		$arr[$l]["update_photo_caption_failed"]					= "Failed updating photo's caption";
		$arr[$l]["buy"]											= "Buy";
		$arr[$l]["is_taxable"]									= "Taxable";
		$arr[$l]["npwp"]										= "NPWP";
		$arr[$l]["nppkp"]										= "NPPKP";
		$arr[$l]["npwp_address"]								= "NPWP Address";
		$arr[$l]["failed_sign_up"]								= "Sign up failed, please try again";
		$arr[$l]["browse"]										= "Browse";
		$arr[$l]["description"]									= "Description";
		$arr[$l]["store"]										= "Store";
		$arr[$l]["store_name"]									= "Store Name";
		$arr[$l]["pic"]											= "PIC";
		$arr[$l]["product_information"]							= "Product Information";
		$arr[$l]["weight"]										= "Weight";
		$arr[$l]["dimension"]									= "Dimension";
		$arr[$l]["condition"]									= "Condition";
		$arr[$l]["product_description"]							= "Product Description";
		$arr[$l]["price"]										= "Price";
		$arr[$l]["goods_prices"]								= "Goods Price List";
		$arr[$l]["failed_transaction"]							= "Transaction was failed, please contact our customer service.";
		$arr[$l]["product_name"]								= "Product Name";
		$arr[$l]["qty"]											= "Qty";
		$arr[$l]["min_qty"]										= "Minumum Qty";
		$arr[$l]["commission"]									= "Commission";
		$arr[$l]["display_price"]								= "Display Price";
		$arr[$l]["promo_code"]									= "Promo Code";
		$arr[$l]["province"]									= "Province";
		$arr[$l]["city"]										= "City";
		$arr[$l]["district"]									= "District";
		$arr[$l]["subdistrict"]									= "Sub District";
		$arr[$l]["cart"]										= "Cart";
		$arr[$l]["shopping_cart"]								= "Shopping Cart";
		$arr[$l]["success_add_to_cart"]							= "Product successfully added to the cart";
		$arr[$l]["more_shopping"]								= "More Shopping";
		$arr[$l]["pay"]											= "Pay";
		$arr[$l]["paid"]										= "Paid";
		$arr[$l]["finalization_of_purchases"]					= "Finalization of Purchases";
		$arr[$l]["finalization_of_purchases_failed"]			= "Finalization of Purchases Failed";
		$arr[$l]["notes_for_seller"]							= "Notes for Seller";
		$arr[$l]["delivery_destination"]						= "Delivery Destination";
		$arr[$l]["choose_another_address"]						= "Choose another address";
		$arr[$l]["delivery_courier"]							= "Delivery Courier";
		$arr[$l]["courier_service"]								= "Courier Service";
		$arr[$l]["shipping_charges"]							= "Shipping Charges";
		$arr[$l]["addresses"]									= "Addresses";
		$arr[$l]["register_shipping_address_first"]				= "Please register your shipping address first";
		$arr[$l]["banks"]										= "Banks";
		$arr[$l]["bank"]										= "Bank";
		$arr[$l]["change_photo"]								= "Change Photo";
		$arr[$l]["change_logo"]									= "Change Logo";
		$arr[$l]["change_avatar"]								= "Change Avatar";
		$arr[$l]["change_header"]								= "Change Store Header";
		$arr[$l]["error_upload_image"]							= "Error upload image";
		$arr[$l]["bank_name"]									= "Bank Name";
		$arr[$l]["account_no"]									= "Account No";
		$arr[$l]["account_name"]								= "Account Name";
		$arr[$l]["branch"]										= "Branch";
		$arr[$l]["data_saved_successfully"]						= "Data saved successfully";
		$arr[$l]["image_saved_successfully"]					= "Image saved successfully";
		$arr[$l]["failed_saving_data"]							= "Failed saving data.";
		$arr[$l]["example_home_office"]							= "example: Home, Office,...";
		$arr[$l]["address_name"]								= "Address Name";
		$arr[$l]["address_type"]								= "Address Type";
		$arr[$l]["primary_address"]								= "Primary Address";
		$arr[$l]["add_address"]									= "Add Address";
		$arr[$l]["edit_address"]								= "Edit Address";
		$arr[$l]["primary_bank"]								= "Primary Bank";
		$arr[$l]["add_bank"]									= "Add Bank";
		$arr[$l]["edit_bank"]									= "Edit Bank";
		$arr[$l]["confirm_delete"]								= "Are You sure want to delete this data";
		$arr[$l]["confirm_delete_transaction"]					= "Are You sure want to delete this goods from cart";
		$arr[$l]["profile_my_store"]							= "Profile My Store";
		$arr[$l]["my_goods"]									= "My Products";
		$arr[$l]["goods"]										= "Goods";
		$arr[$l]["goods_list"]									= "Goods List";
		$arr[$l]["you_not_yet_seller"]							= "You are not yet registered as a seller";
		$arr[$l]["register_as_seller_now"]						= "Want to register as a seller now";
		$arr[$l]["add_goods"]									= "Add Goods";
		$arr[$l]["add_goods_photo"]								= "Add Goods Photo";
		$arr[$l]["edit_goods_photo"]							= "Edit Goods Photo";
		$arr[$l]["edit_goods"]									= "Edit Goods";
		$arr[$l]["goods_photos"]								= "Goods Photos";
		$arr[$l]["stock"]										= "Stock";
		$arr[$l]["stock_history"]								= "Stock History";
		$arr[$l]["empty_stock"]									= "Empty Stock";
		$arr[$l]["current_stock"]								= "Current Stcok";
		$arr[$l]["example_first_stock"]							= "example: First Stock";
		$arr[$l]["add_goods_stock_history"]						= "Add Stock History";
		$arr[$l]["edit_goods_stock_history"]					= "Edit Stock History";
		$arr[$l]["add_goods_prices"]							= "Add Goods Prices";
		$arr[$l]["edit_goods_prices"]							= "Edit Goods Prices";
		$arr[$l]["goods_name"]									= "Goods Name";
		$arr[$l]["unit"]										= "Unit";
		$arr[$l]["new"]											= "New";
		$arr[$l]["second_hand"]									= "Second Hand";
		$arr[$l]["choose_categories"]							= "Choose Categories";
		$arr[$l]["choose_couriers"]								= "Choose Couriers";
		$arr[$l]["weight_per_unit"]								= "Weight per Unit";
		$arr[$l]["availability_days"]							= "Tempo availability of goods";
		$arr[$l]["days"]										= "Day(s)";
		$arr[$l]["rupiahs"]										= "Rupiahs";
		$arr[$l]["please_select_categories"]					= "Please select categories";
		$arr[$l]["please_select_couriers"]						= "Please select couriers";
		$arr[$l]["l_w_h"]										= "Length (cm) x Width (cm) x Height (cm)";
		$arr[$l]["l_w_h2"]										= "L (cm) x W (cm) x H (cm)";
		$arr[$l]["length"]										= "Length";
		$arr[$l]["width"]										= "Width";
		$arr[$l]["height"]										= "Height";
		$arr[$l]["you_dont_have_access"]						= "You don't have access";
		$arr[$l]["date"]										= "Date";
		$arr[$l]["po_number"]									= "PO Number";
		$arr[$l]["in_out"]										= "In/Out";
		$arr[$l]["in"]											= "In";
		$arr[$l]["out"]											= "Out";
		$arr[$l]["notes"]										= "Notes";
		$arr[$l]["invoice_at"]									= "Invoice At";
		$arr[$l]["invoice_no"]									= "Invoice No";
		$arr[$l]["po_at"]										= "PO At";
		$arr[$l]["po_no"]										= "PO No";		
		$arr[$l]["process_this_po"]								= "Process this PO";
		$arr[$l]["this_po_has_been_processed"]					= "This PO has been processed";
		$arr[$l]["po_was_delivered"]							= "Goods on this PO list was delivered";
		$arr[$l]["goods_was_delivered"]							= "Goods was delivered";
		$arr[$l]["update_goods_was_delivered"]					= "Goods delivered update status";
		$arr[$l]["edit_receipt_no"]								= "Edit Receipt Number";
		$arr[$l]["delivered_at"]								= "Delivered At";
		$arr[$l]["are_you_sure_to_process_this_po"]				= "Are You sure to process this PO";
		$arr[$l]["please_enter_the_shipping_receipt_number"]	= "Please enter the shipping receipt number";
		$arr[$l]["shipping_receipt_number"]						= "Shipping receipt number";
		$arr[$l]["receipt_number"]								= "Receipt number";
		$arr[$l]["transaction_done"]							= "Transaction Done";
		$arr[$l]["are_you_sure_transaction_done"]				= "Are You sure this transaction were done";
		$arr[$l]["purchase_list"]								= "Purchase List";
		$arr[$l]["store_sales_list"]							= "Store Sales List";
		$arr[$l]["total_bill"]									= "Total Bill";
		$arr[$l]["total_shopping"]								= "Total Shopping";
		$arr[$l]["payment_confirmation_success"]				= "Payment Confirmation sent";
		$arr[$l]["payment"]										= "Payment";
		$arr[$l]["choose_the_destination_bank"]					= "Choose the destination bank";
		$arr[$l]["the_destination_bank"]						= "The destination bank";
		$arr[$l]["please_add_your_store_address"]				= "Please add Your store`s address";
		$arr[$l]["to"]											= "to";
		$arr[$l]["other_goods_from_seller"]						= "Other goods from seller";
		$arr[$l]["show_shopping_progress"]						= "Show progress";
		$arr[$l]["shopping_progress"]							= "Shopping Progress";
		$arr[$l]["reason_markopelago_member"]					= "&#34;Why sell and shop at Markopelago?<br>because Markopelago is really Indonesian&#34; this is the proof :";
		$arr[$l]["marko_id_invalid_char"]						= "Use letters and numbers only (without spaces)";
		$arr[$l]["marko_id_invalid_length"]						= "Minimum 6 characters";
		$arr[$l]["marko_id_exist"]								= "Marko ID has already been used";
		
		/*==================================================================================================================================*/
		/*==================================================================================================================================*/
		$l = "id";
		$arr[$l]["search"] 										= "Cari";
		$arr[$l]["please_type_your_serach"] 					= "Silakan ketik pencarian Anda";
		$arr[$l]["categories"] 									= "Kategori";
		$arr[$l]["allcategories"] 								= "Semua Kategori";
		$arr[$l]["yes"] 										= "Ya";
		$arr[$l]["no"] 											= "Tidak";
		$arr[$l]["cancel"] 										= "Batal";
		$arr[$l]["close"] 										= "Tutup";
		$arr[$l]["at"] 											= "pada";
		$arr[$l]["send"] 										= "Kirim";
		$arr[$l]["more"] 										= "Lihat Lebih";
		$arr[$l]["show_advanced_search"] 						= "Tampilkan Pencarian";
		$arr[$l]["hide_advanced_search"] 						= "Sembunyikan Pencarian";
		$arr[$l]["hello"] 										= "Halo";
		$arr[$l]["username"] 									= "Username";
		$arr[$l]["signin"] 										= "Masuk";
		$arr[$l]["signout"] 									= "Keluar";
		$arr[$l]["signup"] 										= "Daftar";
		$arr[$l]["starts_here"] 								= "Perjalanan Anda dimulai disini";
		$arr[$l]["fullname"]	 								= "Nama Lengkap";
		$arr[$l]["email"]	 									= "E-mail";
		$arr[$l]["address"]										= "Alamat";
		$arr[$l]["birth_at"]									= "Tanggal Lahir";
		$arr[$l]["birth_place"]									= "Tempat Lahir";
		$arr[$l]["email_address"]								= "Alamat Email";
		$arr[$l]["password"]									= "Kata Sandi";
		$arr[$l]["forgot_password"]								= "Lupa Kata Sandi";
		$arr[$l]["reset_password_instruction"]					= "Instruksi Reset Kata Sandi";
		$arr[$l]["reset_password_instruction_sent"]				= "Instruksi reset kata sandi telah terkirim, silakan cek email Anda";
		$arr[$l]["request_reset_password"]						= "Silakan masukan alamat email Anda yang telah terdaftar di markopelago.com dan Kami akan mengirimkan instruksi reset kata sandi kepada Anda";
		$arr[$l]["request_reset_password_token_expired"]		= "Insturksi reset kata sandi ini telah kedaluwarsa, pastikan link ini dari email terbaru atau silakan minta instruksi reset kata sandi lagi.";
		$arr[$l]["email_confirmation_token_expired"]			= "Link konfirmasi email ini telah kedaluwarsa, silakan hubungi cs@markopelago.com";
		$arr[$l]["email_confirmation_failed"]					= "Konfirmasi email gagal, silakan hubungi cs@markopelago.com";
		$arr[$l]["email_confirmed"]								= "Terima Kasih, Konfirmasi email Anda telah berhasil.";
		$arr[$l]["your_email_not_exist"]						= "Alamat email Anda belum terdaftar di markopelago.com";
		$arr[$l]["please_relogin"]								= "Silakan login ulang";
		$arr[$l]["oldpassword"]									= "Kata Sandi Lama";
		$arr[$l]["newpassword"]									= "Kata Sandi Baru";
		$arr[$l]["repassword"]									= "Ketik Ulang Kata Sandi";
		$arr[$l]["minimum_6_characters"]						= "Minimal 6 karakter";
		$arr[$l]["password_error"]								= "Kesalahan pada Kata Sandi";
		$arr[$l]["email_invalid"]								= "Kesalahan pada email";
		$arr[$l]["email_already_in_use"]						= "Email sudah digunakan, silakan gunakan email yang lain";
		$arr[$l]["range_characters"]							= "6-8 Karakter";
		$arr[$l]["by_signing_up_i_agree_to"]					= "Dengan mendaftar berarti Saya telah menyetujui";
		$arr[$l]["terms_and_conditions"]						= "Syarat dan Ketentuan";
		$arr[$l]["terms_and_conditions_agreed"]					= "Ya, Saya menyetujui <a class=\"scroll-link\" href=\"javascript:loadInfo('terms_and_conditions');\">Syarat dan Ketentuan</a> yang berlaku di Markopelago.com";
		$arr[$l]["and"]											= "dan";
		$arr[$l]["or"]											= "atau";
		$arr[$l]["privacy_policy"]								= "Polis kerahasiaan";
		$arr[$l]["keyword"]										= "Kata Kunci";
		$arr[$l]["news"]										= "Berita";
		$arr[$l]["show_all"]									= "Lihat Semua";
		$arr[$l]["signup"]										= "Daftar";
		$arr[$l]["my_dashboard"]								= "Dasbor Saya";
		$arr[$l]["dashboard"]									= "Dasbor";
		$arr[$l]["back_to_dashboard"]							= "Kembali Ke Dasbor";
		$arr[$l]["signin_success"]								= "Anda berhasil masuk";
		$arr[$l]["signup_success"]								= "Selamat, Anda telah berhasil daftar di markopelago.com";
		$arr[$l]["error_wrong_username_password"]				= "Anda gagal masuk, username dan/atau password salah, Silakan ulangi lagi!";
		$arr[$l]["connect_socially_with_us"]					= "Terhubung media sosial dengan kami";
		$arr[$l]["links"]										= "Link";
		$arr[$l]["contact_us"]									= "Hubungi Kami";
		$arr[$l]["about"]										= "Tentang Kami";
		$arr[$l]["contact"]										= "Hubungi";
		$arr[$l]["message"]										= "Pesan";
		$arr[$l]["send_message_to_seller"]						= "Kirim pesan ke penjual";
		$arr[$l]["register_as"]									= "Daftar sebagai";
		$arr[$l]["register"]									= "Daftar";
		$arr[$l]["seller"]										= "Penjual";
		$arr[$l]["about_seller"]								= "Tentang Penjual";
		$arr[$l]["buyer"]										= "Pembeli";
		$arr[$l]["forwarder"]									= "Ekspeditur";
		$arr[$l]["profile"]										= "Profil";
		$arr[$l]["nationality"]									= "Kebangsaan";
		$arr[$l]["location"]									= "Lokasi";
		$arr[$l]["save"]										= "Simpan";
		$arr[$l]["add"]											= "Tambah";
		$arr[$l]["edit"]										= "Ubah";
		$arr[$l]["view"]										= "Lihat";
		$arr[$l]["view_detail"]									= "Lihat Detail";
		$arr[$l]["delete"]										= "Hapus";
		$arr[$l]["data_not_found"]								= "Data tidak ditemukan";
		$arr[$l]["no_photo_found"]								= "Foto tidak ditemukan";
		$arr[$l]["message_not_found"]							= "Pesan tidak ditemukan";
		$arr[$l]["gender"]										= "Jenis Kelamin";
		$arr[$l]["applicants"]									= "Pelamar";
		$arr[$l]["you_have_to_login_first"]						= "Anda harus login terlebih dahulu";
		$arr[$l]["hot_products"]								= "Hot Products";
		$arr[$l]["newest_goods"]								= "Produk yang baru masuk";
		$arr[$l]["best_selling_goods"]							= "Produk Terlaris";
		$arr[$l]["recommended_goods"]							= "Rekomendasi Produk";
		$arr[$l]["recommended_sellers"]							= "Rekomendasi Penjual";
		$arr[$l]["view_all"]									= "Lihat semua";
		$arr[$l]["register_as_seller"]							= "Daftar sebagai Penjual";
		$arr[$l]["register_as_buyer"]							= "Daftar sebagai Pembeli";
		$arr[$l]["register_as_forwarder"]						= "Daftar sebagai Ekspeditur";
		$arr[$l]["change_password"]								= "Ubah Password";
		$arr[$l]["change_password_success"]						= "Ubah Password Berhasil";
		$arr[$l]["change_password_failed"]						= "Ubah Password Gagal";
		$arr[$l]["survey"]										= "Survei";
		$arr[$l]["seller_survey"]								= "Survei Penjual";
		$arr[$l]["forwarder_survey"]							= "Survei Ekspeditur";
		$arr[$l]["add_seller_survey"]							= "Tambah Survei Penjual";
		$arr[$l]["add_forwarder_survey"]						= "Tambah Survei Ekspeditur";
		$arr[$l]["edit_seller_survey"]							= "Ubah Survei Penjual";
		$arr[$l]["edit_forwarder_survey"]						= "Ubah Survei Ekspeditur";
		$arr[$l]["my_survey_histories"]							= "Histori Survei Saya";
		$arr[$l]["name"]										= "Nama";
		$arr[$l]["phone"]										= "Telepon";
		$arr[$l]["survey_date"]									= "Tanggal Survei";
		$arr[$l]["coordinate"]									= "Koordinat";
		$arr[$l]["get_coordinate"]								= "Muat Koordinat";
		$arr[$l]["next"]										= "Lanjut";
		$arr[$l]["back"]										= "Kembali";
		$arr[$l]["surveyed_at"]									= "Tanggal Survei";
		$arr[$l]["upload_photo"]								= "Unggah Foto";
		$arr[$l]["take_photo"]									= "Ambil Foto";
		$arr[$l]["finish"]										= "Selesai";
		$arr[$l]["are_you_sure_delete_photo"]					= "Anda yakin akan menghapus foto ini?";
		$arr[$l]["update_photo_caption_success"]				= "Berhasil mengubah judul photo";
		$arr[$l]["update_photo_caption_failed"]					= "Gagal mengubah judul photo";
		$arr[$l]["buy"]											= "Beli";
		$arr[$l]["is_taxable"]									= "PKP";
		$arr[$l]["npwp"]										= "NPWP";
		$arr[$l]["nppkp"]										= "NPPKP";
		$arr[$l]["npwp_address"]								= "Alamat NPWP";
		$arr[$l]["failed_sign_up"]								= "Registrasi gagal, silakan coba lagi";
		$arr[$l]["browse"]										= "Telusuri";
		$arr[$l]["description"]									= "Deskripsi";
		$arr[$l]["store"]										= "Toko";
		$arr[$l]["store_name"]									= "Nama Toko";
		$arr[$l]["pic"]											= "PIC";
		$arr[$l]["product_information"]							= "Info Produk";
		$arr[$l]["weight"]										= "Berat";
		$arr[$l]["dimension"]									= "Dimensi";
		$arr[$l]["condition"]									= "Kondisi";
		$arr[$l]["product_description"]							= "Deskripsi Produk";
		$arr[$l]["price"]										= "Harga";
		$arr[$l]["goods_prices"]								= "Daftar Harga Produk";
		$arr[$l]["failed_transaction"]							= "Transaksi gagal, silakan hubungi pelayanan pelanggan Kami";
		$arr[$l]["product_name"]								= "Nama Produk";
		$arr[$l]["qty"]											= "Qty";
		$arr[$l]["min_qty"]										= "Qty Minumum";
		$arr[$l]["commission"]									= "Komisi";
		$arr[$l]["display_price"]								= "Harga tampilan";
		$arr[$l]["promo_code"]									= "Kode Promo";
		$arr[$l]["province"]									= "Propinsi";
		$arr[$l]["city"]										= "Kota";
		$arr[$l]["district"]									= "Kecamatan";
		$arr[$l]["subdistrict"]									= "Kelurahan";
		$arr[$l]["cart"]										= "Keranjang";
		$arr[$l]["shopping_cart"]								= "Keranjang Belanja";
		$arr[$l]["success_add_to_cart"]							= "Produk berhasil ditambahkan ke keranjang";
		$arr[$l]["more_shopping"]								= "Lanjut Belanja";
		$arr[$l]["pay"]											= "Bayar";
		$arr[$l]["paid"]										= "Lunas";
		$arr[$l]["finalization_of_purchases"]					= "Finalisasi Pembelian";
		$arr[$l]["finalization_of_purchases_failed"]			= "Finalisasi Pembelian Gagal";
		$arr[$l]["notes_for_seller"]							= "Catatan untuk Penjual";
		$arr[$l]["delivery_destination"]						= "Tujuan Pengiriman";
		$arr[$l]["choose_another_address"]						= "Pilih alamat lain";
		$arr[$l]["delivery_courier"]							= "Kurir Pengiriman";
		$arr[$l]["courier_service"]								= "Servis Kurir";
		$arr[$l]["shipping_charges"]							= "Ongkos Kirim";
		$arr[$l]["addresses"]									= "Alamat";
		$arr[$l]["register_shipping_address_first"]				= "Harap daftarkan alamat pengiriman terlebih dahulu";
		$arr[$l]["banks"]										= "Bank";
		$arr[$l]["bank"]										= "Bank";
		$arr[$l]["change_photo"]								= "Ubah Foto";
		$arr[$l]["change_logo"]									= "Ubah Logo";
		$arr[$l]["change_avatar"]								= "Ubah Avatar";
		$arr[$l]["change_header"]								= "Ubah Header Toko";
		$arr[$l]["error_upload_image"]							= "Ada kesalahan saat mengunggah gambar";
		$arr[$l]["bank_name"]									= "Nama Bank";
		$arr[$l]["account_no"]									= "Nomor Akun";
		$arr[$l]["account_name"]								= "Nama Pemilik Rekening";
		$arr[$l]["branch"]										= "Cabang";
		$arr[$l]["data_saved_successfully"]						= "Penyimpanan data berhasil";
		$arr[$l]["image_saved_successfully"]					= "Penyimpanan gambar berhasil";
		$arr[$l]["failed_saving_data"]							= "Gagal menyimpan data.";
		$arr[$l]["example_home_office"]							= "contoh: Rumah, Kantor,...";
		$arr[$l]["address_name"]								= "Nama Alamat";
		$arr[$l]["address_type"]								= "Jenis Alamat";
		$arr[$l]["primary_address"]								= "Alamat Utama";
		$arr[$l]["add_address"]									= "Tambah Alamat";
		$arr[$l]["edit_address"]								= "Ubah Alamat";
		$arr[$l]["primary_bank"]								= "Bank Utama";
		$arr[$l]["add_bank"]									= "Tambah Bank";
		$arr[$l]["edit_bank"]									= "Ubah Bank";
		$arr[$l]["confirm_delete"]								= "Anda yakin akan menghapus data tersebut";
		$arr[$l]["confirm_delete_transaction"]					= "Anda yakin akan menghapus barang ini dari keranjang belanja";
		$arr[$l]["profile_my_store"]							= "Profil Toko Saya";
		$arr[$l]["my_goods"]									= "Daftar Produk Saya";
		$arr[$l]["goods"]										= "Produk";
		$arr[$l]["goods_list"]									= "Daftar Produk";
		$arr[$l]["you_not_yet_seller"]							= "Anda belum terdaftar sebagai penjual";
		$arr[$l]["register_as_seller_now"]						= "Ingin mendaftar sebagai penjual sekarang";
		$arr[$l]["add_goods"]									= "Tambah Produk";
		$arr[$l]["add_goods_photo"]								= "Tambah Foto Produk";
		$arr[$l]["edit_goods_photo"]							= "Ubah Foto Produk";
		$arr[$l]["edit_goods"]									= "Ubah Produk";
		$arr[$l]["goods_photos"]								= "Foto Produk";
		$arr[$l]["stock"]										= "Stok";
		$arr[$l]["stock_history"]								= "Catatan Stok";
		$arr[$l]["empty_stock"]									= "Stok Kosong";
		$arr[$l]["current_stock"]								= "Stok Sekarang";
		$arr[$l]["example_first_stock"]							= "contoh: Stok Awal";
		$arr[$l]["add_goods_stock_history"]						= "Tambah Catatan Stok";
		$arr[$l]["edit_goods_stock_history"]					= "Ubah Catatan Stok";
		$arr[$l]["add_goods_prices"]							= "Tambah Harga Produk";
		$arr[$l]["edit_goods_prices"]							= "Ubah Harga Produk";
		$arr[$l]["goods_name"]									= "Nama Produk";
		$arr[$l]["unit"]										= "Satuan";
		$arr[$l]["new"]											= "Baru";
		$arr[$l]["second_hand"]									= "Bekas";
		$arr[$l]["choose_categories"]							= "Pilih Kategori";
		$arr[$l]["choose_couriers"]								= "Pilih Kurir";
		$arr[$l]["weight_per_unit"]								= "Berat per satuan";
		$arr[$l]["availability_days"]							= "Tempo ketersedian produk";
		$arr[$l]["days"]										= "Hari";
		$arr[$l]["rupiahs"]										= "Rupiah";
		$arr[$l]["please_select_categories"]					= "Silakan pilih kategori";
		$arr[$l]["please_select_couriers"]						= "Silakan pilih kurir";
		$arr[$l]["l_w_h"]										= "Panjang (cm) x Lebar (cm) x Tinggi (cm)";
		$arr[$l]["l_w_h2"]										= "P (cm) x L (cm) x T (cm)";
		$arr[$l]["length"]										= "Panjang";
		$arr[$l]["width"]										= "Lebar";
		$arr[$l]["height"]										= "Tinggi";
		$arr[$l]["you_dont_have_access"]						= "Anda tidak punya akses";
		$arr[$l]["date"]										= "Tanggal";
		$arr[$l]["po_number"]									= "Nomor PO";
		$arr[$l]["in_out"]										= "Masuk/Keluar";
		$arr[$l]["in"]											= "Masuk";
		$arr[$l]["out"]											= "Keluar";
		$arr[$l]["notes"]										= "Keterangan";
		$arr[$l]["invoice_at"]									= "Tanggal Invoice";
		$arr[$l]["invoice_no"]									= "Nomor Invoice";
		$arr[$l]["po_at"]										= "Tanggal PO";
		$arr[$l]["po_no"]										= "Nomor PO";
		$arr[$l]["process_this_po"]								= "Proses PO ini";
		$arr[$l]["this_po_has_been_processed"]					= "PO ini telah diproses";
		$arr[$l]["po_was_delivered"]							= "Barang pada PO ini telah terkirim";
		$arr[$l]["goods_was_delivered"]							= "Barang ini telah terkirim";
		$arr[$l]["update_goods_was_delivered"]					= "Update Status Barang terkirim";
		$arr[$l]["edit_receipt_no"]								= "Ubah nomor Resi";
		$arr[$l]["delivered_at"]								= "Terkirim pada";
		$arr[$l]["are_you_sure_to_process_this_po"]				= "Anda yakin akan memproses PO ini";
		$arr[$l]["please_enter_the_shipping_receipt_number"]	= "Harap masukkan nomor resi pengiriman";
		$arr[$l]["shipping_receipt_number"]						= "Nomor resi pengiriman";
		$arr[$l]["receipt_number"]								= "Nomor resi";
		$arr[$l]["transaction_done"]							= "Transaksi Selesai";
		$arr[$l]["are_you_sure_transaction_done"]				= "Anda yakin transaksi ini telah selesai";
		$arr[$l]["purchase_list"]								= "Daftar Pembelian";
		$arr[$l]["store_sales_list"]							= "Daftar Penjualan Toko";
		$arr[$l]["total_bill"]									= "Total Tagihan";
		$arr[$l]["total_shopping"]								= "Total Belanja";
		$arr[$l]["payment_confirmation_success"]				= "Konfirmasi pembayaran telah terkirim";
		$arr[$l]["payment"]										= "Pembayaran";
		$arr[$l]["choose_the_destination_bank"]					= "Pilih bank tujuan";
		$arr[$l]["the_destination_bank"]						= "Bank tujuan";
		$arr[$l]["please_add_your_store_address"]				= "Silakan tambahkan alamat toko Anda";
		$arr[$l]["to"]											= "s/d";
		$arr[$l]["other_goods_from_seller"]						= "Produk lainnya dari penjual";
		$arr[$l]["show_shopping_progress"]						= "Lihat Progres";
		$arr[$l]["shopping_progress"]							= "Progres Belanja";
		$arr[$l]["reason_markopelago_member"]					= "&#34;Kenapa jualan dan belanja di Markopelago?<br>Karena Markopelago Indonesia Banget&#34; ini buktinya :";
		$arr[$l]["marko_id_invalid_char"]						= "Gunakan huruf dan angka saja (tanpa spasi)";
		$arr[$l]["marko_id_invalid_length"]						= "Minimum 6 karakter";
		$arr[$l]["marko_id_exist"]								= "Marko ID sudah ada yang menggunakan";
		
		return $arr[$this->locale][$index];
	}
}
?>
