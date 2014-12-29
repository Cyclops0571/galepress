<?php include('lib/header.php'); ?>
<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="<?php echo getURL('anasayfa.php'); ?>"><?php echo dil_ANASAYFA ?></a> <span class="divider">/</span></li>
						<li class="active"><?php echo dil_HAKKIMIZDA ?></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2>Detaysoft</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<h2><?php echo dil_TANIM ?></h2>
		<div class="row">
			<div class="span10">
				<p class="lead">
					<?php echo dil_TANIMDETAY_YAZI ?>
				</p>
			</div>
		</div>
		<hr class="tall">
		<div class="row">
			<div class="span8">
				<h3><?php echo dil_KM ?></h3>
				<p>
					<ul>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI1 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI2 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI3 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI4 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI5 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI6 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI7 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI8 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI9 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI10 ?></li>
						<li style="list-style-image:url('/website/img/aa.png');"><?php echo dil_KM_YAZI11 ?></li>
					</ul>
				</p>
			</div>
		</div>
		<hr class="tall">
		<div class="row">
			<div class="span12">
				<h3 class="pull-top"><?php echo dil_LOKASYONLAR ?></h3>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<ul class="timeline">
					<li>
						<div class="thumb">
							<img src="/website/img/office-1.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong><?php echo dil_LOK_ISTANBUL ?></strong></h4><br />
								<p><?php echo dil_DETAYADRES_IST ?><?php echo dil_TELEFON ?> +90 (216) 443 13 29 <?php echo dil_FAKS ?> +90 (216) 443 08 27</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-2.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong><?php echo dil_LOK_SIVAS ?></strong></h4><br />
								<p><?php echo dil_DETAYADRES_SIV ?><?php echo dil_TELEFON ?> +90 (346) 217 11 21 <?php echo dil_FAKS ?> +90 (346) 217 11 21</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-3.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong><?php echo dil_LOK_DUBAI ?></strong></h4><br />
								<p>Dubai Silicon Oasis Authority C:101 Pobox:341035 Dubai / UAE<br /><?php echo dil_TELEFON ?> +971 (04) 501 57 95 <?php echo dil_FAKS ?> +971 (04) 501 57 96</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-4.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong><?php echo dil_LOK_ELAZIG ?></strong></h4><br />
								<p>Elazığ Teknokent</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php include('lib/footer.php'); ?>