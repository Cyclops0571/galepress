@layout('layouts.login')

@section('content')
{{ Form::open(__('route.forgotmypassword'), 'POST') }}
{{ Form::token() }}
<div class="container">        
    <div class="login-block">
	<div class="block bg-light loginBlock" style="border-radius:13px;">
	    <div class="head">
		<div class="user">                                                                               
		    <img src="/img/myLogo3.png">                          
		</div>
	    </div>
	    <div class="content controls npt">
		<div class="form-row user-change-row" style="display: block;">
		    <div class="col-md-12">
			<div class="input-group">
			    <div class="input-group-addon">
				<span class="icon-envelope-alt" id="forgot-pass-icon"></span>
			    </div>
			    <input type="text" class="form-control txt required" id="Mail" name="Email" onKeyPress="return cUser.loginEvent(event, cUser.forgotMyPassword);" placeholder="Email"/>
			    {{ $errors->first('Email', '<p class="error">:message</p>') }}
			</div>
		    </div>
		</div>
		<div class="form-row">
		    <div class="col-md-6">
			<a style="display:block;" class="btn btn-mini" href="{{URL::to(__('route.login'))}}">{{ __('common.login_goback') }}</a>
		    </div>      
		    <div class="col-md-6">			
			<input type="button" name="login" id="login" class="btn btn-mini" value="{{ __('common.login_button_resetmypassword') }}" onclick="cUser.forgotMyPassword();" />
		    </div>         
		</div>
	    </div>
	</div>
    </div>
</div>
{{ Form::close() }}
@endsection