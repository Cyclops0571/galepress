		<footer>
			<div class="container">
				<div class="row" style="margin:0 auto;">
					<div class="footer-ribon">
						<span><?php echo dil_KOLAYULASIM?></span>
					</div>
					<div class="span3" >
						<div class="foot_line"><img src="/website/img/footer-line.png" /></div>
						<h4><?php echo dil_HABERDAR?></h4>
						<p><?php echo dil_HABERDAR_YAZI?></p>
						<div class="alert alert-success hidden" id="newsletterSuccess">
							<?php echo dil_EMAIL_BASARILI ?>
						</div>
						<div class="alert alert-error hidden" id="newsletterError"></div>
						<form class="form-inline" id="newsletterForm" action="/newsletter-subscribe" method="POST">
							<div class="control-group">
								<div class="input-append">
									<input class="span2" placeholder="&nbsp;<?php echo dil_EMAIL ?>" name="email" id="email" type="text">
									<button class="btn" type="submit"><?php echo dil_GIT ?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="span3" >    
						<div class="foot_line"><img src="/website/img/footer-line.png" /></div>                       
						<h4><?php echo dil_TWEET ?></h4>
						<div id="tweet" class="twitter" data-account-id="crivosthemes">
							<p><?php echo dil_YUKLENIYOR ?></p>
						</div>
					</div>
					<div class="span3">
						<div class="foot_line"><img src="/website/img/footer-line.png" /></div>
						<div class="contact-details">
							<h4><?php echo dil_ILETISIM ?></h4>
							<ul class="contact">
								<li><p><i class="icon-map-marker"></i> <strong><?php echo dil_ADRES ?></strong>&nbsp;<?php echo dil_DETAYADRES_IST ?> </p></li>
								<li><p><i class="icon-phone"></i> <strong><?php echo dil_TELEFON ?></strong> +90 (216) 443 13 29</p></li>
								<li><p><i class="icon-envelope"></i> <strong>Email:</strong> <a href="mailto:info@galepress.com">info@galepress.com</a></p></li>
							</ul>
						</div>
					</div>
					<div class="span2">
						<h4><?php echo dil_TAKIP ?></h4>
						<div class="social-icons">
							<ul class="social-icons">
								<li class="facebook"><a href="https://www.facebook.com/pages/Galepress/267455253374597?fref=ts" target="_blank" title="Facebook">Facebook</a></li>
								<li class="twitter"><a href="https://twitter.com/GalePress" target="_blank" title="Twitter">Twitter</a></li>
								<li class="linkedin"><a href="http://www.linkedin.com/profile/view?id=269652107&trk=tab_pro" target="_blank" title="Linkedin">Linkedin</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container">
					<div class="row">
						<div class="span1">
							<a href="index.html" class="logo">
								<img alt="Detaysoft" src="/website/img/logo-footer.png">
							</a>
						</div>
						<div class="span7">
							<p>© Copyright 2013 by Detaysoft. All Rights Reserved.</p>
						</div>
						<nav id="sub-menu">
							<ul>
								<li><a href="<?php echo getURL('sitemap.php'); ?>"><?php echo dil_SITEMAP ?></a></li>
								<li><a href="<?php echo getURL('iletisim.php'); ?>"><?php echo dil_ILETISIM ?></a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</footer>
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



	

	<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information. -->
	<!--
	<script>
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-XXXXX-X']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	-->
	<?php if($_SERVER["REQUEST_URI"] == '/tr/calisma-yapisi' || $_SERVER["REQUEST_URI"] == '/en/work-flow' || $_SERVER["REQUEST_URI"] == '/de/arbeitsweise') { ?>
	<script type="text/javascript">
		swfobject.registerObject("FLVPlayer");
	</script>
	<?php } ?>
	<?php if($_SERVER["REQUEST_URI"] == '/tr/' || $_SERVER["REQUEST_URI"] == '/en/' || $_SERVER["REQUEST_URI"] == '/de/') { ?>
	<script type="text/javascript">
		$(function(){
			$('.bubble').removeClass('hidden');
		});
		setTimeout(function(){$('.bubble').fadeOut();}, 4000);
	</script>
	<?php } ?>
	<?php include("website_analyticstracking.php"); ?>
</body>
</html>