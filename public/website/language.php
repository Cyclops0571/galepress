<?php
session_start();
$dil= $_SESSION['benimdilim']; // session kayiti olusturuyoruz
 
if ($dil==""||$dil==null){
$dil="tr";
}//eğer kullanıcı direk olarak siteyi dolaşmaya başlıyorsa
 
//varsayılan dil olarak bir dil atıyoruz ben tr atadım mesela
 
if ($dil =="tr"){
 
//Header
define("dil_orders_file_select",    'Dosya yukle');

define("dil_SITE_TITLE",    'GalePress - Dijital Yayın Platformu');

define("dil_GALELOGIN",    '/tr/giris');

 
define("dil_DYSTITLE",    'İçeriklerinizi Yönetmek için Üye Girişi Ekranı');
define("dil_ANASAYFA",    'Anasayfa');
define("dil_HAKKIMIZDA",    'Hakkımızda');
define("dil_GALEPRESS",    'GalePress');
define("dil_NEDIR",    'Nedir?');
define("dil_NEDIR_TEKNOLOJI",    'TEKNOLOJİ');
define("dil_NEDIR_PAYLASIM",    'Doküman Paylaşımı');
define("dil_NEDIR_LOGO",    'Logo ve Uygulama Adı');
define("dil_URUNLER",    'Ürünler');
define("dil_AVANTAJLAR",    'Avantajlar');
define("dil_FIYATLAR",    'Fiyatlar');
define("dil_MUSTERILERIMIZ",    'Müşterilerimiz');
define("dil_CALISMAYAPISI",    'Çalışma Yapısı');
define("dil_ILETISIM",    'İletişim');
define("dil_ARAMA",    'Arama yapın...');
define("dil_DYS",    'DYS');
define("dil_DYSBASLIK",    'Doküman Yönetim Sistemi');

//Slider

define("dil_GALENEDIR", 'NEDİR?');
define("dil_GALENEDIR_YAZI", 'Gazete, dergi, katalog, kitap gibi dokümanların, <br />
                                             tablet bilgisayarlar ve akıllı telefonlar üzerinden okunmasını sağlar.');
define("dil_MOBILUYG", 'MOBİL UYGULAMA');
define("dil_MOBILUYG_YAZI", "Appstore'da kendi adınıza uygulamanız olsun.");
define("dil_DYP", "DOKÜMAN YÖNETİM PANELİ");
define("dil_DYP_YAZI", 'Okunmasını istediğiniz dokümanları uygulamanızın kütüphanesine yükleyin.');
define("dil_ITP", 'İNTERAKTİF TASARIM PANELİ');
define("dil_ITP_YAZI", 'Dokümanınızın içeriğini hareketli ve sesli görsellerle zenginleştirin.<br />');
define("dil_AVANTAJLAR", 'AVANTAJLAR');
define("dil_AVANTAJLAR_YAZI1", 'Uygulamanızı yönetme imkanı');
define("dil_AVANTAJLAR_YAZI2", 'Aynı anda 155 ülkeye erişim');
define("dil_AVANTAJLAR_YAZI3", 'Matbaa maliyeti yok');
define("dil_AVANTAJLAR_YAZI4", 'KATALOĞU EĞLENCELİ KILAN İNTERAKTİF ÖĞELER');

define("dil_SLIDE_FOOTER", 'Dijital çağa rakiplerinizden önce entegre olun!');

define("dil_SLIDE_FLIPBOOK","Dergi, broşür ve katalog gibi içeriklerinizin online web ortamında da görüntülenmesini sağlayın!");


// Footer
define("dil_KOLAYULASIM", 'Kolay Ulaşım');

define("dil_HABERDAR",    'Haberdar Olun!');
define("dil_HABERDAR_YAZI",    'GalePress yeniliklerinden haberdar olmak için lütfen mail listemize kaydolun.');
define("dil_EMAIL",    'Email Adresinizi Yazın');
define("dil_EMAIL_BASARILI",    '<strong>Başarılı!</strong> E-mail adresiniz listemize kaydedildi.');
define("dil_GIT",    'Gönder!');

define("dil_TWEET",    'Son Paylaşılanlar');
define("dil_YUKLENIYOR",    'Lütfen Bekleyin...');


define("dil_ADRES",    'Adres:');
define("dil_TELEFON",    'Telefon:');
define("dil_FAKS",    'Faks:');
define("dil_TAKIP",    'Takip Edin');

define("dil_DETAYADRES_IST",    'Alemdağ Cad. No: 109, 34692 Üsküdar / İstanbul / Türkiye<br />');

define("dil_DETAYADRES_SIV",    'Yenişehir Mah. İşhan Köyü,Ötegeçe Mevkii 49/1 58140 Teknokent Sivas / Türkiye<br />');

define("dil_SSS",    'SSS');
define("dil_SSS_UZUN",    'SIKÇA SORULAN SORULAR');
define("dil_SITEMAP",    'Site Haritası');

//Sipariş Sayfası
define("dil_UYGULAMAFORMU",    'Uygulama Formu');
define("dil_UYGULAMAOLUSTUR",    'Uygulama Oluşturma Bilgi Formu');
define("dil_UYGULAMAOLUSTUR_BUYUK",    'UYGULAMA OLUŞTURMA FORMU');

define("dil_UYGULAMAOLUSTUR_detail1",    'Uygulama Detaylarını Gir');
define("dil_UYGULAMAOLUSTUR_detail2",    'Uygulama Resimlerini Yükle');
define("dil_UYGULAMAOLUSTUR_detail3",    'Uygulama Bilgileri Gönderildi!');


define("dil_SIPARIS",'Uygulama oluşturmaya başlamak için bu formu doldurabilir veya bizimle <a href="iletisim"><u>iletişime</u></a> geçebilirsiniz.');
define("dil_SIPARIS_NO",'Sipariş No');

define("dil_ADSOYAD",    'Ad Soyad *');
define("dil_UYGULAMAAD",    'Uygulama Adı');
define("dil_FIRMAAD",    'Firma Adı *');
define("dil_UYGULAMAACIKLAMA",    'Uygulama Açıklaması');
define("dil_WEBSITE",    'Web Site ');
define("dil_KEYWORDS",    'Anahtar Kelimeler');
define("dil_GUVENLIKKOD",    'Güvenlik Kodu ');
define("dil_DOSYAYUKLE",    'Dosyaları Yükle');
define("dil_GONDER",    'Gönder');
define("dil_SATINAL",    'Satın Al');
define("dil_STATIK_EKO",    'Statik / Eko Paket');
define("dil_STATIK_ST",    'Statik / Standart Paket');
define("dil_STATIK_PRO",    'Statik / Pro Paket');
define("dil_STATIK_LMTZ",    'Statik / Limitsiz Paket');

define("dil_INTERACTIVITE_ST",    'İnteraktif / Standart Paket');
define("dil_INTERACTIVITE_PRO",    'İnteraktif / Pro Paket');
define("dil_INTERACTIVITE_LMTZ",    'İnteraktif / Limitsiz Paket');
define("dil_INTERACTIVITE_KRMSL",    'İnteraktif / Kurumsal Paket');

define("dil_REQUIRED_FIELDS",    '* doldurulması zorunlu alanlardır.');
define("dil_APP_SENT",    'Uygulama Bilgi Formu Gönderildi!');
define("dil_APP_SENT_SUCCESS",    'Başarılı! Uygulama bilgi formunuz başarıyla tarafımıza iletilmiştir.');
define("dil_APP_SENT_OK",    'Tamam');
define("dil_APP_SENT_BTN",    'Formu Gönder');
define("dil_APP_SETUP",    'Kurulum Aşamaları');

define("dil_APP_INFOS",    'Uygulama Detayı');
define("dil_APP_IMAGES",    'Uygulama Resimleri');
define("dil_APP_SETUP_FINAL",    'Uygulamayı Oluştur');

define("dil_APP_STAGE2_all",    "Uygulamanız için 1024x1024 çözünürlüğünde bir logo ile demo bir pdf yüklemeniz gerekmektedir. Yüklediğiniz pdf'in sayfaları App Store'daki uygulama indirme sayfasında görüntülenecektir.");
define("dil_APP_STAGE2_first",    'Uygulamanız için 1024x1024 çözünürlüğünde bir resim yüklemeniz gerekmektedir.');
define("dil_APP_STAGE2_second",    'Uygulamanız için demo bir pdf de yüklemeniz gerekmektedir.');

define("dil_APP_SETUP_continue",    'İleri');




// SİPARİŞ tooltipler
define("dil_APP_ORDER_NO_TIP",    'shop.galepress.com üzerinden satın aldığınız uygulamanız için mail adresinize iletilmiş olan sipariş numarasını girmelisiniz.');
define("dil_APP_DESC_TIP",    "Uygulamanızı açıklayan cümlelere yer vermelisiniz. Uygulama açıklamanız uygulama indirme sayfasında görüntülenecektir. En fazla 4000 karakter girebilirsiniz.");
define("dil_UYGULAMAAD_TIP",    'Uygulama adı için en fazla 14 karakter girebilirsiniz.');
define("dil_UYGULAMATANIM_TIP",    'Uygulamanız ile ilgili açıklayıcı cümlelere yer verilmelidir. En fazla 4000 karakter girebilirsiniz.');
define("dil_UYGULAMAKEYS_TIP",    'Anahtar kelimeler uygulamanızın bulunabilirliğini arttırır. En fazla 100 karakter girebilirsiniz.');
define("dil_UYGULAMAFILES_TIP",    "Uygulamanızın açılışında görüntülenecek resimlerini PNG formatında yüklemelisiniz.<br>Resimlerin boyutu en fazla 5 mb olabilir.<br>Uygulamanız ile ilgili demo bir pdf yüklemelisiniz.");
define("dil_EMAIL_TIP",    'Email bilgisi kullanıcılarınızın sizinle kolaylıkla irtibata geçebilmesini sağlar. Email bilgisini girmediğiniz takdirde bir sonraki güncellemeye kadar email hesabınızı kaydedemeyeceksiniz.');


// SİPARİŞ Hata Mesajları
define("dil_APP_Err_FILE",    'dosyanızı kontrol ediniz!');
define("dil_APP_Err_FILE_SIZE",    'Dosyanızın boyutu en fazla 5 mb olabilir!');
define("dil_APP_Err_FILE_TYPE",    "Dosyanızın formatı PNG olmalıdır!");
define("dil_APP_Err_PDF_FILE_TYPE",    "Dosyanızın formatı PDF olmalıdır!");

define("dil_APP_Err_Order_No",    "Sipariş numarası alanını boş bıraktınız!");
define("dil_APP_Err_App_Name",    "Uygulama adı alanını boş bıraktınız!");
define("dil_APP_Err_App_Desc",    "Uygulama açıklaması alanını boş bıraktınız!");
define("dil_APP_Err_Keywords",    "Anahtar kelimeler alanını boş bıraktınız!");


//Fiyatlandırma Sayfası
define("dil_STATIK",    'STATİK PAKETLER:');
define("dil_INTERAKTIFCUMLE",    'PDF üzerine video, ses, 3D resim galeri, 360˚resim, harite gibi interaktifliği sağlayan medyalar eklenebilir.');
define("dil_STATIKCUMLE",    'Sadece PDF in yalın olarak yayınlandığı paketler. PDF üzerine video, ses, 3D resim galeri vb. medyalar eklenemez.');
define("dil_FIYAT",    'Fiyatlandırma');
define("dil_EKO",    'EKO');
define("dil_SATISBUTON",    'Satın Al');
define("dil_STANDART",    'Standart');
define("dil_PRO",    'PRO');
define("dil_LIMITSIZ",    'Limitsiz');
define("dil_KURUMSAL",    'Kurumsal');
define("dil_GRAFIKHIZMET",    'Grafik Hizmeti');
define("dil_SERVISMODUL",    'Anket Modülü');
define("dil_INTERAKTIF",    'İNTERAKTİF PAKETLER:');
define("dil_EKOLIST",'<li><b>3</b> Eşzamanlı PDF Sayısı</li>
										<li><b>9.000</b> Yıllık İndirme Sayısı</li>
										<li><b>750</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_STALIST",'
										<li><b>9</b> Eşzamanlı PDF Sayısı</li>
										<li><b>18.000</b> Yıllık İndirme Sayısı</li>
										<li><b>1.500</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_PROLIST",'
										<li><b>9</b> Eşzamanlı PDF Sayısı</li>
										<li><b>18.000</b> Yıllık İndirme Sayısı</li>
										<li><b>1.500</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_LIMITSIZLIST",'
										<li><b>120</b> Eşzamanlı PDF Sayısı</li>
										<li><b>Limitsiz</b> Yıllık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Aylık İndirme Sayısı</li>
										<li><b>50 MB</b> Maks. PDF Boyutu </li>');

define("dil_STALIST2",'
										<li><b>24</b> Eşzamanlı PDF Sayısı</li>
										<li><b>60.000</b> Yıllık İndirme Sayısı</li>
										<li><b>5.000</b> Aylık İndirme Sayısı</li>
										<li><b>250 MB</b> Maks. PDF Boyutu </li>');
										
define("dil_PROLIST2",'
										<li><b>60</b> Eşzamanlı PDF Sayısı</li>
										<li><b>60.000</b> Yıllık İndirme Sayısı</li>
										<li><b>5.000</b> Aylık İndirme Sayısı</li>
										<li><b>250 MB</b> Maks. PDF Boyutu </li>');
										
define("dil_LIMITSIZLIST2",'
										<li><b>Limitsiz</b> Eşzamanlı PDF Sayısı</li>
										<li><b>Limitsiz</b> Yıllık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Aylık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Maks. PDF Boyutu </li>');
										
// İletişim
define("dil_ILETISIM_BUYUK",    'İLETİŞİM');
define("dil_KONU",    'Konu');
define("dil_MESAJ",    'Mesaj');
define("dil_MERKEZOFIS",    'Merkez Ofis');
define("dil_CALISMASAAT",    'Çalışma <strong>Saatleri</strong>');
define("dil_CALISMASAAT_YAZI",    '<li><i class="icon-time"></i> Pazartesi - Cuma 09:00 - 18:00</li>
								<li><i class="icon-time"></i> Cumartesi - Pazar (Kapalı)</li>');
define("dil_EMAILBASARI",    '<strong>Başarılı!</strong> Mesajınız gönderildi.');
								
define("dil_EMAILHATA",    '<strong>Hata!</strong> Bir hata oluştu!');

// Tutorials
define("dil_CALISMA",    'Çalışma Yapısı');

define("dil_ICERIKGENEL",    'İNTERAKTİF TASARLAYICI - GENEL');
define("dil_INTERAKTIFANA",    'İNTERAKTİF TASARLAYICI - ANA EKRAN');

define("dil_INTERAKTIFVIDEO",    'İNTERAKTIF TASARLAYICI - VİDEO');
define("dil_INTERAKTIFSES",    'İNTERAKTİF TASARLAYICI - SES');

define("dil_INTERAKTIFGOOGLE",    'İNTERAKTİF TASARLAYICI - GOOGLE HARİTA (ENLEM-BOYLAM)');
define("dil_INTERAKTIFHARITA",    'İNTERAKTİF TASARLAYICI - HARİTA');

define("dil_INTERAKTIFLINK",    'İNTERAKTİF TASARLAYICI - LİNK');
define("dil_INTERAKTIFWEB",    'İNTERAKTİF TASARLAYICI - WEB');

define("dil_INTERAKTIFYOUTUBE",    'İNTERAKTİF TASARLAYICI - YOUTUBE VİDEO');
define("dil_INTERAKTIFTOOLTIP",    'İNTERAKTİF TASARLAYICI - TOOLTIP');

define("dil_INTERAKTIFSCROLLER",    'İNTERAKTİF TASARLAYICI - SCROLLER');
define("dil_INTERAKTIFIMAJWIN",    'İNTERAKTİF TASARLAYICI - İMAJ BOYUTU DEĞİŞTİRME (WINDOWS)');

define("dil_INTERAKTIFIMAJMAC",    'İNTERAKTİF TASARLAYICI - İMAJ BOYUTU DEĞİŞTİRME (MAC)');
define("dil_INTERAKTIFSLIDER",    'İNTERAKTİF TASARLAYICI - SLIDER');

define("dil_INTERAKTIF360",    'İNTERAKTİF TASARLAYICI - 360');
define("dil_INTERAKTIFBOOKMARKS",    'İNTERAKTİF TASARLAYICI - BOOKMARKS');

define("dil_INTERAKTIFANIMATON",    'İNTERAKTİF TASARLAYICI - ANİMASYON');
define("dil_INTERAKTIFAYARLAR",    'AYARLAR');
define("dil_INTERAKTIFPDF",    'PDF YÜKLEME');
define("dil_INTERAKTIFLOGIN",    'LOGIN');

//Müşterilerimiz

define("dil_REFERANSLARIMIZ",    'Referanslarımız');

//Anasayfa

define("dil_GALEPRESSDYP",    'GalePress Dijital Yayın Platformu');
define("dil_GALEPRESSDYP_YAZI",    'Günümüzde bilgiye basılı materyallerden ulaşma alışkanlığı yerini hızla akıllı telefonlara, çok amaçlı tabletlere, özel geliştirilmiş e-okuyuculara ve diğer dijital cihazlara bırakıyor. Yeni çağın yenilikçi çözümleriyle birlikte hızla hayatımıza giren dijital yayıncılık artık bir seçenek değil, bir gereklilik olarak karşımıza çıkmaya başladı.<br />
			              GalePress; dünyadan ülkemize hızla yayılan bu oluşumun merkezinde yer alıp, hem yayıncılar hem de okuyucuların bu yeni çağın yayıncılık düzeninde yerlerini almalarını sağlayan çözümler sunmaktadır. ');
define("dil_ALTBASLIK",    'Mobil uygulama ile marka bilinirliğinizi artırın!');
define("dil_ALTYAZI",    '250+ Milyon Kullanıcı - 155 Ülke - Kolay Ulaşım');
define("dil_YUKLE",    'Yükle');
define("dil_INTERAKTIFANASAYFA",    'İnteraktif Yap');
define("dil_YAYINLA",    'Yayınla');

// Hakkımızda

define("dil_TANIM",    'Genel Tanıtım');
define("dil_TANIMDETAY_YAZI",    "Detaysoft, 13 yılı aşkın bir süredir, yazılım uygulamaları ve yenilikçi geliştirme konusunda, personel sayısı 200'ü aşan ve kendi sektöründe lider kuruluşlara danışmanlık hizmeti vermektedir. Kurulduğu 1999 yılından itibaren başarılı projeler üreten Detaysoft, zamanla sektörünün en deneyimli teknoloji firmaları arasına girdi. Ürettiği başarılı projeler, özgün çözümler ve uzun vadeli ortak çalışma anlayışı Detaysoft'u tercih eden iş ortaklarının sayısını artırdı. Sektördeki bu karşılıklı güven sayesinde Detaysoft, önemli bir büyüme ivmesi yakaladı. 2007 yılında Dubai ofisini açan Detaysoft, 2008 yilinda Sivas ofisini kurdu. Detaysoft Sivas ofisinde, büyük şehirlerden sonra ilk defa Anadolu'da büyük bir SAP danışman kadrosu oluşturdu. Türkiye'deki en büyük SAP iş ortaklarından Detaysoft, 13 yılı aşkın bir süredir SAP'nin tüm ürün ailesini kapsayan konularda, Mobil Uygulama Danışmanlığı alanları dâhil olmak üzere, Ar-Ge Projelerinde ürün geliştirmekte ve danışmanlık hizmetleri vermektedir. ");
define("dil_KM",    'KİLOMETRE TAŞLARI');
define("dil_KM_YAZI1",    "20 Sektörde 200'ün üzerinde müşteri referansı ve 400'den fazla tamamlanmış proje");
define("dil_KM_YAZI2",    'SAP Gold Partner');
define("dil_KM_YAZI3",    'SAP PCOE Sertifikası Sahibi');
define("dil_KM_YAZI4",    '2011 Best Performance Challenge Kapsamında En İyi Performans Ödülü Sahibi');
define("dil_KM_YAZI5",    '4 farklı ofis lokasyonu : İstanbul, Sivas, Dubai, Elazığ');
define("dil_KM_YAZI6",    'Turquality® Destek Programı kapsamında, Bilişim alaninda 1.Grup Danışman Firma');
define("dil_KM_YAZI7",    'Tübitak tarafindan desteklenmiş Ar-Ge Projeleri');
define("dil_KM_YAZI8",    'Sybase mobil uygulama çözüm ortağı');
define("dil_KM_YAZI9",    'SuccessFactors çözüm ortağı');
define("dil_KM_YAZI10",    "Uluslararası SAP İş Ortakları Mükemmeliyet Ödülleri 2013 -Pazarlama alanında ‘En İyi İş Ortağı’");
define("dil_KM_YAZI11",    "Türkiye Bilişim 500'de Danışmanlık kategorisinde 6. sırada bulunuyor.");
define("dil_LOKASYONLAR",    'LOKASYONLAR');

define("dil_LOK_ISTANBUL",    'İSTANBUL - MERKEZ');
define("dil_LOK_SIVAS",    'SİVAS - OFİS');
define("dil_LOK_DUBAI",    'DUBAI - OFİS FZCO');
define("dil_LOK_ELAZIG",    'ELAZIĞ - OFİS');



//NEDİR?

define("dil_NEDIR_YAZI",    "GalePress, gazete, dergi, katalog, kitap, eğitim dökümanı, kullanıcı klavuzu,  gibi dokümanların, tablet bilgisayarlar ve akıllı telefonlar üzerinden okunmasını sağlayan WEB platformu ve Mobil Uygulamasıdır.");
define("dil_NEDIR_YAZI2",    "Teknoloji hergün gelişmekte ve akıllı cihazların ulaşılabilirliği artmaktadır. Teknolojinin bize sunduğu yeni imkanlar ise yeni tecrübeler yaşamamıza sebep olmaktadır. Yeni teknoloji altyapısını kullanan GalePress; dokümanların, tablet bilgisayarlar ve akıllı telefonlar üzerinden basımını, yayınlamasını ve dağıtımını sağlamaktadır.");
define("dil_NEDIR_YAZI3",    "Bu platform ile matbu baskı alınan veya alınmayan dokümanlar kod bilgisi gerektirmeden, kolayca yayınlanabilir. Katalog, kullanıcı kılavuzu, bülten, dergi, gazete, kitap, eğitim dokümanı, tanıtım broşürü, flyer, kampanya duyuruları, şirket içi dokümanlar, fiyat listeleri yayınlanabilir. Şirket içi veya son kullanıcıya yönelik doküman paylaşım süreçlerinizde kullanılabilir.");
define("dil_NEDIR_YAZI4",    "Firma özel uygulama ile müşterilerimiz, kendilerine ait, kendi logo ve firma isimlerinin olduğu bir uygulamaya sahip olur. Bu uygulamanın içinde bir PDF kütüphanesi yer alır.");
define("dil_NEDIR_YAZI5",    "Yine firmaya özel kullanıcı adı ve şifre ile GalePress Doküman Yönetim Sistemi'ne erişilir ve uygulamanın kütüphanesinde yer alacak PDF'ler için ekleme, çıkarma ve yayınlama işlemleri gerçekleştirilir.");
define("dil_NEDIR_YAZI6",    "Doküman Yönetim Sisteminin bir parçası olarak çalışan İnteraktif İçerik Ekleme Sistemi ile PDF'ler üzerine hareketli ve sesli görseller eklemek mümkündür. Bu işlemler sürükle bırak mantığı ile basit bir şekilde gerçekleştirilir. Okuyuculara da mobil platformlarda nitelikli, ayrıntılı ve ilgi çekici içerik deneyimi sağlanır.");



define("dil_MOBILUYG_YAZI", "Appstore'da kendi adınıza uygulamanız olsun.");
define("dil_MOBILUYG_YAZI1", "Kendi adınıza ve kendi logonuzla size özel uygulama");
define("dil_MOBILUYG_YAZI2", "Yayında olan normal ve interaktif PDF dokümanlarını görüntüleme");
define("dil_MOBILUYG_YAZI3", "İndirilmiş olan PDF dokümanlarını görüntüleme");
define("dil_MOBILUYG_YAZI4", "Kategori bazında doküman görüntüleme");
define("dil_MOBILUYG_YAZI5", "PDF içinde arama yapabilme");
define("dil_MOBILUYG_YAZI6", "Facebook, Tweeter linkleri");
define("dil_MOBILUYG_YAZI7", "WEB sayfasına tek tuş ile erişim");
define("dil_MOBILUYG_YAZI8", "Tek tuş ile mail gönderebilme");
define("dil_MOBILUYG_YAZI9", "Okunan sayfanın tek tuş ile paylaşılması");

define("dil_DYP_YAZI1", "Doküman yönetim sistemine erişim");
define("dil_DYP_YAZI2", "Firma özel kullanıcı adı şifresi");
define("dil_DYP_YAZI3", "Satın alınan uygulamaların görüntülenmesi");
define("dil_DYP_YAZI4", "Uygulama için PDF yüklenmesi");
define("dil_DYP_YAZI5", "Yüklenen PDF ile cihazlara kullanıcının yazdığı bildirim iletisinin gönderilmesi");
define("dil_DYP_YAZI6", "Dinamik kategori yapısı");
define("dil_DYP_YAZI7", "Yüklenen PDF'lere kategori tanımlanması");
define("dil_DYP_YAZI8", "PDF yüklemesinde sayı, yayıntarihi, açıklama gibi bilgilerin girilmesi");
define("dil_DYP_YAZI9", "PDF'lerin yayınlanması ve yayından kaldırılması");
define("dil_DYP_YAZI10", "Uygulama raporlarının alınması");
define("dil_DYP_YAZI11", "Doküman özel raporlarının alınması");
define("dil_DYP_YAZI12", "Detaylı rapor ekranları");

define("dil_RAPORLAR", "RAPORLAR");
define("dil_RAPORLAR_YAZI", "Geri bildirim raporları ile her şeyden haberdar olun.");
define("dil_RAPORLAR_YAZI1", "Trafik Raporu");
define("dil_RAPORLAR_YAZI2", "Cihaz Raporu");
define("dil_RAPORLAR_YAZI3", "İndirilme Raporu");
define("dil_RAPORLAR_YAZI4", "Görüntülenme Raporu");

define("dil_INTERAKTIF_ICERIK_EKLE", "İNTERAKTİF İÇERİK EKLEME PANELİ");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI", "Dokümanınızın içeriğini hareketli ve sesli görsellerle zenginleştirin.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI1", "Doküman yönetim sistemi ile yüklenmiş PDF'ler üzerine interaktif görsellerin eklenmesi");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI2", "İnteraktif görseller: Video, ses, harita, web link, PDF link, WEB sayfası, açıklama kutuları, sabit bölgede kayan uzun yazılar, kayan resimler, 360 derece hareketli dönen nesneler, içindekiler indeks tablosunun oluşturulması");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI3", "Her interaktif görsel için çeşitli ayarlar");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI4", "PDF üzerine eklenecek alanın belirlenmesi");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI5", "PDF sayfalarını üstte, küçük resimler halinde görüntüleyebilme");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI6", "Eklenen interaktif görsellerin ön izlemesinin yapılabilmesi");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI7", "Eklenen interaktif görsellerin listelenmesi");







//AVANTAJLAR
define("dil_AVANTAJLAR_SLIDER_YAZI1", "Dijital çağa rakiplerinizden önce entegre olun");
define("dil_AVANTAJLAR_SLIDER_YAZI2", "App. Store ile 117 ülkede yayınlama imkanı");
define("dil_AVANTAJLAR_SLIDER_YAZI3", "Müşterilerinize farklı deneyimler sunarak marka değerinizi artırın");
define("dil_AVANTAJLAR_SLIDER_YAZI4", "Dokümanlarınızı 3.parti çözüm sağlayıcılar olmaksızın son kullanıcıya sunun");
define("dil_AVANTAJLAR_SLIDER_YAZI5", "Yüksek maliyetler harcamadan, yayınlarınızı takip eden müşteri kitlenizi oluşturun");
define("dil_AVANTAJLAR_SLIDER_YAZI6", "Dokümanlarınız ulaşılabilir ve kalıcı olsun");
define("dil_AVANTAJLAR_SLIDER_YAZI7", "Baskı dağıtımı yapılmayan yurt içi ve yurt dışı bölgelerde okuyuculara ulaşın");
define("dil_AVANTAJLAR_SLIDER_YAZI8", "Akıllı cihazların özellikleriyle, ilgi çekici ve interaktif kataloglar üretin");
define("dil_AVANTAJLAR_SLIDER_YAZI9", "Okuyucularınız sıkılmadan yayınlarınızı incelesin");
define("dil_AVANTAJLAR_SLIDER_YAZI10", "Yüksek matbaa baskı maliyeti, dağıtım maliyeti, tekrar baskımaliyeti, baskı süresi,");
define("dil_AVANTAJLAR_SLIDER_YAZI11", "Dağıtım fazlası dokümanlar, arşiv zorluğu olmadan yayıncılık imkanı.");
define("dil_AVANTAJLAR_SLIDER_YAZI12", "Bulut altyapısı ile yazılım yatırım maliyeti, donanım, destek maliyeti olmadan
 kullandığın kadar öde yaklaşımı ile mobil platform hizmeti");
define("dil_AVANTAJLAR_SLIDER_YAZI13", "Detaysoft’un 1. seviye Turquality danışmanlık firma seviyesi sayesinde yatırımın yarısı
 devlet teşviğinden sağlanabilir.");
define("dil_AVANTAJLAR_SLIDER_YAZI14", "Belirleyeceğiniz anahtar kelimeler ile App. Store’ da bulunabilme");



//SİTEMAP

define("dil_WHO_US", "Biz Kimiz?");
define("dil_WHO_US_YAZI", "GalePress; dünyadan ülkemize hızla yayılan bu oluşumun merkezinde yer alıp, hem yayıncılar hem de okuyucuların bu yeni çağın yayıncılık düzeninde yerlerini almalarını sağlayan çözümler sunmaktadır.");
define("dil_AVANTAJLAR1_SITEMAP", "Çevreye duyarlı yayın çözümü");
define("dil_AVANTAJLAR2_SITEMAP", "Kolay Kullanım");
define("dil_AVANTAJLAR3_SITEMAP", "Tek Tuşla Yayınlama");


//Sipariş Formu Server Hataları
define("dil_SERVERHATA1", "Lütfen zorunlu alanları doldurun.");
define("dil_SERVERHATA2", "PNG formatında resim dosyaları yüklemelisiniz.");
define("dil_SERVERHATA3", "Dosyaların boyutu en fazla 300 kb olmalıdır.");
define("dil_SERVERHATA4", "Telefon numarası alanı rakamlardan oluşmalıdır.");
define("dil_SERVERHATA5", "Email formatı hatalı.");
define("dil_SERVERHATA6", "İlk dosya 57x57 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA7", "İlk dosya 72x72 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA8", "İlk dosya 114x114 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA9", "İlk dosya 144x144 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA10", "İlk dosya 1024x1024 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA11", "Telefon numarası alanına toplam 10 karakter girilmelidir.");
define("dil_SERVERHATA12", "Bir hata oluştu!");


define("dil_SERVERMESAJ1", "Tebrikler! Uygulama bilgileriniz sisteme kaydedildi.");
define("dil_SERVERMESAJ2", " adlı paketi seçtiniz.<br>Sipariş numaranız ");

}



else if ($dil =="en"){
 
//Header
define("dil_orders_file_select",    'Dosya yukle');
define("dil_SITE_TITLE",    'GalePress - Digital Publishing Platform');
define("dil_GALELOGIN",    '/en/login');

define("dil_DYSTITLE",    'Member Login Screen to Manage Your Content');
define("dil_ANASAYFA",    'Home');
define("dil_HAKKIMIZDA",    'About Us');
define("dil_GALEPRESS",    'GalePress');
define("dil_NEDIR",    'GalePress?');
define("dil_NEDIR_TEKNOLOJI",    'Technology');
define("dil_NEDIR_PAYLASIM",    'Document Sharing');
define("dil_NEDIR_LOGO",    'Logo and Application Name');
define("dil_URUNLER",    'Products');
define("dil_AVANTAJLAR",    'Benefits');
define("dil_FIYATLAR",    'Prices');
define("dil_MUSTERILERIMIZ",    'Customers');
define("dil_CALISMAYAPISI",    'Tutorials');
define("dil_ILETISIM",    'Contact');
define("dil_ARAMA",    'Search...');
define("dil_DYS",    'DMS');
define("dil_DYSBASLIK",    'Document Management System');

//Slider

define("dil_GALENEDIR", 'What is GalePress?');
define("dil_GALENEDIR_YAZI", "GalePress enables documents like magazines, catalouges and books <br />
                                             to be read over tablet pc's and smart phones. ");
define("dil_MOBILUYG", 'MOBILE APPLICATION');
define("dil_MOBILUYG_YAZI", "You can have your own application in Appstore.");
define("dil_DYP", 'DOCUMENT MANAGEMENT PANEL');
define("dil_DYP_YAZI", 'Load the pdf file that belongs to your magazine, newspaper and/or catalogue.');
define("dil_ITP", 'Interactive Design Panel');
define("dil_ITP_YAZI", 'Chance to enrich by exporting introduction<br />
videos, intro-audios, image slides, 3d images, panoromic product and place images,<br/>
interactive maps and info buttons.
');
define("dil_AVANTAJLAR", 'ADVANTAGES');
define("dil_AVANTAJLAR_YAZI1", 'To manage your application');
define("dil_AVANTAJLAR_YAZI2", 'The chance to be published in 155 countries via App. Store');
define("dil_AVANTAJLAR_YAZI3", 'No printing costs');
define("dil_AVANTAJLAR_YAZI4", 'Let your readers enjoy your publications without boredom');

define("dil_SLIDE_FOOTER", 'Be the first who integrates into the digital age before your rivals!');

define("dil_SLIDE_FLIPBOOK","Let your contents like magazines, brochures and catalogues to be shown in online web media.");

// Footer
define("dil_KOLAYULASIM", 'Get in Touch');

define("dil_HABERDAR",    'Newsletter!');
define("dil_HABERDAR_YAZI",    'Keep up on our always evolving product features and technology. Enter your e-mail and subscribe to our newsletter.');
define("dil_EMAIL",    'Write Your Email Adress');
define("dil_EMAIL_BASARILI",    '<strong>Success!</strong> Your email adress saved to our list.');
define("dil_GIT",    'Send!');

define("dil_TWEET",    'Latest Tweet');
define("dil_YUKLENIYOR",    'Please wait...');

define("dil_ADRES",    'Adress:');
define("dil_TELEFON",    'Telephone:');
define("dil_FAKS",    'Fax:');
define("dil_TAKIP",    'Follow Us');

define("dil_DETAYADRES_IST",    'Alemdağ rd. No: 109, 34692 Üsküdar / İstanbul / Turkey<br />');

define("dil_DETAYADRES_SIV",    'Yenişehir st. İşhan Köyü,Ötegeçe Mevkii 49/1 58140 Teknokent Sivas / Turkey<br />');


define("dil_SSS",    'FAQ');
define("dil_SSS_UZUN",    'FREQUENTLY ASKED QUESTIONS');
define("dil_SITEMAP",    'Sitemap');

//Sipariş Sayfası
define("dil_UYGULAMAFORMU",    'Application Form');
define("dil_UYGULAMAOLUSTUR",    'Application Creating Data Sheet');
define("dil_UYGULAMAOLUSTUR_BUYUK",    'APPLICATION CREATING DATA SHEET');


define("dil_SIPARIS",'<h4>Fill out this form to create an application or please <a href="contact"><u>contact</u></a> us.</h2>');
define("dil_SIPARIS_NO", 'Order No');

define("dil_ADSOYAD",    'Name Surname *');
define("dil_UYGULAMAAD",    'Application Name');
define("dil_FIRMAAD",    'Company Name *');
define("dil_UYGULAMAACIKLAMA",    'Description of Application');
define("dil_KEYWORDS",    'Keywords');
define("dil_WEBSITE",    'Web Site ');
define("dil_GUVENLIKKOD",    'Secure Code ');
define("dil_DOSYAYUKLE",    'Upload Your Files');
define("dil_GONDER",    'Send');
define("dil_SATINAL",    'Buy');
define("dil_STATIK_EKO",    'Static / Eko Package');
define("dil_STATIK_ST",    'Static / Standard Package');
define("dil_STATIK_PRO",    'Static / Pro Package');
define("dil_STATIK_LMTZ",    'Static / Unlimited Package');

define("dil_INTERACTIVITE_ST",    'Interactive / Standard Package');
define("dil_INTERACTIVITE_PRO",    'Interactive / Pro Package');
define("dil_INTERACTIVITE_LMTZ",    'Interactive / Unlimited Package');
define("dil_INTERACTIVITE_KRMSL",    'Interactive / Institutional Package');

define("dil_REQUIRED_FIELDS",    '*  fields are required');
define("dil_APP_SENT",    'Application Data Sheet Sent!');
define("dil_APP_SENT_SUCCESS",    'Success! Application information form has been successfully sent.');
define("dil_APP_SENT_OK",    'Ok');
define("dil_APP_SENT_BTN",    'Send Form');
define("dil_APP_SETUP",    'Installation Steps');

define("dil_APP_INFOS",    'Application Details');
define("dil_APP_IMAGES",    'Application Images');
define("dil_APP_SETUP_FINAL",    'Application Create');

define("dil_APP_STAGE2_all",    'You must upload picture resolution of 1024x1024 and a demo pdf for your application.');
define("dil_APP_STAGE2_first",    'You must upload picture resolution of 1024x1024 for your application.');
define("dil_APP_STAGE2_second",    'You must upload a demo pdf for your application.');

define("dil_APP_SETUP_continue",    'Next');



// SİPARİŞ tooltipler

define("dil_APP_ORDER_NO_TIP",    'Must be entered order number <br>in your mail message.');
define("dil_APP_ORDER_NO",    'Must be entered order number <br>in your mail message.');
define("dil_APP_DESC_TIP",    'Your description will appear as in the App Store.');

define("dil_UYGULAMAAD_TIP",    'This field should contain the name of the application which should be up to 14 characters in length.');
define("dil_UYGULAMATANIM_TIP",    'This area of application should include descriptive sentences. Up to 4000 characters can be entered.');
define("dil_UYGULAMAKEYS_TIP",    'This field should contain keywords relevant to your application for increase to availability. Up to 100 characters can be entered.');
define("dil_UYGULAMAFILES_TIP",    "In this field you can upload logos with different resolutions. The maximum size of logos should be 5 mb, its format should be 'PNG'; its required resolution should be 1024x1024. Required fields are 1024x1024 and PDF.");
define("dil_EMAIL_TIP",    'Email information can contact us easily provide. If you do not enter your email information will not save your email account up to the next update.');


// SİPARİŞ Hata Mesajları
define("dil_APP_Err_FILE",    'Please check your file!');
define("dil_APP_Err_FILE_SIZE",    'The maximum size of file should be 5 mb');
define("dil_APP_Err_FILE_TYPE",    "Its format should be PNG!");
define("dil_APP_Err_PDF_FILE_TYPE",    "Its format should be PDF!");

define("dil_APP_Err_Order_No",    "You must fill order number field!");
define("dil_APP_Err_App_Name",    "You must fill application name field!");
define("dil_APP_Err_App_Desc",    "You must fill application description field!");
define("dil_APP_Err_Keywords",    "You must fill keywords field!");


define("dil_STATIK",    'STATIC PACKAGES:');
define("dil_INTERAKTIFCUMLE",    'Media like videos, sound, picture gallery and 360 picture that provides interactivity can be added.');
define("dil_STATIKCUMLE",    "Lean packages in which only PDF has been published. Video, audio, 3D photo gallery and likewise media can't be added.");
define("dil_FIYAT",    'Price');
define("dil_SATISBUTON",    'Buy');
define("dil_EKO",    'ECO');
define("dil_STANDART",    'Standard');
define("dil_PRO",    'PRO');
define("dil_LIMITSIZ",    'Unlimited');
define("dil_KURUMSAL",    'Institutional');
define("dil_GRAFIKHIZMET",    'Graphic Service');
define("dil_SERVISMODUL",    'Survey Module');
define("dil_INTERAKTIF",    'INTERACTIVE PACKAGES');
define("dil_EKOLIST",'					<li><b>3</b> Number of Concurrent PDF</li>
										<li><b>9.000</b> Annual Number of Downloads</li>
										<li><b>750</b> 
Monthly Downloads</li>
										<li><b>25 MB</b> Max. PDF Size </li>');
define("dil_STALIST",'
										<li><b>9</b> Number of Concurrent PDF</li>
										<li><b>18.000</b> Annual Number of Downloads</li>
										<li><b>1.500</b> Monthly Downloads</li>
										<li><b>25 MB</b> Max. PDF Size </li>');
define("dil_PROLIST",'
										<li><b>9</b> Number of Concurrent PDF</li>
										<li><b>18.000</b> Annual Number of Downloads</li>
										<li><b>1.500</b> 
Monthly Downloads</li>
										<li><b>25 MB</b> Max. PDF Size </li>');
define("dil_LIMITSIZLIST",'
										<li><b>120</b> Number of Concurrent PDF</li>
										<li><b>Unlimited</b> Annual Number of Downloads</li>
										<li><b>Unlimited</b> Monthly Downloads</li>
										<li><b>50 MB</b> Max. PDF Size </li>');
define("dil_STALIST2",'
										<li><b>24</b> Number of Concurrent PDF</li>
										<li><b>60.000</b>
Annual Number of Downloads</li>
										<li><b>5.000</b> 
Monthly Downloads</li>
										<li><b>250 MB</b> Max. PDF Size </li>');
										
define("dil_PROLIST2",'
										<li><b>60</b> Number of Concurrent PDF</li>
										<li><b>60.000</b> Annual Number of Downloads</li>
										<li><b>5.000</b> 
Monthly Downloads</li>
										<li><b>250 MB</b> 
Max. PDF Size </li>');
										
define("dil_LIMITSIZLIST2",'
										<li><b>Unlimited</b> Number of Concurrent PDF</li>
										<li><b>Unlimited</b> 
Annual Number of Downloads</li>
										<li><b>Unlimited</b> Monthly Downloads</li>
										<li><b>Unlimited</b> Max. PDF Size </li>');
										
// İletişim
define("dil_ILETISIM_BUYUK",    'CONTACT');
define("dil_KONU",    'Subject *');
define("dil_MESAJ",    'Message *');
define("dil_MERKEZOFIS",    'Central Office');
define("dil_CALISMASAAT",    'Working <strong>Hours</strong>');
define("dil_CALISMASAAT_YAZI",    '<li><i class="icon-time"></i> Monday - Friday 09:00 - 18:00</li>
								<li><i class="icon-time"></i> Saturday - Sunday (Closed)</li>');
define("dil_EMAILBASARI",    '<strong>Success!</strong> Your message is sent.');
define("dil_EMAILHATA",    '<strong>Error!</strong>');

// Tutorials
define("dil_CALISMA",    'Tutorials');
define("dil_ICERIKGENEL",    'INTERACTIVE DESIGNER - GENERAL');
define("dil_INTERAKTIFANA",    'INTERACTIVE DESIGNER - MAIN SCREEN');

define("dil_INTERAKTIFVIDEO",    'INTERACTIVE DESIGNER - VIDEO');
define("dil_INTERAKTIFSES",    'INTERACTIVE DESIGNER - SOUND');

define("dil_INTERAKTIFGOOGLE",    'INTERACTIVE DESIGNER - GOOGLE MAP (LATITUDE-LONGITUDE)');
define("dil_INTERAKTIFHARITA",    'INTERACTIVE DESIGNER - MAP');

define("dil_INTERAKTIFLINK",    'INTERACTIVE DESIGNER - LINK');
define("dil_INTERAKTIFWEB",    'INTERACTIVE DESIGNER - WEB');

define("dil_INTERAKTIFYOUTUBE",    'INTERACTIVE DESIGNER - YOUTUBE VİDEO');
define("dil_INTERAKTIFTOOLTIP",    'INTERACTIVE DESIGNER - TOOLTIP');

define("dil_INTERAKTIFSCROLLER",    'INTERACTIVE DESIGNER - SCROLLER');
define("dil_INTERAKTIFIMAJWIN",    'INTERACTIVE DESIGNER - CHANGING IMAGE SIZE (WINDOWS)');

define("dil_INTERAKTIFIMAJMAC",    'INTERACTIVE DESIGNER - CHANGING IMAGE SIZE (MAC)');
define("dil_INTERAKTIFSLIDER",    'INTERACTIVE DESIGNER - SLIDER');

define("dil_INTERAKTIF360",    'INTERACTIVE DESIGNER - 360');
define("dil_INTERAKTIFBOOKMARKS",    'INTERACTIVE DESIGNER - BOOKMARKS');

define("dil_INTERAKTIFANIMATON",    'INTERACTIVE DESIGNER - ANIMATION');
define("dil_INTERAKTIFAYARLAR",    'SETTINGS');
define("dil_INTERAKTIFPDF",    'PDF DOWNLOADS');
define("dil_INTERAKTIFLOGIN",    'LOGIN');
//Müşterilerimiz

define("dil_REFERANSLARIMIZ",    'References');

//Anasayfa

define("dil_GALEPRESSDYP",    'GalePress Digital Publishing Platform');
define("dil_GALEPRESSDYP_YAZI",    'At the present time the custom to reach information by the help of printed materials are rapidly been replaced by fast smart phones, multi purpose use tablets, exclusively designed e-readers and other digital gadgets. Digital publishing coming into our lives with the innovative solutions of new age is not an option anymore but a must.<br />
			              GalePress, in the center of the phenomenon rapidly expanding in our country, offers solutions for both publishers and the readers who wants to have their own place in this new age of publishing. ');
define("dil_ALTBASLIK",    'Increase the brand awareness with mobile application!');
define("dil_ALTYAZI",    '250+Billion User - 155 Country - Easy Transportation');
define("dil_YUKLE",    'Upload');
define("dil_INTERAKTIFANASAYFA",    'Make Interactive');
define("dil_YAYINLA",    'Publish');

// Hakkımızda

define("dil_TANIM",    'GENERAL DESCRIPTION');
define("dil_TANIMDETAY_YAZI",    "Detaysoft has provided customer-satisfaction focused and privileged services to over 200 global sector-leading organizations for more than 13 years.  Starting with a core consultant team during its establishment in 1999,  it is one of the most experienced consultancy companies now. Through its successful projects, unique solutions and long-term partnership perception, Detaysoft increased its preferability among its business partners.

In the past few years, Detaysoft has held an important growth rate. In 2007, Detaysoft established Dubai office and with the establishment of Sivas Office in 2008, Detaysoft built the first SAP consultancy team in Central Anatolian.   ");
define("dil_KM",    'MILESTONES');
define("dil_KM_YAZI1",    "Experience in more than 400 projects, over 200 customers and 20 sectors");
define("dil_KM_YAZI2",    'SAP Gold Partner');
define("dil_KM_YAZI3",    'SAP PCOE Certificate Holder');
define("dil_KM_YAZI4",    'SAP 2011 Best Performance Challenge Winner');
define("dil_KM_YAZI5",    '4 office locations: Istanbul(HD), Sivas, Elazığ, Dubai');
define("dil_KM_YAZI6",    'Turquality 1.Group IT Consulting Firm');
define("dil_KM_YAZI7",    'R&D projects suppported by Tübitak');
define("dil_KM_YAZI8",    'Sybase Mobile solution partner');
define("dil_KM_YAZI9",    'SAP SuccessFactors partner');
define("dil_KM_YAZI10",    "SAP EMEA Partner Excellence Award 2013 for Top Partner - Marketing Best Practice");
define("dil_KM_YAZI11",    "Among Turkey's Top 500 IT Companies and Top 10 IT Consulting Firms");

define("dil_LOKASYONLAR",    'LOCATIONS');

define("dil_LOK_ISTANBUL",    'İSTANBUL - CENTRAL');
define("dil_LOK_SIVAS",    'SİVAS - OFFICE');
define("dil_LOK_DUBAI",    'DUBAI - OFFFICE FZCO');
define("dil_LOK_ELAZIG",    'ELAZIĞ - OFFICE');

//NEDİR?

define("dil_NEDIR_YAZI",    "Galepress is supplied  for tablet and smartsphones reading from newspaper document catalog  books.");
define("dil_NEDIR_YAZI2",    "Day by day smart devices are getting accessible  and technology develop at the same time. Technology cause that the new oppurtunity to new experience in our life. Galepress which uses the new substructure of technology is provided for publishing, routing.");
define("dil_NEDIR_YAZI3",    "With the help of this platform, catalogues, manuals, bulletins, magazines, newspapers, books, academic documents, booklets, flyers, campaign announcements, company documents, price lists can be published.");
define("dil_NEDIR_YAZI4",    "Sharing the company documents and the process in targeting the last customer are another useful area.");
define("dil_NEDIR_YAZI5",    "Galepress Document Management System is being accessed and will be located in the application's library for PDFs adding, removing, and publishing operations are performed.");
define("dil_NEDIR_YAZI6",    "Adding Interactive Content System PDFs with interactive and animated visuals is possible to add on. This is done by drag and drop operations. Readers also qualified mobile platforms, detailed and engaging content experience is provided.");


// ÜRÜNLER

define("dil_MOBILUYG_YAZI", "Particular application for each firm with the authority of editing.");
define("dil_MOBILUYG_YAZI1", "Special application with your own logo and for your name.");
define("dil_MOBILUYG_YAZI2", "Display the normal and interactive active PDF ");
define("dil_MOBILUYG_YAZI3", "Display the downloaded PDF documents");
define("dil_MOBILUYG_YAZI4", "Display documents by categories");
define("dil_MOBILUYG_YAZI5", "Searching in PDF");
define("dil_MOBILUYG_YAZI6", "Facebook and Twitter Links");
define("dil_MOBILUYG_YAZI7", "One button easy access to firm website");
define("dil_MOBILUYG_YAZI8", "One button easy send to email");
define("dil_MOBILUYG_YAZI9", "Share your home page in social media and/or email environment ");


define("dil_DYP_YAZI1", "Access the document management system");
define("dil_DYP_YAZI2", "Spesific username and password for your company");
define("dil_DYP_YAZI3", "Displaying of purchased applications");
define("dil_DYP_YAZI4", "Uploading the PDF documents for application");
define("dil_DYP_YAZI5", "Push notification");
define("dil_DYP_YAZI6", "Dynamic category structure");
define("dil_DYP_YAZI7", "Defining categories to additions PDF");
define("dil_DYP_YAZI8", "Number, date of publication, such as the description of the information to be entered while PDF loading");
define("dil_DYP_YAZI9", "PDF's publishment and unpublishment");
define("dil_DYP_YAZI10", "Getting of the application reports");
define("dil_DYP_YAZI11", "Getting of the document special reports");
define("dil_DYP_YAZI12", "Detailed report screens");


define("dil_RAPORLAR", "REPORTS");
define("dil_RAPORLAR_YAZI", "With feedback reports to be aware of everything");
define("dil_RAPORLAR_YAZI1", "Traffic Report");
define("dil_RAPORLAR_YAZI2", "Device Report");
define("dil_RAPORLAR_YAZI3", "Download Report");
define("dil_RAPORLAR_YAZI4", "Views Report");


define("dil_INTERAKTIF_ICERIK_EKLE", "INTERACTIVE PANEL");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI", "Chance to enrich by exporting introduction videos, intro-audios, image slides, 3d images, panoromic product and place images, interactive maps and info buttons.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI1", "Upload your media & drag and drop to on your PDF.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI2", "Create your PDF’s table of contents.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI3", "Listing added interactive visuals");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI4", "PDFs are loaded with interactive visuals on the addition of document management system");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI5", "Variety of settings for each interactive visual");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI6", "PDF pages displaying thumbnails at the top");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI7", "Added to list of interactive visual");

//AVANTAJLAR
define("dil_AVANTAJLAR_SLIDER_YAZI1", "Be the first who integrates into the digital age before your rivals");
define("dil_AVANTAJLAR_SLIDER_YAZI2", "The chance to be published in 155 countries via App. Store");
define("dil_AVANTAJLAR_SLIDER_YAZI3", "Increase your trademark value by offering different experiences to your customers");
define("dil_AVANTAJLAR_SLIDER_YAZI4", "Deliver your documents to your customers without a third-party application");
define("dil_AVANTAJLAR_SLIDER_YAZI5", "Create a body of customers following your publications, without spending fortunes");
define("dil_AVANTAJLAR_SLIDER_YAZI6", "Make your documents and publications permanent");
define("dil_AVANTAJLAR_SLIDER_YAZI7", "Reach your readers where there is no delivery in the country and abroad");
define("dil_AVANTAJLAR_SLIDER_YAZI8", "Create interesting and interactive catalogues with the help of smart devices");
define("dil_AVANTAJLAR_SLIDER_YAZI9", "Let your readers enjoy your publications without boredom");
define("dil_AVANTAJLAR_SLIDER_YAZI10", "Easy to be found in Apps Store with your own keywords");
define("dil_AVANTAJLAR_SLIDER_YAZI11", "Distribution over documents, possibility of publishing without archives difficulty.");
define("dil_AVANTAJLAR_SLIDER_YAZI12", "Investment costs, software, hardware, support costs with cloud infrastructure");
define("dil_AVANTAJLAR_SLIDER_YAZI13", "Since Detaysoft is a first level Turquality advisory firm the half the inverstment can be obtained from the government.");
define("dil_AVANTAJLAR_SLIDER_YAZI14", "To be in the app store with keywords that you specify.");

//SİTEMAP

define("dil_WHO_US", "Who Are We?");
define("dil_WHO_US_YAZI", "GalePress, in the center of the phenomenon rapidly expanding in our country, offers solutions for both publishers and the readers who wants to have their own place in this new age of publishing.");
define("dil_AVANTAJLAR1_SITEMAP", "Environmentally sensitive broadcast solution");
define("dil_AVANTAJLAR2_SITEMAP", "Easy to Use");
define("dil_AVANTAJLAR3_SITEMAP", "One-Click Publish");



//Sipariş Formu Server Hataları
define("dil_SERVERHATA1", "Fill in the required fields.");
define("dil_SERVERHATA2", "Image format must be PNG.");

define("dil_SERVERHATA3", "Files size must be a maximum of 300 KB.");
define("dil_SERVERHATA4", "Telephone number must consist of numbers area.");
define("dil_SERVERHATA5", "Invalid email format.");
define("dil_SERVERHATA6", "The first file must be the 57x57 resolution values​​.");
define("dil_SERVERHATA7", "The first file must be the 72x72 resolution values​​.");
define("dil_SERVERHATA8", "The first file must be the 114x114 resolution values​​.");
define("dil_SERVERHATA9", "The first file must be the 144x144 resolution values​​.");
define("dil_SERVERHATA10", "Your image file must be the 1024x1024 resolution values​​ and Pdf file is not selected");
define("dil_SERVERHATA11", "Telephone field must be total of 10 characters.");
define("dil_SERVERHATA12", "An error has occurred.");


define("dil_SERVERMESAJ1", "Congratulations! Application information is recorded in the system. ");
define("dil_SERVERMESAJ2", " chosen from the package.<br>Order Number ");
}



if ($dil =="de"){
 
//Header
define("dil_orders_file_select",    'Dosya yukle');
define("dil_SITE_TITLE",    'GalePress - Digitale Publikationsplattform');

define("dil_GALELOGIN",    '/de/einloggen');

 
define("dil_DYSTITLE",    'Loginfenster für Mitglieder zum Verwalten der Inhalte');
define("dil_ANASAYFA",    'Startseite');
define("dil_HAKKIMIZDA",    'Über uns ');
define("dil_GALEPRESS",    'GalePress');
define("dil_NEDIR",    'Was ist GalePress?');
define("dil_NEDIR_TEKNOLOJI",    'Technologie');
define("dil_NEDIR_PAYLASIM",    'Dokument-Sharing');
define("dil_NEDIR_LOGO",    'Logo und Name der Anwendung');
define("dil_URUNLER",    'Produkte');
define("dil_AVANTAJLAR",    'Vorteile');
define("dil_FIYATLAR",    'Preise');
define("dil_MUSTERILERIMIZ",    'Unsere Kunden');
define("dil_CALISMAYAPISI",    'Arbeitsweise');
define("dil_ILETISIM",    'Kontakt');
define("dil_ARAMA",    'Suchen ...');
define("dil_DYS",    'DMS');
define("dil_DYSBASLIK",    'Dokumenten Management System?');

//Slider

define("dil_GALENEDIR", 'Was ist GalePress?');//HAKAN
define("dil_GALENEDIR_YAZI", 'Ermöglicht den Abruf der Dokumente wie Zeitungen, Zeitschriften, Kataloge und Bücher <br> auf den Tabletcomputern und Smartphones');
define("dil_MOBILUYG", 'MOBILE APPLIKATION');
define("dil_MOBILUYG_YAZI", "Haben Sie eigene Applikation im Appstore");
define("dil_DYP", "DOKUMENTEN MANAGEMENT PANEL");
define("dil_DYP_YAZI", 'Laden Sie die Dokumente in Ihre Bibliothek, die Sie zum Abruf zur Verfagung stellen wollen.');
define("dil_ITP", 'PANEL FÜR INTERAKTIVE GESTALTUNG');
define("dil_ITP_YAZI", 'Bereichern Sie die Inhalte Ihrer Dokumente mit audio-visuellen Bilddateien.<br />');
define("dil_AVANTAJLAR", 'VORTEILE');
define("dil_AVANTAJLAR_YAZI1", 'Verwaltungsmöglichkeit der eigenen Applikation');
define("dil_AVANTAJLAR_YAZI2", 'Gleichzeitiger Zugriff in 155 Ländern');
define("dil_AVANTAJLAR_YAZI3", 'Ohne Druckereikosten');
define("dil_AVANTAJLAR_YAZI4", 'Interaktive Elemente für einen amüsanten Katalog');

define("dil_SLIDE_FOOTER", 'Integrieren Sie sich in die digitale Welt vor Ihrer Konkurrenten!');

define("dil_SLIDE_FLIPBOOK","Zeitschriften, Broschüren und Kataloge für solche Inhalte in der Online-Umgebung <br> von dem Web angezeigt werden!");


// Footer
define("dil_KOLAYULASIM", 'Einfacher zugriff');

define("dil_HABERDAR",    'Bleiben Sie auf dem Laufenden!');
define("dil_HABERDAR_YAZI",    'Um die Neuigkeiten von GalePress nicht zu verpassen, tragen Sie sich in die Mailingliste.');
define("dil_EMAIL",    'Geben Sie Ihre Email-Adresse ein.');
define("dil_EMAIL_BASARILI",    '<strong>Erfolgreich!</strong> Ihre Email-Adresse wurde eingetragen. ');
define("dil_GIT",    'Senden!');

define("dil_TWEET",    'Letzte Tweets!');
define("dil_YUKLENIYOR",    'Bitte warten...');


define("dil_ADRES",    'Adresse:');
define("dil_TELEFON",    'Telefon:');
define("dil_FAKS",    'Fax:');
define("dil_TAKIP",    'Folgen');

define("dil_DETAYADRES_IST",    'Alemdağ Straße No: 109, 34692 Üsküdar / Istanbul / Türkei<br />');

define("dil_DETAYADRES_SIV",    'Yenişehir Mah. İşhan Köyü,Ötegeçe Mevkii 49/1 58140 Teknokent Sivas / Türkei <br />');

define("dil_SSS",    'FAQ');
define("dil_SSS_UZUN",    'HÄUFIG GESTELLTE FRAGEN');
define("dil_SITEMAP",    'Sitemap');

//Sipariş Sayfası
define("dil_UYGULAMAFORMU",    'Antragsformular');
define("dil_UYGULAMAOLUSTUR",    'Erstellen von Anwendungs ​​Angaben Form');
define("dil_UYGULAMAOLUSTUR_BUYUK",    'UYGULAMA OLUŞTURMA BİLGİ FORMU');

define("dil_SIPARIS",'<h4>Füllen Sie dieses Formular, um eine Anwendung zu erstellen oder <a href="kontakt"><u>kontaktieren</u></a> Sie uns bitte.</h2>');
define("dil_SIPARIS_NO",'Bestellen Nr.');


define("dil_ADSOYAD",    'Vorname, Name *');
define("dil_UYGULAMAAD",    'Bezeichnung der Applikation');
define("dil_FIRMAAD",    'Firma Adı *');
define("dil_UYGULAMAACIKLAMA",    'Anwendungsbeschreibung');
define("dil_WEBSITE",    'Web Site ');
define("dil_KEYWORDS",    'Stichworte');
define("dil_GUVENLIKKOD",    'Güvenlik Kodu ');
define("dil_DOSYAYUKLE",    'Herunterladen von Dateien');
define("dil_GONDER",    'Gönder');
define("dil_SATINAL",    'Satın Al');
define("dil_STATIK_EKO",    'Statik / Eko Paket');
define("dil_STATIK_ST",    'Statik / Standart Paket');
define("dil_STATIK_PRO",    'Statik / Pro Paket');
define("dil_STATIK_LMTZ",    'Statik / Limitsiz Paket');

define("dil_INTERACTIVITE_ST",    'İnteraktif / Standart Paket');
define("dil_INTERACTIVITE_PRO",    'İnteraktif / Pro Paket');
define("dil_INTERACTIVITE_LMTZ",    'İnteraktif / Limitsiz Paket');
define("dil_INTERACTIVITE_KRMSL",    'İnteraktif / Kurumsal Paket');

define("dil_REQUIRED_FIELDS",    '*  Felder sind Pflichtfelder');
define("dil_APP_SENT",    'Applikationsdatenblatt gesendet!');
define("dil_APP_SENT_SUCCESS",    'Erfolgreich! Anwendungshinweise Formular wurde erfolgreich gesendet.');
define("dil_APP_SENT_OK",    'Ok');
define("dil_APP_SENT_BTN",    'Senden Formular');

define("dil_APP_SETUP",    'Installationsschritte');

define("dil_APP_INFOS",    'Anwendungsinformationen');
define("dil_APP_IMAGES",    'Anwendungsfotos');
define("dil_APP_SETUP_FINAL",    'Anwendung erstellen');

define("dil_APP_STAGE2_all",    'Sie müssen Bildauflösung von 1024x1024 und eine Demo-pdf für Ihre Anwendung zu laden.');
define("dil_APP_STAGE2_first",    'Sie müssen Bildauflösung von 1024x1024 für Ihre Anwendung zu laden.');
define("dil_APP_STAGE2_second",    'Sie müssen eine Demo pdf für Ihre Anwendung zu laden.');

define("dil_APP_SETUP_continue",    'Nächste');


// SİPARİŞ tooltipler
define("dil_APP_ORDER_NO_TIP",    'Muss Auftragsnummer in Ihrem <br>E-Mail-Nachricht eingegeben werden.');
define("dil_APP_DESC_TIP",    'Ihre Beschreibung wird wie im App Store erscheinen.');

define("dil_UYGULAMAAD_TIP",    'Dieses Feld sollte den Namen der Anwendung, die bis zu 14 Zeichen lang sein sollten enthalten.');
define("dil_UYGULAMATANIM_TIP",    'Dieser Bereich der Anwendung sollte beschreibende Sätze enthalten. Bis zu 4000 Zeichen eingegeben werden.');
define("dil_UYGULAMAKEYS_TIP",    'Dieses Feld sollte zu Ihrer Anwendung für die Erhöhung, um die Verfügbarkeit Schlüsselwörter enthalten. Bis zu 100 Zeichen eingegeben werden.');
define("dil_UYGULAMAFILES_TIP",    "In diesem Feld Konnen SIE Logos mit unterschiedlichen Auflösungen hochladen. Die Maximale Größe der Logos sollten 5 MB Sein, sollte das. Format 'PNG' sein; Waden erforderliche auflösung sollte 1024x1024 seins. Erforderliche Felder Sind 1024x1024 und PDF.");
define("dil_EMAIL_TIP",    'E-Mail-Informationen können Sie uns ganz einfach Kontakt zu liefern. Wenn Sie nicht in Ihrer E-Mail Informationen, werden nicht speichern Sie Ihre E-Mail-Konto bis zum nächsten Update.');


// SİPARİŞ Hata Mesajları
define("dil_APP_Err_FILE",    'Bitte überprüfen Sie Ihre Datei!');
define("dil_APP_Err_FILE_SIZE",    'Die maximale Größe der Datei sollte 5 MB sein!');
define("dil_APP_Err_FILE_TYPE",    "Das Format sollte PNG sein!");
define("dil_APP_Err_PDF_FILE_TYPE",    "Das Format sollte PDF sein!");

define("dil_APP_Err_Order_No",    "Sie müssen Zahlenfeld, um zu füllen!");
define("dil_APP_Err_App_Name",    "Sie müssen Anwendungsname Feld zu füllen!");
define("dil_APP_Err_App_Desc",    "Sie müssen Applikationsbeschreibung Feld zu füllen!");
define("dil_APP_Err_Keywords",    "Sie müssen Keywords-Feld zu füllen!");


//Fiyatlandırma Sayfası
define("dil_STATIK",    'STATİK PAKETLER:');
define("dil_INTERAKTIFCUMLE",    'PDF üzerine video, ses, 3D resim galeri, 360˚resim, harite gibi interaktifliği sağlayan medyalar eklenebilir.');
define("dil_STATIKCUMLE",    'Sadece PDF in yalın olarak yayınlandığı paketler. PDF üzerine video, ses, 3D resim galeri vb. medyalar eklenemez.');
define("dil_FIYAT",    'Fiyatlandırma');
define("dil_EKO",    'EKO');
define("dil_SATISBUTON",    'Satın Al');
define("dil_STANDART",    'Standart');
define("dil_PRO",    'PRO');
define("dil_LIMITSIZ",    'Limitsiz');
define("dil_KURUMSAL",    'Kurumsal');
define("dil_GRAFIKHIZMET",    'Grafik Hizmeti');
define("dil_SERVISMODUL",    'Anket Modülü');
define("dil_INTERAKTIF",    'İNTERAKTİF PAKETLER:');
define("dil_EKOLIST",'<li><b>3</b> Eşzamanlı PDF Sayısı</li>
										<li><b>9.000</b> Yıllık İndirme Sayısı</li>
										<li><b>750</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_STALIST",'
										<li><b>9</b> Eşzamanlı PDF Sayısı</li>
										<li><b>18.000</b> Yıllık İndirme Sayısı</li>
										<li><b>1.500</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_PROLIST",'
										<li><b>9</b> Eşzamanlı PDF Sayısı</li>
										<li><b>18.000</b> Yıllık İndirme Sayısı</li>
										<li><b>1.500</b> Aylık İndirme Sayısı</li>
										<li><b>25 MB</b> Maks. PDF Boyutu </li>');
define("dil_LIMITSIZLIST",'
										<li><b>120</b> Eşzamanlı PDF Sayısı</li>
										<li><b>Limitsiz</b> Yıllık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Aylık İndirme Sayısı</li>
										<li><b>50 MB</b> Maks. PDF Boyutu </li>');

define("dil_STALIST2",'
										<li><b>24</b> Eşzamanlı PDF Sayısı</li>
										<li><b>60.000</b> Yıllık İndirme Sayısı</li>
										<li><b>5.000</b> Aylık İndirme Sayısı</li>
										<li><b>250 MB</b> Maks. PDF Boyutu </li>');
										
define("dil_PROLIST2",'
										<li><b>60</b> Eşzamanlı PDF Sayısı</li>
										<li><b>60.000</b> Yıllık İndirme Sayısı</li>
										<li><b>5.000</b> Aylık İndirme Sayısı</li>
										<li><b>250 MB</b> Maks. PDF Boyutu </li>');
										
define("dil_LIMITSIZLIST2",'
										<li><b>Limitsiz</b> Eşzamanlı PDF Sayısı</li>
										<li><b>Limitsiz</b> Yıllık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Aylık İndirme Sayısı</li>
										<li><b>Limitsiz</b> Maks. PDF Boyutu </li>');
										
// İletişim
define("dil_ILETISIM_BUYUK",    'KONTAKT');
define("dil_KONU",    'Gegenstand');
define("dil_MESAJ",    'Nachricht');
define("dil_MERKEZOFIS",    'Sitz');
define("dil_CALISMASAAT",    '<strong>Arbeitszeiten</strong>');
define("dil_CALISMASAAT_YAZI",    '<li><i class="icon-time"></i> Montag - Freitag 09:00 - 18:00</li>
								<li><i class="icon-time"></i> Cumartesi - Pazar (Kapalı)</li>');
define("dil_EMAILBASARI",    '<strong>Erfolgreich!</strong> Nachricht gesendet.');
								
define("dil_EMAILHATA",    '<strong>Fehler!</strong> Ein Fehler aufgetreten!');

// Tutorials
define("dil_CALISMA",    'Arbeitsweise');

define("dil_ICERIKGENEL",    'INTERAKTIVER GESTALTER - ALLGEMEINES');
define("dil_INTERAKTIFANA",    'INTERAKTIVER GESTALTER - HAUPTFENSTER');

define("dil_INTERAKTIFVIDEO",    'INTERAKTIF TASARLAYICI - VIDEO');
define("dil_INTERAKTIFSES",    'INTERAKTIVER GESTALTER  - KLANG');

define("dil_INTERAKTIFGOOGLE",    'INTERAKTIVER GESTALTER  - GOOGLE-KARTE (BREITEN-/ LÄNGENGRAD)');
define("dil_INTERAKTIFHARITA",    'INTERAKTIVER GESTALTER  - KARTE');

define("dil_INTERAKTIFLINK",    'INTERAKTIVER GESTALTER  - KARTE');
define("dil_INTERAKTIFWEB",    'INTERAKTIVER GESTALTER  - WEB');

define("dil_INTERAKTIFYOUTUBE",    'INTERAKTIVER GESTALTER  - YOUTUBE-VIDEO');
define("dil_INTERAKTIFTOOLTIP",    'INTERAKTIVER GESTALTER  - TOOLTIP');

define("dil_INTERAKTIFSCROLLER",    'INTERAKTIVER GESTALTER  - UMBLÄTTERN');
define("dil_INTERAKTIFIMAJWIN",    'INTERAKTIVER GESTALTER  - BILDGRÖSSE ÄNDERN (WINDOWS)');

define("dil_INTERAKTIFIMAJMAC",    'INTERAKTIVER GESTALTER  - BILDGRÖSSE ÄNDERN (MAC)');
define("dil_INTERAKTIFSLIDER",    'INTERAKTIVER GESTALTER  - SLIDER');

define("dil_INTERAKTIF360",    'INTERAKTIVER GESTALTER  - 360');
define("dil_INTERAKTIFBOOKMARKS",    'INTERAKTIVER GESTALTER  - LESEZEICHEN');

define("dil_INTERAKTIFANIMATON",    'INTERAKTIVER GESTALTER - ANIMATION');
define("dil_INTERAKTIFAYARLAR",    'EINSTELLUNGEN');
define("dil_INTERAKTIFPDF",    'PDF DOWNLOADS');
define("dil_INTERAKTIFLOGIN",    'LOGIN');
//Müşterilerimiz

define("dil_REFERANSLARIMIZ",    'Unsere Referenzen');

//Anasayfa

define("dil_GALEPRESSDYP",    'GalePress Digitale Publikationsplattform');//HAKAN
define("dil_GALEPRESSDYP_YAZI",    'Informationszugriff auf den Druckmaterialien wird heutzutage immer mehr durch Smaprtphones, multifunktionellen Tabletcomputer, besondere E-Reader und durch die weiteren digitalen Geräte ersetzt. Die neue digitale Publikation, die mit den innovativen Lösungen unseres neuen Zeitalters einhergehen, ist nicht mehr eine Alternative sondern ein Muß. <br>
GalePress befindet sich inmitten einer neuen Entwicklung, die weltweit auch unser Land betrifft, und bietet neue Lösungen an, die nicht nur für Publisher sondern auch für Leser einen festen Standpunkt ermöglichen.');
define("dil_ALTBASLIK",    'Erhöhen sie Ihre Markenbekanntheit mit Hilfe der mobilen Applikationen!');
define("dil_ALTYAZI",    'Mehr als 250 millionen benutzer - 155 Länder - Einfacher Zugriff');
define("dil_YUKLE",    'Hochladen');
define("dil_INTERAKTIFANASAYFA",    'Interaktiv machen');
define("dil_YAYINLA",    'Veröffentlichen');

// Hakkımızda

define("dil_TANIM",    'Allgemeine Beschreibung');
define("dil_TANIMDETAY_YAZI",    "Detaysoft steht seit mehr als 13 Jahren im Rahmen der Software-Applikationen und innovativen Entwicklung mit Hilfe ihrer Belegschaft von mehr als 200 Mitarbeitern den im eigenen Sektor jeweils marktführenden Unternehmen als Berater zur Verfügung. Seit der Gründung im Jahre 1999 hat Detaysoft erfolgreiche Projekte erstellt und hat sich als erfahrenes Technologieunternehmen etabliert. Dank  der eigenen erfolgreichen Projekte, originalen Lösungen und langfristigen Zusammenarbeitern wird Detaysoft von den möglichen Partnern derzeit immer mehr bevorzugt. Mit Hilfe dieses gegenseitigen Vertrauens im Sektor hat Detaysoft ein beachtliches Wachstum verzeichnet. Detaysoft hat 2007 ein Büro in Dubai und 2008 ein weiteres in Sivas eröffnet. Mit dem Sivas-Büro hat Detaysoft nach den großen Städten zum ersten Mal in Anatolien ein großes SAP-Beratungsteam erstellt. Detaysoft ist einer der größten SAP-Partner in der Türkei bietet seit mehr als 13 Jahren in allen flächendeckenden Bereichen von SAP einschließlich der Beratung für Mobile Applikationen im Rahmen der Forschungs- und Entwicklungsprojekten Beratungsdienstleistungen an und entwickelt neue Produkte.");
define("dil_KM",    'MEILENSTEINE');
define("dil_KM_YAZI1",    "In 20 Sektoren mehr als 200 Kundenreferenzen und mehr als 400 abgeschlossene Projekte");
define("dil_KM_YAZI2",    'SAP Gold-Partner');
define("dil_KM_YAZI3",    'SAP PCOE-Zertifikat');
define("dil_KM_YAZI4",    'Preise für Beste Leistung im Rahmen von 2011 Best Performance Challenge');
define("dil_KM_YAZI5",    '4 verschiedene Standorte: Istanbul, Sivas, Dubai, Elazığ');
define("dil_KM_YAZI6",    '1. Gruppe Beraterfirma für IT im Rahmen des Turquality®-Unterstützungsprogramms');
define("dil_KM_YAZI7",    'Forschungs- und Entwicklungsprojekte mit Tübitak-Unterstützung');
define("dil_KM_YAZI8",    'Sybase-Lösungspartner für mobile Applikationen');
define("dil_KM_YAZI9",    'SuccessFactors-Lösungspartner');
define("dil_KM_YAZI10",    "Exzellente Auszeichnung für die unternationalen SAP-Partner 2013  - 'Bester Partner' in der Vermarktung");
define("dil_KM_YAZI11",    "In der türkischen IT-Welt befindet sich unter 500 Beratern im 6. Platz");
define("dil_LOKASYONLAR",    'STANDORTE');

define("dil_LOK_ISTANBUL",    'ISTANBUL - HAUPTSITZ');
define("dil_LOK_SIVAS",    'SİVAS - BÜRO');
define("dil_LOK_DUBAI",    'DUBAI - BÜRO FZCO');
define("dil_LOK_ELAZIG",    'ELAZIĞ - BÜRO');



//NEDİR?

define("dil_NEDIR_YAZI",    "GalePress ermöglicht als eine Web-Plattform und eine mobile Applikation den Abruf der Dokumente wie Zeitungen, Zeitschriften, Kataloge, Bücher, Ausbildungsmaterialien, Gebrauchsanweisungen, etc. auf den Tabletcomputern und Smartphones.");
define("dil_NEDIR_YAZI2",    "Die Technologie wird jeden Tag weiterentwickelt und erhöht die Verfügbarkeit der Smartphones. Die neuen technologischen Möglichkeiten bieten uns auch neue Erlebnisse an. GalePress benutz die neue technologische Infrastruktur und ermöglicht die Publikation bzw. Veröffentlichung und Verteilung der Dokumente über Tabletcomputer und Smartphones.");
define("dil_NEDIR_YAZI3",    "Mit Hilfe dieser Plattform können die druckfähigen und nicht druckfähigen Dokumente ohne Erfordernis eines Kodes einfach veröffentlicht werden. Kataloge, Gebrauchsanweisungen, Newsletter, Zeitschriften, Zeitungen, Bücher, Ausbildungsmaterialien, Werbebroschüren, Flugzettel, Ausschreibungen, betriebsinterne Dokumente, Preisliten können veröffentlicht werden. Diese Plattform können Sie für die Dokumente für betriebsinterne Zwecke oder für den Endkunden in Anspruch nehmen.");
define("dil_NEDIR_YAZI4",    "Mit den firmenspezifischen Applikationen verfügen unsere Kunden über eine Applikation mit eigenem Logo und mit eigener Firmenbezeichnung. In dieser Applikation befindet sich eine PDF-Bibliothek.");
define("dil_NEDIR_YAZI5",    "Ferner ist mit Hilfe der firmenspezifischen Benutzerdaten der zugriff zum Dokumentenmanagementsystem von GalePress sowie die Weiterentwicklung, Bearbeitung und Veröffentlichung der PDF-Dateien möglich.");
define("dil_NEDIR_YAZI6",    "Mit Hilfe der interaktiven Inhalterweiterung als ein Teil des Dokumentenmanagementsystems können die PDFs mit audio-visuellen Elementen versehen werden. Diese Prozesse erfolgen durch Drag & Drop auf einfache Weise. Den Lesern werden auf den mobilen Plattformen qualitative, ausführliche und atraktive Inhalte angeboten.");


define("dil_MOBILUYG_YAZI", "Haben Sie eigene Applikation im Appstore");
define("dil_MOBILUYG_YAZI1", "Eigene Applikation im eigenen Namen und mit eigenem Logo");
define("dil_MOBILUYG_YAZI2", "Abruf der verfügbaren normalen und interaktiven PDF-Dateien");
define("dil_MOBILUYG_YAZI3", "Abruf der heruntergeladenen PDF-Dokumente");
define("dil_MOBILUYG_YAZI4", "Dokumentenabruf auf der Basis der Kategorien");
define("dil_MOBILUYG_YAZI5", "Suche in der PDF-Datei");
define("dil_MOBILUYG_YAZI6", "Links von Facebook, Twitter");
define("dil_MOBILUYG_YAZI7", "Leichter Zugriff zur WEB-Seite mit einem Button");
define("dil_MOBILUYG_YAZI8", "Emailsendung mit einem Button");
define("dil_MOBILUYG_YAZI9", "Teilen der gelesenen Seite mit einem Button");

define("dil_DYP_YAZI1", "Zugriff zum Dokumentenmanagementsystem");
define("dil_DYP_YAZI2", "Firmeneigene Benutzerdaten");
define("dil_DYP_YAZI3", "Anzeige der eingekauften Applikationen");
define("dil_DYP_YAZI4", "PDF-Hochladung für Applikation");
define("dil_DYP_YAZI5", "Push-Benachrichtigung");
define("dil_DYP_YAZI6", "Dynamische Kategoriestruktur");
define("dil_DYP_YAZI7", "Kategoriezuordnung der hochgeladenen PDF-Dateien");
define("dil_DYP_YAZI8", "Eingabemöglichkeiten von Veröffentlichungsdaten wie Ausgabe, Datum und von weiteren Erklärungen bei der Hochladung der PDF-Dateien");
define("dil_DYP_YAZI9", "Veröffentlichung der PDF-Dateien und Zurücknahme");
define("dil_DYP_YAZI10", "Einholung der Applikationsberichte");
define("dil_DYP_YAZI11", "Einholung der dokumenteneigene Berichte");
define("dil_DYP_YAZI12", "Ausführliche Berichtfenster");

define("dil_RAPORLAR", "BERICHTE");
define("dil_RAPORLAR_YAZI", "Bleiben Sie auf dem Laufenden mit Hilfe der Feedbackberichte");
define("dil_RAPORLAR_YAZI1", "Verkehrsbericht");
define("dil_RAPORLAR_YAZI2", "Gerätebericht");
define("dil_RAPORLAR_YAZI3", "Download-Bericht");
define("dil_RAPORLAR_YAZI4", "Abrufbericht");

define("dil_INTERAKTIF_ICERIK_EKLE", "PANEL FÜR INTERAKTIVE INHALTERWEITERUNG");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI", "Bereichern Sie die Inhalte Ihrer Dokumente mit audio-visuellen Bilddateien.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI1", "Mit Hilfe des Dokumentenmanagementsystems versehen Sie Ihre PDF-Dateien mit interaktiven Bildelementen.");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI2", "Interaktive Bilddateien: Video, Klangdateien, Karten, Web-Links, PDF-Links, WEB-Seiten, Nachrichtkästen, lange Lauftexte auf den festen Untergründen, Laufbilder, 360° umdrehende Objekte, Erstellung der Inhaltsverzeichnisse");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI3", "Diverse Einstellungen für jeweilige interaktive Bilddateien");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI4", "Feststellung der Teile von PDF-Dateien für Erweiterungen");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI5", "Anzeige der PDF-Seite im Vordergrund als kleine Bilder");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI6", "Vorschau der hochgeladenen interaktiven Bilddateien");
define("dil_INTERAKTIF_ICERIK_EKLE_YAZI7", "Auflistung der hochgeladenen interaktiven Bilddateien");


//AVANTAJLAR
define("dil_AVANTAJLAR_SLIDER_YAZI1", "Integrieren Sie sich in die digitale Welt vor Ihrer Konkurrenten");
define("dil_AVANTAJLAR_SLIDER_YAZI2", "Mit Hilfe von App. Store Veröffentlichung in 117 Ländern");
define("dil_AVANTAJLAR_SLIDER_YAZI3", "Bieten Sie Ihren Kunden verschiedene Erlebnisse und erhöhen Sie Ihren Markenwert");
define("dil_AVANTAJLAR_SLIDER_YAZI4", "Stellen Sie Ihre Dokumente den Endkunden ohne Einschaltung von dritten Lösungspartnern zur Verfügung.");
define("dil_AVANTAJLAR_SLIDER_YAZI5", "Gewinnen Sie für Ihre Publikationen eigenen Kundenkreis ohne erhebliche Kosten");
define("dil_AVANTAJLAR_SLIDER_YAZI6", "Erhalten Sie verfügbare und nachhaltige Dokumente");
define("dil_AVANTAJLAR_SLIDER_YAZI7", "Gelangen Sie zu den Lesern im In- und Ausland, die keinen Zugriff auf Druckmaterialien haben.");
define("dil_AVANTAJLAR_SLIDER_YAZI8", "Mit Hilfe der Eigenschaften der intelligenten Geräte erstellen Sie attraktive und interaktive Kataloge.");
define("dil_AVANTAJLAR_SLIDER_YAZI9", "Lesemöglichkeit ohne Langweilen 
");
define("dil_AVANTAJLAR_SLIDER_YAZI10", "Publikation ohne erhebliche Kosten für Druckerei und Verteilung und für den erneuten Druck, ohne Zeitverschwendung bei der Druckerei,");
define("dil_AVANTAJLAR_SLIDER_YAZI11", "ohne Retouren und ohne Archivaufwand");
define("dil_AVANTAJLAR_SLIDER_YAZI12", "Investitionskosten, Hardware und Unterstützungskosten mit Hilfe des Cloud Computings");
define("dil_AVANTAJLAR_SLIDER_YAZI13", "Da Detaysoft ein Turquality-Berater 1. Grades ist, kann die Hälfte der OInvestition staatlich gefördert werden.");
define("dil_AVANTAJLAR_SLIDER_YAZI14", "Mit Hilfe der zu definierenden Schlüsselwörter kann die Applikation im App. Store ausfindig gemacht werden.");



//SİTEMAP

define("dil_WHO_US", "Wer sind wir?");
define("dil_WHO_US_YAZI", "GalePress befindet sich inmitten einer neuen Entwicklung, die weltweit auch unser Land betrifft, und bietet neue Lösungen an, die nicht nur für Publisher sondern auch für Leser einen festen Standpunkt ermöglichen.");
define("dil_AVANTAJLAR1_SITEMAP", "Umweltschonende Publikationslösung");
define("dil_AVANTAJLAR2_SITEMAP", "Einfach zu bedienen");
define("dil_AVANTAJLAR3_SITEMAP", "Veröffentlichung mit einem Button");


//Sipariş Formu Server Hataları
define("dil_SERVERHATA1", "Bitte Füllen Sie die Pflichtfelder aus.");
define("dil_SERVERHATA2", "Sie müssen Bilderdateien im PNG-Format hochladen.");//hakan
define("dil_SERVERHATA3", "Dosyaların boyutu en fazla 300 kb olmalıdır.");
define("dil_SERVERHATA4", "Telefon numarası alanı rakamlardan oluşmalıdır.");
define("dil_SERVERHATA5", "Email formatı hatalı.");
define("dil_SERVERHATA6", "İlk dosya 57x57 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA7", "İlk dosya 72x72 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA8", "İlk dosya 114x114 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA9", "İlk dosya 144x144 çözünürlük değerlerine sahip olmalıdır.");
define("dil_SERVERHATA11", "Telefon numarası alanına toplam 10 karakter girilmelidir.");
define("dil_SERVERHATA12", "Bir hata oluştu!");


define("dil_SERVERHATA10", "Resim dosyanız 1024x1024 çözünürlük değerlerine sahip olmalıdır! Pdf dosyası seçilmedi!");
define("dil_SERVERHATA10_title","Logo ve Pdf Dosyası");
define("dil_SERVERHATA11", "Logonuz 1024x1024 çözünürlük değerlerine sahip olmalıdır!");
define("dil_SERVERHATA11_title", "Logo");
define("dil_SERVERHATA12", "Pdf dosyası seçilmedi!");
define("dil_SERVERHATA12_title", "PDF");



define("dil_SERVERMESAJ1", "Tebrikler! Uygulama bilgileriniz sisteme kaydedildi.");
define("dil_SERVERMESAJ2", " adlı paketi seçtiniz.<br>Sipariş numaranız ");

}

?>