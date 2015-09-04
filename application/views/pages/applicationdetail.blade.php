@layout('layouts.master')

@section('content')    

<?php
$ApplicationID = 0;
$CustomerID = 0;
$Name = '';
$Detail = '';
$Price = '';
$BundleText = '';
$StartDate = '';
$ExpirationDate = '';
$ApplicationStatusID = 0;
$IOSVersion = 0;
$IOSLink = '';
$AndroidVersion = 0;
$AndroidLink = '';
$PackageID = 0;
$Blocked = 0;
$Status = 0;
$Trail = 0;
$Version = 0;
$NotificationText = '';
$CkPem = '';

if (isset($row)) {
    $ApplicationID = (int) $row->ApplicationID;
    $CustomerID = (int) $row->CustomerID;
    $Name = $row->Name;
    $Detail = $row->Detail;
    $Price = $row->Price;
    $BundleText = $row->BundleText;
    $StartDate = $row->StartDate;
    $ExpirationDate = $row->ExpirationDate;
    $ApplicationStatusID = (int) $row->ApplicationStatusID;
    $IOSVersion = (int) $row->IOSVersion;
    $IOSLink = $row->IOSLink;
    $AndroidVersion = (int) $row->AndroidVersion;
    $AndroidLink = $row->AndroidLink;
    $PackageID = (int) $row->PackageID;
    $Blocked = (int) $row->Blocked;
    $Status = (int) $row->Status;
    $Trail = (int) $row->Trail;
    $Version = (int) $row->Version;
    $NotificationText = $row->NotificationText;
    $CkPem = $row->CkPem;
} else {
    $CustomerID = (int) Input::get('customerID', 0);
}

$customers = DB::table('Customer')
	->where('StatusID', '=', eStatus::Active)
	->order_by('CustomerName', 'ASC')
	->get();

$groupcodes = DB::table('GroupCode AS gc')
	->join('GroupCodeLanguage AS gcl', function($join) {
	    $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
	    $join->on('gcl.LanguageID', '=', DB::raw((int) Session::get('language_id')));
	})
	->where('gc.GroupName', '=', 'ApplicationStatus')
	->where('gc.StatusID', '=', eStatus::Active)
	->order_by('gc.DisplayOrder', 'ASC')
	->order_by('gcl.DisplayName', 'ASC')
	->get();

$packages = DB::table('Package')
	->order_by('PackageID', 'ASC')
	->get();
