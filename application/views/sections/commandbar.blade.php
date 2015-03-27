<div class="col-md-3" style="padding-top:5px; float:left;">
    <div class="input-group">
		@if((int)Input::get('customerID', 0) > 0)
            <a href="{{URL::to(__('route.'.$page.'_new').'?customerID='.Input::get('customerID', 0))}}" title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle"><span class="icon-plus"></span></a>
        @elseif((int)Input::get('applicationID', 0) > 0)
            
                <a href="{{URL::to(__('route.'.$page.'_new').'?applicationID='.Input::get('applicationID', 0))}}" title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle" style="margin-left:5px;"><span class="icon-plus"></span></a>
            
            
                <a href="#modalPushNotification" title="Push Notification" data-toggle="modal" data-target="#modalPushNotification" class="widget-icon widget-icon-circle" style="margin-left:10px;"><span class="icon-bullhorn"></span></a>
            
           
                <a href="/tr/flipbook/{{Input::get('applicationID', 0)}}" title="Flipbook" class="widget-icon widget-icon-circle" target="_blank" style="margin-left:10px;"><span class="icon-book"></span></a>

                <!--<a href="#modalTemplateChooser" data-toggle="modal" data-target="#modalTemplateChooser" class="widget-icon widget-icon-circle" style="margin-left:10px;"><span class="icon-dashboard"></span></a> -->
          
        @else
            <a href="{{URL::to(__('route.'.$page.'_new'))}}" title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle"><span class="icon-plus"></span></a>
        @endif
    </div>
</div>
<div class="col-md-4" style="float:right; max-width:300px;">

        {{ Form::open($route, 'GET') }}
            {{ Form::hidden('page', '1') }}
            {{ Form::hidden('sort', Input::get('sort', $pk)) }}
            {{ Form::hidden('sort_dir', Input::get('sort_dir', 'DESC')) }}
            {{ Form::hidden('applicationID', Input::get('applicationID', '0')) }}
            <div class="input-group">
                <div class="input-group-addon"><span class="icon-search"></span></div>
                <input class="form-control" name="search" value="{{ Input::get('search', '') }}" type="text">
                <input type="submit" class="btn hidden" value="{{ __('common.commandbar_search') }}" />
            </div>
        {{ Form::close() }} 
  
</div>