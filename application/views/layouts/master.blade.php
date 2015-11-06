@layout('layouts.html')

@section('head')
@parent
@endsection

@section('body')
<body class="bg-img-num1">
    <div class="container content-list">
        <div class="row">
            <input type="hidden" id="currentlanguage" value="{{ Session::get('language') }}" />
            <div class="loader-big hidden"></div>
            @include('sections.header')
        </div>
        <div class="row">
            <div class="page-container">
                <div class="page-sidebar">
                    @include('sections.sidebar')
                </div>          
		<div class="page-content">
                    @_yield('content')
                </div>
		    @include('sections.support')
            </div>
        </div>
        <div class="row">
	    <br>
        </div>
    </div>

    <div class="statusbar hidden" id="myNotification">
        <div class="statusbar-icon" style="margin-left:41%"><span></span></div>
        <div class="statusbar-text">
            <span class="text"></span>
            <span class="detail"></span>
        </div>
        <div class="statusbar-close icon-remove" onclick="cNotification.hide()"></div>
    </div>

    <div class="modal in" id="modalChangeLanguage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalClose()">×</button>
                    <h4 class="modal-title">{{ __('common.site_lang_settings') }}</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="controls">
                        <div class="form-row">
                            <div class="col-md-12">
				<?php foreach(Laravel\Config::get('application.languages') as $lang): ?>
                                <div class="checkbox">
                                    <label>
					<div class="radio">
					    <span id="radio_<?php echo $lang; ?>" <?php echo Laravel\Config::get('application.language') === $lang ? 'class="checked"' : ''; ?> >
						<input type="radio" class="hidden" onclick='LanguageActive(<?php echo json_encode($lang); ?>);'>
					    </span>
					</div>
					<img src="/img/flags/<?php echo $lang;?>_icon.png" />
				    </label>
                                </div>
				<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal in" id="modalPushNotification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">{{ __('common.pushnotify_caption') }}</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="controls">
                        {{ Form::open(__('route.applications_pushnotification'), 'POST', array('id' => 'formPushNotification')) }}
			{{ Form::token() }}
			<div class="content controls">
			    <div class="form-row">
				<div class="col-md-4">{{ __('common.pushnotify_detail') }} <span class="error">*</span></div>                        
				<div class="col-md-8">
				    <?php
				    $applicationID = (int) Input::get('applicationID', '0');
				    $notificationText = __('common.applications_defaultnotificationtext');
				    $chk = Common::CheckApplicationOwnership($applicationID);
				    if ($chk) {
					$s = Application::find($applicationID);
					if ($s) {
					    $notificationText = $s->NotificationText;
					}
				    }
				    ?>
				    <input type="hidden" class="form-control textbox required" name="ApplicationID" value="{{ $applicationID }}" />
				    <input type="text" class="form-control textbox required" name="NotificationText" value="{{ $notificationText }}" />
				</div>
			    </div>
			    <div class="form-row">
				<input class="btn my-btn-send pull-right col-md-3"  style="margin-right:9px;" type="button" onclick="cApplication.pushNotification();" value="{{ __('common.pushnotify_send') }}">
			    </div>
			</div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset(Request::route()->action['as']) && Request::route()->action['as'] == 'contents')
    {{ View::make('sections.templatechooser', array("templateResults" => $templateResults,"application" => $application, "categorySet"=> $categorySet)); }}
    @endif
    @if(isset(Request::route()->action['as']) && Request::route()->action['as'] == 'maps_list')
    {{ View::make('sections.mapslist') }}
    @endif
    {{ View::make('sections.sessionmodal') }}
</body>

@endsection