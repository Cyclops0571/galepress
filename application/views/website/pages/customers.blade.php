@layout('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
						<li class="active">{{__('website.page_customers')}}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2 style="text-transform:uppercase;">{{__('website.references')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/oguz-metal/id602583856?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-7.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/keas/id665855119?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-4.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/gazetem/id602205559?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-3.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/app/detaysoft/id655469976?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-2.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/bigblue/id632025251?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-1.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/zen-diamond/id640445738?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-5.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="musterilerimiz.php" class="thumb-info">
							<img src="/website/img/logo-client-8.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/tgsd/id632004216?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-6.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/us/app/asemble/id724557489?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-9.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/us/app/buyuk-kulup-dergisi/id765356919?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-10.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/us/app/enerjisa/id786330938?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-11.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/inciler-grup/id768097839?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-12.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/dijital-kutuphane/id815592407?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-13.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/cl/app/mpark-dergisi/id768152508?l=en&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-14.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="#" class="thumb-info">
							<img src="/website/img/logo-client-15_.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="#" class="thumb-info">
							<img src="/website/img/logo-client-16.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="#" class="thumb-info">
							<img src="/website/img/logo-client-17.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="#" class="thumb-info">
							<img src="/website/img/logo-client-18.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
			</ul>
		</div>
		<div class="row">
			<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/oguz-metal/id602583856?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-19.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/keas/id665855119?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-20.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/gazetem/id602205559?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-21.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/app/detaysoft/id655469976?mt=8" class="thumb-info">
							<img src="/website/img/logo-client-22.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/bigblue/id632025251?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-23.jpg" width="208" height="64" style="padding-left:52px;"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="https://itunes.apple.com/tr/app/zen-diamond/id640445738?l=tr&mt=8" class="thumb-info">
							<img src="/website/img/logo-client-24.jpg" width="208" height="64"> 
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
				<li class="span2 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<a href="musterilerimiz.php" class="thumb-info">
							<img src="/website/img/logo-client-25.jpg" width="208" height="64">
							<span class="thumb-info-action">
							</span>
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
	
@endsection