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
	$ImagePublicPath = '';
	$ImageLocalPath = '';
	$TargetUrl = '';
	$TargetContent = '';
}
?>
	<style type="text/css">
	.text-center.app-name{
		font-size:1em !important;
		height:15px !important;
		line-height:15px !important;
	}
	.templateScreen .header .header-categories {
	  background-size: 40% auto !important;
	  height: 11px !important;
	}
	.header,.footer,.footer div{
		height: 20px !important;
		background-position: top center !important;
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
                    <h2>SLIDE RESİM DETAYLARI</h2>
                </div>
            	<div class="content controls" style="overflow:visible">

                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.banners_select_content') }} <span class="error">*</span></div>
                        <div class="col-md-8">
                            <select class="form-control select2" id="ddlContent" name="ddlContent">
								<option value=""{{ ($selectedContentID == 0 ? ' selected="selected"' : '') }}>{{ __('common.banners_select_content') }}</option>
								<?php foreach($contents as $content): ?>
								<option value="{{ $content->ContentID }}"{{ ($selectedContentID == (int)$content->ContentID ? ' selected="selected"' : '') }}>{{ $content->Name }}</option>
								<?php endforeach; ?>
							</select>
                        </div>
                        <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_name') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{__('common.banner_form_target_url')}}</div>
                        <div class="col-md-8">
                        	<input type="text" id="address" name='address' value="<?php echo "2222222"; ?>" />
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_detail') }}"><span class="icon-info-sign"></span></a></div>
                    </div> 
					<div class="form-row">
                        <div class="col-md-3">{{__('common.map_form_desc')}}</div>
                        <div class="col-md-8">
                        	<input type="text" id="description" name='description' value="<?php echo "33333333"; ?>" />
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_detail') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Önizleme</div>
                        <div class="col-md-8" style="position:relative;">
                        	<div class="col-md-6" style="width:48%;">
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
	                        <div class="col-md-6" style="position:absolute;bottom:0;right:0;padding:0;">
	                            <div data-device="ipad" data-orientation="landscape" data-color="white" class="device-mockup">
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
                        </div>
                    </div>
                    <div class="form-row">
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

@endsection