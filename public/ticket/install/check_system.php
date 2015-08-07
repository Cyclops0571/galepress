<?php
include('includes/header.php');

if (!isset($_SESSION['install_data']) || ($_SESSION['install_data']['stage'] < 1)) {
	header('Location: index.php');
}

$system_check = array();

$system_check['php_version']	= PHP_VERSION;
$system_check['pass']			= true;

$system_check['php']			= true;
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	$system_check['php']		= false;
	$system_check['pass']		= false;
}

$system_check['php54']			= true;
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	$system_check['php54']		= false;
}

$system_check['php_pdo']		= true;
if (!extension_loaded('pdo')) {
	$system_check['php_pdo']	= false;
	$system_check['pass']		= false;
}

$system_check['php_pdo_mysql']		= true;
if (!extension_loaded('pdo_mysql')) {
	$system_check['php_pdo_mysql']	= false;
	$system_check['pass']		= false;
}

$system_check['php_mcrypt']		= true;
if (!extension_loaded('mcrypt')) {
	$system_check['php_mcrypt']	= false;
	$system_check['pass']		= false;
}

$system_check['php_hash']			= true;
if (!extension_loaded('hash')) {
	$system_check['php_hash']		= false;
	$system_check['pass']			= false;
}

$system_check['file_write']				= true;
$system_check['config_file_write']		= true;

if (isset($_GET['file_check']) && ($_GET['file_check'] == 'skip')) {

}
else {
	if (!$ipm_install->test_write()) {
		$system_check['file_write']			= false;
		$system_check['pass']				= false;
	}
	if (!$ipm_install->test_write_config()) {
		$system_check['config_file_write']	= false;
		$system_check['pass']				= false;
	}
}

$system_check['php_ldap']		= false;
if (extension_loaded('ldap')) {
	$system_check['php_ldap']	= true;
}

$system_check['php_gd']		= false;
if (extension_loaded('gd')) {
	$system_check['php_gd']	= true;
}

$system_check['php_openssl']	= false;
if (extension_loaded('openssl')) {
	$system_check['php_openssl']	= true;
}

$system_check['php_mbstring']		= false;
if (extension_loaded('mbstring')) {
	$system_check['php_mbstring']	= true;
}

if (file_exists(ROOT . '/user/settings/config.php')) {
	$system_check['pass'] = false;
}

$system_check['no_htaccess']			= true;
if (file_exists(ROOT . '/.htaccess')) {
	$system_check['no_htaccess']		= false;
}

$storage_path = $ipm_install->storage_path();
$system_check['storage_path']			= false;
if (!empty($storage_path) && (is_writable($storage_path))) {
	$system_check['storage_path']		= true;
}

if ($system_check['pass']) {
	if (isset($_POST['next'])) {
		$_SESSION['install_data']['stage'] = 2;
		header('Location: database.php');
	}
}

include('includes/html-header.php');

?>
<script type="text/javascript">
$(document).ready(function () {
	$.ajax({
		type: "GET",
		dataType: "json",
		url:  "update_check.php",
		success: function(data){
			if (data !== null) {
				if (data.success) {
					if (data.is_current_version) {
						$('#latest_installer_tr').addClass('success');
						$('#latest_installer').html('Pass');
					}
					else {
						$('#latest_installer_tr').addClass('warning');
						$('#latest_installer').html('Failed');
					}
				}
				else {
					$('#latest_installer_tr').addClass('warning');
					$('#latest_installer').html('Unable to contact update server.');
				}
			}
		}
	 });
});
</script>

