<?php
$title = Config::get('custom.companyname');

if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
{
	$customer = Auth::User()->Customer();

	$title = $customer->CustomerName;
}
?>
<!--<div class="page-navigation-panel logo"></div>-->
<div class="page-navigation-panel" style="background: url('/img/background/bt_cubs.png') left top repeat;background-color: rgba(29,29,29,1);">
	@if(Str::length($title) < 17)
		<div class="name">{{ __('common.dashboard_welcome') }}, {{ $title }}</div>
	@else
		<div class="name">{{ __('common.dashboard_welcome') }},<br /> {{ $title }}</div>
	@endif
	<div class="control"><a href="#" class="psn-control"><span class="icon-reorder" style="color:#1681bf;"></span></a></div>
</div>

<ul class="page-navigation bg-light">
	<li>
		<a href="{{URL::to(__('route.home'))}}"><span class="icon-home"></span>{{ __('common.home') }}</a>
	</li>
	@if((int)Auth::User()->UserTypeID == eUserTypes::Manager)
	<li>
		<a href="#"><span class="icon-sitemap"></span> {{ __('common.menu_caption') }}</a>
		<ul>
			{{ HTML::nav_link(__('route.customers'), __('common.menu_customers')) }}
			{{ HTML::nav_link(__('route.applications'), __('common.menu_applications')) }}
			{{ HTML::nav_link(__('route.contents'), __('common.menu_contents')) }}
			{{ HTML::nav_link(__('route.orders'), __('common.menu_orders')) }}
		</ul>
	</li>
	@elseif((int)Auth::User()->UserTypeID == eUserTypes::Customer)
	<li>
		<a href="#"><span class="icon-dropbox"></span>{{ __('common.menu_caption_applications') }}</a>
		<ul>
			<?php $currentDate = date("Y-m-d"); ?>
			@foreach(Auth::User()->Customer()->Applications(1) as $app)
			@if( $app->ExpirationDate < $currentDate )
			<li style="width:100%;">{{ HTML::link(__('route.contents').'?applicationID='.$app->ApplicationID, $app->Name, array('class' => 'expired-app')) }}</li>
			@else
			<li style="width:100%;">{{ HTML::link(__('route.contents').'?applicationID='.$app->ApplicationID, $app->Name) }}</li>
			@endif
			@endforeach
		</ul>                               
	</li>
	@endif
	<li>
		<a href="#"><span class="icon-file-text-alt"></span> {{ __('common.menu_caption_reports') }}</a>
		<ul>
			{{ HTML::nav_link(__('route.reports').'?r=101', __('common.menu_report_101')) }}
			{{ HTML::nav_link(__('route.reports').'?r=201', __('common.menu_report_201')) }}
			{{ HTML::nav_link(__('route.reports').'?r=301', __('common.menu_report_301')) }}
			{{ HTML::nav_link(__('route.reports').'?r=302', __('common.menu_report_302')) }}
			{{ HTML::nav_link(__('route.reports').'?r=1301', __('common.menu_report_1301')) }}
			{{ HTML::nav_link(__('route.reports').'?r=1302', __('common.menu_report_1302')) }}
			{{ HTML::nav_link(__('route.reports').'?r=1101', __('common.menu_report_1101')) }}
			{{ HTML::nav_link(__('route.reports').'?r=1201', __('common.menu_report_1201')) }}
		</ul>
	</li>                          
	<li>
		<a href="#"><span class="icon-cogs"></span> {{ __('common.menu_caption_preferences') }}</a>
		<ul>
			@if((int)Auth::User()->UserTypeID == eUserTypes::Manager)
			{{ HTML::nav_link(__('route.users'), __('common.menu_users')) }}
			@endif
			{{ HTML::nav_link(__('route.mydetail'), __('common.menu_mydetail')) }}
		</ul>
	</li>
</ul> 
