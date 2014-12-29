<?php
session_start();

// Basit Güvenlik Kodu (Capthca) Scripti v1.0 
// 70 x 22 ebatlarýnda statik bir güvenlik kodu scriptidir.
// Görsel ebatý 5 haneli Blurmix fontuna göre ayarlanmýþtýr.
// Caner ÖNCEL - http://www.egonomik.com 

// Resim detaylarýný tanýmlýyoruz.
	$font = "Blurmix_0.TTF"; 
	$width = "70";
	$height = "22";
	$hane = "5";

// Kodda kullanýlacak olan karakterleri tanýmlayan fonksiyon
// 1, 0, o, ý, i, l gibi karakterleri karýþýklýk yaratmamasý için egale ediyoruz.
	function rastgele($text) {
	$mevcut = "abcdefghjkmnprstuxvyz23456789ABCDEFGHJKMNPRSTUXVYZ";
	for($i=0;$i<$text;$i++) {
	$salla .= $mevcut{rand(0,48)}; }
	return $salla; }
	$metin = rastgele($hane);

// Arkaplan resmini oluþturuyoruz
	$resim_yaz=imagecreate($width,$height);
	imagecolorallocate($resim_yaz, 255, 255, 255);

// Metin rengi ve karýþýklýk yaratmasýný istediðimiz diðer renklerini tanýmlýyoruz.
	$text_renk = imagecolorallocate($resim_yaz, 29, 96, 146);
	$bg1 = imagecolorallocate($resim_yaz, 244, 244, 244);
	$bg2 = imagecolorallocate($resim_yaz, 227, 239, 253);
	$bg3 = imagecolorallocate($resim_yaz, 207, 244, 204);

	header('Content-type: image/png');
	imagettftext($resim_yaz, 26, -4, 4, 25, $bg1, $font, $metin);
	imagettftext($resim_yaz, 30, -7, 0, 15, $bg2, $font, $metin);

// Arka plana rastgele çizgiler yazdýrýyoruz.
	for( $i=0; $i<($width*$height)/400; $i++ ) {
	imageline($resim_yaz, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $bg3);	}

// Esasoðlan metnimizi (güvenlik kodu) bastýrýyoruz.
	imagettftext($resim_yaz, 14, 3, 7, 17, $text_renk, $font, $metin);
	imagepng($resim_yaz);
	imagedestroy($resim_yaz);

// Session deðerlerini atýyoruz.
	$_SESSION['guvenlik_kodu'] = "$metin";
	session_register("guvenlik_kodu");

?>