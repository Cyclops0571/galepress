@layout('layouts.master')

@section('content')
<?php
if (false) {
	$application = new Application();
	$tabs = new Tab();
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
			<input type="hidden" name="ApplicationID" value="<?php echo $application->ApplicationID; ?>"?>
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
								<input name="BannerActive" type="checkbox" value="1" <?php echo $application->BannerActive ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span class="icon-info-sign"></span></a></div>
			</div>


			<div class="form-row" style="border-bottom: 1px solid #565656;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid black;">{{ __('common.application_settings_caption_tab') }}</div>
			</div>
			<!-- Tab Status -->
			<div class="form-row">
				<div class="col-md-3">{{ __('common.tabs_tab_status') }}</div>
				<div class="col-md-8">
					<div class="checkbox-inline" style="padding-left:0;">
						<div class="checker">
							<span>
								<input name="TabActive" type="checkbox" value="1" <?php echo $application->TabActive ? 'checked' : ''; ?>>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_tab_status') }}"><span class="icon-info-sign"></span></a></div>
			</div>
			<?php $tabNo = 1; ?>
			<?php foreach ($tabs as $tab): ?>
				<div class="form-row" style="border-bottom: 1px solid #565656;">
					<div class="col-md-12 text-center" style="border-bottom: 1px solid black;">Tab <?php echo $tabNo; ?></div>
				</div>
				<div class="form-row">
					<div class="col-md-3">{{ __('common.tabs_url') }}</div>
					<div class="col-md-8">
						<div class="input-group file">                                    
							<input type="text" id="TargetUrl_<?php echo $tabNo; ?>" class="form-control" name="Url_<?php echo $tabNo; ?>" value="<?php echo $tab->Url; ?>" placeholder="<?php echo "galepress.com"; ?>" style="height:35px;"/>
							<span class="input-group-btn">
								<button class="btn btn-primary urlCheck" type="button" id="checkUrl_<?php echo $tabNo; ?>" onclick="cApplication.checkUrl(this);"><span class="icon-ok"></span></button>
							</span>
						</div>
						<span class="error urlError hide" style="color:red;">{{__('interactivity.link_error')}}</span>
					</div>
					<div class="col-md-1"><a class="tipr" title="{{ __('common.tabs_info_url') }}"><span class="icon-info-sign"></span></a></div>
				</div>

				<div class="form-row">
					<div class="col-md-3">{{ __('common.tabs_inhouse_url') }}</div>
					<div class="col-md-8">
						<select style="width: 100%;" tabindex="-1" id="InhouseUrl_<?php echo $tabNo; ?>" name="InhouseUrl_<?php echo $tabNo; ?>" class="form-control select2" onchange="cApplication.InhouseUrlChange(this);">
							<option value=""<?php echo (empty($tab->InhouseUrl) ? ' selected="selected"' : '') ?>></option>
							<option value="0">Seçiniz...</option>
							<?php foreach ($galepressTabs as $tabKey => $tabValue): ?>
								<option value="{{ $tabKey }}"{{ ($tabKey == $tab->InhouseUrl ? ' selected="selected"' : '') }}>{{ $tabValue }}</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_inhouse_url') }}"><span class="icon-info-sign"></span></a></div>
				</div>

				<div class="form-row">
					<div class="col-md-3">{{ __('common.tabs_icon') }}</div>
					<div class="col-md-8">
						<input type="hidden" name="hiddenSelectedIcon_<?php echo $tabNo ?>" value="<?php echo $tab->IconUrl; ?>" />
						<a href="#" rel="popover" id="selectedIcon_<?php echo $tabNo ?>" class="btn selectedIcon" data-popover-content="#myPopover_<?php echo $tabNo ?>">
							<?php $imgSrc = !empty($tab->IconUrl) ? $tab->IconUrl : '/img/app-icons/1.png'; ?>
							<img id="imgSelectedIcon_<?php echo $tabNo; ?>" src="<?php echo $imgSrc; ?>" width="30"/>
						</a>
						<div id="myPopover_<?php echo $tabNo ?>" class="hide">
							<ul class="iconList myIconClass_<?php echo $tabNo;?>">
								<?php for ($i = 1; $i < 14; $i++): ?>
									<li><button type="button" class="btn"><img src="/img/app-icons/<?php echo $i ?>.png" width="30" /></button></li>
								<?php endfor; ?>
							</ul>
						</div>
						<script type="text/javascript">
						cApplication.selectedIcon(<?php echo $tabNo; ?>);
						</script>
					</div>
					<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_icon') }}"><span class="icon-info-sign"></span></a></div>
				</div>

				<div class="form-row">
					<div class="col-md-3">{{ __('common.tabs_active') }}</div>
					<div class="col-md-8">
						<div class="checkbox-inline" style="padding-left:0;">
							<div class="checker">
								<span>
									<input name="TabStatus_<?php echo $tabNo; ?>" type="checkbox" value="1" <?php echo $tab->Status == eStatus::Active ? 'checked' : ''; ?>>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_icon') }}"><span class="icon-info-sign"></span></a></div>
				</div>

				<?php $tabNo++; ?>
			<?php endforeach; ?>



			<div class="form-row" style="border-top: 1px solid black;">
				<div class="col-md-12 text-center" style="border-bottom: 1px solid #565656;"></div>
			</div>
			<div class="form-row">
				<div class="col-md-3 col-md-offset-8">
					<input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cApplication.saveUserSettings();" />
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