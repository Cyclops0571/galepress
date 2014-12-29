<?php include('lib/header.php'); ?>
<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="<?php echo getURL('anasayfa.php'); ?>"><?php echo dil_ANASAYFA ?></a> <span class="divider">/</span></li>
						<li class="active"><?php echo dil_ILETISIM ?></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2><?php echo dil_ILETISIM_BUYUK ?></h2>
				</div>
			</div>
		</div>
	</section>
	<!-- Google Maps -->
	<div id="googlemaps" class="google-map hidden-phone">
		<iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?sll=41.02412729999838,29.082303075601857&amp;sspn=0.011445367295009806,0.027466615125843856&amp;t=m&amp;q=Detaysoft,+Alemda%C4%9F+Cd,+%C3%9Csk%C3%BCdar,+T%C3%BCrkiye&amp;dg=opt&amp;ie=UTF8&amp;hq=Detaysoft,&amp;hnear=Alemda%C4%9F+Cd,+%C3%9Csk%C3%BCdar,+T%C3%BCrkiye&amp;ll=41.028737,29.090552&amp;spn=0.011331,0.051455&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe><br />
	</div>
	<div class="container">
		<div class="row">
			<div class="span6">
				<div class="alert alert-success hidden" id="contactSuccess">
					<?php echo dil_EMAILBASARI ?>
				</div>
				<div class="alert alert-error hidden" id="contactError">
					<?php echo dil_EMAILHATA ?>
				</div>
				<h2 class="short"><strong><?php echo dil_ILETISIM ?></strong></h2>
				<form action="" id="contactForm" type="post">
					<div class="row controls">
						<div class="span3 control-group">
							<label><?php echo dil_ADSOYAD ?></label>
							<input type="text" value="" maxlength="100" class="span3" name="name" id="name">
						</div>
						<div class="span3 control-group">
							<label>E-Mail *</label>
							<input type="email" value="" maxlength="100" class="span3" name="email" id="email">
						</div>
					</div>
					<div class="row controls">
						<div class="span6 control-group">
							<label><?php echo dil_KONU ?></label>
							<input type="text" value="" maxlength="100" class="span6" name="subject" id="subject">
						</div>
					</div>
					<div class="row controls">
						<div class="span6 control-group">
							<label><?php echo dil_MESAJ ?></label>
							<textarea maxlength="5000" rows="10" class="span6" name="message" id="message"></textarea>
						</div>
					</div>
					<div class="btn-toolbar" style="float:right;">
						<input type="submit" value="<?php echo dil_GONDER ?>" class="btn btn-primary btn-large" data-loading-text="Loading...">
					</div>
				</form>
			</div>
			<div class="span6">
				<h4 class="pull-top">Detaysoft<strong></strong></h4>
				<p>Detay Danışmanlık Bilgisayar Hizmetleri Sanayi ve Dış Ticaret A.Ş.</p>
				<hr />
				<h4><strong><?php echo dil_MERKEZOFIS ?></strong></h4>
				<ul class="unstyled">
					<li><i class="icon-map-marker"></i> <strong><?php echo dil_ADRES ?></strong> <?php echo dil_DETAYADRES_IST ?></li>
					<li><i class="icon-phone"></i> <strong><?php echo dil_TELEFON ?></strong> +90 (216) 443 13 29</li>
					<li><i class="icon-envelope"></i> <strong>E-Mail </strong> <a href="mailto:info@galepress.com">info@galepress.com</a></li>
				</ul>
				<hr />
				<h4><?php echo dil_CALISMASAAT?></h4>
				<ul class="unstyled">
					<?php echo dil_CALISMASAAT_YAZI ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php include('lib/footer.php'); ?>