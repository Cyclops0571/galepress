<?php
session_start();

// Basit G�venlik Kodu (Capthca) Scripti v1.0 
// 70 x 22 ebatlar�nda statik bir g�venlik kodu scriptidir.
// G�rsel ebat� 5 haneli Blurmix fontuna g�re ayarlanm��t�r.
// Caner �NCEL - http://www.egonomik.com 

// Resim detaylar�n� tan�ml�yoruz.
	$font = "Blurmix_0.TTF"; 
	$width = "70";
	$height = "22";
	$hane = "5";

// Kodda kullan�lacak olan karakterleri tan�mlayan fonksiyon
// 1, 0, o, �, i, l gibi karakterleri kar���kl�k yaratmamas� i�in egale ediyoruz.
	function rastgele($text) {
	$mevcut = "abcdefghjkmnprstuxvyz23456789ABCDEFGHJKMNPRSTUXVYZ";
	for($i=0;$i<$text;$i++) {
	$salla .= $mevcut{rand(0,48)}; }
	return $salla; }
	$metin = rastgele($hane);

// Arkaplan resmini olu�turuyoruz
	$resim_yaz=imagecreate($width,$height);
	imagecolorallocate($resim_yaz, 255, 255, 255);

// Metin rengi ve kar���kl�k yaratmas�n� istedi�imiz di�er renklerini tan�ml�yoruz.
	$text_renk = imagecolorallocate($resim_yaz, 29, 96, 146);
	$bg1 = imagecolorallocate($resim_yaz, 244, 244, 244);
	$bg2 = imagecolorallocate($resim_yaz, 227, 239, 253);
	$bg3 = imagecolorallocate($resim_yaz, 207, 244, 204);

	header('Content-type: image/png');
	imagettftext($resim_yaz, 26, -4, 4, 25, $bg1, $font, $metin);
	imagettftext($resim_yaz, 30, -7, 0, 15, $bg2, $font, $metin);

// Arka plana rastgele �izgiler yazd�r�yoruz.
	for( $i=0; $i<($width*$height)/400; $i++ ) {
	imageline($resim_yaz, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $bg3);	}

// Esaso�lan metnimizi (g�venlik kodu) bast�r�yoruz.
	imagettftext($resim_yaz, 14, 3, 7, 17, $text_renk, $font, $metin);
	imagepng($resim_yaz);
	imagedestroy($resim_yaz);

// Session de�erlerini at�yoruz.
	$_SESSION['guvenlik_kodu'] = "$metin";
	session_register("guvenlik_kodu");

?>