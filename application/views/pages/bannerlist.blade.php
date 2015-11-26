@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
    $rows = new Banner();
    $row = new Banner();
    $application = new Application;
}
?>

<!--<form id="list">--> 
<div class="col-md-8">
    <form id="bannerForm">
	<input type="hidden" name="applicationID" value="<?php echo $application->ApplicationID; ?>" />
	<div class="block block-drop-shadow" >
	    <div class="header">
		<h2>{{ __('common.application_settings_caption_banner') }}</h2>
	    </div>
	    <div class="content controls" id="bannerSettings">
		<div class="form-row">
		    <div class="col-md-3">{{__('common.contents_status')}}</div>
		    <div class="col-md-8 toggle_div">
			<input type="checkbox" 
			<?php echo $application->BannerActive ? 'checked' : ''; ?>
			       data-toggle="toggle" data-size="mini" 
			       id="BannerActive" name="BannerActive" 
			       data-style="ios"
			       data-onstyle="info" 
			       data-offstyle="danger" 
			       data-on="<?php echo __('common.active'); ?>" 
			       data-off="<?php echo __('common.passive'); ?>" 
			       data-width="60"
			       />
		    </div>
		    <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
		</div>
		<div class="form-row">
		    <div class="col-md-3"><?php echo __("common.banner_use_costomer_banner"); ?></div>
		    <div class="col-md-8">
			<div class="input-group">
			    <span class="input-group-addon">
				<input type="checkbox" name="BannerCustomerActive" id="BannerCustomerActive" value="1" <?php echo $application->BannerCustomerActive ? 'checked' : ''; ?> onclick="cApplication.BannerCustomerActive()">
			    </span>
			    <input  type="text" name="BannerCustomerUrl" value="<?php echo $application->BannerCustomerUrl; ?>" placeholder="http://">
			    <span class="input-group-btn">
				<button class="btn btn-primary urlCheck" type="button" onclick="cApplication.checkUrl(this);"><span class="icon-ok"></span></button>
			    </span>
			</div>
		    </div>
		    <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_use_customer_banner') }}"><span class="icon-info-sign"></span></a></div>
		</div>
		<div class="form-row">
		    <div class="col-md-3">{{__('common.banners_autoplay')}}</div>
		    <div class="col-md-8 toggle_div">
			<input type="checkbox" 
			<?php echo $application->BannerAutoplay ? 'checked' : ''; ?>
			       data-toggle="toggle" data-size="mini" 
			       id="BannerAutoplay" name="BannerAutoplay" 
			       data-style="ios"
			       data-onstyle="info" 
			       data-offstyle="danger" 
			       data-on="<?php echo __('common.active'); ?>" 
			       data-off="<?php echo __('common.passive'); ?>" 
			       data-width="60"
			       />
		    </div>
		    <div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_autoplay') }}"><span class="icon-info-sign"></span></a></div>
		</div>
		<div class="form-row">
		    <div class="col-md-3">{{__('common.banners_autoplay_interval')}}</div>
		    <div class="col-md-8">
			<input type="text" name="BannerIntervalTime" value="<?php echo $application->BannerIntervalTime; ?>"/>
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
	    </div>
	    <div class="content controls">
		<div class="form-row row-save">
		    <div class="col-md-3 col-md-offset-8">
			<input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cBanner.settingSave(<?php echo $application->ApplicationID ?>);" />
		    </div>           
		</div>
	    </div>
	</div>


	<!-- IMAGE UPLOAD START -->
	<input type="file" name="ImageFile" id="ImageFile" class="hidden" />
	<div for="ImageFile" class="myProgress hide">
	    <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
	    <label for="scale"></label>
	    <div class="scrollbox dot">
		<div class="scale" style="width: 0%"></div>
	    </div>
	</div>
	<!-- IMAGE UPLOAD END -->

	<div class="block block-drop-shadow">
	    <div class="col-md-12">  
		<table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
		    <thead>
			<tr>
			    <?php if ((int) Auth::User()->UserTypeID == eUserTypes::Customer): ?>
    			    <th>
    		    <div class="input-group commands">
    			<a href="<?php echo URL::to(__('route.' . $page . '_new')); ?>" title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
    			    <span class="icon-plus"></span>
    			</a>
    		    </div>
    		    </th>
		    <?php endif; ?>
		    <?php foreach ($fields as $field): ?>
    		    <th scope="col"><?php echo $field; ?></th>
		    <?php endforeach; ?>
		    </tr>
		    </thead>
		    <tbody>
			<?php foreach ($rows as $row): ?>

    			<tr id="bannerIDSet_<?php echo $row->BannerID ?>" class="{{ HTML::oddeven($page) }}">
				<?php if ((int) Auth::User()->UserTypeID == eUserTypes::Manager): ?>
				    <td><?php echo $row->CustomerName; ?></td>
				    <td><?php echo $row->ApplicationName; ?></td>
				<?php else: ?>
				    <td style="cursor:pointer;"><span class="icon-resize-vertical list-draggable-icon"></span></td>
				<?php endif; ?>
    			    <td>
    				<!--onclickde yeni image uploader popupi acilmali ??? -->
    				<img id="bannerImage_<?php echo $row->BannerID; ?>" src="<?php echo $row->getImagePath($application) ?>" width="60px" height="30px"  style="cursor: pointer" onclick="fileUpload(this)" />
    				<div id="uploadProgress_<?php echo $row->BannerID; ?>" class="myProgress hide">
    				    <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
    				    <label for="scale"></label>
    				    <div class="scrollbox dot">
    					<div class="scale" style="width: 0%"></div>
    				    </div>
    				</div>

    			    </td>
    			    <td>
    				<a href="#" id="<?php echo $row->BannerID; ?>" 
    				   data-name="TargetUrl" 
    				   data-type="text" 
    				   data-pk="<?php echo $row->BannerID; ?>" 
    				   data-title="<?php echo __("common.banner_form_target_url"); ?>" >
					   <?php echo $row->TargetUrl; ?>
    				</a>
    			    </td>
    			    <!--<td><?php echo $row->TargetContent; ?></td>-->
    			    <!--<td><?php echo $row->Description; ?></td>-->
    			    <td>
    				<div class="toggle_div">
    				    <input type="checkbox" 
    					   class='bannerCheckbox'
					       <?php echo $row->Status == eStatus::Active ? 'checked' : ''; ?>
    					   style="color: white"
    					   data-toggle="toggle" data-size="mini" 
    					   id="BannerStatus_<?php echo $row->BannerID; ?>"
    					   data-style="ios"
    					   data-onstyle="info" 
    					   data-offstyle="danger" 
    					   data-on="<?php echo __('common.active'); ?>" 
    					   data-off="<?php echo __('common.passive'); ?>" 
    					   data-width="50"
    					   />
    				</div>
    			    <td><?php echo $row->BannerID; ?></td>
    			    <td style="alignment-adjust: middle">
    				<div style="padding-top: 8px;">
    				    <span style=" cursor: pointer; font-size: 30px;" class="icon-remove-sign" onclick="cBanner.delete(<?php echo $row->BannerID; ?>);"></span>
    				</div>
    			    </td>
    			</tr>

			<?php endforeach; ?>
			<?php if (empty($rows)): ?>
    			<tr>
    			    <td class="select">&nbsp;</td>
    			    <td colspan="{{ count ($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
    			</tr>
			<?php endif; ?>
		    </tbody>
		</table>
	    </div>
	</div>
    </form>
