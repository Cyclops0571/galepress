<div class="col-md-5 pull-left">
    <div class="col-md-offset-0 input-group commands">
        <?php if ((int)Input::get('customerID', 0) > 0): ?>
        <a href="{{URL::to(__('route.'.$page.'_new').'?customerID='.Input::get('customerID', 0))}}"
           title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php elseif ((int)Input::get('applicationID', 0) > 0): ?>
        <a href="{{URL::to(__('route.'.$page.'_new').'?applicationID='.Input::get('applicationID', 0))}}"
           title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php if (isset(Request::route()->action['as']) && Request::route()->action['as'] == 'contents'): ?>
        <a href="#modalPushNotification" title="Push Notification" data-toggle="modal"
           data-target="#modalPushNotification" class="widget-icon widget-icon-circle">
            <span class="icon-bullhorn"></span>
        </a>
        <?php $application = Application::find(Input::get('applicationID', 0)); ?>
        <?php if($application && $application->FlipboardActive): ?>
        <a href="/tr/flipbook/{{Input::get('applicationID', 0)}}" title="Flipbook"
           class="widget-icon widget-icon-circle" target="_blank">
            <span class="icon-book"></span>
        </a>
        <?php endif; ?>
        <?php endif; ?>

        <?php else: ?>
        <a href="{{URL::to(__('route.'.$page.'_new'))}}" title="{{__('common.commandbar_add')}}"
           class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php endif; ?>
    </div>
</div>
<div class="col-md-4 commandbar-search">

    {{ Form::open($route, 'GET') }}
    {{ Form::hidden('page', '1') }}
    {{ Form::hidden('sort', Input::get('sort', $pk)) }}
    {{ Form::hidden('sort_dir', Input::get('sort_dir', 'DESC')) }}
    {{ Form::hidden('applicationID', Input::get('applicationID', '0')) }}
    <div class="input-group">
        <div class="input-group-addon"><span class="icon-search"></span></div>
        <input class="form-control" name="search" value="{{ Input::get('search', '') }}" type="text">
        <input type="submit" class="btn hidden" value="{{ __('common.commandbar_search') }}"/>
    </div>
    {{ Form::close() }}

</div>