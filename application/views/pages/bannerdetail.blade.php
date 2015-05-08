@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
	$banner = new Banner();
}


if ($banner) {
	$selectedContentID = $banner->TargetContent;
	$ApplicationID = $banner->ApplicationID;
	$bannerID = $banner->BannerID;
	$orderNo = $banner->OrderNo;
	$ImagePublicPath = $banner->ImagePublicPath;
	$ImageLocalPath = $banner->ImageLocalPath;
	$TargetUrl = $banner->TargetUrl;
	$TargetContent = $banner->TargetContent;
} else {
	$selectedContentID = 0;
	$ApplicationID = $application->ApplicationID;
	$bannerID = 0;
	$orderNo = 0;
	$ImagePublicPath = '/img/bannerSlider/defaultPreview.jpg';
	$ImageLocalPath = '';
	$TargetUrl = '';
	$TargetContent = '';
}
?>
    <!--BANNER SLIDER-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="/css/masterslider/style/masterslider.css" />
    <link href="/css/masterslider/skins/default/style.css" rel='stylesheet' type='text/css'>
    <link href='/css/masterslider/ms-partialview.css' rel='stylesheet' type='text/css'>
    <!--<script src="js/masterslider/jquery-1.10.2.min.js"></script>-->
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
	  background-size: 40% auto !important;
	  height: 11px !important;
	}
	.templateScreen .header,.footer,.footer div{
		height: 22px !important;
		background-position: top center !important;
	}
	.templateScreen .ms-skin-default .ms-nav-prev{
		left: 0;
	}
	.templateScreen .ms-skin-default .ms-nav-next{
		right: 0;
	}
	.templateScreen .ms-bullets.ms-dir-h{
		bottom: 0;
	}
	.checkbox-inline{
		padding-left: 0 !important;
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
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.banners_select_content') }}</div>
                        <div class="col-md-8">
                            <select class="form-control select2" id="ddlContent" name="ddlContent">
								<option value=""{{ ($selectedContentID == 0 ? ' selected="selected"' : '') }}>{{ __('common.banners_select_content') }}</option>
								<?php foreach($contents as $content): ?>
								<option value="{{ $content->ContentID }}"{{ ($selectedContentID == (int)$content->ContentID ? ' selected="selected"' : '') }}>{{ $content->Name }}</option>
								<?php endforeach; ?>
							</select>
                        </div>
                        <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_content') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banner_form_target_url')}}</div>
                        <div class="col-md-8">
                        	<input type="text" id="address" name='address' value="" placeholder="<?php echo "galepress.com"; ?>" />
                        	<span class="error hide" style="color:red;">{{__('interactivity.link_error')}}</span>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_address') }}"><span class="icon-info-sign"></span></a></div>
                    </div> 
					<div class="form-row">
                        <div class="col-md-3">{{__('common.map_form_desc')}}</div>
                        <div class="col-md-8">
                        	<input type="text" id="description" name='description' value="<?php echo ""; ?>" />
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_desc') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banners_autoplay')}}</div>
                        <div class="col-md-8">
                        	<div class="checkbox-inline">
	                           <div class="checker"><span><input type="checkbox" value="1"></span></div>
	                       	</div>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_autoplay') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banners_autoplay_interval')}}</div>
                        <div class="col-md-8">
                        	<input type="text" placeholder="5"/>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_interval') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banners_autoplay_speed')}}</div>
                        <div class="col-md-8">
                        	<input type="text" placeholder="20"/>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_speed') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.contents_status')}}</div>
                        <div class="col-md-8">
                        	<div class="checkbox-inline">
	                           <div class="checker"><span><input type="checkbox" value="1" checked="checked"></span></div>
	                       	</div>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_active') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banners_image')}}</div>
                        <div class="col-md-8" style="position:relative;">
                        	<div class="col-md-6" style="width:48%; padding:0; margin-left:-9px;">
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
														<div class="ms-partialview-template" id="partial-view-1">
															<div class="master-slider ms-skin-default" id="masterslider">
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>     
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>      
															    </div>
															     <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/> 
															    </div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-row">
												<?php for($i = 0; $i < 9; $i++): ?>
													<?php
													$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
													$name = "";
													$detail = "";
													if(isset($templateResults[$i])) {
														$imageSrcTmp = $templateResults[$i]->FilePath.'/'.$templateResults[$i]->FileName;
														if(is_file(path("public") . $imageSrcTmp)) {
															$imageSrc = "/" . $imageSrcTmp;
														}
														$name = $templateResults[$i]->Name;
														$detail = $templateResults[$i]->Detail;
														$Sayi = $templateResults[$i]->MonthlyName;
													}
													if($i==0 || $i==3 || $i==6){
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
													if($i==2 || $i==5 || $i==8){
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
	                        <div class="col-md-6" style="position:absolute;bottom:0;right:0;padding:0;width:52%;">
	                            <div data-device="ipad" data-orientation="landscape" data-color="white" class="device-mockup">
	                              <div class="device">
	                                <div class="screen">
										<div class="templateScreen">
											<div class="header clearfix" style="height:22px !important;">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
													<div class="header-categories"></div>
												</div>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
											</div>
											<div class="container">
												<div class="form-row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="ms-partialview-template" id="partial-view-2">
															<div class="master-slider ms-skin-default" id="masterslider2">
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>     
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
															    </div>
															    <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>      
															    </div>
															     <div class="ms-slide" data-delay="5">
															        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/> 
															    </div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-row">
												<?php for($i = 0; $i < 9; $i++): ?>
													<?php
													$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
													$name = "";
													$detail = "";
													if(isset($templateResults[$i])) {
														$imageSrcTmp = $templateResults[$i]->FilePath.'/'.$templateResults[$i]->FileName;
														if(is_file(path("public") . $imageSrcTmp)) {
															$imageSrc = "/" . $imageSrcTmp;
														}
														$name = $templateResults[$i]->Name;
														$detail = $templateResults[$i]->Detail;
														$Sayi = $templateResults[$i]->MonthlyName;
													}
													if($i==0 || $i==3 || $i==6){
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
													if($i==2 || $i==5 || $i==8){
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
							<button type="button" class="btn col-md-7" onclick="javascript:location.href ='{{ URL::to(__('route.banners').'?applicationID='.$ApplicationID) }}'">{{__('common.map_form_return')}}</button>
							<button type="button" class="btn col-md-5 my-btn-success" onclick="cBanner.save();">{{__('common.detailpage_save')}}</button>
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
	$(function(){
		cBanner.addImageUpload();
	});
</script>

<script type="text/javascript">

	if($('#imgPreview').attr('src')=="/img/bannerSlider/defaultPreview.jpg" || $('#imgPreview').attr('src')==""){
		$('.my-btn-success').addClass('noTouch').css('background','rgba(52, 52, 52, 0)');
	}

	var slider = new MasterSlider();
	
	slider.control('arrows');	
	slider.control('bullets');

	slider.setup('masterslider' , {
		width:320,
		height:138,
		space:10,
		autoplay:true,
		view:'basic',
		layout:'partialview',
		speed:20
	});

	var slider2 = new MasterSlider();
	
	slider2.control('arrows');	
	slider2.control('bullets');

	slider2.setup('masterslider2' , {
		width:150,
		height:65,
		space:5,
		view:'fadeWave',
		layout:'partialview',
		speed:20
	});
</script>

@endsection