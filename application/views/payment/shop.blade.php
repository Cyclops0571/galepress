<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>GalePress Shop</title>		
		<meta name="keywords" content="GalePress, Paketler" />
		<meta name="description" content="GalePress paket bilgilerinin bulunduğu sayfa.">
		<meta name="author" content="GalePress">
		<link rel="shortcut icon" href="/website/img/favicon2.ico">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,200italic,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

		<!-- Libs CSS -->
		<link rel="stylesheet" href="/website/styles/shop/vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/website/styles/shop/vendor/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/website/styles/shop/vendor/owl-carousel/owl.carousel.css" media="screen">
		<link rel="stylesheet" href="/website/styles/shop/vendor/owl-carousel/owl.theme.css" media="screen">
		<link rel="stylesheet" href="/website/styles/shop/vendor/magnific-popup/magnific-popup.css" media="screen">
		<link rel="stylesheet" href="/website/styles/shop/vendor/isotope/jquery.isotope.css" media="screen">
		<link rel="stylesheet" href="/website/styles/shop/vendor/mediaelement/mediaelementplayer.css" media="screen">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="/website/styles/shop/theme.css">
		<link rel="stylesheet" href="/website/styles/shop/theme-elements.css">
		<link rel="stylesheet" href="/website/styles/shop/theme-blog.css">
		<link rel="stylesheet" href="/website/styles/shop/theme-shop.css">
		<link rel="stylesheet" href="/website/styles/shop/theme-animate.css">

		<!-- Responsive CSS -->
		<link rel="stylesheet" href="/website/styles/shop/theme-responsive.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="/website/styles/shop/skins/default.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="/website/styles/shop/custom.css">

		<!-- Head Libs -->
		<script src="/website/styles/shop/vendor/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="/website/styles/shop/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="/website/styles/shop/vendor/respond.js"></script>
		<![endif]-->

		<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
		<style type="text/css">
			*{
				font-family: 'Titillium Web', sans-serif !important;
			}
			i[class~="icon"] {
			    font-family: FontAwesome !important;
			}
			.lead{
				font-weight: 300 !important;
			}
			p .alternative-font{
				top: 0 !important;
				font-size: 1.1em !important;
			}
			.pricing-table h3 span{
				font-weight: 300 !important;
			}
			#footer .footer-copyright nav ul li{
				border: none !important;
			}
			#footer .container .row > div{
				margin-bottom: 12px !important;
			}
			/*#header > .container{
				height: 37px !important;
			}*/
			#header{
				min-height: 0 !important;
			}
			#header nav ul.nav-main{
				margin: 0 !important;
			}
			.sub-menu li a img{
				border: 1px solid black;
				-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.50);
				-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.50);
				box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.50);
			}
			.sub-menu a:hover img{
				opacity: 0.3;
			}
			.sub-menu .read{
				position:absolute;top:48%;left:28%;font-size:3em;
				display: none;
			}
			.sub-menu li:hover .read{
				display: block;
			}
			.sub-menu li{
				max-width: 200px;
			}
			.modal{
				overflow: hidden;
			}
			.logo.logo-sticky-active img{
				top: 32px !important;
			}
			.modal .modal-body {
			    max-height: 400px;
			    overflow-y: scroll;
			}
			.toggle-group{
				width: 187%;
			}
			.modal .modal-dialog{
				height: 100%;
  				overflow-y: auto;
			}
		</style>

	</head>
	<body>
		<?php if(FALSE) {
			$paymentAccount = new PaymentAccount();
		}
		?>
		<div class="body">
			<header id="header">
				<div class="container">
					<h1 class="logo">
						<a href="index.html">
							<img alt="GalePress" data-sticky-width="252" data-sticky-height="82" src="/website/img/logo-dark.png">
						</a>
					</h1>
					<nav>
						<ul class="nav nav-pills nav-top">
							<li>
								<a href="http://www.detaysoft.com/kurumsal/" target="_blank"><i class="icon icon-angle-right"></i>Hakkımızda</a>
							</li>
							<li>
								<a href="http://www.detaysoft.com/iletisim/" target="_blank"><i class="icon icon-angle-right"></i>İletişim</a>
							</li>
							<li class="phone">
								<span><i class="icon icon-phone"></i>+90 (216) 443 13 29</span>
							</li>
						</ul>
					</nav>
					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="icon icon-bars"></i>
					</button>
				</div>
				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<li class="dropdown mega-menu-item mega-menu-fullwidth active">
									<a class="dropdown-toggle" href="#">
										Sözleşme ve Şartlar
										<i class="icon icon-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
										<li>
											<div class="mega-menu-content">
												<div class="row">
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="read">OKU</span>
																<span class="mega-menu-sub-title">MESAFELİ SATIŞ SÖZLEŞMESİ</span>
																<ul class="sub-menu">
																	<li><a href="/website/sozlesme/mesafeli-satis-sozlesmesi.docx"><img src="/website/styles/shop/img/mesafeliSatis.jpg" width="200"/></a></li>
																	<!-- <li><a href="feature-icons.html">Icons</a></li>
																	<li><a href="feature-animations.html">Animations</a></li>
																	<li><a href="feature-typography.html">Typography</a></li>
																	<li><a href="feature-grid-system.html">Grid System</a></li> -->
																</ul>
															</li>
														</ul>
													</div>
													<div class="col-md-3">
														<ul class="sub-menu">
															<li>
																<span class="read">OKU</span>
																<span class="mega-menu-sub-title">GİZLİLİK SÖZLEŞMESİ</span>
																<ul class="sub-menu">
																	<li><a href="/website/sozlesme/gizlilik.docx"><img src="/website/styles/shop/img/gizlilik.jpg" width="200"/></a></li>
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</header>
			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="/">Anasayfa</a></li>
									<li class="active">Paketler</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h2>GalePress Paketler</h2>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<h2>İnteraktif Paketler</h2>

					<div class="row">
						<div class="col-md-12">
							<p class="lead">
								PDF üzerine video, ses, 3D resim galeri, 360˚, animasyon, harita gibi <span class="alternative-font">interaktifliği</span> sağlayan medyalar eklenebilir.
							</p>
						</div>
					</div>

					<hr class="tall" />
					<div class="row">

						<div class="pricing-table">

							<div class="col-md-offset-4 col-md-3 center">
								<div class="plan most-popular">
									<div class="plan-ribbon-wrapper"><div class="plan-ribbon">Popular</div></div>
									<h3>Standart<span style="line-height: 80px;">&#x20BA;100</span><br /><i style="color: rgb(0, 136, 204);font-size: 15px;">Aylık</i></h3>
									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Satın Al</button>
									<ul>
										<li><b>IOS, Android</b> mobil uygulama</li>
										<li><b>6 Adet</b> Pdf yükleme</li>
										<li><b>1000</b> Aylık İndirme Sayısı</li>
										<li><b>100 MB</b> Pdf Boyutu</li>
									</ul>
								</div>
							</div>

						</div>

					</div>


				</div>

			</div>

			<footer id="footer">
				<div class="container">
					<div class="row">

						<div class="col-md-5">
							<div class="newsletter">
								<h4>Hakkımızda</h4>
								<p>Detaysoft, 13 yılı aşkın bir süredir, yazılım uygulamaları ve yenilikçi geliştirme konusunda, personel sayısı 200'ü aşan ve kendi sektöründe lider kuruluşlara danışmanlık hizmeti vermektedir.</p>
							</div>
						</div>
						<div class="col-md-5">
							<div class="contact-details">
								<h4>İletişim</h4>
								<ul class="contact">
									<li><p><i class="icon icon-map-marker"></i> <strong>Adres:</strong> Alemdağ Cad. No: 109, Üsküdar / İstanbul / Türkiye</p></li>
									<li><p><i class="icon icon-phone"></i> <strong>Telefon:</strong> +90 (216) 443 13 29</p></li>
									<li><p><i class="icon icon-print"></i> <strong>Fax:</strong> +90 (216) 443 08 27</p></li>
									<li><p><i class="icon icon-envelope"></i> <strong>Email:</strong> <a href="mailto:info@galepress.com">info@galepress.com</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<h4>Takip Edin</h4>
							<div class="social-icons">
								<ul class="social-icons">
									<li class="facebook"><a href="https://www.facebook.com/pages/Galepress/267455253374597?fref=ts" target="_blank" data-placement="bottom" rel="tooltip" title="Facebook">Facebook</a></li>
									<li class="twitter"><a href="https://twitter.com/GalePress" target="_blank" data-placement="bottom" rel="tooltip" title="Twitter">Twitter</a></li>
									<li class="linkedin"><a href="https://www.linkedin.com/company/galepress" target="_blank" data-placement="bottom" rel="tooltip" title="Linkedin">Linkedin</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-1" style="padding:0; margin-top:3px;">
								<a href="http://www.detaysoft.com/" class="logo">
									<img alt="Detaysoft" class="img-responsive" src="/website/img/logo-footer.png">
								</a>
							</div>
							<div class="col-md-7">
								<p>© Copyright 2014. All Rights Reserved.</p>
							</div>
							<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><img src="/website/styles/shop/img/visa.png" width="45"/></li>
										<li><img src="/website/styles/shop/img/master.png" width="45"/></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		        <h4 class="modal-title">Ödeme Sayfasına Doğru...</h4>
		      </div>
				<form action="/odeme" method="post" id="userInfos" class="form-horizontal" novalidate>
			      <div class="modal-body">
					  <?php $bireysel_kurumsal = $paymentAccount->kurumsal ? 'data-on="Kurumsal" data-off="Bireysel"' : 'data-on="Bireysel" data-off="Kurumsal"' ;?>
			      		<div class="form-group">
						    <label for="customerType" class="control-label col-xs-3" style="padding-top: 16px;">Bireysel / Kurumsal</label>
						    <div class="col-xs-9">
			      				<input class="form-control required" type="checkbox" checked data-toggle="toggle" data-size="normal" id="customerType" name="customerType" data-onstyle="success" data-offstyle="info" <?php echo $bireysel_kurumsal; ?> data-width="200">
						    </div>
						</div>
						<div class="form-group">
						    <label for="email" class="control-label col-xs-3">Email Adresi</label>
						    <div class="col-xs-9">
						    	<input id="email" class="form-control required" maxlength="25" name="email" size="20" type="email" tabindex="1" value="<?php echo $paymentAccount->email;?>" placeholder="Email" required>
						    </div>
						</div>
						<div class="form-group">
						    <label for="phone" class="control-label col-xs-3">Telefon</label>
						    <div class="col-xs-9">
						    	<input id="phone" maxlength="14" name="phone" size="20" type="text" class="form-control required" tabindex="2" value="<?php echo $paymentAccount->phone;?>" placeholder="Telefon" required>
						    </div>
						</div>
						<hr>
						<h5 class="col-xs-12">FATURA BİLGİLERİ</h5>
						<div class="form-group">
						    <label for="customerTitle" class="control-label col-xs-3">İsim / Ünvan</label>
						    <div class="col-xs-9">
						    	<input id="customerTitle" class="form-control required" maxlength="100" name="customerTitle" size="20" type="text" tabindex="6" value="<?php echo $paymentAccount->title;?>" placeholder="Birey veya Şirket Unvanı" required>
							</div>
						</div>
			      		<div class="form-group">
						    <label for="tc" class="control-label col-xs-3">Tc Kimlik No</label>
						    <div class="col-xs-9">
						    	<input class="form-control required" id="tc" name="tc" type="text" maxlength="11" tabindex="3" value="<?php echo $paymentAccount->tckn;?>" placeholder="<?php echo $paymentAccount->tckn;?>"/>
						    </div>
						</div>
						<div class="form-group">
						    <label for="country" class="control-label col-xs-3">Ülke</label>
						    <div class="col-xs-9">
						    	<input id="country" class="form-control required" maxlength="25" name="country" size="20" type="text" tabindex="4" value="Türkiye" placeholder="Ülke Bilgisi" required disabled>
						    </div>
						</div>
						<div class="form-group">
						    <label for="city" class="control-label col-xs-3">Şehir</label>
						    <div class="col-xs-9">
						    	<select id="city" class="form-control required" name="city" tabindex="6" placeholder="Şehir Bilgisi" required>
						    		<option selected="selected" disabled="disabled">Şehir Seçiniz</option>
						    		@foreach($city as $c)
									<option value="{{$c->CityID}}" <?php echo $c->CityID == $paymentAccount->city_id ? 'selected="selected"' : ''; ?> >{{$c->CityName}}</option>
									@endforeach
								</select>
						    </div>
						</div>
						<div class="form-group">
						    <label for="address" class="control-label col-xs-3">Adres</label>
						    <div class="col-xs-9">
								<textarea id="address" class="form-control required" maxlength="100" name="address" size="20" tabindex="6" placeholder="Adres Bilgisi, Sok. No, Konut No" required rows="4"><?php echo $paymentAccount->address;?></textarea>
							</div>
						</div>
						<div class="form-group hide">
						    <label for="taxOffice" class="control-label col-xs-3">Vergi Dairesi</label>
						    <div class="col-xs-9">
						    	<input id="taxOffice" class="form-control required" maxlength="100" name="taxOffice" size="20" type="text" tabindex="7" value="<?php echo $paymentAccount->vergi_dairesi; ?>" placeholder="Vergi Dairesi" required>
							</div>
						</div>
						<div class="form-group hide">
						    <label for="taxNo" class="control-label col-xs-3">Vergi No</label>
						    <div class="col-xs-9">
						    	<input id="taxNo" class="form-control required" maxlength="100" name="taxNo" size="20" type="text" tabindex="8" value="<?php echo $paymentAccount->vergi_no; ?>" placeholder="Vergi Numarası" required>
							</div>
						</div>
						<div class="form-group errorMsg hide" style="color:#CA0101; text-align:center; font-size:18px;">
							<span>Lütfen bilgilerinizi kontrol edin...</span>
						</div>
			      </div>
			      <div class="modal-footer">
			        <button class="btn btn-primary" id="payBtn" type="submit">Devam Et</button>
			      </div>
		      </form>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- Libs -->
		<script src="/website/styles/shop/vendor/jquery.js"></script>
		<script src="/website/styles/shop/vendor/jquery.appear.js"></script>
		<script src="/website/styles/shop/vendor/jquery.easing.js"></script>
		<script src="/website/styles/shop/vendor/jquery.cookie.js"></script>
		<script src="/website/styles/shop/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="/website/styles/shop/vendor/jquery.validate.js"></script>
		<script src="/website/styles/shop/vendor/jquery.stellar.js"></script>
		<script src="/website/styles/shop/vendor/jquery.knob.js"></script>
		<script src="/website/styles/shop/vendor/jquery.gmap.js"></script>
		<script src="/website/styles/shop/vendor/twitterjs/twitter.js"></script>
		<script src="/website/styles/shop/vendor/isotope/jquery.isotope.js"></script>
		<script src="/website/styles/shop/vendor/owl-carousel/owl.carousel.js"></script>
		<script src="/website/styles/shop/vendor/jflickrfeed/jflickrfeed.js"></script>
		<script src="/website/styles/shop/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="/website/styles/shop/vendor/mediaelement/mediaelement-and-player.js"></script>
		
		<!-- Theme Initializer -->
		<script src="/website/scripts/shop/theme.plugins.js"></script>
		<script src="/website/scripts/shop/theme.js"></script>
		
		<!-- Custom JS -->
		<script src="/website/scripts/shop/custom.js"></script>
		<script src="/website/scripts/shop/validate/jquery.mask.min.js"></script>
		<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>


		<script type="text/javascript">
		$(function(){

			$('#customerType').change(function() {
			   	$('#taxOffice').closest('.form-group').toggleClass('hide');
			    $('#taxNo').closest('.form-group').toggleClass('hide');
			    $('#tc').closest('.form-group').toggleClass('hide');
			    if(!$(this).prop('checked')){
			    	$('#taxOffice').val("");
			    	$('#taxNo').val("");
			    	$('#tc').val("null");
			    }
			    else{
			    	$('#taxOffice').val("null");
			    	$('#taxNo').val("null");
			    	$('#tc').val("");
			    }
			});

			$("#tc").keyup(function() {
			    $("#tc").val(this.value.match(/[0-9]*/));
			});

			$("#phone").mask("(999) 999-9999", {placeholder: "(___) __ ____"});
		

			$("#userInfos").bind("submit", function() {

				var email = $("#email").val();
				var phone = $("#phone").val();

				var phonePattern = /[0-9]/;
				var mailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			    if( phone.length < 14 || !phonePattern.test(phone) ) {
			    	$('.errorMsg').removeClass('hide').text('Lütfen geçerli bir telefon adresi girin.');
			    	$('#phone').focus();
			        return false;
			    }
			    else if(email=="" || !mailPattern.test(email)){
			    	$('.errorMsg').removeClass('hide').text('Lütfen geçerli bir email adresi girin.');
			    	$('#email').focus();
			        return false;
			    }
			    else if($("#tc").val().length<11 && $('#customerType').prop('checked')){
					$('.errorMsg').removeClass('hide').text('Lütfen geçerli bir tc kimlik numarası girin.');
					$('#tc').focus();
					return false;
				}
				// else if($("#region").val()==null){
				// 	$('.errorMsg').removeClass('hide').text('Lütfen bölge seçiniz.');
				// 	$('#region').focus();
				// 	return false;
				// }
				else if($("#city").val()==null){
					$('.errorMsg').removeClass('hide').text('Lütfen şehir seçiniz.');
					$('#city').focus();
					return false;
				}
			    else {
			    	$('.errorMsg').addClass('hide');
			    	// return false;
			    }
			});
			
		});
		</script>
	</body>
</html>