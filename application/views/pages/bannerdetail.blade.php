@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
	$banner = new Banner();
	$bannerSet = new Banner();
	$application = new Application();
}
$ApplicationID = $application->ApplicationID;
$defaultSliderImage = '/img/bannerSlider/defaultPreview.jpg';
if ($banner) {
	$bannerID = $banner->BannerID;
	$orderNo = $banner->OrderNo;
	$ImagePublicPath = $banner->getImagePath($application);
	$ImageLocalPath = $banner->ImageLocalPath;
	$TargetUrl = $banner->TargetUrl;
	$TargetContent = $banner->TargetContent;
	$Description = $banner->Description;
	$Autoplay = $banner->Autoplay;
	$IntervalTime = $banner->IntervalTime;
	$TransitionRate = $banner->TransitionRate;
	$Status = $banner->Status;
} else {
	$bannerID = 0;
	$orderNo = 0;
	$ImagePublicPath = '/img/bannerSlider/defaultPreview.jpg';
	$ImageLocalPath = '';
	$TargetUrl = '';
	$TargetContent = '';
	$Description = '';
	$Autoplay = 1;
	$IntervalTime = 5;
	$TransitionRate = 20;
	$Status = 1;
}
?>
<!--BANNER SLIDER-->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" href="/css/masterslider/style/masterslider.css" />
<link href="/css/masterslider/skins/black-2/style.css" rel='stylesheet' type='text/css'>
<link href='/css/masterslider/style/ms-gallery-style.css' rel='stylesheet' type='text/css'>

<script src="/js/masterslider/jquery.easing.min.js"></script>
<script src="/js/masterslider/masterslider.min.js"></script>
<!--BANNER SLIDER-->
<style type="text/css">
	.templateScreen .text-center.app-name{
		font-size:1em !important;
		height:15px !important;
		line-height:15px !important;
	}
	.templateScreen .header .header-categories {
		background-size: 35% auto !important;
		height: 12px !important;
		cursor: default !important;
	}
	.templateScreen .header,.footer,.footer div{
		height: 22px !important;
		background-position: top center !important;
		cursor: default !important;
	}
	.checkbox-inline{
		padding-left: 0 !important;
	}
	.urlCheck:hover{
		background-color: #59AD2F !important;
		color: white !important;
		border: 1px solid #141414 !important;
	}
	.urlCheck:focus,.urlCheck:active{
		background-color: #2e2e2e !important;
		border-color: none !important;
	}
	.urlCheck{
		background-image: none !important;
	}
	.container .form-row [class*="col-"], [class*="col-"] img{
		cursor: default !important;
	}
	#ms-gallery-1{
		margin:0 auto;
	}
	.ms-gallery-template .ms-gallery-botcont{
		position: absolute !important;
		bottom:0 !important;
		width: 100% !important;
		opacity: 0.7;
	}
	.ms-bullets.ms-dir-h,.ms-bullets.ms-dir-h .ms-bullets-count {
		right: 3% !important;
	}
	.ms-gallery-template .ms-gallery-botcont{
		height: 18px !important;
	}
	.ms-gallery-template .ms-bullet{
		width: 3px !important;
		height: 3px !important;
		margin: 2px !important;
	}
	.ms-gallery-template .ms-bullets.ms-dir-h{
		bottom: 5px !important;
	}
	.ms-gallery-template .ms-gal-playbtn{
		display: none !important;
	}
	.ms-gallery-template .ms-gal-thumbtoggle{
		display: none !important;
	}
	.ms-gallery-template .ms-slide-info {
		padding: 2px 3px !important;
		font-size: 0.3em !important;
	}
	.ms-timerbar{
		display: none !important;
	}
</style>

{{ Form::open(__('route.banners_detail'), 'POST') }}
{{ Form::token() }}
<input type="hidden" name="primaryKeyID" id="primaryKeyID" value="<?php echo $bannerID; ?>" />
@if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
<input type="hidden" name="applicationID" id="ApplicationID" value="<?php echo $ApplicationID; ?>" />
@endif

