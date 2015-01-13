<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Common Language Lines
	|--------------------------------------------------------------------------
	*/
	'login_caption' => 'Galepress Login',
	'login_remember' => 'Beni hatırla',
	'login_button' => 'Giriş',
	'login_button_resetmypassword' => 'Parolamı sıfırla',
	'login_forgotmypassword' => 'Parolamı Unuttum',
	'login_goback' => 'Geri Dön',
	'login_error' => 'Hatalı kullanıcı bilgisi girdiniz!',
	'login_error_expiration' => 'uygulamanızın geçerlilik süresi sonlanmıştır!',
	'login_email_subject' => 'Galepress.com parola sıfırlama e-postası',
	'login_email_message' => "".
								"Sayın :firstname :lastname, \n\n".
								"Parolanızı sıfırlamak için aşağıdaki linke tıklayabilirsiniz. Eğer böyle bir talepte bulunmadıysanız lütfen bu e-postayı önemsemeyiniz.\n\n".
								":url\n\n".
								"Saygılarımızla, \n".
								"Galepress",
	'login_resetpassword_email_subject' => 'Galepress.com parola sıfırlama e-postası',
	'login_resetpassword_email_message' => "".
								"Sayın :firstname :lastname, \n\n".
								"Parolanız :pass olarak değiştirilmiştir. \n\n".
								"Saygılarımızla, \n".
								"Galepress",
	'login_emailsent' => 'Parolanızı sıfırlayabileceğiniz link e-posta adresinize gönderilmiştir.',
	'login_emailnotfound' => 'Kayıtlı bir e-posta adresi bulunamadı!',
	'login_ticketnotfound' => 'Parola sıfırlama talebiniz bulunamadı!',
	'login_passwordhasbeenchanged' => 'Parolanız başarıyla değiştirildi.',
	'login_succesfullyloggedout' => 'Sistemden başarıyla çıkış yaptınız!',
	'login_success_redirect' => 'Başarılı, anasayfaya yönlendiriliyorsunuz...',

	'menu_caption' => 'Menü',
	'menu_caption_applications' => 'Uygulamalar',
	'menu_caption_reports' => 'Raporlar',
	'menu_caption_preferences' => 'Ayarlar',
	'menu_caption_statistics' => 'İstatistikler',
	'menu_caption_pushnotify' => 'Bildirim Gönder',
	
	'menu_customers' => 'Müşteriler',
	'menu_applications' => 'Uygulamalar',
	'menu_contents' => 'İçerikler',
	'menu_orders' => 'Siparişler',
	'menu_users' => 'Kullanıcılar',
	'menu_mydetail' => 'Kullanıcı Bilgileri',
	'menu_pushnotify' => 'Bildirim Gönder',
	'menu_logout' => 'Çıkış',
	
	'menu_report_101' => 'Müşteri Raporu',
	'menu_report_201' => 'Uygulama Raporu',
	'menu_report_301' => 'Trafik Raporu',
	'menu_report_302' => 'Cihaz Raporu',
	'menu_report_1101' => 'Müşteri Konum Raporu',
	'menu_report_1201' => 'Uygulama Konum Raporu',
	'menu_report_1301' => 'İndirilme Raporu',
	'menu_report_1302' => 'Görüntülenme Raporu',
	
	'statistics_user' => 'Kullanıcı Adı:',
	'statistics_lastlogin' => 'Sisteme Son Giriş Tarihi:',
	'statistics_firstlogin' => 'Sisteme ilk kez girildi.',
	
	'commandbar_add' => 'Ekle',
	'commandbar_search' => 'Ara',
	
	'header_upload' => 'Yüklenmedi',
	'header_application' => 'Uygulama:',
	'header_begindate' => 'Başlangıç Tarihi:',
	'header_enddate' => 'Bitiş Tarihi:',
	'header_status' => 'Store Yayın Durumu:',
	
	'home' => 'Gösterge Paneli',
	
	'list_norecord' => 'Kayıt bulunamadı!',
	
	'file_notfound' => 'Dosya bulunamadı!',
	
	'detailpage_caption' => 'Kayıt Sayfası',
	'detailpage_save' => 'Kaydet',
	'detailpage_update' => 'Güncelle',
	'detailpage_delete' => 'Sil',
	'detailpage_send' => 'Yeni parola gönder',
	'detailpage_success' => 'İşlem başarıyla yapıldı.',
	'detailpage_fail' => 'İşlem yapılırken hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
	'detailpage_validation' => 'Doldurulması gereken alanlar var!',
	
	'mydetail' => 'Kullanıcı Bilgilerim',
	'pushnotify_caption' => 'BİLDİRİM GÖNDER',
	'pushnotify_detail' => 'Bildirim Metni',
	'pushnotify_send' => 'Gönder',
	
	'users_caption' => 'Kullanıcılar',
	'users_caption_detail' => 'Kullanıcı Detayı',
	'users_list_column1' => '',
	'users_list_column2' => 'K.T.',
	'users_list_column3' => 'Ad',
	'users_list_column4' => 'Soyad',
	'users_list_column5' => 'E-posta',
	'users_list_column6' => 'ID',
	'users_usertype' => 'Kullanıcı Türü',
	'users_customer' => 'Müşteri',
	'users_firstname' => 'Ad',
	'users_lastname' => 'Soyad',
	'users_email' => 'E-posta',
	'users_username' => 'Kullanıcı Adı',
	'users_password' => 'Parola',
	'users_password2' => 'Parola (Tekrar)',
	'users_timezone' => 'Zaman Dilimi',
	
	'customers_caption' => 'Müşteriler',
	'customers_caption_detail' => 'Müşteri Detayı',
	'customers_list_column1' => '',
	'customers_list_column2' => 'U.S.',
	'customers_list_column3' => 'K.S.',
	'customers_list_column4' => 'M. No',
	'customers_list_column5' => 'Müşteri Adı',
	'customers_list_column6' => 'Telefon',
	'customers_list_column7' => 'E-posta',
	'customers_list_column8' => 'ID',
	'customers_customerno' => 'Müşteri No:',
	'customers_customername' => 'Müşteri Adı:',
	'customers_address' => 'Adres:',
	'customers_city' => 'Şehir:',
	'customers_country' => 'Ülke:',
	'customers_phone1' => 'Telefon:',
	'customers_phone2' => 'Faks:',
	'customers_email' => 'E-mail:',
	'customers_billname' => 'Fatura Adı:',
	'customers_billaddress' => 'Fatura Adresi:',
	'customers_billtaxoffice' => 'Vergi Dairesi:',
	'customers_billtaxnumber' => 'Vergi No:',
	
	'applications_caption' => 'Uygulamalar',
	'applications_caption_detail' => 'Uygulama Detayı',
	'applications_list_column1' => '',
	'applications_list_column2' => 'İ.S.',
	'applications_list_column3' => 'Müşteri',
	'applications_list_column4' => 'Uygulama Adı',
	'applications_list_column5' => 'Uygulama Durumu',
	'applications_list_column6' => 'Paket',
	'applications_list_column7' => 'Bloke',
	'applications_list_column8' => 'Durum',
	'applications_list_column9' => 'Bitiş Tarihi',
	'applications_list_column10' => 'ID',

	'applications_list_blocked1' => 'Evet',
	'applications_list_blocked0' => 'Hayır',
	'applications_list_status1' => 'Yayında',
	'applications_list_status0' => 'Yayında değil',
	'applications_customer' => 'Müşteri:',
	'applications_applicationname' => 'Uygulama Adı:',
	'applications_detail' => 'Detay:',
	'applications_startdate' => 'Başlangıç Tarihi (gg.aa.yyyy):',
	'applications_expirationdate' => 'Geçerlilik Tarihi (gg.aa.yyyy):',
	'applications_notificationtext' => 'Bildirim Metni:',
	'applications_defaultnotificationtext' => 'Yeni bir içerik yüklendi!',
	'applications_file' => 'Ck.Pem:',
	'applications_file_select' => 'Ck.Pem seç...',
	'applications_applicationstatus' => 'Uygulama Durumu:',
	'applications_iosversion' => 'IOS Version:',
	'applications_ioslink' => 'IOS Link:',
	'applications_androidversion' => 'Android Version:',
	'applications_androidlink' => 'Android Link:',
	'applications_package' => 'Paket:',
	'applications_blocked' => 'Bloke:',
	'applications_status' => 'Durum:',
	'applications_expired_detail' => 'Lütfen yetkili kişiler ile iletişime geçiniz.',
	
	'contents_caption' => 'İçerikler',
	'contents_caption_detail' => 'İçerik Detayı',
	'contents_list_column1' => '',
	'contents_list_column2' => 'Müşteri',
	'contents_list_column3' => 'Uygulama',
	'contents_list_column4' => 'İçerik Adı',
	'contents_list_column5' => 'Bloke',
	'contents_list_column6' => 'Durum',
	'contents_list_column7' => 'ID',
	'contents_list_customer_column1' => '',
	'contents_list_customer_column2' => 'İçerik Adı',
	'contents_list_customer_column3' => 'Kategori',
	'contents_list_customer_column4' => 'Yayın. T',
	'contents_list_customer_column5' => 'Bloke',
	'contents_list_customer_column6' => 'Durum',
	'contents_list_customer_column7' => 'ID',
	'contents_list_blocked1' => 'Evet',
	'contents_list_blocked0' => 'Hayır',
	'contents_list_status1' => 'Yayında',
	'contents_list_status0' => 'Yayında değil',
	
	'contents_application' => 'Uygulama:',
	'contents_name' => 'İçerik Adı:',
	'contents_detail' => 'Detay:',
	'contents_category' => 'Kategori:',
	'contents_monthlyname' => 'Sayı:',
	'contents_publishdate' => 'Yayınlanma Tarihi:',
	'contents_file' => 'Dosya:',
	'contents_file_select' => 'PDF seç...',
	'contents_file_interactive_label' => 'İnteraktif Tasarlayıcı',
	'contents_file_interactive' => 'İnteraktif tasarlayıcıyı aç',
	'contents_interactive_file_has_been_created' => 'İnteraktif dosya oluştu.',
	'contents_interactive_file_hasnt_been_created' => 'İnteraktif dosya henüz oluşturulmadı.',
	'contents_filelink' => 'Dosyayı buraya tıklayarak indirebilirsiniz',
	'contents_transfer' => 'Eski interaktif içeriği yeni pdf dosyasına aktar!',
	'contents_coverimage' => 'Kapak Resmi Önizleme',
	'contents_coverimage_select' => 'Resim seç...',
	'contents_isprotected' => 'Parola Koruması:',
	'contents_password' => 'Parola:',
	'contents_isbuyable' => 'Satın Alınabilirlik:',
	'contents_price' => 'Fiyat:',
	'contents_currency' => 'Para Birimi:',
	'contents_identifier' => 'Ürün Kimliği:',
	'contents_ismaster' => 'Master:',
	'contents_autodownload' => 'Otomatik İndirme:',
	'contents_approval' => 'Onay:',
	'contents_blocked' => 'Bloke:',
	'contents_status' => 'Aktif:',
	'contents_wrongpassword' => 'Hatalı parola!',

	'contents_tooltip_application' => 'Uygulama',
	'contents_tooltip_name' => 'Tablet bilgisayarlarda gözükecek içerik adı.',
	'contents_tooltip_detail' => 'İçerik ile ilgili detaylı açıklama alanı.',
	'contents_tooltip_category' => 'İçerikleri farklı kategorilerle etiketlenebilir, tablet bilgisayarlarda bu katogorilere göre filtreleme yapılabilir.',
	'contents_tooltip_monthlyname' => 'İçerikler tablet bilgisayarlarda burada yazılan değere göre büyükten küçüğe doğru sıralanacaktır.',
	'contents_tooltip_publishdate' => 'İçeriğin ait olduğu yayın tarihi. Şuan için bu alan bilgi amaçlıdır, bir kontrol yapılmamaktadır.',
	'contents_tooltip_file' => 'Yayınlanmasını istediğiniz PDF dosyasını seçin ve sisteme yüklenmesini bekleyin.',
	'contents_tooltip_coverimage' => 'Yüklenen PDF\'in ilk sayfası otomatik olarak kapak olur, başka bir png/jpg resim dosyası ile değiştirilebilir. (En iyi görünüm için 468x667 çözünürlük tercih ediniz.)',
	'contents_tooltip_isprotected' => 'İşaretli içeriklerin indirilebilmesi için şifre girilmesi gerekir.',
	'contents_tooltip_password' => 'İçeriğin indirilmesi için gerekli olan şifre alanı.',
	'contents_tooltip_isbuyable' => 'Henüz kullanımda değildir. Üzerinde çalışılmaktadır.',
	'contents_tooltip_price' => 'Henüz kullanımda değildir. Üzerinde çalışılmaktadır.',
	'contents_tooltip_currency' => 'Henüz kullanımda değildir. Üzerinde çalışılmaktadır.',
	'contents_tooltip_identifier' => 'Henüz kullanımda değildir. Üzerinde çalışılmaktadır.',
	'contents_tooltip_ismaster' => 'Henüz kullanımda değildir. Üzerinde çalışılmaktadır.',
	'contents_tooltip_autodownload' => 'İşaretli içerikler kullanıcıya sorulmadan direk indirilecektir. Küçük boyutlu içeriklerde kullanılması tavsiye edilir, aksi halde programın başlaması uzun sürecektir.',
	'contents_tooltip_approval' => 'Onay',
	'contents_tooltip_blocked' => 'Bloke.',
	'contents_tooltip_status' => 'İşaretli içerikler tablet bilgisayarlarda gözükür ve indirilebilir. galepress.com\'a yüklediğiniz ama tablet bilgisayarlarda gözükmesini ve indirilmesini istemediğiniz içerikler için boş bırakın.',
	'contents_tooltip_interactive' => 'İnteraktif tasarlayıcıyı açar.',
	
	'contents_category_title' => 'Kategorileri düzenle',
	'contents_category_list_general' => 'Genel',
	'contents_category_list_choose' => 'Seç',
	'contents_category_list_modify' => 'Düzenle',
	'contents_category_list_delete' => 'Sil',
	'contents_category_column1' => 'Seç',
	'contents_category_column2' => 'Kategori Adı',
	'contents_category_column3' => 'İşlem',
	'contents_category_new' => 'Yeni Kategori Ekle',
	'contents_category_name' => 'Kategori Adı:',
	'contents_category_button_add' => 'Ekle',
	'contents_category_button_giveup' => 'Vazgeç',
	'contents_category_warning_title' => 'Kategori Seçilmedi!',
	'contents_category_warning_content' => 'İçeriğiniz için en az bir kategori seçmeniz gerekmektedir!',
	'contents_category_warning_ok' => 'Tamam',

	'contents_password_title' => 'Parolaları düzenle',
	'contents_password_list_general' => 'Genel',
	'contents_password_list_choose' => 'Seç',
	'contents_password_list_modify' => 'Düzenle',
	'contents_password_list_delete' => 'Sil',
	'contents_password_column1' => 'Seç',
	'contents_password_column2' => 'Açıklama',
	'contents_password_column3' => 'Miktar',
	'contents_password_column4' => 'İşlem',
	'contents_password_new' => 'Yeni Parola Ekle',
	'contents_password_name' => 'Açıklama:',
	'contents_password_pwd' => 'Parola:',
	'contents_password_qty' => 'Miktar:',
	'contents_password_button_add' => 'Ekle',
	'contents_password_button_giveup' => 'Vazgeç',

	'contents_delete_question' => 'Silmek istediğinize emin misiniz?',
	'contents_delete' => 'Sil',
	
	'orders_caption' => 'Siparişler',
	'orders_caption_detail' => 'Sipariş Detayı',
	'orders_list_column1' => 'Sipariş No',
	'orders_list_column2' => 'Uygulama Adı',
	'orders_list_column3' => 'Web Sitesi',
	'orders_list_column4' => 'E-posta',
	'orders_list_column5' => 'ID',
	'orders_application' => 'Uygulama:',
	'orders_orderno' => 'Sipariş No:',
	'orders_name' => 'Uygulama Adı:',
	'orders_description' => 'Açıklama:',
	'orders_keywords' => 'Anahtar Kelimeler:',
	'orders_product' => 'Ürün:',
	'orders_qty' => 'Adet:',
	'orders_website' => 'Web Sitesi:',
	'orders_email' => 'E-posta:',
	'orders_facebook' => 'Facebook:',
	'orders_twitter' => 'Twitter:',
	'orders_image1024x1024' => '1024 x 1024 simge:',
	'orders_image640x960' => '640 x 960 simge:',
	'orders_image640x1136' => '640 x 1136 simge:',
	'orders_image1536x2048' => '1536 x 2048 simge:',
	'orders_image2048x1536' => '2048 x 1536 simge:',
	'orders_pdf' => 'Pdf:',
	'orders_file_select' => 'Dosya seç...',
	
	'reports_caption' => 'Raporlar',
	'reports_filter' => 'Filtreleme Seçenekleri',
	'reports_date' => 'Tarih kriteri',
	'reports_customer' => 'Müşteri',
	'reports_select_customer' => 'Müşteri seçiniz...',
	'reports_application' => 'Uygulama',
	'reports_select_application' => 'Uygulama seçiniz...',
	'reports_content' => 'İçerik',
	'reports_select' => 'Seçiniz...',
	'reports_select_content' => 'İçerik seçiniz...',
	'reports_location' => 'Konum',
	'reports_select_country' => 'Ülke seçiniz...',
	'reports_select_city' => 'Şehir seçiniz...',
	'reports_select_district' => 'İlçe seçiniz...',
	'reports_refresh' => 'Yenile',
	'reports_excel' => 'Excel olarak indir',
	'reports_viewonmap' => 'Harita üzerinde göster',
	/*
	'reports_customer_report' => 'MÜŞTERİ RAPORU',
	'reports_application_report' => 'UYGULAMA RAPORU',
	'reports_content_report' => 'İÇERİK RAPORU',
	'reports_device_report' => 'CİHAZ RAPORU',
	*/
	'reports_date1' => 'Tarih:',
	'reports_print' => 'Yazdır',
	'reports_device' => 'Cihaz',
	'reports_usage' => 'Kullanım adeti',
	'reports_graph' => 'Cihaz Kullanım Grafiği',
	'reports_graph_ratio' => 'Cihaz Kullanım Oranı',
	'reports_columns_report101' => array("Müşteri No", "Müşteri Adı", "Uygulama Adeti", "Bloke Uygulama Adeti", "İçerik Adeti", "Onaylanmış İçerik Adeti", "Bloke İçerik Adeti", "Toplam Dosya Boyutu (Byte)", "İndirilme Adeti", "Toplam Trafik (Byte)"),
	'reports_columns_report201' => array("Müşteri No", "Müşteri Adı", "Uygulama Adı", "SKT", "Uygulama Durumu", "Uygulama Bloke", "İçerik Adeti", "Onaylanmış İçerik Adeti", "Bloke İçerik Adeti", "Toplam Dosya Boyutu (Byte)", "İndirilme Adeti", "Toplam Trafik (Byte)"),
	'reports_columns_report301' => array("Uygulama Adı", "İçerik Adı", "Toplam Dosya Boyutu (Byte)", "Toplam Trafik (Byte)"),
	'reports_columns_report301_admin' => array("Müşteri No", "Müşteri Adı", "Uygulama Adı", "SKT", "Uygulama Durumu", "Uygulama Bloke", "İçerik Adı", "İçerik Onay", "İçerik Bloke", "Toplam Dosya Boyutu (Byte)", "Toplam Trafik (Byte)"),
	'reports_columns_report302' => array("Cihaz", "İndirilme Adeti"),
	'reports_columns_report1101' => array("Müşteri No", "Müşteri Adı", "Ülke", "Şehir", "İlçe", "İndirilme Adeti"),
	'reports_columns_report1201' => array("Müşteri No", "Müşteri Adı", "Uygulama Adı", "Ülke", "Şehir", "İlçe", "İndirilme Adeti"),
	'reports_columns_report1301' => array("Müşteri No", "Müşteri Adı", "Uygulama Adı", "İçerik Adı", "Ülke", "Şehir", "İlçe", "İndirilme Adeti"),
	'reports_columns_report1302' => array("Müşteri No", "Müşteri Adı", "Uygulama Adı", "İçerik Adı", "Ülke", "Şehir", "İlçe", "Sayfa", "Kullanıcı Sayısı", "Süre (Saniye)"),

	'task_subject' => 'Galepress.com görevi esnasında hata oluştu',
	'task_message' => "".
						"Sayın yetkili, \n\n".
						":task görevi yapılırken bir hata oluştu. Hata detayını aşağıda görebilirsiniz.\n\n".
						":detail\n\n".
						"Saygılarımızla, \n".
						"Galepress",
						
	'task_success_subject' => 'Galepress.com görevi başarıyla tamamlandı',
	'task_success_message' => "".
						"Sayın yetkili, \n\n".
						":task görevi başarıyla tamamlandı. Ek açıklamaları aşağıda görebilirsiniz.\n\n".
						":detail\n\n".
						"Saygılarımızla, \n".
						"Galepress",
	
	'dashboard_title' => 'İNDİRİLME SAYISI',
	'dashboard_total' => 'Toplam',
	'dashboard_welcome' => 'Hoşgeldiniz',
	'dashboard_lastlogin_time' => 'Son Giriş Saati:',
	'dashboard_app_count' => 'Uygulama Adeti',
	'dashboard_content_count' => 'İçerik Adeti',
	'dashboard_previous_months' => 'Önceki Aylar',
	'dashboard_weekly_total' => 'Haftalık Toplam',
	'dashboard_yesterday' => 'Dün',
	'dashboard_filter' => 'Filtreleme',
	'dashboard_app' => 'Uygulama',
	'dashboard_content' => 'İçerik',
	'dashboard_begin_date' => 'Bitiş Tarihi',
	'dashboard_refresh' => 'Yenile',

	'session_continue' => 'Devam Et',

	'site_lang_settings' => 'Site Dil Ayarı',
	'site_loading' => 'Yükleniyor...',
	'site_system_message' => 'Sistem Mesajı',
	'site_system_message_expiring' => 'Oturumunuz sonlanacak:',
	'site_system_message_expired' => 'Oturumunuz sonlandı!',

	'month_names' => array('', 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'),

);