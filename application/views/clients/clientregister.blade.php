<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ Config::get('custom.companyname') }}</title>
        <!-- Meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-Language" content="tr" />
        <meta http-equiv="imagetoolbar" content="false" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Serdar Saygılı" />
        <meta name="copyright" content="Galepress Technology" />
        <meta name="company" content="Detay Danışmanlık Bilgisayar Hiz. San. ve Dış Tic. A.Ş." />
        <link rel="shortcut icon" href="/website/img/favicon2.ico">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	@include('js.language')
        {{ HTML::script('js/jquery-2.1.0.min.js'); }}
        {{ HTML::script('js/jquery-ui-1.10.4.custom.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/generic.js?v=' . APP_VER); }}
    </head>
    <body>
	<style>
	    /* statusbar */
	    .statusbar{position: fixed; bottom: 0px; width: 100%; padding: 10px; background: rgba(0,0,0,0.70); z-index: 99;}
	    .statusbar .statusbar-icon{float: left; margin-right: 10px; padding: 3px 0px;}
            .statusbar .statusbar-icon [class^=icon]{font-size: 20px; line-height: 24px;}
	    .statusbar .statusbar-text{font-size: 12px; font-weight: lighter; color: #FFF; float: left; padding-right: 30px; line-height: 30px;}
	    .statusbar .statusbar-body{float: left; padding-right: 30px;}
	    .statusbar .statusbar-close{position: absolute; right: 15px; top: 50%; margin-top: -8px; cursor: pointer; opacity: 0.2; filter: alpha(opacity=20);}
            .statusbar .statusbar-close:hover{ opacity: 0.5; filter: alpha(opacity=50);}

	    .statusbar.statusbar-info{background: rgba(47,132,177,0.70);} /* #2F84B1 */
	    .statusbar.statusbar-danger{background: rgba(175,47,47,0.70);}/* #AF2F2F */
	    .statusbar.statusbar-success{background: rgba(89,173,47,0.70);} /* #FFA91F */
	    .statusbar.statusbar-warning{background: rgba(255,169,31,0.70);} /* #59AD2F */        
	    /* eof statusbar */
	</style>
	<?php
	$ClientID = 0;
	$ApplicationID = 0;
	$Username = '';
	$Password = '';
	$Email = '';
	$FirstName = '';
	$LastName = '';
	$LastLoginData = '';
	$InvalidPasswordAttempts = 0;
	/* @var $applications Application */
	$applications;
	/* @var $client Client */
	if (isset($client)) {
	    $ClientID = (int) $client->ClientID;
	    $ApplicationID = (int) $client->ApplicationID;
	    $Username = $client->Username;
	    $Password = $client->Password;
	    $Email = $client->Email;
	    $FirstName = $client->Name;
	    $LastName = $client->Surname;
	}
	?>
	<div class="col-md-12">
	    <div class="header">
		<h2><?php echo __('common.detailpage_caption'); ?> </h2>
	    </div>
	    <div class="content controls">
		<?php echo Laravel\Form::open(__('route.clients_register_save'), 'POST'); ?>
		<input type="hidden" name="ApplicationID" value="<?php echo $application->ApplicationID; ?>" />
		<div class="form-row">
		    <div class="col-md-4"><?php echo __('common.clients_username'); ?> <span class="error">*</span></div>
		    <?php echo $errors->first('Username', '<p class="error">:message</p>'); ?>
		    <div class="col-md-8">
			<input type="text" name="Username" id="Username" class="form-control textbox required" value="<?php echo $Username; ?>" />
		    </div>
		</div>
		<?php if ($ClientID > 0): ?>
    		<div class="form-row">
    		    <div class="col-md-4"><?php echo __('common.clients_password_current'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
    		    <div class="col-md-8">
    			<input type="password" name="Password" id="Password" class="form-control textbox<?php echo $ClientID == 0 ? ' required' : ''; ?>" value="" />      
    		    </div>
    		</div>
    		<div class="form-row">
    		    <div class="col-md-4"><?php echo __('common.clients_password_new'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
    		    <div class="col-md-8">
    			<input type="password" name="Password" id="Password" class="form-control textbox<?php echo $ClientID == 0 ? ' required' : ''; ?>" value="" />      
    		    </div>
    		</div>
    		<div class="form-row">
    		    <div class="col-md-4"><?php echo __('common.clients_password_retype_new'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
    		    <div class="col-md-8">
    			<input type="password" name="Password" id="Password" class="form-control textbox<?php echo $ClientID == 0 ? ' required' : ''; ?>" value="" />      
    		    </div>
    		</div>
		<?php else: ?>
    		<div class="form-row">
    		    <div class="col-md-4"><?php echo __('common.clients_password'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
			<?php echo $errors->first('Password', '<p class="error">:message</p>'); ?>
    		    <div class="col-md-8">
    			<input type="password" name="Password" id="Password" class="form-control textbox" value="" />      
    		    </div>
    		</div>              
    		<div class="form-row">
    		    <div class="col-md-4"><?php echo __('common.clients_password2'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
    		    <div class="col-md-8">
    			<input type="password" name="Password2" id="Password2" class="form-control textbox" value="" />      
    		    </div>
    		</div>              
		<?php endif; ?>
		<div class="form-row">
		    <div class="col-md-4"><?php echo __('common.clients_firstname'); ?> <span class="error">*</span></div>
		    <?php echo $errors->first('FirstName', '<p class="error">:message</p>'); ?>
		    <div class="col-md-8">
			<input type="text" name="FirstName" id="FirstName" class="form-control textbox required" value="<?php echo $FirstName; ?>" />
		    </div>
		</div>
		<div class="form-row">
		    <div class="col-md-4"><?php echo __('common.clients_lastname'); ?> <span class="error">*</span></div>
		    <?php echo $errors->first('LastName', '<p class="error">:message</p>'); ?>
		    <div class="col-md-8">
			<input type="text" name="LastName" id="LastName" class="form-control textbox required" value="<?php echo $LastName; ?>" />
		    </div>
		</div>
		<div class="form-row">
		    <div class="col-md-4"><?php echo __('common.users_email'); ?> <span class="error">*</span></div>
		    <?php echo $errors->first('Email', '<p class="error">:message</p>'); ?>
		    <div class="col-md-8">
			<input type="text" name="Email" id="Email" class="form-control textbox required" value="<?php echo $Email; ?>" />
		    </div>
		</div>
		<div class="form-row">
		    <div class="col-md-10"></div>
		    <div class="col-md-2">
			<input type="submit" class="btn my-btn-success" name="save" value="<?php echo __('common.detailpage_save'); ?>" />
		    </div>
		</div>
		<?php echo Laravel\Form::close(); ?>
	    </div>
	</div>
	<script>
	    $(function () {
		if(typeof deneme !== "undefined" && typeof deneme.errmsg !== "undefined") {
		    sNotification.failure(response.errmsg);
//		    if(typeof response.errmsg !== "undefined") {
//		    }
		} else {
		    console.log("zzzzzzz");
		    
		}
	    });

	</script>
    </body>
</html>