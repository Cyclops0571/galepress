@layout('layouts.login')


@section('content')    
    <?php
	   $cookie = Cookie::get('DSCATALOG_USERNAME', '');
	?>

    {{ Form::open(__('route.login'), 'POST') }}
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
            						  <span class="icon-user" id="login-icon-user" style="font-size:15px;"></span>
            						</div>
            			            <input class="form-control txt required" type="text" placeholder="{{ __('common.users_username') }}" id="Username" name="Username" onKeyPress="return cUser.loginEvent(event, cUser.login);" value="{{ $cookie }}" /> </input>
            						{{ $errors->first('Username', '<p class="error">:message</p>') }}
            			        </div>
            			    </div>
                    	</div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="icon-key" id="login-icon-key"></span>
                                    </div>
                                    <input type="password" class="form-control txt required" id="Password" name="Password" onKeyPress="return cUser.loginEvent(event, cUser.login);" placeholder="{{ __('common.users_password') }}"/>
        							{{ $errors->first('Password', '<p class="error">:message</p>') }}
                                </div>
                            </div>
                        </div>                        
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="checkbox">
                                    <label style="font-size:14px;"><input type="checkbox" name="Remember" {{ (strlen($cookie) > 0 ? ' checked="checked"' : '') }} />{{ __('common.login_remember') }}</label>
                                </div>
                            </div>  
        					<div class="col-md-4">
                                <input type="button" class="btn btn-mini" name="login" id="login" value="{{ __('common.login_button') }}" onclick="cUser.login();" />
                            </div>
                        </div>
                        <div class="form-row">
        					<div class="col-md-12">
                                <div style="text-align:center"><u><a href="{{URL::to(__('route.forgotmypassword'))}}">{{ __('common.login_forgotmypassword') }}</a></u></div>
                            </div>			
                        </div> 
                    </div> 
                </div>                       
            </div>           
        </div>
    {{ Form::close() }}

@endsection