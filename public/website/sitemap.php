<?php include('lib/header.php'); ?>
<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="<?php echo getURL('anasayfa.php'); ?>">Home</a> <span class="divider">/</span></li>
						<li class="active">Pages</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2><?php echo dil_SITEMAP ?></h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="span6">
				<ul class="sitemap list icons" style="list-style-type: none;">
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('anasayfa.php'); ?>"><?php echo dil_ANASAYFA ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('hakkimizda.php'); ?>"><?php echo dil_HAKKIMIZDA ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('nedir.php'); ?>"><?php echo dil_NEDIR ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('nesatar.php'); ?>"><?php echo dil_URUNLER ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('avantajlar.php'); ?>"><?php echo dil_AVANTAJLAR ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('musterilerimiz.php'); ?>"><?php echo dil_MUSTERILERIMIZ ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('calismayapisi.php'); ?>"><?php echo dil_CALISMAYAPISI ?></a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="<?php echo getURL('iletisim.php'); ?>"><?php echo dil_ILETISIM ?></a>
					</li>
				</ul>
			</div>
			<div class="span6 hidden-phone" >
				<h2><?php echo dil_WHO_US ?></h2>
				<p class="lead"><?php echo dil_WHO_US_YAZI ?></p>
				<ul class="list icons">
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR_YAZI2?></li>
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR1_SITEMAP ?> </li>
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR_YAZI3 ?></li>
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR_YAZI4?></li>
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR2_SITEMAP ?></li>
					<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_AVANTAJLAR3_SITEMAP ?></li>
				</ul>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>
<?php include('lib/footer.php'); ?>