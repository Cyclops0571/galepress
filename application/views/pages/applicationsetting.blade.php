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
    {{ Form::open(__('route.applications_save'), 'POST') }}
    {{ Form::token() }}   
    <div class="block block-drop-shadow">
	<div class="header">
	    <h2>{{ __('common.application_settings_caption_template') }}</h2>
	</div>
	<div class="content controls">
	    <input type="hidden" name="ApplicationID" value="<?php echo $application->ApplicationID; ?>"?>
	    <div class="form-row" style="border-bottom: 1px solid #565656; margin-top:0;">
		<div class="col-md-12 text-center" style="border-bottom: 1px solid black;"></div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.template_chooser_background') }}</div>
		<div class="col-md-8">
		    <select name="ThemeBackground" class="form-control select2" style="width: 100%;" tabindex="-1">
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
		    <select name="ThemeForeground" class="form-control select2" style="width: 100%;" tabindex="-1">
			<?php foreach(eTemplateColor::colorSet() as $colorKey => $colorName): ?>
			    <option value="<?php echo $colorKey; ?>" <?php echo $application->ThemeForeground == $colorKey ? "selected" : ''; ?> >
				    <?php echo eTemplateColor::colorName($colorKey); ?>
			    </option>
			<?php endforeach; ?>
		    </select>
		</div>
		<div class="col-md-1"><a  class="tipr" title="{{ __('common.application_settings_template_foreground_tip') }}"><span class="icon-info-sign"></span></a></div>
	    </div>
	</div>
    </div>
    <div class="block block-drop-shadow">
	<div class="content controls">
	    <div class="form-row">
		<div class="col-md-11">
		    {{ __('common.application_settings_caption_banner') }}
		</div>
		<div class="col-md-1">
		    <a class="btn active" href="<?php echo Laravel\URL::to(__('route.banners') . '?applicationID=' . $application->ApplicationID); ?>" title="Banner"  class=" page-navigation">
			<span class="icon-arrow-right">
			</span>
		    </a>
		</div>
	    </div>
	</div>
    </div>

    <div class="block block-drop-shadow">
	<div class="header">
	    <h2>{{ __('common.application_settings_caption_tab') }}</h2>
	</div>
	<div class="content controls">
	    <div class="form-row" style="border-bottom: 1px solid #565656; margin-top:0;">
		<div class="col-md-12 text-center" style="border-bottom: 1px solid black;"></div>
	    </div>
	    <!-- Tab Status -->
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.tabs_tab_status') }}</div>
		<div class="col-md-8">
		    <div class="checkbox-inline" style="padding-left:0;">
			<div class="checker">
			    <span>
				<input name="TabActive" id="TabActive" onchange="cApplication.checkTabStatus()" type="checkbox" value="1" <?php echo $application->TabActive ? 'checked' : ''; ?>>
			    </span>
			</div>
		    </div>
		</div>
		<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_tab_status') }}"><span class="icon-info-sign"></span></a></div>
	    </div>
	    <?php $tabNo = 1; ?>
	    <?php foreach ($tabs as $tab): ?>
    	    <div class="form-row">
    		<div class="col-md-5 text-center" style="height:30px; padding-right:0">
    		    <hr style="border-top: 1px solid black; border-bottom: 1px solid #565656; margin-top:15px;">
    		</div>
    		<div class="col-md-2 text-center">Tab <?php echo $tabNo; ?></div>
    		<div class="col-md-5 text-center" style="height:30px; padding-left:0">
    		    <hr style="border-top: 1px solid black; border-bottom: 1px solid #565656; margin-top:15px;">
    		</div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3">{{ __('common.tabs_title')}}</div>
    		<div class="col-md-8">
    		    <input type="text" name="TabTitle_<?php echo $tabNo; ?>" id="TabTitle_<?php echo $tabNo; ?>" value="<?php echo $tab->TabTitle; ?>" maxlength="12" />
    		</div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3">{{ __('common.tabs_inhouse_url') }}</div>
    		<div class="col-md-8">
    		    <select style="width: 100%;" tabindex="-1" id="InhouseUrl_<?php echo $tabNo; ?>" name="InhouseUrl_<?php echo $tabNo; ?>" class="form-control select2 inhouseUrl" onchange="cApplication.InhouseUrlChange(this);">
			    <?php foreach ($galepressTabs as $tabKey => $tabValue): ?>
				<option value="0"{{ (empty($tab->InhouseUrl) ? ' selected="selected"' : '') }}>{{ __('common.tabs_url') }}</option>
				<option value="{{$tabKey}}"{{ ($tabKey == $tab->InhouseUrl ? ' selected="selected"' : '') }}>{{ $tabValue }}</option>
			    <?php endforeach; ?>
    		    </select>
    		</div>
    		<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_inhouse_url') }}"><span class="icon-info-sign"></span></a></div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3">{{ __('common.tabs_url') }}</div>
    		<div class="col-md-8">
    		    <div class="input-group file">                                    
    			<input type="text" id="TargetUrl_<?php echo $tabNo; ?>" class="form-control targetUrlCount" name="Url_<?php echo $tabNo; ?>" value="<?php echo $tab->Url; ?>" placeholder="<?php echo "galepress.com"; ?>" style="height:35px;"/>
    			<span class="input-group-btn">
    			    <button class="btn btn-primary urlCheck" type="button" id="checkUrl_<?php echo $tabNo; ?>" onclick="cApplication.checkUrl(this);"><span class="icon-ok"></span></button>
    			</span>
    		    </div>
    		    <span class="error urlError hide" style="color:red;">{{__('interactivity.link_error')}}</span>
    		</div>
    		<div class="col-md-1"><a class="tipr" title="{{ __('common.tabs_info_url') }}"><span class="icon-info-sign"></span></a></div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3">{{ __('common.tabs_icon') }}</div>
    		<div class="col-md-8">
    		    <input type="hidden" name="hiddenSelectedIcon_<?php echo $tabNo ?>" value="<?php echo $tab->IconUrl; ?>" />
    		    <a href="#" rel="popover" id="selectedIcon_<?php echo $tabNo ?>" class="btn selectedIcon" data-popover-content="#myPopover_<?php echo $tabNo ?>">
			    <?php $imgSrc = !empty($tab->IconUrl) ? $tab->IconUrl : '/img/app-icons/1.png'; ?>
    			<img id="imgSelectedIcon_<?php echo $tabNo; ?>" src="<?php echo $imgSrc; ?>" width="25"/>
    		    </a>
    		    <div id="myPopover_<?php echo $tabNo ?>" class="hide">
    			<ul class="iconList myIconClass_<?php echo $tabNo; ?>">
				<?php for ($i = 1; $i < 8; $i++): ?>
				    <li><button type="button" class="btn"><img src="/img/app-icons/<?php echo $i ?>.png" width="25" /></button></li>
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
    				<input name="TabStatus_<?php echo $tabNo; ?>" class="tabActiveCheck" type="checkbox" value="1" <?php echo $tab->Status == eStatus::Active ? 'checked' : ''; ?>>
    			    </span>
    			</div>
    		    </div>
    		</div>
    		<div class="col-md-1"><a  class="tipr" title="{{ __('common.tabs_info_icon') }}"><span class="icon-info-sign"></span></a></div>
    	    </div>
		<?php $tabNo++; ?>
	    <?php endforeach; ?>
	</div>
    </div>

    <div class="block block-drop-shadow">
	<div class="header" style="border-bottom: 1px solid black">
	    <h2>{{ __('common.application_settings_subscription') }}</h2>
	</div>
	<div class="content controls">
	    <?php foreach (Subscription::types() as $key => $value): ?> 
    	    <div class="form-row" style="border-bottom: 1px solid #565656">
    		<div class="col-md-12"> <?php echo __("clients." . $value); ?></div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3"><?php echo __('common.active'); ?></div>
    		<div class="col-md-8">
    		    <input name="SubscriptionStatus_<?php echo $key; ?>" type="checkbox" value="1" <?php echo $application->subscriptionStatus($key) == eStatus::Active ? 'checked' : ''; ?>>
    		</div>
    		<div class="col-md-1"><a  class="tipr" title="<?php echo __('clients.active_info_' . $value) ?>"><span class="icon-info-sign"></span></a></div>
    	    </div>
    	    <div class="form-row">
    		<div class="col-md-3"><?php echo __('clients.identifier'); ?></div>
    		<div class="col-md-8">
    		    <div class="input-group">
    			<input type="text" id="SubscriptionIdenfier_<?php echo $key; ?>"  value="<?php echo $application->SubscriptionIdentifier($key); ?>" readonly="readonly">
    			<span class="input-group-btn">
    			    <button class="btn btn-primary urlCheck" type="button" onclick="cApplication.refreshSubscriptionIdentifier(<?php echo $application->ApplicationID; ?>, <?php echo $key; ?>);">
    				<span class="icon-refresh"></span>
    			    </button>
    			</span>
    		    </div>
    		</div>
    		<div class="col-md-1"><a  class="tipr" title="<?php echo __('clients.identifier_info_' . $value) ?>"><span class="icon-info-sign"></span></a></div>
    	    </div>
	    <?php endforeach; ?>
	</div>
    </div>

    <div class="block block-drop-shadow">
	<div class="content controls">
	    <div class="form-row row-save">
		<div class="col-md-3 col-md-offset-8">
		    <input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cApplication.saveUserSettings();" />
		</div>           
	    </div>
	</div>
    </div>
    {{ Form::close() }}
