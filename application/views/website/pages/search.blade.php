@layout('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a><span class="divider">/</span></li>
						<li class="active">GalePress</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2>{{__('website.search')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="search-results">
			<script>
			(function() {
				var cx = '003558081527571790912:iohyqlcsz2m';
				var gcse = document.createElement('script');
				gcse.type = 'text/javascript';
				gcse.async = true;
				gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
				'//www.google.com/cse/cse.js?cx=' + cx;
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(gcse, s);
			})();
			</script>
			<gcse:search></gcse:search>
		</div>
	</div>
</div>
	
@endsection