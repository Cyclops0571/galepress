	
@if(Auth::User()->UserTypeID != eUserTypes::Manager)
<!--BANNER SLIDER-->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" href="/css/masterslider/style/masterslider.css" />
<link href="/css/masterslider/skins/black-2/style.css" rel='stylesheet' type='text/css'>
<link href='/css/masterslider/style/ms-gallery-style.css' rel='stylesheet' type='text/css'>

<script src="/js/masterslider/jquery.easing.min.js"></script>
<script src="/js/masterslider/masterslider.min.js"></script>

<!--BANNER SLIDER-->
	
<div class="modal in" id="modalTemplateChooser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; overflow:hidden;">
	<div class="modal-dialog" style="width:40%; margin-top:0 !important; padding-top:0 !important;">
		<div class="modal-content">
			<div class="modal-body clearfix">
				<div class="controls">
					<div class="content controls">
						<div id="ipadView"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<!-- Tema seçici için sayfanın sağında çıkan filtrelemeyle ilgili açılır kapanır bölüm. -->
<div class="site-settings" id="templateChooserBox">
	<!-- <div class="site-settings-button"><span class="icon-tablet" style="font-size:30px; line-height:39px;"></span></div> -->
	<div class="block block-transparent bg-light nm filterBlock">                
		<div class="header" style="height:35px; line-height:35px; border-bottom:1px solid black;">
			<h2 style="text-transform: capitalize;">{{ __('common.template_chooser_title') }}</h2>
		</div>
		<div class="content controls reportSubtitle">
			<form id="templateForm" method="get">
				<input type="hidden" name="applicationID" value="<?php echo Input::get("applicationID", 0)?>" />
				<div class="form-row">
					<div class="col-md-12">{{ __('common.template_chooser_background') }}:</div>
					<!-- <div class="col-md-12">
						<div class="input-group">
							<div class="input-group-addon"><span class="icon-dropbox"></span></div>
							<select style="width: 100%;" tabindex="-1" id="templateBackgroundChange" class="form-control select2">
								<option value="0">Light</option>
								<option value="1">Dark</option>
							</select>
						</div>
					</div> -->
					<div class="form-row">
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label>
									<div class="radio"><input type="radio" class="templateBackgroundChange" name="templateBackground" value="1"></div>
									{{ __('common.template_chooser_backcolor1') }}<img src="/img/template-chooser/color-picker-dark.png" width="15" style="margin-left:10px;"></label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label>
									<div class="radio"><input type="radio" class="templateBackgroundChange" name="templateBackground" value="2"></div>
									{{ __('common.template_chooser_backcolor2') }}<img src="/img/template-chooser/color-picker-light.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-row" style="border-bottom:1px solid black; padding-bottom:10px;">
					<div class="col-md-12">{{ __('common.template_chooser_foreground') }}:</div>
					<!-- <div class="col-md-12">
						<div class="input-group">
							<div class="input-group-addon"><span class="icon-cloud"></span></div>
							<select style="width: 100%;" tabindex="-1" id="templateForegroundChange" class="form-control select2">
								<option value="0" style="color:#2185C5">Blue</option>
								<option value="1" style="color:#6D6D6D">Gray</option>
								<option value="2" style="color:#049604">Green</option>
								<option value="3" style="color:#FF5500" selected>Orange</option>
								<option value="4" style="color:#B9121B">Red</option>
								<option value="5" style="color:#FFCE00">Yellow</option>
							</select>
						</div>
					</div> -->
					<div class="form-row">
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label style="color:#2980B9;">
									<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="1"></div>
									{{ __('common.template_chooser_frontcolor3') }}<img src="/img/template-chooser/color-picker-blue.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label style="color:#00A388;">
									<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="2"></div>
									{{ __('common.template_chooser_frontcolor1') }}<img src="/img/template-chooser/color-picker-green.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label style="color:#E2B705;">
									<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="3"></div>
									{{ __('common.template_chooser_frontcolor2') }}<img src="/img/template-chooser/color-picker-yellow.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label style="color:#AB2626;">
									<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="4"></div>
									{{ __('common.template_chooser_frontcolor4') }}<img src="/img/template-chooser/color-picker-red.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="radiobox-inline">
								<label style="color:#E74C3C;">
									<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="5"></div>
									{{ __('common.template_chooser_frontcolor5') }}<img src="/img/template-chooser/color-picker-orange.png" width="15" style="margin-left:10px;">
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-row text-center">
					<div class="btn-group">
                      <button type="button" id="templateChooserClose" class="btn">{{ __('common.template_chooser_close') }}</button>
                      <button type="button" class="btn my-btn-success" onclick="cTemplate.save();">{{ __('common.template_chooser_use') }}</button>
                    </div>
				</div>
			</form>
		</div>                 
	</div>
</div>                  
<script type="text/javascript">
$(function () {
    var ApplicationID = <?php echo $application->ApplicationID; ?>;
    var ThemeBackground = <?php echo $application->ThemeBackground; ?>;
    var ThemeForeground = <?php echo $application->ThemeForeground; ?>;
    var Autoplay = <?php echo $application->BannerAutoplay; ?>;
    var Speed = <?php echo $application->BannerTransitionRate; ?>;
    cTemplate.show(ApplicationID, ThemeBackground, ThemeForeground, Autoplay, Speed);
});
</script>
@endif   