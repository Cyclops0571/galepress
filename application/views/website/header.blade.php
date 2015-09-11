<nav id="main-navigation" role="navigation" class="navbar navbar-fixed-top navbar-standard"><a href="javascript:void(0)" class="search_button"><i class="fa fa-search"></i></a>
    <form action="/{{ Session::get('language') }}" method="get" role="search" class="h_search_form" id="searchForm">
        <div class="container">
	    <div class="h_search_form_wrapper">
		<div class="input-group">
		    <span class="input-group-btn">
			<button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
		    </span>
		    <input type="text" class="form-control" name="q" id="q" placeholder="{{__('website.search')}}" style="color:#909090"></div>
		<div class="h_search_close"><a href="#"><i class="fa fa-times"></i></a></div>
	    </div>
        </div>
    </form>
    <div class="container">
        <div class="navbar-header">
	    <button type="button" class="navbar-toggle"><i class="fa fa-align-justify fa-lg"></i></button><a href="/{{ Session::get('language') }}" class="navbar-brand"><img src="/website/img/logo-white.png" alt="" class="logo-white"><img src="/website/img/logo-dark.png" alt="" class="logo-dark"></a>
        </div>
        <div class="navbar-collapse collapse">
	    <ul class="nav navbar-nav navbar-right service-nav">
		<li>
		    <a href="/{{ Session::get('language') }}/{{__('route.website_tryit')}}">{{__('website.menu_tryit')}}</a>
		</li>
		<li>
		    <a href="/{{ Session::get('language') }}/{{__('route.login')}}"><i class="fa fa-mobile fa-lg"></i>&nbsp;<span class="badge">{{__('website.menu_login')}}</span></a>
		</li>
		<li class="dropdown languageChange">
		    <a href="/tr" data-toggle="dropdown" data-hover="dropdown" id="menu_item_Portfolio" data-ref="#" class="dropdown-toggle">
			<img src="/website/img/flags/trFlag.png" /><span class="caret"></span>
		    </a>
		    <ul aria-labelledby="menu_item_Portfolio" class="dropdown-menu" style="min-width:52px !important;width:52px !important;">
			<li><a href="/en" data-ref="#"><img src="/website/img/flags/enFlag.png" class="noTouch"/></a></li>
			<li><a href="/de" data-ref="#"><img src="/website/img/flags/deFlag.png" class="noTouch" /></a></li>
		    </ul>
		</li>
	    </ul>
	    <button type="button" class="navbar-toggle"><i class="fa fa-close fa-lg"></i></button>
	    <ul class="nav yamm navbar-nav navbar-left main-nav">
		<li><a href="/{{ Session::get('language') }}/{{__('route.website_why_galepress')}}" title="{{__('website.menu_howitworks')}}" id="menu_item_Home" data-ref="#">{{__('website.menu_howitworks')}}</a></li>

		<li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors')}}" title="{{__('website.menu_solutions')}}" id="menu_item_Pages" data-ref="#">{{__('website.menu_solutions')}}</a></li>

		<li><a href="/{{ Session::get('language') }}/{{__('route.website_showcase')}}" title="{{__('website.menu_showcase')}}" id="menu_item_features-grid" data-ref="features-grid">{{__('website.menu_showcase')}}</a></li>

		<li><a href="/{{ Session::get('language') }}/{{__('route.website_contact')}}" title="{{__('website.contact')}}" id="menu_item_Contactus" data-ref="#">{{__('website.contact')}}</a></li>
		<li><a href="/{{__('route.website_blog')}}" title="Blog" id="menu_item_Blog" data-ref="#">{{__('website.block')}}</a></li>
	    </ul>
        </div>
    </div>
</nav>