<div class="row">
	<div class="col-md-3">
		<div class="well well-sm">
			<h4>Help</h4>
			<p>If your system is missing any Optional Components you can install them later.</p>
		</div>
	</div>
	<div class="col-md-9">		
		<div class="alert alert-warning">
			If you get a 404 or 500 error after the install please check to ensure the Apache Mod Rewrite module is enabled.
			<strong><a href="https://portal.dalegroup.net/public/kb_view/1/">More Info</a></strong>.
		</div>	
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-left">
					<h1 class="panel-title">Step 1 - System Check</h1>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
			
				<?php if (file_exists(ROOT . '/user/settings/config.php')) { ?>
					<div class="alert alert-danger">
						The config file "user/settings/config.php" already exists, the install cannot continue.
						<br />
						You must delete this file if you wish to start a new install.
					</div>
				<?php } else { ?>
					
					<?php if (isset($message)) echo '<div class="message">' . ipm_htmlentities($message) . '</div>'; ?>
					<div id="update_check"></div>

					<h4>Required Components</h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Item</th>
									<th>Pass/Fail</th>
									<th>Info</th>
								</tr>
							</thead>
							<tr <?php if ($system_check['php']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td>PHP Version 5.3.0+</td>
								<td><?php if ($system_check['php']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td>Required for base system (found <?php echo $system_check['php_version']; ?>)</td>
							</tr>
							<tr <?php if ($system_check['php_pdo']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">PHP PDO Extension</td>
								<td class="centre"><?php if ($system_check['php_pdo']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for database system</td>
							</tr>
							<tr <?php if ($system_check['php_pdo_mysql']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">PHP PDO MySQL Extension</td>
								<td class="centre"><?php if ($system_check['php_pdo_mysql']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for database system</td>
							</tr>
							<tr <?php if ($system_check['php_mcrypt']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">PHP Mcrypt Extension</td>
								<td class="centre"><?php if ($system_check['php_mcrypt']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for security system</td>
							</tr>
							<tr <?php if ($system_check['php_hash']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">PHP Hash Extension</td>
								<td class="centre"><?php if ($system_check['php_hash']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for security system</td>
							</tr>
							<tr <?php if ($system_check['file_write']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">File Write Access 1</td>
								<td class="centre"><?php if ($system_check['file_write']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required to write .htaccess file (in root folder)</td>
							</tr>
							<tr <?php if ($system_check['config_file_write']) { echo ' class="success"'; } else { echo 'class="danger"';} ?>>
								<td class="centre">File Write Access 2</td>
								<td class="centre"><?php if ($system_check['config_file_write']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required to write to user/settings/ folder</td>
							</tr>
						</table>
					</div>
							
					<h4>Optional Components</h4>
					<div class="table-responsive">
							<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Item</th>
									<th>Pass/Fail</th>
									<th>Info</th>
								</tr>
							</thead>
							<tr id="latest_installer_tr">
								<td class="centre">Latest Installer</td>
								<td class="centre" id="latest_installer">Checking...</td>
								<td class="centre">Installing the latest version is recommended</td>
							</tr>
							<tr <?php if ($system_check['storage_path']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">File Storage</td>
								<td class="centre"><?php if ($system_check['storage_path']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required to write to user/files/ folder</td>
							</tr>
							<tr <?php if ($system_check['php54']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">PHP 5.4+</td>
								<td class="centre"><?php if ($system_check['php54']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Tickets 5.2 is the last version to support PHP 5.3</td>
							</tr>
							<tr <?php if ($system_check['php_ldap']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">PHP LDAP Extension</td>
								<td class="centre"><?php if ($system_check['php_ldap']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for Active Directory authentication</td>
							</tr>
							<tr <?php if ($system_check['no_htaccess']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">No .htaccess File</td>
								<td class="centre"><?php if ($system_check['no_htaccess']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">The installer will create the required .htaccess file</td>
							</tr>
							<tr <?php if ($system_check['php_gd']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">PHP GD Extension</td>
								<td class="centre"><?php if ($system_check['php_gd']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for anti-spam captcha</td>
							</tr>
							<tr <?php if ($system_check['php_openssl']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">PHP OpenSSL Extension</td>
								<td class="centre"><?php if ($system_check['php_openssl']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for Pushover notifications</td>
							</tr>
							<tr <?php if ($system_check['php_mbstring']) { echo ' class="success"'; } else { echo 'class="warning"';} ?>>
								<td class="centre">PHP mbstring Extension</td>
								<td class="centre"><?php if ($system_check['php_mbstring']) { echo 'Pass'; } else { echo 'Fail'; } ?></td>
								<td class="centre">Required for POP3 email download</td>
							</tr>
						</table>
					</div>
					<?php if ($system_check['pass']) { ?>
						<br />
						<div class="pull-right">
							<form method="post" action="<?php echo ipm_htmlentities($_SERVER['REQUEST_URI']); ?>">
								<p class="seperator"><button type="submit" name="next" class="btn btn-primary">Next</button></p>
							</form>	
						</div>
					<?php } else { ?>
						<br />
						<div class="alert alert-danger">
						Sorry you cannot install Tickets on this server, please check your web server.
						</div>
					<?php } ?>
				
				
				<?php } ?>
					
				<br />
				<p><a href="index.php" class="btn btn-default">Back</a></p>
			</div>
		</div>	

		
	</div>
	<div class="clear"></div>
	<br />
</div>

<?php
include('includes/html-footer.php');
?>