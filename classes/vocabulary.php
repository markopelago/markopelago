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
		$arr[$l]["email_address"]								= "E-mail Address";
		$arr[$l]["password"]									= "Password";
		$arr[$l]["repassword"]									= "Retype Password";
		$arr[$l]["minimum_6_characters"]						= "Minimum 6 characters";
		$arr[$l]["password_error"]								= "Password Invalid";
		$arr[$l]["email_invalid"]								= "Email Invalid";
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
		$arr[$l]["view_all"]									= "View All";
		
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
		$arr[$l]["email_address"]								= "Alamat Email";
		$arr[$l]["password"]									= "Kata Sandi";
		$arr[$l]["repassword"]									= "Ketik Ulang Kata Sandi";
		$arr[$l]["minimum_6_characters"]						= "Minimal 6 karakter";
		$arr[$l]["password_error"]								= "Kesalahan pada Kata Sandi";
		$arr[$l]["email_invalid"]								= "Kesalahan pada email";
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
		$arr[$l]["view_all"]									= "Lihat semua";
		
		return $arr[$this->locale][$index];
	}
}
?>
