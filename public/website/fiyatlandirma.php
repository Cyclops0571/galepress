<?php
session_start();

$_SESSION["benimdilim"]="tr";
$uri = $_SERVER['REQUEST_URI'];
$segment = explode('/', $uri);
$_SESSION["benimdilim"]=$segment[1];

if(isset($_POST["submit_tr"]))
{
	header('Location: /tr/');
}
else if(isset($_POST["submit_eng"]))
{
	header('Location: /en/');
}
else if(isset($_POST["submit_de"]))
{
	header('Location: /de/');
}

$currentPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

if($currentPage=="anasayfa.php")
	$activePage=1;
elseif($currentPage=="hakkimizda.php")
	$activePage=2;
elseif($currentPage=="nedir.php")
	$activePage=31;
elseif($currentPage=="nesatar.php")
	$activePage=32;
elseif($currentPage=="avantajlar.php")
	$activePage=33;
elseif($currentPage=="musterilerimiz.php")
	$activePage=4;
elseif($currentPage=="calismayapisi.php")
	$activePage=5;
elseif($currentPage=="iletisim.php")
	$activePage=6;

function getURL($page) {

	if(isset($_SESSION["benimdilim"])) {

		if($_SESSION["benimdilim"] == "en") {
			$arr = array(
				'anasayfa.php' => '',
				'hakkimizda.php' => 'about-us',
				'nedir.php' => 'what-is-galepress',
				'nesatar.php' => 'products',
				'avantajlar.php' => 'advantages',
				'musterilerimiz.php' => 'our-customers',
				'calismayapisi.php' => 'work-flow',
				'iletisim.php' => 'contact',
				'sss.php' => 'faq',
				'sitemap.php' => 'sitemap'
			);
			return '/en/'.$arr[$page];
		}
		if($_SESSION["benimdilim"] == "de") {
			$arr = array(
				'anasayfa.php' => '',
				'hakkimizda.php' => 'uber-uns',
				'nedir.php' => 'was-ist-galepress',
				'nesatar.php' => 'produkte',
				'avantajlar.php' => 'vorteile',
				'musterilerimiz.php' => 'unsere-kunden',
				'calismayapisi.php' => 'arbeitsweise',
				'iletisim.php' => 'kontakt',
				'sss.php' => 'faq',
				'sitemap.php' => 'sitemap'
			);
			return '/de/'.$arr[$page];
		}
	}
	$arr = array(
		'anasayfa.php' => '',
		'hakkimizda.php' => 'hakkimizda',
		'nedir.php' => 'galepress-nedir',
		'nesatar.php' => 'urunler',
		'avantajlar.php' => 'avantajlar',
		'musterilerimiz.php' => 'musterilerimiz',
		'calismayapisi.php' => 'calisma-yapisi',
		'iletisim.php' => 'iletisim',
		'sss.php' => 'sss',
		'sitemap.php' => 'site-haritasi'
	);
	

	return '/tr/'.$arr[$page];

}
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<head>
	<?php include('language.php'); ?>
	<!-- Basic -->
	<meta charset="utf-8">
	<title><?php echo dil_SITE_TITLE ?></title>
	<meta name="keywords" content="GalePress Dijital Yayıncılık" />
	<meta name="description" content="GalePress - Dijital Yayıncılık Platformu">
	<meta name="author" content="galepress.com">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-itunes-app" content="app-id=647802727">
	<!-- Libs CSS -->
	<link rel="stylesheet" href="/website/css/bootstrap.css">
	<link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome.css">

	<link rel="stylesheet" href="/website/css/fonts/open-sans-condensed/css/open-sans-condensed.css">

	<link rel="stylesheet" href="/website/vendor/flexslider/flexslider.css" media="screen" />
	<link rel="stylesheet" href="/website/vendor/fancybox/jquery.fancybox.css" media="screen" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="/website/css/theme.css">
	<link rel="stylesheet" href="/website/css/theme-elements.css">

	<!-- Current Page Styles -->
	<link rel="stylesheet" href="/website/vendor/revolution-slider/css/settings.css" media="screen" />
	<link rel="stylesheet" href="/website/vendor/revolution-slider/css/captions.css" media="screen" />
	<link rel="stylesheet" href="/website/vendor/circle-flip-slideshow/css/component.css" media="screen" />

	<!-- Custom CSS -->
	<link rel="stylesheet" href="/website/css/custom.css">
	
	<!-- Skin -->
	<link rel="stylesheet" href="/website/css/skins/blue.css">

	<!-- Responsive CSS -->
	<link rel="stylesheet" href="/website/css/bootstrap-responsive.css" />
	<link rel="stylesheet" href="/website/css/theme-responsive.css" />

	<!-- Favicons -->
	<link rel="shortcut icon" href="/website/img/favicon2.ico">


	<!-- Head Libs -->
	<script src="/website/vendor/modernizr.js"></script>
	<link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome-ie7.css">
	<link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome-ie7.min.css">
	<link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome.min.css">

	<!--[if IE]>
	<link rel="stylesheet" href="/website/css/ie.css">
	<![endif]-->

	<!--[if lte IE 8]>
	<script src="/website/vendor/respond.js"></script>
	<![endif]-->

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/website/vendor/jquery.js"><\/script>')</script>
    <script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="/uploadify/jquery.uploadify-3.1.min.js"></script>
	<script src="/bundles/jupload/js/jquery.iframe-transport.js"></script>
	<script src="/bundles/jupload/js/jquery.fileupload.js"></script>
	<script src="/js/jquery.base64.decode.js"></script>
	<script src="/js/gurus.string.js"></script>

	<!-- Facebook OpenGraph Tags - Go to http://developers.facebook.com/ for more information.
	<meta property="og:title" content="GalePress - Dijital Yayıncılık Platformu"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="http://www.galepress.com"/>
	<meta property="og:image" content="http://www.galepress.com"/>
	<meta property="og:site_name" content="GalePress"/>
	<meta property="fb:app_id" content=""/>
	<meta property="og:description" content="GalePress - Dijital Yayıncılık Platformu"/>
	-->

	<?php 
	$a = include($_SERVER['DOCUMENT_ROOT']."/../application/language/".$_SESSION["benimdilim"]."/route.php");
	?>
	<script type="text/javascript">
		<!--
		var route = new Array();
		route["orders_save"] = "<?php echo $a['orders_save']; ?>";
		route["orders_uploadfile"] = "<?php echo $a['orders_uploadfile']; ?>";
		route["orders_uploadfile2"] = "<?php echo $a['orders_uploadfile2']; ?>";
		// -->
	</script>
