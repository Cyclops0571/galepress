<footer>
	<div class="container">
		<div class="row" style="margin:0 auto;">
			<div class="footer-ribon">
				<span>{{__('website.easy_touch')}}</span>
			</div>
			<div class="span3" >
				<div class="foot_line"><img src="/website/img/footer-line.png" /></div>
				<h4>{{__('website.get_in_touch')}}</h4>
				<p>{{__('website.get_in_touch_desc')}}</p>
				<div class="alert alert-success hidden" id="newsletterSuccess">
					{{__('website.newsletter_success')}}
				</div>
				<div class="alert alert-error hidden" id="newsletterError"></div>
				<form class="form-inline" id="newsletterForm" action="/website/php/newsletter-subscribe.php" method="POST">
					<div class="control-group">
						<div class="input-append">
							<input class="span2" placeholder="&nbsp;{{__('website.newsletter_email')}}" name="email" id="email" type="text">
							<button class="btn" type="submit">{{__('website.newsletter_subscription')}}</button>
						</div>
					</div>
				</form>
			</div>
			<div class="span3" >    
				<div class="foot_line"><img src="/website/img/footer-line.png" /></div>                       
				<h4>{{__('website.latest_sharings')}}</h4>
				<div id="tweet" class="twitter" data-account-id="crivosthemes">
					<p>{{__('website.please_wait')}}</p>
				</div>
			</div>
			<div class="span3">
				<div class="foot_line"><img src="/website/img/footer-line.png" /></div>
				<div class="contact-details">
					<h4>{{__('website.contact')}}</h4>
					<ul class="contact">
						<li><p><i class="icon-map-marker"></i> <strong>{{__('website.address')}}</strong>&nbsp;{{__('website.address_istanbul')}}</p></li>
						<li><p><i class="icon-phone"></i> <strong>{{__('website.phone')}}</strong> +90 (216) 443 13 29</p></li>
						<li><p><i class="icon-envelope"></i> <strong>Email:</strong> <a href="mailto:info@galepress.com">info@galepress.com</a></p></li>
					</ul>
				</div>
			</div>
			<div class="span2">
				<h4>{{__('website.stay_with_us')}}</h4>
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
					<a href="/" class="logo">
						<img alt="Detaysoft" src="/website/img/logo-footer.png">
					</a>
				</div>
				<div class="span7">
					<p>{{__('website.copyright')}}</p>
				</div>
				<nav id="sub-menu">
					<ul>
						<li><a href="/{{ Session::get('language') }}/{{ __('route.website_sitemap') }}">{{__('website.sitemap')}}</a></li>
						<li><a href="/{{ Session::get('language') }}/{{ __('route.website_contact') }}">{{__('website.contact')}}</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</footer>