$Price = number_format((float)$Price, 2);
?>
<div class="col-md-8">    
    <div class="block block-drop-shadow">
	<div class="header">
	    <h2>{{ __('common.detailpage_caption') }}</h2>
	</div>
	<div class="content controls">
	    {{ Form::open(__('route.applications_save'), 'POST') }}
	    {{ Form::token() }}
	    <div class="form-row">
		<input type="hidden" name="ApplicationID" id="ApplicationID" value="{{ $ApplicationID }}" />
		<div class="col-md-3">{{ __('common.applications_customer') }} <span class="error">*</span></div>
		{{ $errors->first('CustomerID', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <select class="form-control select2 required"  style="width: 100%;" tabindex="-1" id="CustomerID" name="CustomerID">
			<option value=""{{ ($CustomerID == 0 ? ' selected="selected"' : '') }}></option>
			@foreach ($customers as $customer)
			<option value="{{ $customer->CustomerID }}"{{ ($CustomerID == $customer->CustomerID ? ' selected="selected"' : '') }}>{{ $customer->CustomerName }}</option>
			@endforeach
		    </select>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_applicationname') }}<span class="error">*</span></div>
		{{ $errors->first('Name', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <input type="text" name="Name" id="Name" class="form-control textbox required" value="{{ $Name }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_detail') }}</div>
		<div class="col-md-9">
		    <textarea name="Detail" id="Detail" class="form-control" rows="2" cols="20">{{ $Detail }}</textarea>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_price') }}</div>
		<div class="col-md-9">
		    <div class="input-group">
			<input type="text" name="Price" id="Price" class="form-control textbox" placeholder="{{__('common.applications_placeholder_price')}}"  value="{{ $Price }}"/>
			<span class="input-group-addon">TL + (KDV)</span>
		    </div>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_bundle') }}</div>
		<div class="col-md-9">
		    <input type="text" name="BundleText" id="BundleText" class="form-control textbox" value="{{ $BundleText }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_startdate') }}<span class="error">*</span></div>
		{{ $errors->first('StartDate', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <input type="text" name="StartDate" id="StartDate" class="form-control textbox date required" disable="disable" value="{{ Common::dateRead($StartDate, 'dd.MM.yyyy') }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_expirationdate') }}<span class="error">*</span></div>
		{{ $errors->first('ExpirationDate', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <input type="text" name="ExpirationDate" id="ExpirationDate" class="form-control textbox date required" disable="disable" value="{{ Common::dateRead($ExpirationDate, 'dd.MM.yyyy') }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_notificationtext') }}</div>
		<div class="col-md-9">
		    <input type="text" name="NotificationText" id="NotificationText" class="form-control textbox" value="{{ $NotificationText }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_file') }}</div>
		<div class="col-md-9">
		    <div class="fileupload_container">
			@if(strlen($CkPem) > 0)
			<a href="/files/customer_{{ $CustomerID }}/application_{{ $ApplicationID }}/{{ $CkPem }}" target="_blank" class="uploadedfile">{{ __('common.contents_filelink') }}</a><br />
			@endif
			<input type="file" name="CkPem" id="CkPem" class="hidden" />

			<div id="CkPemButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
			    <div id="File-button" class="uploadify-button " style="height: 30px; line-height: 30px; width: 120px;">
				<span class="uploadify-button-text">{{ __('common.applications_file_select') }}</span>
			    </div>
			</div>

			<div for="CkPem" class="myProgress hide">
			    <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
			    <label for="scale"></label>
			    <div class="scrollbox dot">
				<div class="scale" style="width: 0%"></div>
			    </div>
			</div>

		    </div>

		    <input type="hidden" name="hdnCkPemSelected" id="hdnCkPemSelected" value="0" />
		    <input type="hidden" name="hdnCkPemName" id="hdnCkPemName" value="{{ $CkPem }}" />
		    <script type="text/javascript">
			    $(function () {

				if ($("html").hasClass("lt-ie10"))
				{
				    $("#CkPem").uploadify({
					'swf': '/uploadify/uploadify.swf',
					'uploader': '/' + $('#currentlanguage').val() + '/' + route["applications_uploadfile2"],
					'cancelImg': '/uploadify/uploadify-cancel.png',
					'fileTypeDesc': 'PEM Files',
					'fileTypeExt': '*.pem',
					'buttonText': "{{ __('common.applications_file_select') }}",
					'multi': false,
					'auto': true,
					'successTimeout': 300,
					'onSelect': function (file) {
					    $('#hdnCkPemSelected').val("1");
					    $("[for='CkPem']").removeClass("hide");
					},
					'onUploadProgress': function (file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
					    var progress = totalBytesUploaded / totalBytesTotal * 100;
					    $("[for='CkPem'] label").html(progress.toFixed(0) + '%');
					    $("[for='CkPem'] div.scale").css('width', progress.toFixed(0) + '%');
					},
					'onUploadSuccess': function (file, data, response) {

					    if (data.getValue("success") == "true")
					    {
						var fileName = data.getValue("filename");

						$('#hdnCkPemName').val(fileName);
						$("[for='CkPem']").addClass("hide");
					    }
					},
					'onCancel': function (file) {
					    $("[for='CkPem']").addClass("hide");
					}
				    });
				}
				else
				{
				    $("#CkPem").fileupload({
					url: '/' + $('#currentlanguage').val() + '/' + route["applications_uploadfile"],
					dataType: 'json',
					sequentialUploads: true,
					formData: {
					    'element': 'CkPem'
					},
					add: function (e, data)
					{
					    if (/\.(pem)$/i.test(data.files[0].name))
					    {
						$('#hdnCkPemSelected').val("1");
						$("[for='CkPem']").removeClass("hide");

						data.context = $("[for='CkPem']");
						data.context.find('a').click(function (e) {
						    e.preventDefault();
						    var template = $("[for='CkPem']");
						    data = template.data('data') || {};
						    if (data.jqXHR)
						    {
							data.jqXHR.abort();
						    }
						});
						var xhr = data.submit();
						data.context.data('data', {jqXHR: xhr});
					    }
					},
					progressall: function (e, data)
					{
					    var progress = data.loaded / data.total * 100;

					    $("[for='CkPem'] label").html(progress.toFixed(0) + '%');
					    $("[for='CkPem'] div.scale").css('width', progress.toFixed(0) + '%');
					},
					done: function (e, data)
					{
					    if (data.textStatus == 'success')
					    {
						var fileName = data.result['CkPem'][0].name;

						$('#hdnCkPemName').val(fileName);
						$("[for='CkPem']").addClass("hide");
					    }
					},
					fail: function (e, data)
					{
					    $("[for='CkPem']").addClass("hide");
					}
				    });

				    //select file
				    $("#CkPemButton").removeClass("hide").click(function () {

					$("#CkPem").click();
				    });
				}

			    });
		    </script>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_applicationstatus') }}</div>
		<div class="col-md-9">
		    <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ApplicationStatusID" name="ApplicationStatusID">
			<option value=""{{ ($ApplicationStatusID == 0 ? ' selected="selected"' : '') }}></option>
			@foreach ($groupcodes as $groupcode)
			<option value="{{ $groupcode->GroupCodeID }}"{{ ($ApplicationStatusID == $groupcode->GroupCodeID ? ' selected="selected"' : '') }}>{{ $groupcode->DisplayName }}</option>
			@endforeach
		    </select>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_iosversion') }}</div>
		<div class="col-md-9">
		    <input type="text" name="IOSVersion" id="IOSVersion" class="form-control textbox" value="{{ $IOSVersion }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_ioslink') }}</div>
		<div class="col-md-9">
		    <input type="text" name="IOSLink" id="IOSLink" class="form-control textbox" value="{{ $IOSLink }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_androidversion') }}</div>
		<div class="col-md-9">
		    <input type="text" name="AndroidVersion" id="AndroidVersion" class="form-control textbox" value="{{ $AndroidVersion }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_androidlink') }}</div>
		<div class="col-md-9">
		    <input type="text" name="AndroidLink" id="AndroidLink" class="form-control textbox" value="{{ $AndroidLink }}"/>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_package') }}</div>
		<div class="col-md-9">
		    <select class="form-control select2 required" style="width: 100%;" tabindex="-1" id="PackageID" name="PackageID">
			<option value=""{{ ($PackageID == 0 ? ' selected="selected"' : '') }}></option>
			@foreach ($packages as $package)
			<option value="{{ $package->PackageID }}"{{ ($PackageID == $package->PackageID ? ' selected="selected"' : '') }}>{{ $package->Name }}</option>
			@endforeach
		    </select>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_blocked') }}</div>
		<div class="col-md-9">
		    <div class="checkbox-inline">
			<input type="checkbox"  name="Blocked" id="Blocked" value="1"{{ ((int)$Blocked == 1 ? ' checked="checked"' : '') }} />
		    </div>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.applications_status') }}</div>
		<div class="col-md-9">
		    <div class="checkbox-inline">
			<input type="checkbox" name="Status" id="Status" value="1"{{ ((int)$Status == 1 ? ' checked="checked"' : '') }} />
		    </div>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">Trail?</div>
		<div class="col-md-9">
		    <select class="form-control select2 required" style="width: 100%;" tabindex="-1" id="Trail" name="Trail">
			<option value="2"{{ ($Trail == 2 ? ' selected="selected"' : '') }}>Müşterimiz</option>
			<option value="1"{{ ($Trail == 1 ? ' selected="selected"' : '') }}>Deneme Sürümü</option>
		    </select>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-8"></div>
		@if($ApplicationID == 0)
		<div class="col-md-2"></div>
		<div class="col-md-2">
		    <input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_save') }}" onclick="cApplication.save();" />
		</div>
		@else
		<div class="col-md-2">
		    <a href="#modal_default_10" data-toggle="modal"><input type="button" value="{{ __('common.detailpage_delete') }}" name="delete" class="btn delete expand remove" /></a>
		</div>
		<div class="col-md-2">
		    <input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cApplication.save();" />
		</div>
		@endif            
	    </div>
	    {{ Form::close() }}
	</div>
    </div>
</div>
<div class="modal modal-info" id="modal_default_10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Silmek istediğinize emin misiniz?</h4>
	    </div>                
	    <div class="modal-footer">
		<button type="button" class="btn btn-default btn-clean"  data-dismiss="modal" onclick="cApplication.erase();" style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>       
		<button type="button" class="btn btn-default btn-clean" data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
	    </div>
	</div>
    </div>
</div>
@endsection