<div class="col-md-9">
	<div class="block bg-light-ltr">

		<div class="header">
			<h2 style="text-transform:uppercase;">{{ __('common.banner_form_name') }}</h2>
		</div>
		<div class="content controls" style="overflow:visible">
			<?php /* 
			 <div class="form-row">
				<div class="col-md-3">{{ __('common.banners_select_content') }}</div>
				<div class="col-md-8">
					<select class="form-control select2" id="TargetContent" name="TargetContent">
						<option value=""{{ ($TargetContent == 0 ? ' selected="selected"' : '') }}>{{ __('common.banners_select_content') }}</option>
						<?php foreach ($contents as $content): ?>
							<option value="{{ $content->ContentID }}"{{ ($TargetContent == (int)$content->ContentID ? ' selected="selected"' : '') }}>{{ $content->Name }}</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_content') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			*/
			?>
			
			<div class="form-row">
				<div class="col-md-3">{{__('common.banner_form_target_url')}}</div>
				<div class="col-md-8">
					<div class="input-group file">                                    
						<input type="text" id="TargetUrl" class="form-control" name='TargetUrl' value="<?php echo $TargetUrl; ?>" placeholder="<?php echo "galepress.com"; ?>" style="height:35px;"/>
						<span class="input-group-btn">
							<button class="btn btn-primary urlCheck" type="button" id="checkUrl" onclick="cBanner.checkUrl();"><span class="icon-ok"></span></button>
						</span>
					</div>
					<span class="error urlError hide" style="color:red;">{{__('interactivity.link_error')}}</span>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_address') }}"><span class="icon-info-sign"></span></a></div>
			</div> 
			<div class="form-row">
				<div class="col-md-3">{{__('common.map_form_desc')}}</div>
				<div class="col-md-8">
					<input type="text" id="Description" name='Description' value="<?php echo $Description; ?>" />
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_desc') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline">
						<div class="checker">
							<span>
								<input name="Autoplay" type="checkbox" value="1" <?php echo $Autoplay ? 'checked="checked"' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_autoplay') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay_interval')}}</div>
				<div class="col-md-8">
					<input type="text" name="IntervalTime" value="<?php echo $IntervalTime ?>"/>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_interval') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay_speed')}}</div>
				<div class="col-md-8">
					<input type="text" name="TransitionRate"  value="<?php echo $TransitionRate; ?>"/>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_speed') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.contents_status')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline">
						<div class="checker">
							<span>
								<input name="Status" type="checkbox" value="1" <?php echo $Status ? 'checked="checked"' : "" ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_image')}}</div>
				<div class="col-md-8" style="position:relative;">
					<div class="col-md-6" style="width:46%; padding:0; margin-left:-9px;">
						<div data-device="ipad" data-orientation="portrait" data-color="white" class="device-mockup">
							<div class="device">
								<div class="screen">
									<div class="templateScreen">
										<div class="header clearfix">
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
												<div class="header-categories"></div>
											</div>
											<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
										</div>
										<div class="container">
											<div class="form-row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="ms-gallery-template" id="ms-gallery-1">
														<!-- masterslider -->
														<div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
															<?php foreach ($bannerSet as $savedBanner): ?>
																<div class="ms-slide" data-delay="{{$IntervalTime}}">
																	<?php $imgPath = $savedBanner->getImagePath($application); ?>
																	<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" /> 
																	<div class="ms-info">{{$savedBanner->Description}}</div>
																</div>
															<?php endforeach; ?>
															<?php if (empty($bannerSet)): ?>
																<?php for ($i = 0; $i < 4; $i++): ?>
																	<div class="ms-slide" data-delay="{{$IntervalTime}}">
																		<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}"/> 
																		<div class="ms-info">LOREM IPSUM DOLOR SIT AMET</div>
																	</div>
																<?php endfor; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row">
												<?php for ($i = 0; $i < 9; $i++): ?>
													<?php
													$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
													$name = "";
													$detail = "";
													if (isset($templateResults[$i])) {
														$imageSrcTmp = $templateResults[$i]->FilePath . '/' . $templateResults[$i]->FileName;
														if (is_file(path("public") . $imageSrcTmp)) {
															$imageSrc = "/" . $imageSrcTmp;
														}
														$name = $templateResults[$i]->Name;
														$detail = $templateResults[$i]->Detail;
														$Sayi = $templateResults[$i]->MonthlyName;
													}
													if ($i == 0 || $i == 3 || $i == 6) {
														echo "<div class=form-row>";
													}
													?>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
														<img src="{{$imageSrc}}" width="95%">
														<div class="content-bar noTouch">
															<div class="col-md-12">{{$detail}}</div>
															<div class="col-md-12">{{$name}}</div>
															<div class="col-md-12">{{$Sayi}}</div>
														</div>
													</div>
													<?php
													if ($i == 2 || $i == 5 || $i == 8) {
														echo "</div>";
													}
													?>
												<?php endfor; ?>
											</div>
										</div>
										<div class="footer text-center">
											<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6" style="position:absolute;bottom:0;right:0;padding:0;width:56%;">
						<div data-device="ipad" data-orientation="landscape" data-color="white" class="device-mockup">
							<div class="device">
								<div class="screen">
									<div class="templateScreen">
										<div class="header clearfix" style="height:21px !important;">
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
												<div class="header-categories"></div>
											</div>
											<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
										</div>
										<div class="container">
											<div class="form-row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="ms-gallery-template" id="ms-gallery-2">
														<!-- masterslider -->
														<div class="master-slider ms-skin-black-2 round-skin" id="masterslider2">
															<?php foreach ($bannerSet as $savedBanner): ?>
																<div class="ms-slide" data-delay="{{$IntervalTime}}">
																	<?php $imgPath = $savedBanner->getImagePath($application); ?>
																	<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" /> 
																	<div class="ms-info">{{$savedBanner->Description}}</div>
																</div>
															<?php endforeach; ?>
															<?php if (empty($bannerSet)): ?>
																<?php for ($i = 0; $i < 4; $i++): ?>
																	<div class="ms-slide" data-delay="{{$IntervalTime}}">
																		<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}"/> 
																		<div class="ms-info">LOREM IPSUM DOLOR SIT AMET</div>
																	</div>
																<?php endfor; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row">
												<?php for ($i = 0; $i < 9; $i++): ?>
													<?php
													$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
													$name = "";
													$detail = "";
													if (isset($templateResults[$i])) {
														$imageSrcTmp = $templateResults[$i]->FilePath . '/' . $templateResults[$i]->FileName;
														if (is_file(path("public") . $imageSrcTmp)) {
															$imageSrc = "/" . $imageSrcTmp;
														}
														$name = $templateResults[$i]->Name;
														$detail = $templateResults[$i]->Detail;
														$Sayi = $templateResults[$i]->MonthlyName;
													}
													if ($i == 0 || $i == 3 || $i == 6) {
														echo "<div class=form-row>";
													}
													?>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
														<img src="{{$imageSrc}}" width="95%">
														<div class="content-bar noTouch">
															<div class="col-md-12">{{$detail}}</div>
															<div class="col-md-12">{{$name}}</div>
															<div class="col-md-12">{{$Sayi}}</div>
														</div>
													</div>
													<?php
													if ($i == 2 || $i == 5 || $i == 8) {
														echo "</div>";
													}
													?>
												<?php endfor; ?>
											</div>
										</div>
										<div class="footer text-center" style="height:19px !important; padding: 4px 7px;">
											<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row" style="border-top: 1px solid rgb(34, 34, 34);padding-top: 10px;">
				<div class="btn-group col-md-3 col-md-offset-8" style="padding-right:9px;">
					<button type="button" class="btn col-md-7" onclick="javascript:location.href ='{{ URL::to(__('route.banners').'?applicationID='.$ApplicationID) }}'" style="cursor:pointer !important;">{{__('common.map_form_return')}}</button>
					<button type="button" class="btn col-md-5 my-btn-success" onclick="cBanner.save();" style="cursor:pointer !important;">{{__('common.detailpage_save')}}</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="rightbar col-md-3">
	<div class="block bg-light">
		<div class="content controls" style="overflow:visible">
			<div class="form-row">
				<div class="header">
					<h2 class="header" style="text-align:center;">{{ __('common.banners_original_image') }}</h2>
				</div>
				<div class="form-row" id="areaCoverImg" style="text-align:center;">
					<img class="ImagePreview" id="imgPreview" src="<?php echo $ImagePublicPath; ?>" width="200" />
					<blockquote style="border-left:none; font-size:16px; text-align:left;  padding: 15px 26px 0;">
						<p class="reportSubtitle">{{ __('common.banners_tooltip_coverimage') }}</p>
					</blockquote>
				</div>
				<div class="fileupload_container">
					<div class="input-group file" style="margin: 0 auto;"> 
						<input type="file" name="ImageFile" id="ImageFile" class="hidden" />

						<div id="ImageFileButton" class="uploadify" style="height: 30px; width: 120px; opacity: 1;">
							<div id="File-button" class="uploadify-button " style="height: 30px; line-height: 30px; width: 120px;">
								<span class="uploadify-button-text">{{ __('common.image_select') }}</span>
							</div>
						</div>

						<div for="ImageFile" class="myProgress hide">
							<a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
							<label for="scale"></label>
							<div class="scrollbox dot">
								<div class="scale" style="width: 0%"></div>
							</div>
						</div>
					</div>
					<input type="hidden" name="hdnImageFileSelected" id="hdnImageFileSelected" value="0" />
					<input type="hidden" name="hdnImageFileName" id="hdnImageFileName" value="" />
				</div>
			</div>
		</div>
	</div>           