</head>
<body>
<input type="hidden" id="currentlanguage" value="<?php echo $_SESSION["benimdilim"] ?>" />
<div class="body">
		  <div role="main" class="main">
		  		<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="span12">
								<ul class="breadcrumb">
									<li><a href="http://www.galepress.com">Anasayfa</a><span class="divider">/</span></li>
									<li class="active">Paketler</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="span12">
								<h2>GalePress</h2>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<h3 class="short"><?php  echo dil_STATIK ?></h3>
					<p class="lead"><?php  echo dil_STATIKCUMLE ?></p>

					<div class="row">
						<div class="pricing-table">
							<div class="span3">
								<div class="plan">
									<h3><?php  echo dil_EKO ?><span>€1.290</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Statik-Ekonomik-Paket,PR-3.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
										<?php  echo dil_EKOLIST ?>
									</ul>
								</div>
							</div>
                            							<div class="span3">
								<div class="plan">
									<h3><?php  echo dil_STANDART ?><span>€1.990</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Statik-Standart-Paket,PR-4.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
										<?php  echo dil_STALIST ?>
									</ul>
								</div>
							</div>
							<div class="span3 center">
								<div class="plan most-popular">
									<div class="plan-ribbon-wrapper"><div class="plan-ribbon">Popüler</div></div>
									<h3><?php  echo dil_PRO ?><span>€2.490</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Statik-Pro-Paket,PR-5.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
										<?php  echo dil_PROLIST ?>
									</ul>
								</div>
							</div>

							<div class="span3">
								<div class="plan">
									<h3><?php  echo dil_LIMITSIZ ?><span>€3.990</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Statik-Limitsiz-Paket,PR-6.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
										<?php  echo dil_LIMITSIZLIST ?>
									</ul>
								</div>
							</div>
						</div>

					</div>
                    
					<h3 class="short"><?php  echo dil_INTERAKTIF ?></h3>
					<p class="lead"><?php  echo dil_INTERAKTIFCUMLE ?></p>

					<div class="row">

						<div class="pricing-table">
							<div class="span4">
								<div class="plan">
									<h3><span>€4.990</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Interaktif-Standart-Paket,PR-7.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
									
									</ul>
								</div>
							</div>
							<div class="span4">
								<div class="plan most-popular">
                                <div class="plan-ribbon-wrapper"><div class="plan-ribbon">Popular</div></div>
									<h3><?php  echo dil_PRO ?><span>€6.490</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Interaktif-Pro-Paket,PR-8.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
                                    	<?php  echo dil_PROLIST2 ?>
									</ul>
								</div>
							</div>
							<div class="span4">
								<div class="plan">
									<h3><?php  echo dil_LIMITSIZ ?><span>€9.990</span></h3>
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Interaktif-Limitsiz-Paket,PR-9.html"><?php  echo dil_SATISBUTON ?></a>
									<ul>
										<?php  echo dil_LIMITSIZLIST2 ?>
									</ul>
								</div>
							</div>
														
						</div>

					</div>
				
					
					<div class="row">

						<div class="pricing-table">
							<div class="span4">
							
							</div>
								<div class="span4">
								<div class="plan">
									<h3><?php  echo dil_KURUMSAL ?><span>€15.000</span></h3>
									
									<a class="btn btn-large btn-primary" href="http://shop.galepress.com/Interaktif-Kurumsal-Paket,PR-10.html"><?php  echo dil_SATISBUTON ?></a><br>
									<h5 style="float:left;"><?php  echo dil_GRAFIKHIZMET ?></h5>
									<h5 style="float:right;"><?php  echo dil_SERVISMODUL ?></h5>&nbsp;
									<ul>
										<?php  echo dil_LIMITSIZLIST2 ?>
									</ul>
								</div>
							</div>
							<div class="span4">
							
							</div>
							
						</div>
					</div>
				</div>
		</div>
	</div>

	<!-- Libs -->
	<script src="/website/vendor/jquery.easing.js"></script>
	<script src="/website/vendor/jquery.cookie.js"></script>
	<!-- <script src="master/style-switcher/style.switcher.js"></script> -->
	<script src="/website/vendor/bootstrap.js"></script>
	<script src="/website/vendor/selectnav.js"></script>
	<script src="/website/vendor/twitterjs/twitter.js"></script>
	<script src="/website/vendor/revolution-slider/js/jquery.themepunch.plugins.js"></script>
	<script src="/website/vendor/revolution-slider/js/jquery.themepunch.revolution.js"></script>
	<script src="/website/vendor/flexslider/jquery.flexslider.js"></script>
	<script src="/website/vendor/circle-flip-slideshow/js/jquery.flipshow.js"></script>
	<script src="/website/vendor/fancybox/jquery.fancybox.js"></script>
	<script src="/website/vendor/jquery.validate.js"></script>
	<script src="/website/js/plugins.js"></script>

	<!-- Current Page Scripts -->
	<script src="/website/js/views/view.home.js"></script>
	<script src="/website/js/views/view.contact.js"></script>

	<!-- Theme Initializer -->
	<script src="/website/js/theme.js"></script>

	<!-- Custom JS -->
	<script src="/website/js/custom.js"></script>
	<script src="/website/js/jquery.inputlimiter.1.3.1.min.js"></script>


</body>
</html>
