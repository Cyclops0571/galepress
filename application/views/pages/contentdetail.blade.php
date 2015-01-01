@layout('layouts.master')

@section('content')    
    
    <?php

	$ContentID = 0;
	$ApplicationID = 0;
	$Name = '';
	$Detail = '';
	$MonthlyName = '';
	$PublishDate = '';
	$CategoryID = 0;
	$IsProtected = 0;
	$Password = '';
	$IsBuyable = 0;
	$Price = 0;
	$CurrencyID = 0;
	$IsMaster = 0;
	$Identifier = '';
	$AutoDownload = 0;
	$Approval = 0;
	$Blocked = 0;
	$Status = 0;
	$Version = 0;
	$ContentFileID = 0;
	$Transferable = false;
	$Transferred = false;
	
	if(isset($row))
	{
		$ContentID = (int)$row->ContentID;
		$ApplicationID = (int)$row->ApplicationID;
		$Name = e($row->Name);
		$Detail = $row->Detail;
		$MonthlyName = $row->MonthlyName;
		$PublishDate = $row->PublishDate;
		$CategoryID = (int)$row->CategoryID;
		
		$IsProtected = (int)$row->IsProtected;
		$Password = $row->Password;
		$IsBuyable = (int)$row->IsBuyable;
		//$Price = (int)$row->Price;
		//$Price = (float)$row->Price;
		$Price = number_format((float)$row->Price, 2, '.', '');
		$CurrencyID = (int)$row->CurrencyID;
		$IsMaster = (int)$row->IsMaster;
		$Identifier = $row->Identifier;
		$AutoDownload = (int)$row->AutoDownload;
		$Approval = (int)$row->Approval;
		$Blocked = (int)$row->Blocked;
		$Status = (int)$row->Status;
		$Version = (int)$row->Version;
		$ContentFileID = (int)DB::table('ContentFile')
							->where('ContentID', '=', $ContentID)
							->where('StatusID', '=', eStatus::Active)
							->max('ContentFileID');

		$oldContentFile = DB::table('ContentFile')
				->where('ContentID', '=', $ContentID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('ContentFileID', 'DESC')
				->take(1)
				->first();
		if($oldContentFile) {
			$Transferable = (int)$oldContentFile->Interactivity == 1;
			$Transferred = (int)$oldContentFile->Transferred == 1;
		}
		/*
		$oldContentFileInteractivity = (int)DB::table('ContentFile')
				->where('ContentID', '=', $ContentID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('ContentFileID', 'DESC')
				->take(1)
				->only('Interactivity');
		$Transferable = (int)$oldContentFileInteractivity == 1;

		$oldContentFileTransferred = (int)DB::table('ContentFile')
				->where('ContentID', '=', $ContentID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('ContentFileID', 'DESC')
				->take(1)
				->only('Transferred');		
		$Transferred = (int)$oldContentFileTransferred == 1;
		*/
	}
	else 
	{
		$ApplicationID = (int)Input::get('applicationID', 0);
	}

	$authInteractivity = Common::AuthInteractivity($ApplicationID);
	$authMaxPDF = Common::AuthMaxPDF($ApplicationID);

	$applications = DB::table('Application')
					->where('StatusID', '=', eStatus::Active)
					->order_by('Name', 'ASC')
					->get();
	
	$categories = DB::table('Category')
					->where('ApplicationID', '=', $ApplicationID)
					->where('StatusID', '=', eStatus::Active)
					->order_by('Name', 'ASC')
					->get();
	
	$groupcodes = DB::table('GroupCode AS gc')
					->join('GroupCodeLanguage AS gcl', function($join)
					{
						$join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
						$join->on('gcl.LanguageID', '=', DB::raw((int)Session::get('language_id')));
					})
					->where('gc.GroupName', '=', 'Currencies')
					->where('gc.StatusID', '=', eStatus::Active)
					->order_by('gc.DisplayOrder', 'ASC')
					->order_by('gcl.DisplayName', 'ASC')
					->get();
	?>
	<iframe id="interactivity" class="interactivity"></iframe>
    {{ Form::open(__('route.contents_save'), 'POST', array('enctype' => 'multipart/form-data')) }}
		{{ Form::token() }}
        <div class="col-md-9">
			<div class="block bg-light-ltr">
                <div class="header">
                    <h2>{{ __('common.detailpage_caption') }}</h2>
                </div>
            	<div class="content controls" style="overflow:visible">
            		
            		@if(!$authMaxPDF)
					<script type="text/javascript">
						$(function() {
							cNotification.failure(notification["auth_max_pdf"]);
						});
					</script>
					@endif

				    <input type="hidden" name="ContentID" id="ContentID" value="{{ $ContentID }}" />
					@if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
					<input type="hidden" name="ApplicationID" id="ApplicationID" value="{{ $ApplicationID }}" />
					@endif
                    @if((int)Auth::User()->UserTypeID == eUserTypes::Manager)
                    <div class="form-row">
						<div class="col-md-3">{{ __('common.contents_application') }} <span class="error">*</span></div>
                        {{ $errors->first('ApplicationID', '<p class="error">:message</p>') }}
                        <div class="col-md-8">
	                        <select style="width: 100%;" tabindex="-1" id="ApplicationID" name="ApplicationID" class="form-control select2 required">
	                            <option value=""{{ ($ApplicationID == 0 ? ' selected="selected"' : '') }}></option>
	                            @foreach ($applications as $application)
	                            <option value="{{ $application->ApplicationID }}"{{ ($ApplicationID == $application->ApplicationID ? ' selected="selected"' : '') }}>{{ $application->Name }}</option>
	                            @endforeach
	                        </select>
                        </div>
						<div class="col-md-1"><a class="tipr" title="{{ __('common.contents_tooltip_application') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                	@endif
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_name') }} <span class="error">*</span></div>
                        <div class="col-md-8">
                            <input type="text" name="Name" id="Name" class="form-control textbox required" value="{{ $Name }}"/>
                        </div>
                        <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_name') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_detail') }}</div>
                        <div class="col-md-8">
                        	<textarea class="form-control" name="Detail" id="Detail" rows="2" cols="15">{{ $Detail }}</textarea>
                        </div>
                         <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_detail') }}"><span class="icon-info-sign"></span></a></div>
                    </div> 
					<div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_category') }}
                        	<a href="javascript:void(0);" class="widget-icon widget-icon-circle" onclick="cContent.showCategoryList();" data-toggle="modal"><span class="icon-pencil"></span></a>
						</div>							
                    	<div class="col-md-8">
                            <select id="CategoryID" name="chkCategoryID[]" multiple="multiple" class="chosen-container" style="opacity:0 !important;" required>
                            	<?php
                                $cnt = 0;
                                if($ContentID > 0)
                                {
                                    $cnt = DB::table('ContentCategory')->where('ContentID', '=', $ContentID)->where('CategoryID', '=', '0')->count();	
                                }
                                ?>
                                @if($cnt>0)
                                <option value="" selected="selected">{{ __('common.contents_category_list_general') }}</option>
                                @else
                                <option value="">{{ __('common.contents_category_list_general') }}</option>
                                @endif
                                @foreach ($categories as $category)
                                	<?php
                                    $cnt = 0;
                                    
                                    if($ContentID > 0)
                                    {
                                        $cnt = DB::table('ContentCategory')->where('ContentID', '=', $ContentID)->where('CategoryID', '=', $category->CategoryID)->count();	
                                    }
                                    ?>
                                    <option value="{{ $category->CategoryID }}"{{ ($cnt > 0 ? ' selected="selected"' : '') }}>{{ $category->Name }}</option>
                                @endforeach
                                <!--<option value="-1" class="modify">{{ __('common.contents_category_title') }}</option>-->
                            </select>
                            <script type="text/javascript">
                            $('#CategoryID').ready(function(){
                            	$('#CategoryID').css('opacity','1');
                            });
                            </script>
                        </div>
                        <div class="col-md-1"><a class="tipr" title="{{ __('common.contents_tooltip_category') }}"><span class="icon-info-sign"></span></a></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_monthlyname') }}</div>
                        <div class="col-md-8">
                        	<input type="text" name="MonthlyName" id="MonthlyName" class="form-control textbox" value="{{ $MonthlyName }}" />
                        </div>
                        <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_monthlyname') }}"><span class="icon-info-sign"></span></a></div>
                    </div> 
                    <div class="form-row" style="background: none !important;">
                        <div class="col-md-3 ">{{ __('common.contents_publishdate') }}</div>
                        <div class="col-md-8">
							<div class="input-group">
								<div class="input-group-addon"><span class="icon-calendar"></span></div>
								<input type="text" name="PublishDate" id="PublishDate" class="form-control textbox date" value="{{ Common::dateRead($PublishDate, 'dd.MM.yyyy') }}" />
							</div>
						</div>
						 <div class="col-md-1"><a class="tipr" title="{{ __('common.contents_tooltip_publishdate') }}"><span class="icon-info-sign"></span></a></div>
					</div>
					<div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_file') }}{{ $ContentID == 0 ? ' <span class="error">*</span>' : '' }}</div>
						<div class="col-md-2" id="contentPdfFile">

							<input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;" />
							<script type="text/javascript">
                            $('#File').ready(function(){
                            	$('#File').css('opacity','1');
                            });
                            </script>

							<div id="FileButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
								<div id="File-button" class="uploadify-button " style="height: 30px; line-height: 30px; width: 120px;">
									<span class="uploadify-button-text">{{ __('common.contents_file_select') }}</span>
								</div>
							</div>

							<div for="File" class="myProgress hide">
					        	<a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
					            <label for="scale"></label>
					            <div class="scrollbox dot">
					                <div class="scale" style="width: 0%"></div>
					            </div>
					        </div>
					        
	                        <input type="hidden" name="hdnFileSelected" id="hdnFileSelected" value="0"/>
	                        <input type="hidden" name="hdnFileName" id="hdnFileName"{{ $ContentID == 0 ? ' class="required"' : '' }} />
	                        <script type="text/javascript">
								<!--
								$(function(){

									if($("html").hasClass("lt-ie10") || $("html").hasClass("lt-ie9") || $("html").hasClass("lt-ie8"))
									{
										$("#File").uploadify({
											'swf': '/uploadify/uploadify.swf',
											'uploader': '/' + $('#currentlanguage').val() + '/' + route["contents_uploadfile2"],
											'cancelImg': '/uploadify/uploadify-cancel.png',
											'fileTypeDesc': 'PDF Files',
											'fileTypeExts': '*.pdf',
											'buttonText': "{{ __('common.contents_file_select') }}",
											'multi': false,
											'auto': true,
											'successTimeout': 300,
											'onSelect': function (file) {
												$('#hdnFileSelected').val("1");
												$("[for='File']").removeClass("hide");
											},
											'onUploadProgress': function (file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
												var progress = totalBytesUploaded / totalBytesTotal * 100;
												if(progress > 99) {
													progress = 100;
												}
												$("[for='File'] label").html(progress.toFixed(0) + '%');
												$("[for='File'] div.scale").css('width', progress.toFixed(0) + '%');
											},
											'onUploadSuccess': function (file, data, response) {

												if(data.getValue("success") == "true")
												{
													var fileName = data.getValue("filename");

													$('#hdnFileName').val(fileName);
													$("[for='File']").addClass("hide");
													
													$('#hdnCoverImageFileSelected').val("1");
													$('#hdnCoverImageFileName').val(data.getValue("coverimagefilename"));
													$('#imgPreview').attr("src", "/files/temp/" + data.getValue("coverimagefilename"));
													
													$("div.rightbar").removeClass("hidden");

													//auto save
													if(parseInt($("#ContentID").val()) > 0) {
														cContent.save(true);
													}
												}
											},
											'onCancel': function(file) {
												$("[for='File']").addClass("hide");
											}
										});
									}
									else
									{
										$("#File").fileupload({
											url: '/' + $('#currentlanguage').val() + '/' + route["contents_uploadfile"],
											dataType: 'json',
											sequentialUploads: true,
											formData: { 
												'element': 'File'
											},
											add: function(e, data)
											{
												if(/\.(pdf)$/i.test(data.files[0].name))
												{
													$('#hdnFileSelected').val("1");
													$("[for='File']").removeClass("hide");
													
													data.context = $("[for='File']");
													data.context.find('a').click(function(e){
														e.preventDefault();
														var template = $("[for='File']");
														data = template.data('data') || {};
														if(data.jqXHR)
														{
															data.jqXHR.abort();
														}
													});
													var xhr = data.submit();
													data.context.data('data', { jqXHR: xhr });
												}
											},
											progressall: function(e, data)
											{
												var progress = data.loaded / data.total * 100;
												
												$("[for='File'] label").html(progress.toFixed(0) + '%');
												$("[for='File'] div.scale").css('width', progress.toFixed(0) + '%');
											},
											done: function(e, data)
											{
												if(data.textStatus == 'success')
												{
													var fileName = data.result.fileName;
													var imageFile = data.result.imageFile;

													$('#hdnFileName').val(fileName);
													$("[for='File']").addClass("hide");
													
													$('#hdnCoverImageFileSelected').val("1");
													$('#hdnCoverImageFileName').val(imageFile);
													$('#imgPreview').attr("src", "/files/temp/" + imageFile);
													
													$("div.rightbar").removeClass("hidden");

													//auto save
													if(parseInt($("#ContentID").val()) > 0) {
														cContent.save(true);
													}
												}
											},
											fail: function(e, data)
											{
												$("[for='File']").addClass("hide");
											}
										});
										
										//select file
										$("#FileButton").removeClass("hide").click(function(){
											
											$("#File").click();
										});
									}

								});
								// -->
							</script>
						</div>
						<div class="col-md-6" style="padding-left:30px; padding-top:2px;">
							@if($ContentID > 0 && $ContentFileID > 0 && $authInteractivity && $Transferable)
							<div class="checkbox-inline">
								<input type="checkbox" name="Transferred" id="Transferred" value="1" checked="checked" />
							</div>
							<span>{{ __('common.contents_transfer') }}</span>
							@endif
						</div>
					 	<div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_file') }}"><span class="icon-info-sign"></span></a></div>
                	</div>
                	@if($ContentID > 0 && $ContentFileID > 0 && $authInteractivity)
	                	<div class="form-row">
	                    	<div class="col-md-3" style="padding-top:8px;">{{ __('common.contents_file_interactive_label') }}</div>
	                    	<div class="col-md-8">
								<div class="fileupload_container">
	                            	<div class="col-md-3" id="contentPdfButton">
	                             		<section>
											<!--<a href="javascript:void(0);" onclick="cContent.openInteractiveIDE({{ $ContentFileID }});" id="btn_interactive">&#xF011;</a>-->
											<a href="/{{ Session::get('language') }}/{{ __('route.interactivity') }}/{{ $ContentFileID }}" onclick="cContent.openInteractiveIDE({{ $ContentFileID }});" id="btn_interactive">&#xF011;</a>
											<span></span>
											@if($ContentID > 0 && $ContentFileID > 0 && $authInteractivity && $Transferred)
											<script type="text/javascript">
												<!--
												//alert('transfer ettikten sonra interaktif tasarlayiciyi acip kontrol ediniz!');
												//document.write('TAAARRARRARRARAA');
												// -->
											</script>
											@endif
										</section>
		                           	</div>
	                            </div>
	                            <?php
	                            	echo '<div class="col-md-6" style="padding-top: 8px">';
	                            	$cf = DB::table('ContentFile')->where('ContentFileID', '=', $ContentFileID)->first();
	                                if($cf)
	                                {
	                                    if((int)$cf->Interactivity == 1 && $authInteractivity)
	                                    {
	                                        if((int)$cf->HasCreated == 1)
	                                        {
												//echo '<a href="/'.Session::get('language').'/'.__('route.contents_request').'?RequestTypeID=1001&ContentID='.$ContentID.'" target="_blank" class="uploadedfile">'.__('common.contents_filelink').'</a><br />';
												echo '<span>'.__('common.contents_interactive_file_has_been_created').'</span>';
	                                        }
	                                        else
	                                        {
	                                            echo '<span>'.__('common.contents_interactive_file_hasnt_been_created').'</span>';
	                                        }
	                                    }
	                                    else
	                                    {
	                                        echo '<span><a href="/'.Session::get('language').'/'.__('route.contents_request').'?RequestTypeID=1001&ContentID='.$ContentID.'" target="_blank" class="uploadedfile">'.__('common.contents_filelink').'</a></span>';
	                                    }
	                                }
	                                $error = Input::get('error');
	                                if(isset($error))
                                    {
										echo '<br><span style="color:#f0d737;">'.$error.'</span>';
                                    }
	                                echo '</div>';
		                        ?>
	                        </div>
							<div class="col-md-1"><a class="tipr" title="{{ __('common.contents_tooltip_interactive') }}"><span class="icon-info-sign"></span></a></div>
						</div>
                	@endif
            	</div>
			</div>				
            <div class="block">
                <div class="content controls" style="overflow:visible">
                    <div class="form-row" >
                        <div class="col-md-3">{{ __('common.contents_isprotected') }}</div>
                        <div class="col-md-8">
                            <div class="checkbox-inline">
                               <input type="checkbox" name="IsProtected" id="IsProtected" value="1"{{ ((int)$IsProtected == 1 ? ' checked="checked"' : '') }} />
                           </div>
                       </div>
                       <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_isprotected') }}"><span class="icon-info-sign"></span></a></div>
                   	</div>
                   	<div class="form-row">
                        <div class="col-md-3">{{ __('common.contents_password') }}
                        	<a href="javascript:void(0);" class="widget-icon widget-icon-circle" onclick="cContent.showPasswordList();" data-toggle="modal"><span class="icon-group"></span></a>
						</div>
                        <div class="col-md-8">               
                         	<input type="password" name="Password" id="Password" class="form-control textbox" value="" />
                     	</div>
                      	<div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_password') }}"><span class="icon-info-sign"></span></a></div>
             		</div>
	            </div>
	        </div>
     		<div class="block disabledFields">
	            <div class="content controls" style="overflow:visible">
	                <div class="form-row">
	                    <div class="col-md-3">{{ __('common.contents_isbuyable') }}</div>
	                    <div class="col-md-8">
	                        <div class="checkbox-inline">
	                           <input type="checkbox" name="IsBuyable" disabled id="IsBuyable" value="1"{{ ((int)$IsBuyable == 1 ? ' checked="checked"' : '') }} />
	                       	</div>                             
	                   </div>
	                    <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_isbuyable') }}"><span class="icon-info-sign"></span></a></div>
	               	</div>
	               	<div class="form-row">
		                <div class="col-md-3">{{ __('common.contents_price') }}</div>
			                <div class="col-md-8">               
			                    <input type="text" name="Price" disabled id="Price" class="form-control textbox" value="{{ $Price }}" style="width:100px;" />
			                </div>
		                 <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_price') }}"><span class="icon-info-sign"></span></a></div>
	            	</div>
		            <div class="form-row">
		                <div class="col-md-3">{{ __('common.contents_currency') }}</div>
		                <div class="col-md-8">
		                    <select id="CurrencyID" name="CurrencyID" disabled class="form-control select2" style="width: 100%;" tabindex="-1">
		                        <option value=""{{ ($CurrencyID == 0 ? ' selected="selected"' : '') }}>{{ __('common.reports_select') }}</option>
		                        @foreach ($groupcodes as $groupcode)
		                        <option value="{{ $groupcode->GroupCodeID }}"{{ ($CurrencyID == $groupcode->GroupCodeID ? ' selected="selected"' : '') }}>{{ $groupcode->DisplayName }}</option>
		                        @endforeach
		                    </select>
		                </div>
		                 <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_currency') }}"><span class="icon-info-sign"></span></a></div>
		            </div>
		            <div class="form-row">
		                <div class="col-md-3">{{ __('common.contents_identifier') }}</div>
		                <div class="col-md-8">               
		                   <input type="text" name="Identifier" disabled id="Identifier" class="form-control textbox" value="{{ $Identifier }}" />
		               </div>
		                <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_identifier') }}"><span class="icon-info-sign"></span></a></div>
		           	</div>
   				</div>
			</div>
			<div class="block">
	            <div class="content controls" style="overflow:visible">
	                <div class="form-row">
	                    <div class="col-md-3">{{ __('common.contents_ismaster') }}</div>
	                    <div class="col-md-8">
	                        <div class="checkbox-inline">
	                           <input type="checkbox" name="IsMaster" id="IsMaster" value="1"{{ ((int)$IsMaster == 1 ? ' checked="checked"' : '') }} />
	                       	</div>                             
	                   </div>
	                    <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_ismaster') }}"><span class="icon-info-sign"></span></a></div>
	               	</div>
   				</div>
			</div>
			<div class="block disabledFields">
			    <div class="content controls" style="overflow:visible">
			        <div class="form-row">
			            <div class="col-md-3">{{ __('common.contents_autodownload') }}</div>
			            <div class="col-md-8">
			                <div class="checkbox-inline">
			                   <input type="checkbox" name="AutoDownload" disabled id="AutoDownload" value="1"{{ ((int)$AutoDownload == 1 ? ' checked="checked"' : '') }} />
			               </div>                               
			           </div>
			            <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_autodownload') }}"><span class="icon-info-sign"></span></a></div>
			       </div>
			   	</div>
			</div>                
			<div class="block">
				<div class="content controls" style="overflow:visible">
				    @if((int)Auth::User()->UserTypeID == eUserTypes::Manager)        
				    <div class="form-row">
				        <div class="col-md-3">{{ __('common.contents_approval') }}</div>
				        <div class="col-md-8">
				            <div class="checkbox-inline">
				             	<input type="checkbox" name="Approval" id="Approval" value="1"{{ ((int)$Approval == 1 ? ' checked="checked"' : '') }} />
				         	</div>                               
				     	</div>
				      	<div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_approval') }}"><span class="icon-info-sign"></span></a></div>
				 	</div>
					<div class="form-row">
					    <div class="col-md-3">{{ __('common.contents_blocked') }}</div>
					    <div class="col-md-8">
					        <div class="checkbox-inline">
					         	<input type="checkbox" name="Blocked" id="Blocked" value="1"{{ ((int)$Blocked == 1 ? ' checked="checked"' : '') }} />
					     </div>                               
					 	</div>
				  		<div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_blocked') }}"><span class="icon-info-sign"></span></a></div>
					</div>
					@endif
					<div class="form-row">
						<div class="col-md-3">{{ __('common.contents_status') }}</div>
						<div class="col-md-8">
							<div class="checkbox-inline">
							   <input type="checkbox" name="Status" id="Status" value="1"{{ ((int)$Status == 1 ? ' checked="checked"' : '') }} />
							</div>                               
						</div>
						 <div class="col-md-1"><a  class="tipr" title="{{ __('common.contents_tooltip_status') }}"><span class="icon-info-sign"></span></a></div>
					</div>
				</div>
			</div> 
			<div class="block">
				<div class="content controls" style="overflow:visible">
					<div class="form-row">
					    <div class="col-md-8"></div>
					    <span class="command">
					        @if($ContentID == 0)
							<div class="col-md-2"></div>
					        <div class="col-md-2"><input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_save') }}" onclick="cContent.save();" /></div>
					        @else
					        <div class="col-md-2">
					        	<a href="#modal_default_10" class="btn delete expand remove" style="width:100%;" data-toggle="modal">{{ __('common.detailpage_delete') }}</a>
					        </div>
					        <div class="col-md-2">
					        	<input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cContent.save();" />
					        </div>
					        @endif
					    </span>
					</div> 
				</div>
			</div>                        
		</div> 
		<div class="rightbar col-md-3 {{ ($ContentID == 0 ? ' hidden' : '') }}">
			<div class="block bg-light">
				<div class="content controls" style="overflow:visible">
					<div class="form-row">
						<div class="header">
							<h2 class="header" style="text-align:center;">{{ __('common.contents_coverimage') }}</h2>
						</div>
						<div class="form-row" style="text-align:center;">
							<img id="imgPreview" src="/{{ Session::get('language') }}/{{ __('route.contents_request') }}?RequestTypeID=1101&ContentID={{ $ContentID }}" width="200" />
						</div>
						<blockquote style="border-left:none; font-size:16px;">
							<p class="reportSubtitle">{{ __('common.contents_tooltip_coverimage') }}</p>
						</blockquote>
						<div class="fileupload_container">
							<div class="input-group file" style="margin: 0 auto;"> 
								<input type="file" name="CoverImageFile" id="CoverImageFile" class="hidden" />

								<div id="CoverImageFileButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
									<div id="File-button" class="uploadify-button " style="height: 30px; line-height: 30px; width: 120px;">
										<span class="uploadify-button-text">{{ __('common.contents_coverimage_select') }}</span>
									</div>
								</div>

								<div for="CoverImageFile" class="myProgress hide">
						        	<a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
						            <label for="scale"></label>
						            <div class="scrollbox dot">
						                <div class="scale" style="width: 0%"></div>
						            </div>
						        </div>

							</div>
							<input type="hidden" name="hdnCoverImageFileSelected" id="hdnCoverImageFileSelected" value="0" />
							<input type="hidden" name="hdnCoverImageFileName" id="hdnCoverImageFileName" value="" />
							<script type="text/javascript">
								<!--
								$(function(){

									if($("html").hasClass("lt-ie10") || $("html").hasClass("lt-ie9") || $("html").hasClass("lt-ie8"))
									{
										$("#CoverImageFile").uploadify({
											'swf': '/uploadify/uploadify.swf',
											'uploader': '/' + $('#currentlanguage').val() + '/' + route["contents_uploadcoverimage2"],
											'cancelImg': '/uploadify/uploadify-cancel.png',
											'fileTypeDesc': 'Image Files',
											'fileTypeExts': '*.jpg;*.png;*.gif;*.jpeg',
											'buttonText': "{{ __('common.contents_coverimage_select') }}",
											'multi': false,
											'auto': true,
											'successTimeout': 300,
											'onSelect': function (file) {
												$('#hdnCoverImageFileSelected').val("1");
												$("[for='CoverImageFile']").removeClass("hide");
											},
											'onUploadProgress': function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
												var progress = totalBytesUploaded / totalBytesTotal * 100;
												$("[for='CoverImageFile'] label").html(progress.toFixed(0) + '%');
												$("[for='CoverImageFile'] div.scale").css('width', progress.toFixed(0) + '%');
											},
											'onUploadSuccess': function (file, data, response) {

												if(data.getValue("success") == "true")
												{
													var fileName = data.getValue("filename");

													$('#hdnCoverImageFileName').val(fileName);
													$('#imgPreview').attr("src", "/files/temp/" + fileName);
													$("[for='CoverImageFile']").addClass("hide");
												}
											},
											'onCancel': function(file) {
												$("[for='CoverImageFile']").addClass("hide");
											}
										});
									}
									else
									{
										$("#CoverImageFile").fileupload({
											url: '/' + $('#currentlanguage').val() + '/' + route["contents_uploadcoverimage"],
											dataType: 'json',
											sequentialUploads: true,
											formData: { 
												'element': 'CoverImageFile'
											},
											add: function(e, data)
											{
												if(/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name))
												{
													$('#hdnCoverImageFileSelected').val("1");
													$("[for='CoverImageFile']").removeClass("hide");

													data.context = $("[for='CoverImageFile']");
													data.context.find('a').click(function(e){
														e.preventDefault();
														var template = $("[for='CoverImageFile']");
														data = template.data('data') || {};
														if(data.jqXHR)
														{
															data.jqXHR.abort();
														}
													});
													var xhr = data.submit();
													data.context.data('data', { jqXHR: xhr });
												}
											},
											progressall: function(e, data)
											{
												var progress = data.loaded / data.total * 100;
												
												$("[for='CoverImageFile'] label").html(progress.toFixed(0) + '%');
												$("[for='CoverImageFile'] div.scale").css('width', progress.toFixed(0) + '%');
											},
											done: function(e, data)
											{
												if(data.textStatus == 'success')
												{
													//var fileName = data.result['CoverImageFile'][0].name;
													var fileName = data.result.fileName;

													$('#hdnCoverImageFileName').val(fileName);
													$('#imgPreview').attr("src", "/files/temp/" + fileName);
													$("[for='CoverImageFile']").addClass("hide");
												}
											},
											fail: function(e, data)
											{
												$("[for='CoverImageFile']").addClass("hide");
											}
										});
										
										//select file
										$("#CoverImageFileButton").removeClass("hide").click(function(){
											
											$("#CoverImageFile").click();
										});
									}

								});
								// -->
							</script>
						</div>
					</div>
				</div>
			</div>           
		</div>
    {{ Form::close() }}

    <div class="modal" id="dialog-category-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ __('common.contents_category_title') }}</h4>
                </div>
                <div class="list_container">
	                <table class="table table-bordered table-striped table-hover">
	                    <colgroup>
	                        <col />
	                        <col width="100px" />
	                    </colgroup>
	                    <thead>
	                        <tr>
	                            <th>{{ __('common.contents_category_column2') }}</th>
	                            <th>{{ __('common.contents_category_column3') }}</th>
	                        </tr>
	                    </thead>
	                    <tbody></tbody>
	                </table>
                </div>
				<div class="cta_container">
					<div class="modal-footer modal-footer-categoryList">
						<div class="col-md-5" style="float:right;">
							<input type="button" value="{{ __('common.contents_category_new') }}" class="btn my-btn-default" onclick="cContent.addNewCategory();" />
						</div>
					</div>				
				</div>
				<div class="form_container hidden">
					{{ Form::open(__('route.categories_save'), 'POST') }}
        			{{ Form::token() }}
                    <input type="hidden" name="CategoryCategoryID" id="CategoryCategoryID" value="" />
                    <input type="hidden" name="CategoryApplicationID" id="CategoryApplicationID" value="" />
                    <div class="modal-footer modal-footer-categoryList">
	                    <div class="form-row">
	                        <div class="col-md-4">
	                        	<label for="CategoryName">{{ __('common.contents_category_name') }}</label>
	                        </div>
	                        <div class="col-md-8">
	                        	<input type="text" name="CategoryName" id="CategoryName" class="form-control textbox required" value="" />
	                        </div>
	                    </div>
	                    <div class="form-row">
								<div class="col-md-4" style="float:right;">
		                    		<input type="button" value="{{ __('common.detailpage_save') }}" class="btn my-btn-success" onclick="cContent.saveCategory();" />
								</div>
								<div class="col-md-4" style="float:right;">
		                    		<input type="button" value="{{ __('common.contents_category_button_giveup') }}" class="btn my-btn-default" onclick="cContent.giveup();" />
								</div>
						</div>
					</div>
					{{ Form::close() }}
				</div>	
            </div>
        </div>
    </div>

	<div class="modal" id="dialog-password-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ __('common.contents_password_title') }}</h4>
                </div>
                <div class="list_container">
	                <table class="table table-bordered table-striped table-hover">
	                    <colgroup>
	                        <col/>
	                        <col/>
	                        <col/>
	                    </colgroup>
	                    <thead>
	                        <tr>
	                        	<th>{{ __('common.contents_password_column2') }}</th>
	                            <th>{{ __('common.contents_password_column3') }}</th>
	                            <th>{{ __('common.contents_password_column4') }}</th>
	                        </tr>
	                    </thead>
	                    <tbody></tbody>
	                </table>
                </div>
				<div class="cta_container">
					<div class="modal-footer modal-footer-categoryList">
						<div class="col-md-5" style="float:right;">
							<input type="button" value="{{ __('common.contents_password_new') }}" class="btn my-btn-default" onclick="cContent.addNewPassword();" />
						</div>
					</div>				
				</div>
				<div class="form_container hidden">
					{{ Form::open(__('route.categories_save'), 'POST') }}
        			{{ Form::token() }}
                    <input type="hidden" name="ContentPasswordID" id="ContentPasswordID" value="" />
                    <input type="hidden" name="ContentPasswordContentID" id="ContentPasswordContentID" value="" />
                    <div class="modal-footer modal-footer-categoryList">
                    	<div class="form-row">
	                        <div class="col-md-4">
	                        	<label for="ContentPasswordName">{{ __('common.contents_password_name') }}</label>
	                        </div>
	                        <div class="col-md-8">
	                        	<input type="text" name="ContentPasswordName" id="ContentPasswordName" class="form-control textbox required" value="" />
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4">
	                        	<label for="ContentPasswordPassword">{{ __('common.contents_password_pwd') }}</label>
	                        </div>
	                        <div class="col-md-8">
	                        	<input type="password" name="ContentPasswordPassword" id="ContentPasswordPassword" class="form-control textbox required" value="" />
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4">
	                        	<label for="ContentPasswordQty">{{ __('common.contents_password_qty') }}</label>
	                        </div>
	                        <div class="col-md-8">
	                        	<input type="number" name="ContentPasswordQty" id="ContentPasswordQty" class="form-control textbox required" value="" />
	                        </div>
	                    </div>
	                    <div class="form-row">
								<div class="col-md-4" style="float:right;">
		                    		<input type="button" value="{{ __('common.detailpage_save') }}" class="btn my-btn-success" onclick="cContent.savePassword();" />
								</div>
								<div class="col-md-4" style="float:right;">
		                    		<input type="button" value="{{ __('common.contents_password_button_giveup') }}" class="btn my-btn-default" onclick="cContent.giveup();" />
								</div>
						</div>
					</div>
					{{ Form::close() }}
				</div>	
            </div>
        </div>
    </div>

    <div class="modal" id="dialog-category-warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="icon-warning-sign" style="color:#ebaf3c;"></span> {{ __('common.contents_category_warning_title') }}</h4>
                </div>
                <div class="modal-body">
	                {{ __('common.contents_category_warning_content') }}
                </div>
				<div class="modal-footer">
					<div class="col-md-5" style="float:right;">
						<input type="button" value="{{ __('common.contents_category_warning_ok') }}" class="btn my-btn-default" data-dismiss="modal" />
					</div>
				</div>
            </div>
        </div>
    </div>

	<div class="modal modal-info" id="modal_default_10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ __('common.contents_delete_question') }}</h4>
                </div>                
                <div class="modal-footer">
					<button type="button" class="btn btn-default btn-clean" data-dismiss="modal" onclick="cContent.erase();" style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>				
                    <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection