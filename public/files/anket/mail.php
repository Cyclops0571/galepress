<?php
if(isset($_POST['formData']))
{
    parse_str($_POST['formData']);
    if(!$name=="")
	{
	      $subject = "RE/MAX Pier Anket Sonuçları";
	      $icerik  = 'Gönderen: ' .$name.$surname. '<br/><br/><u>Sonuçlar:</u><br/><br/>'.
	      "Adı: ".$name."Soyadı: ".$surname.
	      "<br/>Uyruk: ".$uyruk.
	      "<br/>Ev Adresi: ".$homeaddress."<br/>Telefon: ".$phone.
	      "<br/>Doğum Yeri: ".$birthplace."<br/>Doğum Tarihi: ".$birthdate.
	      "<br/>Askerlik Durumu: ".$askerlik."<br/>Medeni Hali: ".$medenihal.
	      "<br/>Çocuk Sayısı: ".$children.
	      "<br/>Öğrenim Durumu: !!!".$ilkokul.
	      "<br/>İş Deneyimi <br/>Çalışılan Kuruluşun Adı ve Yeri: ".$corporate.
	      "<br/>Görevi: ".$mission.
	      "<br/>Başlangıç Tarihi: ".$start_date.
	      "<br/>Bitiş Tarihi: ".$end_date.
	      "<br/>Sürücü Belgeniz var mı? Varsa sınıfı? !!!".$driverLicenceYes.
	      "<br/>Sigara kullanıyor musunuz? !!!".$cigaretteNo.
	      "<br/>Bilgisayar bilginiz hangi seviyededir? !!!".$pcVeryGood.
	      "<br/>Kullanmakta olduğunuz programlar hangileridir? ".$programs.
	      "<br/>ÖZEL MERAKLAR, BECERİLER, HOBİLER ".$skills.
	      "<br/>BİZİ TERCİH ETMENİZİN SEBEPLERİ NELERDİR? ".$prefered.
	      "<br/>TANIŞMA ŞANSINIZ OLSA KİMİNLE TANIŞIRDINIZ? NEDEN? ".$meeting.
	      "<br/>ÇOK İYİ BİR GAYRİMENKUL DANIŞMANI OLURUM, ÇÜNKÜ ".$realty."<br/>";
	      $headers  = 'MIME-Version: 1.0' . "\r\n";
	      $header .= 'Content-Language: tr' . "rn";
	      $headers .= "Content-type: text/html; charset=utf-8\r\n";
	      $headers .= "From:  <".$name.$surname."> \n";
	      
	      mail('serdar.saygili@detaysoft.com', $subject, $icerik, $headers);
	      echo "Mesajınız başarı ile gönderildi.";
	}
	else
	{
	   echo 'Lütfen Formu Doldurun';
	}
}
?>