</div>
{{ Form::close(); }}

<script type="text/javascript">
    var BannerID = <?php echo $bannerID; ?>;
    var ThemeBackground = <?php echo $application->ThemeBackground; ?>;
    var ThemeForeground = <?php echo $application->ThemeForeground; ?>;
	
    $(function () {
		cBanner.addImageUpload();
		cTemplate.loadCss(ThemeBackground, ThemeForeground);
    });

	if ($('#imgPreview').attr('src') == "/img/bannerSlider/defaultPreview.jpg" || $('#imgPreview').attr('src') == "") {
    	$('.my-btn-success').addClass('noTouch').css('background', 'rgba(52, 52, 52, 0)');
    }

    var slider = new MasterSlider();
    slider.setup('masterslider', {
    	width: 320,
	    height: 138,
	    space: 0,
	    view: 'fadeBasic',
	    layout: 'fillwidth',
	    fillMode: 'stretch',
	    speed: {{$TransitionRate}},
	    autoplay: <?php echo ($Autoplay == 1 ? true : false); ?> 
    });
    var gallery = new MSGallery('ms-gallery-1', slider);
    gallery.setup();
    slider.api.addEventListener(MSSliderEvent.CHANGE_START, function () {
    $("#ms-gallery-1 .ms-gallery-botcont").stop(true);
	    $("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0.7}, 750);
    });
    slider.api.addEventListener(MSSliderEvent.CHANGE_END, function () {
    	$("#ms-gallery-1 .ms-gallery-botcont").delay(2500).animate({opacity: 0}, 2500);
    });
	$('#ms-gallery-1').click(function () {
	    $("#ms-gallery-1 .ms-gallery-botcont").stop(true);
		if ($("#ms-gallery-1 .ms-gallery-botcont").css('opacity') > 0) {
	    	$("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0}, 250);
	    }
	    else {
	    	$("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0.7}, 250);
	    }
    });
    var slider2 = new MasterSlider();
    slider2.setup('masterslider2', {
    	width: 150,
	    height: 65,
	    space: 0,
	    view: 'fadeBasic',
	    layout: 'partialview',
	    fillMode: 'stretch',
	    speed: {{$TransitionRate}},
	    autoplay: <?php echo ($Autoplay == 1 ? true : false); ?> 
    });
    var gallery2 = new MSGallery('ms-gallery-2', slider2);
    gallery2.setup();
    slider2.api.addEventListener(MSSliderEvent.CHANGE_START, function () {
    $("#ms-gallery-2 .ms-gallery-botcont").stop(true);
	    $("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0.7}, 750);
    });
    slider2.api.addEventListener(MSSliderEvent.CHANGE_END, function () {
    	$("#ms-gallery-2 .ms-gallery-botcont").delay(2500).animate({opacity: 0}, 2500);
    });
	$('#ms-gallery-2').click(function () {
	    $("#ms-gallery-2 .ms-gallery-botcont").stop(true);
		if($("#ms-gallery-2 .ms-gallery-botcont").css('opacity') > 0) {
	    	$("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0}, 250);
	    }
	    else {
	    	$("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0.7}, 250);
	    }
    });
	$(".ms-info").each(function () {
	    if ($(this).text().length > 50) {
	    var infoText = $(this).text();
		    infoText = infoText.substring(0, 50);
		    $(this).text(infoText + "...");
	    }
    });
</script>

@endsection