</div>
<div class="col-md-6">
    <div id="ipadView"></div>
</div>
<div class="modal" id="dialog-tab-active-warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="icon-warning-sign" style="color:#ebaf3c;"></span>&nbsp;Web Link Geçerli Değil!</h4>
            </div>
            <div class="modal-body">

            </div>
	    <div class="modal-footer">
		<div class="col-md-5" style="float:right;">
		    <input type="button" value="{{ __('common.contents_category_warning_ok') }}" class="btn my-btn-default" data-dismiss="modal" />
		</div>
	    </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
	var ApplicationID = $('input[name=ApplicationID]').val();
	var ThemeBackground = $('select[name=ThemeBackground] option:selected').val();
	var ThemeForeground = $('select[name=ThemeForeground] option:selected').val();
	var Autoplay = $('input[name=BannerAutoplay]').is(':checked');
	var Speed = $('input[name=BannerTransitionRate]').val();
	cTemplate.show(ApplicationID, ThemeBackground, ThemeForeground, Autoplay, Speed);
	cApplication.setSelectInputActive();
	cApplication.BannerActive();
	cApplication.BannerCustomerActive();
	cApplication.checkTabStatus();
	// cApplication.checkHoverBlock();
	$('#dialog-tab-active-warning').on('shown.bs.modal', function () {
	    var text = $('#dialog-tab-active-warning .modal-body').text().replace("[[innerText]]", '{{ __("common.tabs_warning_url")}}');
	    $('#dialog-tab-active-warning .modal-body').text(text);
	});

	$('.money').mask('000.000.000.000.000,00', {reverse: true, placeholder: "00,00"});
    });
</script>
@endsection