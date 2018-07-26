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
		$arr[$l]["categories"] 									= "Categories";
		$arr[$l]["allcategories"] 								= "All Categories";
		$arr[$l]["yes"] 										= "Yes";
		$arr[$l]["no"] 											= "No";
		$arr[$l]["cancel"] 										= "Cancel";
		$arr[$l]["at"] 											= "at";
		$arr[$l]["send"] 										= "send";
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
		$arr[$l]["error_wrong_username_password"]				= "Sign In failed, wrong username and/or password, Please try again!";
		$arr[$l]["connect_socially_with_us"]					= "Connect socially with us";
		$arr[$l]["links"]										= "Links";
		$arr[$l]["contact_us"]									= "Contact Us";
		$arr[$l]["about"]										= "About";
		$arr[$l]["contact"]										= "Contact";
		$arr[$l]["message"]										= "Message";
		$arr[$l]["register_as"]									= "Register as";
		$arr[$l]["register"]									= "Register";
		$arr[$l]["seller"]										= "Seller";
		$arr[$l]["buyer"]										= "Buyer";
		$arr[$l]["forwarder"]									= "Forwarder";
		$arr[$l]["profile"]										= "Profile";
		$arr[$l]["nationality"]									= "Nationality";
		$arr[$l]["location"]									= "Location";
		$arr[$l]["save"]										= "Save";
		$arr[$l]["data_not_found"]								= "Data not found";
		$arr[$l]["message_not_found"]							= "Message not found";
		$arr[$l]["gender"]										= "Gender";
		$arr[$l]["applicants"]									= "Applicants";
		$arr[$l]["you_have_to_login_first"]						= "You have to log in first";
		$arr[$l]["hot_products"]								= "Hot Products";
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
		$arr[$l]["store_name"]									= "Store Name";
		$arr[$l]["pic"]											= "PIC";
		$arr[$l]["product_information"]							= "Product Information";
		$arr[$l]["weight"]										= "Weight";
		$arr[$l]["dimension"]									= "Dimension";
		$arr[$l]["condition"]									= "Condition";
		$arr[$l]["product_description"]							= "Product Description";
		$arr[$l]["price"]										= "Price";
		$arr[$l]["failed_transaction"]							= "Transaction was failed, please contact our customer service.";
		$arr[$l]["product_name"]								= "Product Name";
		$arr[$l]["qty"]											= "Qty";
		$arr[$l]["promo_code"]									= "Promo Code";
		$arr[$l]["province"]									= "Province";
		$arr[$l]["city"]										= "City";
		$arr[$l]["district"]									= "District";
		$arr[$l]["subdistrict"]									= "Sub District";
		$arr[$l]["success_add_to_cart"]							= "Product successfully added to the cart";
		$arr[$l]["more_shopping"]								= "More Shopping";
		$arr[$l]["pay"]											= "Pay";
		$arr[$l]["notes_for_seller"]							= "Notes for Seller";
		$arr[$l]["delivery_destination"]						= "Delivery Destination";
		$arr[$l]["choose_another_address"]						= "Choose another address";
		$arr[$l]["delivery_courier"]							= "Delivery Courier";
		$arr[$l]["courier_service"]								= "Courier Service";
		$arr[$l]["shipping_charges"]							= "Shipping Charges";
		$arr[$l]["addresses"]									= "Addresses";
		$arr[$l]["banks"]										= "Banks";
		$arr[$l]["bank"]										= "Bank";
		$arr[$l]["change_photo"]								= "Change Photo";
		$arr[$l]["change_logo"]									= "Change Logo";
		$arr[$l]["error_upload_image"]							= "Error upload image";
		$arr[$l]["bank_name"]									= "Bank Name";
		$arr[$l]["account_no"]									= "Account No";
		$arr[$l]["account_name"]								= "Account Name";
		$arr[$l]["branch"]										= "Branch";
		$arr[$l]["failed_saving_data"]							= "Failed saving data.";
		$arr[$l]["example_home_office"]							= "example: Home, Office,...";
		
		/*==================================================================================================================================*/
		/*==================================================================================================================================*/
		$l = "id";
		$arr[$l]["search"] 										= "Cari";
		$arr[$l]["categories"] 									= "Kategori";
		$arr[$l]["allcategories"] 								= "Semua Kategori";
		$arr[$l]["yes"] 										= "Ya";
		$arr[$l]["no"] 											= "Tidak";
		$arr[$l]["cancel"] 										= "Batal";
		$arr[$l]["at"] 											= "pada";
		$arr[$l]["send"] 										= "kirim";
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
		$arr[$l]["oldpassword"]									= "Password Lama";
		$arr[$l]["newpassword"]									= "Password Baru";
		$arr[$l]["repassword"]									= "Ketik Ulang Kata Sandi";
		$arr[$l]["minimum_6_characters"]						= "Minimal 6 karakter";
		$arr[$l]["password_error"]								= "Kesalahan pada Kata Sandi";
		$arr[$l]["email_invalid"]								= "Kesalahan pada email";
		$arr[$l]["email_already_in_use"]						= "Email sudah digunakan, silakan gunakan email yang lain";
		$arr[$l]["range_characters"]							= "6-8 Karakter";
		$arr[$l]["by_signing_up_i_agree_to"]					= "Dengan mendaftar berarti Saya telah menyetujui";
		$arr[$l]["terms_and_conditions"]						= "Syarat dan Ketentuan";
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
		$arr[$l]["error_wrong_username_password"]				= "Anda gagal masuk, username dan/atau password salah, Silakan ulangi lagi!";
		$arr[$l]["connect_socially_with_us"]					= "Terhubung media sosial dengan kami";
		$arr[$l]["links"]										= "Link";
		$arr[$l]["contact_us"]									= "Hubungi Kami";
		$arr[$l]["about"]										= "Tentang Kami";
		$arr[$l]["contact"]										= "Hubungi";
		$arr[$l]["message"]										= "Pesan";
		$arr[$l]["register_as"]									= "Daftar sebagai";
		$arr[$l]["register"]									= "Daftar";
		$arr[$l]["seller"]										= "Penjual";
		$arr[$l]["buyer"]										= "Pembeli";
		$arr[$l]["forwarder"]									= "Ekspeditur";
		$arr[$l]["profile"]										= "Profil";
		$arr[$l]["nationality"]									= "Kebangsaan";
		$arr[$l]["location"]									= "Lokasi";
		$arr[$l]["save"]										= "Simpan";
		$arr[$l]["data_not_found"]								= "Data tidak ditemukan";
		$arr[$l]["message_not_found"]							= "Pesan tidak ditemukan";
		$arr[$l]["gender"]										= "Jenis Kelamin";
		$arr[$l]["applicants"]									= "Pelamar";
		$arr[$l]["you_have_to_login_first"]						= "Anda harus login terlebih dahulu";
		$arr[$l]["hot_products"]								= "Hot Products";
		$arr[$l]["recommended_sellers"]							= "Penjual Rekomendasi";
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
		$arr[$l]["store_name"]									= "Nama Toko";
		$arr[$l]["pic"]											= "PIC";
		$arr[$l]["product_information"]							= "Info Produk";
		$arr[$l]["weight"]										= "Berat";
		$arr[$l]["dimension"]									= "Dimensi";
		$arr[$l]["condition"]									= "Kondisi";
		$arr[$l]["product_description"]							= "Deskripsi Produk";
		$arr[$l]["price"]										= "Harga";
		$arr[$l]["failed_transaction"]							= "Transaksi gagal, silakan hubungi pelayanan pelanggan Kami";
		$arr[$l]["product_name"]								= "Nama Produk";
		$arr[$l]["qty"]											= "Qty";
		$arr[$l]["promo_code"]									= "Kode Promo";
		$arr[$l]["province"]									= "Propinsi";
		$arr[$l]["city"]										= "Kota";
		$arr[$l]["district"]									= "Kecamatan";
		$arr[$l]["subdistrict"]									= "Kelurahan";
		$arr[$l]["success_add_to_cart"]							= "Produk berhasil ditambahkan ke keranjang";
		$arr[$l]["more_shopping"]								= "Lanjut Belanja";
		$arr[$l]["pay"]											= "Bayar";
		$arr[$l]["notes_for_seller"]							= "Catatan untuk Penjual";
		$arr[$l]["delivery_destination"]						= "Tujuan Pengiriman";
		$arr[$l]["choose_another_address"]						= "Pilih alamat lain";
		$arr[$l]["delivery_courier"]							= "Kurir Pengiriman";
		$arr[$l]["courier_service"]								= "Servis Kurir";
		$arr[$l]["shipping_charges"]							= "Ongkos Kirim";
		$arr[$l]["addresses"]									= "Alamat";
		$arr[$l]["banks"]										= "Bank";
		$arr[$l]["bank"]										= "Bank";
		$arr[$l]["change_photo"]								= "Ubah Foto";
		$arr[$l]["change_logo"]									= "Ubah Logo";
		$arr[$l]["error_upload_image"]							= "Ada kesalahan saat mengunggah gambar";
		$arr[$l]["bank_name"]									= "Nama Bank";
		$arr[$l]["account_no"]									= "Nomor Akun";
		$arr[$l]["account_name"]								= "Nama Pemilik Rekening";
		$arr[$l]["branch"]										= "Cabang";
		$arr[$l]["failed_saving_data"]							= "Gagal menyimpan data.";
		$arr[$l]["example_home_office"]							= "contoh: Rumah, Kantor,...";
		return $arr[$this->locale][$index];
	}
}
?>
