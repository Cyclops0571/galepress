@layout('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
						<li class="active">{{__('website.page_aboutus')}}</li>
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
		<h2>{{__('website.aboutus_desc')}}</h2>
		<div class="row">
			<div class="span10">
				<p class="lead">
					{{__('website.aboutus_desc_detail')}}
				</p>
			</div>
		</div>
		<hr class="tall">
		<div class="row">
			<div class="span8">
				<h3>{{__('website.aboutus_milestone')}}</h3>
				<p>
					<ul>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone1')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone2')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone3')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone4')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone5')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone6')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone7')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone8')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone9')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone10')}}</li>
						<li style="list-style-image:url('/website/img/aa.png');">{{__('website.aboutus_milestone11')}}</li>
					</ul>
				</p>
			</div>
		</div>
		<hr class="tall">
		<div class="row">
			<div class="span12">
				<h3 class="pull-top">{{__('website.aboutus_locations')}}</h3>
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
								<h4><strong>{{__('website.aboutus_loc_istanbul')}}</strong></h4><br />
								<p>{{__('website.aboutus_loc_istanbul_adress')}}{{__('website.phone')}} +90 (216) 443 13 29 {{__('website.fax')}} +90 (216) 443 08 27</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-2.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong>{{__('website.aboutus_loc_sivas')}}</strong></h4><br />
								<p>{{__('website.aboutus_loc_sivas_adress')}}{{__('website.phone')}} +90 (346) 217 11 21 {{__('website.fax')}} +90 (346) 217 11 21</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-3.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong>{{__('website.aboutus_loc_dubai')}}</strong></h4><br />
								<p>Dubai Silicon Oasis Authority C:101 Pobox:341035 Dubai / UAE<br />{{__('website.phone')}} +971 (04) 501 57 95 {{__('website.fax')}} +971 (04) 501 57 96</p>
							</div>
						</div>
					</li>
					<li>
						<div class="thumb">
							<img src="/website/img/office-4.jpg" alt="" />
						</div>
						<div class="featured-box">
							<div class="box-content">
								<h4><strong>{{__('website.aboutus_loc_elazig')}}</strong></h4><br />
								<p>Elazığ Teknokent</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
	
@endsection