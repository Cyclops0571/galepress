<header>
	<div class="container">
		<h1 class="logo"><a href="/{{ Session::get('language') }}/"><img alt="GalePress" src="/website/img/logo2.png"></a></h1>
		<div class="search">
			<form class="form-search" id="searchForm" action="/{{ Session::get('language') }}/{{ __('route.website_search') }}" method="get">
				<div class="control-group">
					<input type="text" class="input-medium search-query" name="q" id="q" placeholder="{{__('website.search')}}">
					<button class="search" type="submit"><i class="icon-search"></i></button>
				</div>
			</form>
		</div>
		<nav>
			<ul class="nav nav-pills nav-top">
				<li class="lang">
						<a href="/tr" class="buttonTR"></a>
						<a href="/en" class="buttonEng"></a>
						<a href="/de" class="buttonDe"></a>
				</li>
				<li class="adminPanel" title="{{__('website.cms2')}}" style="letter-spacing:1px;"><a href="/{{ Session::get('language') }}/{{__('route.login')}}"><i class="icon-user" ></i>{{__('website.cms2_abbr')}}</a>
				</li>
				<li>
					<div class="bubble hidden">
						<span style="position: relative; top: 18%; margin-left:-4px; line-height:25px; color:#FFF">{{__('website.cms2_desc')}}</span>
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
				<li class="dropdown <?php echo (URI::current() === '/' ? ' active' : ' ') ?>"> <a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a></li>
				<li class="<?php echo (URI::current() === __("route.website_aboutus")->get() ? ' active' : ' ') ?>"> <a href="/{{ Session::get('language') }}/{{__('route.website_aboutus')}}">{{__('website.page_aboutus')}}</a></li>
				<li class="dropdown <?php echo (URI::current() === __("route.website_galepress")->get() || URI::current() === __("route.website_products")->get() || URI::current() === __("route.website_advantages")->get() ? ' active' : ' ') ?>"> <a class="dropdown-toggle" href="#"> GalePress<i class="icon-angle-down"></i></a>
					<ul class="dropdown-menu">
						<li class="<?php echo (URI::current() === __("route.website_galepress")->get() ? ' active' : ' ') ?>" <?php echo (URI::current() === __("route.website_galepress")->get() ? ' style="background:#00b4ff"' : ' ') ?>><a href="/{{ Session::get('language') }}/{{__('route.website_galepress')}}">{{__('website.page_galepress')}}</a></li>
						<li class="<?php echo (URI::current() === __("route.website_products")->get() ? ' active' : ' ') ?>" <?php echo (URI::current() === __("route.website_products")->get() ? ' style="background:#00b4ff"' : ' ') ?>><a href="/{{ Session::get('language') }}/{{__('route.website_products')}}">{{__('website.page_products')}}</a></li>
						<li class="<?php echo (URI::current() === __("route.website_advantages")->get() ? ' active' : ' ') ?>" <?php echo (URI::current() === __("route.website_advantages")->get() ? ' style="background:#00b4ff"' : ' ') ?>><a href="/{{ Session::get('language') }}/{{__('route.website_advantages')}}">{{__('website.page_advantages')}}</a></li>
					</ul>
				</li>
				<li class="<?php echo (URI::current() === __("route.website_customers")->get() ? ' active' : ' ') ?>"><a href="/{{ Session::get('language') }}/{{__('route.website_customers')}}">{{__('website.page_customers')}}</a></li>
				<li class="<?php echo (URI::current() === __("route.website_tutorials")->get() ? ' active' : ' ') ?>"><a href="/{{ Session::get('language') }}/{{__('route.website_tutorials')}}">{{__('website.page_tutorials')}}</a></li>
				<li class="<?php echo (URI::current() === __("route.website_contact")->get() ? ' active' : ' ') ?>"><a href="/{{ Session::get('language') }}/{{__('route.website_contact')}}">{{__('website.page_contact')}}</a></li>
			</ul>
		</nav>
	</div>
</header>