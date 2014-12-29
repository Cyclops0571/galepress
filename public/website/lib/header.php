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
	<style>
		.bubble {
			background-color: #000;
			border-radius: 5px;
			border:1px solid #fff;
			box-shadow: 0 0 6px #ccc;
			display: inline-block;
			padding: 7px 0px;
			position: relative;
			vertical-align:middle;
			text-align:center;
			float: left;   
			margin: 32px 0 -225px -255px;
			opacity:0.8;
			z-index:999;
			width:238px;
			height:auto;
			font-size:18px;
			filter:alpha(opacity=80); /* For IE8 and earlier */
		}

		.bubble::before {
			background-color: #000;
			opacity:0.85;
			filter:alpha(opacity=85); /* For IE8 and earlier */
			content: "\00a0";
			display: block;
			position: absolute;
			top: -2.5px;
			transform:             rotate( 120deg ) skew( -35deg );
			-moz-transform:    rotate( 120deg ) skew( -35deg );
			-ms-transform:     rotate( 120deg ) skew( -35deg );
			-o-transform:      rotate( 120deg ) skew( -35deg );
			-webkit-transform: rotate( 120deg ) skew( -35deg );
			width:  20px;
			height: 10px;
			box-shadow: -2px 2px 2px 0 rgba( 178, 178, 178, .4 );
			left: 205px;  
			z-index:-1;
		}
	</style>
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
	<header>
		<div class="container">
			<h1 class="logo"><a href="<?php echo getURL('anasayfa.php'); ?>"><img alt="GalePress" src="/website/img/logo2.png"></a></h1>
			<div class="search">
				<form class="form-search" id="searchForm" action="arama.php" method="get">
					<div class="control-group">
						<input type="text" class="input-medium search-query" name="q" id="q" placeholder="<?php echo dil_ARAMA?>">
						<button class="search" type="submit"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>
			<nav>
				<ul class="nav nav-pills nav-top">
					<li class="lang" style="list-style:none;">
						<div style="margin-top:6px; float:left; width:85px; height:12px;">
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
								<input type="submit" style="width:20px; height:20px;" class="buttonTR" value="         " name="submit_tr"/>
								&nbsp;
								<input type="submit" style="width:20px; height:20px;" class="buttonEng" value="         " name="submit_eng"/>
								&nbsp;
								<input type="submit" style="width:20px; height:20px;" class="buttonDe" value="         " name="submit_de"/>
							</form>
						</div>
					</li>
					<li class="adminPanel" title="<?php echo dil_DYSBASLIK ?>" style="letter-spacing:1px;"><a href="<?php echo dil_GALELOGIN ?>"><i class="icon-user" ></i><?php echo dil_DYS?></a>
					</li>
					<li>
						<div class="bubble hidden">
							<span style="position: relative; top: 18%; margin-left:-4px; line-height:25px; color:#FFF"><?php echo dil_DYSTITLE ?></span>
						</div>
					</li>
					<li class="phone"> <span><i class="icon-phone"></i>+90 (216) 443 13 29</span></li>
				</ul>
			</nav>
			<div class="social-icons">
				<ul class="social-icons">
					<li class="facebook"><a href="https://www.facebook.com/pages/Galepress/267455253374597?fref=ts" target="_blank" title="Facebook">Facebook</a></li>
					<li class="twitter"><a href="https://twitter.com/GalePress" target="_blank" title="Twitter">Twitter</a></li>
					<li class="linkedin"><a href="http://www.linkedin.com/profile/view?id=269652107&trk=tab_pro" target="_blank" title="Linkedin">Linkedin</a></li>
				</ul>
			</div>
			<nav>
				<ul class="nav nav-pills nav-main" id="mainMenu">
					<li class="dropdown <?php echo ($activePage==1 ? ' active' : ' ') ?>"> <a href="<?php echo getURL('anasayfa.php'); ?>"><?php echo dil_ANASAYFA ?></a></li>
					<li class="<?php echo ($activePage==2 ? ' active' : ' ') ?>"> <a href="<?php echo getURL('hakkimizda.php'); ?>"><?php echo dil_HAKKIMIZDA ?></a></li>
					<li class="dropdown <?php echo ($activePage==3 ? ' active' : ' ') ?>"> <a class="dropdown-toggle" href="#"> GalePress<i class="icon-angle-down"></i></a>
						<ul class="dropdown-menu">
							<li class="<?php echo ($activePage==31 ? ' active' : ' ') ?>" <?php echo ($activePage==31 ? ' style="background:#00b4ff"' : ' ') ?>><a href="<?php echo getURL('nedir.php'); ?>"><?php echo dil_NEDIR ?></a></li>
							<li class="<?php echo ($activePage==32 ? ' active' : ' ') ?>" <?php echo ($activePage==32 ? ' style="background:#00b4ff"' : ' ') ?>><a href="<?php echo getURL('nesatar.php'); ?>"><?php echo dil_URUNLER ?></a></li>
							<li class="<?php echo ($activePage==33 ? ' active' : ' ') ?>" <?php echo ($activePage==33 ? ' style="background:#00b4ff"' : ' ') ?>><a href="<?php echo getURL('avantajlar.php'); ?>"><?php echo dil_AVANTAJLAR ?></a></li>
						</ul>
					</li>
					<li class="<?php echo ($activePage==4 ? ' active' : ' ') ?>"><a href="<?php echo getURL('musterilerimiz.php'); ?>"><?php echo dil_MUSTERILERIMIZ ?></a></li>
					<li class="<?php echo ($activePage==5 ? ' active' : ' ') ?>"><a href="<?php echo getURL('calismayapisi.php'); ?>"><?php echo dil_CALISMAYAPISI ?></a></li>
					<li class="<?php echo ($activePage==6 ? ' active' : ' ') ?>"><a href="<?php echo getURL('iletisim.php'); ?>"><?php echo dil_ILETISIM ?></a></li>
				</ul>
			</nav>
		</div>
	</header>
