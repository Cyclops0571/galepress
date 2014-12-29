@layout('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
						<li class="active">{{__('website.page_contact')}}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2>{{__('website.page_contact_upper')}}</h2>
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
					{{__('website.contact_email_success')}}
				</div>
				<div class="alert alert-error hidden" id="contactError">
					{{__('website.contact_email_error')}}
				</div>
				<h2 class="short"><strong>{{__('website.page_contact')}}</strong></h2>
				<form action="" id="contactForm" type="post">
					<div class="row controls">
						<div class="span3 control-group">
							<label>{{__('website.contact_name')}}</label>
							<input type="text" value="" maxlength="100" class="span3" name="name" id="name">
						</div>
						<div class="span3 control-group">
							<label>E-Mail *</label>
							<input type="email" value="" maxlength="100" class="span3" name="email" id="email">
						</div>
					</div>
					<div class="row controls">
						<div class="span6 control-group">
							<label>{{__('website.contact_subject')}}</label>
							<input type="text" value="" maxlength="100" class="span6" name="subject" id="subject">
						</div>
					</div>
					<div class="row controls">
						<div class="span6 control-group">
							<label>{{__('website.contact_message')}}</label>
							<textarea maxlength="5000" rows="10" class="span6" name="message" id="message"></textarea>
						</div>
					</div>
					<div class="btn-toolbar" style="float:right;">
						<input type="submit" value="{{__('website.contact_send')}}" class="btn btn-primary btn-large" data-loading-text="{{__('website.contact_loading')}}">
					</div>
				</form>
			</div>
			<div class="span6">
				<h4 class="pull-top">Detaysoft<strong></strong></h4>
				<p>Detay Danışmanlık Bilgisayar Hizmetleri Sanayi ve Dış Ticaret A.Ş.</p>
				<hr />
				<h4><strong>{{__('website.contact_centraloffice')}}</strong></h4>
				<ul class="unstyled">
					<li><i class="icon-map-marker"></i> <strong>{{__('website.address')}}</strong> {{__('website.address_istanbul')}}</li>
					<li><i class="icon-phone"></i> <strong>{{__('website.phone')}}</strong> +90 (216) 443 13 29</li>
					<li><i class="icon-envelope"></i> <strong>E-Mail </strong> <a href="mailto:info@galepress.com">info@galepress.com</a></li>
				</ul>
				<hr />
				<h4>{{__('website.contact_workinghours')}}</h4>
				<ul class="unstyled">
					{{__('website.contact_workinghours_detail')}}
				</ul>
			</div>
		</div>
	</div>
</div>
	
@endsection