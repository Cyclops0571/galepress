@layout('layouts.master')

@section('content')
<?php
if (false) {
	$application = new Application();
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
<div class="col-md-6">    
	<div class="block block-drop-shadow bg-light-rtl">
		<div class="header">
			<h2>{{ __('common.application_settings_caption_detail_big') }}</h2>
		</div>
		<div class="content controls">
			{{ Form::open(__('route.applications_save'), 'POST') }}
			{{ Form::token() }}
			<div class="form-row" style="border-bottom: 1px solid #565656;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid black;">{{ __('common.application_settings_caption_template') }}</div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{ __('common.template_chooser_background') }}</div>
				<div class="col-md-8">
					<select class="form-control select2" style="width: 100%;" tabindex="-1">
						<option value="1" <?php echo $application->ThemeBackground == 1 ? "selected" : ''; ?> >
							{{ __('common.template_chooser_backcolor1') }}
						</option>
						<option value="2" <?php echo $application->ThemeBackground == 2 ? "selected" : ''; ?> >
							{{ __('common.template_chooser_backcolor2') }}
						</option>
					</select>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.application_settings_template_background_tip') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{ __('common.template_chooser_foreground') }}</div>
				<div class="col-md-8">
					<select class="form-control select2" style="width: 100%;" tabindex="-1">
						<option value="1" <?php echo $application->ThemeForeground == 1 ? "selected" : ''; ?> >{{ __('common.template_chooser_frontcolor3') }}</option>
						<option value="2" <?php echo $application->ThemeForeground == 2 ? "selected" : ''; ?> >{{ __('common.template_chooser_frontcolor1') }}</option>
						<option value="3" <?php echo $application->ThemeForeground == 3 ? "selected" : ''; ?> >{{ __('common.template_chooser_frontcolor2') }}</option>
						<option value="4" <?php echo $application->ThemeForeground == 4 ? "selected" : ''; ?> >{{ __('common.template_chooser_frontcolor4') }}</option>
						<option value="5" <?php echo $application->ThemeForeground == 5 ? "selected" : ''; ?> >{{ __('common.template_chooser_frontcolor5') }}</option>
					</select>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.application_settings_template_foreground_tip') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row" style="border-bottom: 1px solid #565656;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid black;">{{ __('common.application_settings_caption_banner') }}</div>
			</div>
			<div class="form-row">
				<div class="col-md-3">{{__('common.banners_autoplay')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline" style="padding-left:0;">
						<div class="checker">
							<span>
								<input name="BannerAutoplay" type="checkbox" value="1" <?php echo $application->BannerAutoplay ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
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
			<div class="form-row">
				<div class="col-md-3">{{__('common.contents_status')}}</div>
				<div class="col-md-8">
					<div class="checkbox-inline" style="padding-left:0;">
						<div class="checker">
							<span>
								<input name="Status" type="checkbox" value="1" <?php echo $application->BannerActive ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<div class="form-row" style="border-bottom: 1px solid #565656;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid black;">{{ __('common.application_settings_caption_tab') }}</div>
			</div>

			<div class="form-row">
				<div class="col-md-3">Tab Status</div>
				<div class="col-md-8">
					<div class="checkbox-inline" style="padding-left:0;">
						<div class="checker">
							<span>
								<input name="Status" type="checkbox" value="1" <?php echo $application->BannerActive ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			
			<div class="form-row">
				<div class="col-md-3">Tab 1</div>
				<div class="col-md-8">
					<div class="checkbox-inline" style="padding-left:0;">
						<div class="checker">
							<span>
								<input name="Status" type="checkbox" value="1" <?php echo $application->BannerActive ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>

			<div class="form-row" style="border-top: 1px solid black;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid #565656;"></div>
			</div>
			<div class="form-row">
				<div class="col-md-3 col-md-offset-8">
					<input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" />
				</div>           
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
<div class="col-md-6">
	<div id="ipadView"></div>
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
@endsection