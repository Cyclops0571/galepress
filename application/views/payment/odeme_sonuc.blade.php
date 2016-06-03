<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
        <title>Gale Press Shop</title>
        <meta name="keywords" content="Gale Press, Paketler"/>
        <meta name="description" content="Gale Press paket bilgilerinin bulunduğu sayfa.">
        <meta name="author" content="Gale Press">
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
		</style>

	</head>
	<body>
		<div class="body">
			<header id="header">
				<div class="container">
					<h1 class="logo">
                        <a href="{{Config::get('custom.galepress_https_url')}}">
                            <img alt="Gale Press" data-sticky-width="252" data-sticky-height="82"
                                 src="/website/img/logo-dark.png">
						</a>
					</h1>
					<nav>
						<ul class="nav nav-pills nav-top">
							<li>
                                <a href="<?php echo __('website.about_us_url');?>" target="_blank"><i
                                            class="icon icon-angle-right"></i><?php echo __('website.about_us');?></a>
							</li>
							<li>
                                <a href="<?php echo __('website.contact_url');?>" target="_blank"><i
                                            class="icon icon-angle-right"></i><?php echo __('website.contact'); ?></a>
							</li>
							<li class="phone">
                                <span><i class="icon icon-phone"></i><?php echo __('website.galepressphone'); ?></span>
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
                                        <?php echo __('website.contract'); ?>
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
																	<li><a href="/website/sozlesme/mesafeli-satis-sozlesmesi.docx?1"><img src="/website/styles/shop/img/mesafeliSatis.jpg" width="200"/></a></li>
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
                                    <li><a href="/"><?php echo __('website.page_home'); ?></a></li>
                                    <li class="active"><?php echo __('website.packeges'); ?></li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
                                <h2>Gale Press Ödeme Sonucu</h2>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<h2 style="color:<?php echo ($result == "Success" ? "green" : "#CA0101") ?>">{{$payDataTitle}}</h2>

					<div class="row">
						<div class="col-md-12">
							<p class="lead">
								{{$payDataMsg}}
							</p>
						</div>
					</div>

					<hr class="tall" />

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
                            <div class="col-md-offset-1 col-md-7" style="padding:0; margin-top:3px;">
                                <?php echo __('website.footer_copyright'); ?>
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

	</body>
</html>