</div>
<!--</form>-->
<script type="text/javascript">
    var appID = <?php echo $application->ApplicationID ?>;
    var currentBannerID = 0;
    var imageSource = "";
    function fileUpload(obj) {
	currentBannerID = $(obj).attr("id").split("_")[1];
	imageSource = $(obj).attr("src");
	$("#ImageFile").click();
    }
    $(function () {
	$('.bannerCheckbox').change(function (e, data) {
//	   console.log($(this).attr('id'));
	    var editBannerID = $(this).attr('id').split("_")[1];
//	   (param, fSuccess, formID, additionalData, onlyUseAdditionalData)
	    var fSuccess = undefined;
	    var formID = undefined;
	    var additionalData = '&pk=' + editBannerID + '&applicationID=' + appID + '&Status=' + ($(this).is(':checked') + 0);
	    cCommon.save('banners', undefined, undefined, additionalData, true);
	});

	cApplication.BannerActive();

//	$.fn.editable.defaults.mode = 'inline';
	$('#DataTables_Table_1 tbody a').editable({
	    emptytext: '. . . . .',
	    url: route['banners_save'],
	    params: {'applicationID': appID},
	    ajaxOptions: {
		beforeSend: function () {
		    console.log("asdfasdf");
		    cNotification.loader();
		}
	    },
	    success: function (response, newValue) {
		cNotification.success();
		setTimeout(function () {
		    cNotification.hide();
		}, 1000);
	    }
	});

	$('#ImageFile').fileupload({
	    url: '/' + $('#currentlanguage').val() + '/banners/imageupload',
	    dataType: 'json',
	    add: function (e, data) {
		if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
		    $("#uploadProgress_".currentBannerID).removeClass("hide");
		    $("#bannerImage_".currentBannerID).addClass("hide");

		    $("#uploadProgress_".currentBannerID).click(function (e) {
			e.preventDefault();
			data = $("#uploadProgress_".currentBannerID).data('data') || {};
			if (data.jqXHR) {
			    data.jqXHR.abort();
			}
		    });
		    var xhr = data.submit();
		}
	    },
	    done: function (e, data) {
		if (data.textStatus === 'success') {
		    $("#bannerImage_" + currentBannerID).attr("src", imageSource + "?v=" + Math.random());
		    $("#bannerImage_" + currentBannerID).removeClass("hide");
		    $("#uploadProgress_" + currentBannerID).addClass("hide");
		}
	    }
	}).bind('fileuploadsubmit', function (e, data) {
	    data.formData = {'element': 'ImageFile', 'bannerID': currentBannerID};
	});


	$("#DataTables_Table_1 tbody").sortable({
	    delay: 150,
	    axis: 'y',
	    update: function () {
		var data = $(this).sortable('serialize');
		$.ajax({
		    data: data,
		    type: 'POST',
		    url: '/banners/order/' + appID,
		    success: function (res) {
			cNotification.success();
			setTimeout(function () {
			    cNotification.hide();
			}, 1000);
		    }

		});

	    }
	});
    });

</script>
@endsection