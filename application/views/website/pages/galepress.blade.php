@layout('website.html')

@section('body-content')

<div role="main" class="main">
		  	<section class="page-top">
				<div class="container">
					<div class="row">
						<div class="span12">
							<ul class="breadcrumb">
								<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
								<li class="active">GalePress</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="span12">
							<h2>{{__('website.whatis')}}</h2>
						</div>
					</div>
				</div>
			</section>
			<div class="container">
				<div class="row">
					<div class="span6" style="text-align:center;">
						<img src="/website/img/nedir/01.png" width="70%">
					</div>
					<div class="span6" style="margin-top:150px;">
						<h3>{{__('website.whatis')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc1')}}</p>
					</div>
				</div>
				<div class="row">
					<div class="span6" style="margin-top:150px;">
						<h3>{{__('website.whatis_technology')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc2')}}</p>
					</div>
					<div class="span6" style="text-align:center;">
						<img src="/website/img/nedir/08.png" style="margin-top:100px;">
					</div>
				</div>
				<div class="row" style="height:100px;"></div>
				<div class="row">
					<div class="span6" style="text-align:center;">
						<img src="/website/img/nedir/03.png" width="70%">
					</div>
					<div class="span6" style="margin-top:150px;">
						<h3>{{__('website.whatis_sharedoc')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc3')}}</p>
					</div>
				</div>
				<div class="row">
					<div class="span6" style="margin-top:150px;">
						<h3>{{__('website.whatis_logo')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc4')}}</p>
					</div>
					<div class="span6" style="text-align:center;">
						<img src="/website/img/nedir/06.png" width="70%">
					</div>
				</div>
				<div class="row">
					<div class="span6">
						<img src="/website/img/nedir/07.png" style="margin-left:-15px;">
					</div>
					<div class="span6" style="margin-top:150px;">
						<h3>{{__('website.whatis_cms')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc5')}}</p>
					</div>
				</div>
				<div class="row">
					<div class="span6" style="margin-top:150px;">
						<h3 style="line-height:30px;">{{__('website.advantages_desc4')}}</h3>
						<p style="font-size:19px; line-height:29px;">{{__('website.whatis_desc6')}}</p>
					</div>
					<div class="span6" style="text-align:center;">
						<img src="/website/img/nedir/05.png" width="70%">
					</div>
				</div>
			</div>					
		</div>	
	
@endsection