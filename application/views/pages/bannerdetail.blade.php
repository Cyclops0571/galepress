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
	$Status = $banner->Status;
} else {
	$bannerID = 0;
	$orderNo = 0;
	$ImagePublicPath = '/img/bannerSlider/defaultPreview.jpg';
	$ImageLocalPath = '';
	$TargetUrl = '';
	$TargetContent = '';
	$Description = '';
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
	.checkbox-inline{
		padding-left: 0 !important;
	}
	.urlCheck:hover{
		background-color: #59AD2F !important;
		color: white !important;
		border: 1px solid #141414 !important;
	}
	.urlCheck:focus,.urlCheck:active{
		background-color: #2e2e2e;
		border-color: none !important;
	}
	.urlCheck{
		background-image: none !important;
	}
	.screen .footer{
		padding: 0 !important;
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
			
			<div class="form-row hide">
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
<!--			<div class="form-row">
				<div class="col-md-3">{{__('common.map_form_desc')}}</div>
				<div class="col-md-8">
					<input type="text" id="Description" name='Description' value="<?php echo $Description; ?>" />
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_target_desc') }}"><span class="icon-info-sign"></span></a></div>
			</div>-->
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_active')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline">
						<div class="checker">
							<span>
								<input name="BannerActive" type="checkbox" value="1" <?php echo $application->BannerActive ? 'checked="checked"' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline">
						<div class="checker">
							<span>
								<input name="BannerAutoplay" type="checkbox" value="1" <?php echo $application->BannerAutoplay ? 'checked="checked"' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_autoplay') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay_interval')}}</div>
				<div class="col-md-8">
					<input type="text" name="BannerIntervalTime" value="<?php echo $application->BannerIntervalTime ?>"/>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_interval') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay_speed')}}</div>
				<div class="col-md-8">
					<input type="text" name="BannerTransitionRate"  value="<?php echo $application->BannerTransitionRate; ?>"/>
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
				<div class="col-md-7 col-md-offset-3">
					<div id="ipadView"></div>
				</div>
			</div>
			<div class="form-row" style="border-top: 1px solid rgb(34, 34, 34);padding-top: 10px;">
				<div class="btn-group col-md-3 col-md-offset-8" style="padding-right:9px;">
					<button type="button" class="btn col-md-7" onclick="javascript:location.href ='{{ URL::to(__('route.banners').'?applicationID='.$ApplicationID) }}'" style="cursor:pointer !important;">{{__('common.map_form_return')}}</button>
					<button type="button" class="btn col-md-5 my-btn-success" onclick="cBanner.save(<?php echo $ApplicationID; ?>);" style="cursor:pointer !important;">{{__('common.detailpage_save')}}</button>
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
	var ApplicationID = <?php echo $ApplicationID; ?>;
	var ThemeBackground = <?php echo $application->ThemeBackground; ?>;
    var ThemeForeground = <?php echo $application->ThemeForeground; ?>;
    var Autoplay = <?php echo json_encode($application->BannerAutoplay == 1 ? true : false); ?>;
    var Speed = <?php echo $application->BannerTransitionRate; ?>;
    $(function () {
		cBanner.addImageUpload();
		cTemplate.show(ApplicationID, ThemeBackground, ThemeForeground, Autoplay, Speed);
    });
	
</script>
@endsection