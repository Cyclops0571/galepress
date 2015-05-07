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
<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
    <div class="block block-drop-shadow" style="min-width:264px;">
        {{ Form::open(__('route.banners_detail'), 'POST') }}
        {{ Form::token() }}
        <input type="hidden" name="primaryKeyID" id="primaryKeyID" value="<?php echo $bannerID; ?>" />
        @if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
        <input type="hidden" name="applicationID" id="ApplicationID" value="<?php echo $ApplicationID; ?>" />
        @endif
        <div class="content np">
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
			
			<div class="input-group">
				<div class="input-group-addon"><span class="icon-cloud"></span></div>
				<select class="form-control select2" id="ddlContent" name="ddlContent">
					<option value=""{{ ($selectedContentID == 0 ? ' selected="selected"' : '') }}>{{ __('common.banners_select_content') }}</option>
					<?php foreach($contents as $content): ?>
					<option value="{{ $content->ContentID }}"{{ ($selectedContentID == (int)$content->ContentID ? ' selected="selected"' : '') }}>{{ $content->Name }}</option>
					<?php endforeach; ?>
				</select>
			</div>

            <div class="list list-contacts">
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.banner_form_target_url')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="address" name='address' value="<?php echo "2222222"; ?>" />
                        </div>
                    </div>                                
                </a>                            
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_desc')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="description" name='description' value="<?php echo "33333333"; ?>" />
                        </div>
                    </div>                                
                </a>
                <a href="#" class="list-item text-center" style="padding:10px;">

                    <div class="btn-group">
						<button type="button" style="max-width:95px;" class="btn" onclick="javascript:location.href ='{{ URL::to(__('route.banners').'?applicationID='.$ApplicationID) }}'">{{__('common.map_form_return')}}</button>
						<button type="button" style="max-width:76px;" class="btn my-btn-success" onclick="cBanner.save();">{{__('common.detailpage_save')}}</button>
                    </div>

                </a>                        
            </div>                        
        </div>
        {{ Form::close(); }}
    </div>

</div>
<script type="text/javascript">
	var BannerID = <?php echo $bannerID; ?>;
	$(function(){
		cBanner.addImageUpload();
	});
</script>

@endsection