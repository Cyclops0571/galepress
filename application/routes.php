<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

/*
Route::get('(:any)/(:any)', array('do' => function(){

	return URI::current();
}));
*/




Route::get('/', function() { return View::make('website.pages.home'); });
Route::get("test", "test@index");
Route::post("test", "test@index");
Route::get("move", "test@moveInteractivite");
Route::get("test/image", "test@image");
Route::post("test/image", "test@image");
$languages = Config::get('application.languages', array());

foreach($languages as $currentLanguage) {
	
	// <editor-fold defaultstate="collapsed" desc="website">
	Route::get(__('route.website_aboutus')->get($currentLanguage), array('as' => 'website_aboutus_get', 'uses' => 'website@aboutus'));
	Route::get(__('route.website_galepress')->get($currentLanguage), array('as' => 'website_galepress_get', 'uses' => 'website@galepress'));
	Route::get(__('route.website_products')->get($currentLanguage), array('as' => 'website_products_get', 'uses' => 'website@products'));
	Route::get(__('route.website_advantages')->get($currentLanguage), array('as' => 'website_advantages_get', 'uses' => 'website@advantages'));
	Route::get(__('route.website_showcase')->get($currentLanguage), array('as' => 'website_showcase_get', 'uses' => 'website@customers'));
	Route::get(__('route.website_tutorials')->get($currentLanguage), array('as' => 'website_tutorials_get', 'uses' => 'website@tutorials'));
	Route::get(__('route.website_contact')->get($currentLanguage), array('as' => 'website_contact_get', 'uses' => 'website@contact'));
	Route::get(__('route.website_sitemap')->get($currentLanguage), array('as' => 'website_sitemap_get', 'uses' => 'website@sitemap'));
	Route::get(__('route.website_search')->get($currentLanguage), array('as' => 'website_search_get', 'uses' => 'website@search'));
	// Route::get(__('route.website_blog')->get($currentLanguage), array('as' => 'website_blog_get', 'uses' => 'website@blog'));
	// Route::get(__('route.website_blog_news')->get($currentLanguage), array('as' => 'website_blog_news_get', 'uses' => 'website@blogNews'));
	// Route::get(__('route.website_blog_tutorials')->get($currentLanguage), array('as' => 'website_blog_tutorials_get', 'uses' => 'website@blogTutorials'));
	Route::get(__('route.website_sectors')->get($currentLanguage), array('as' => 'website_sectors_get', 'uses' => 'website@sectors'));
	Route::get(__('route.website_sectors_retail')->get($currentLanguage), array('as' => 'website_sectors_retail_get', 'uses' => 'website@sectors_retail'));
	Route::get(__('route.website_sectors_humanresources')->get($currentLanguage), array('as' => 'website_sectors_humanresources_get', 'uses' => 'website@sectors_humanresources'));
	Route::get(__('route.website_sectors_education')->get($currentLanguage), array('as' => 'website_sectors_education_get', 'uses' => 'website@sectors_education'));
	Route::get(__('route.website_sectors_realty')->get($currentLanguage), array('as' => 'website_sectors_realty_get', 'uses' => 'website@sectors_realty'));
	Route::get(__('route.website_sectors_medicine')->get($currentLanguage), array('as' => 'website_sectors_medicine_get', 'uses' => 'website@sectors_medicine'));
	Route::get(__('route.website_sectors_digitalpublishing')->get($currentLanguage), array('as' => 'website_sectors_digitalpublishing_get', 'uses' => 'website@sectors_digitalpublishing'));
	Route::get(__('route.website_why_galepress')->get($currentLanguage), array('as' => 'website_why_galepress_get', 'uses' => 'website@why_galepress'));
	Route::get(__('route.website_tryit')->get($currentLanguage), array('as' => 'website_tryit_get', 'uses' => 'website@tryit'));
	Route::post(__('route.website_tryit')->get($currentLanguage), array('as' => 'website_tryit_post', 'uses' => 'website@tryit'));
	Route::get('deneyin-test', array('as' => 'website_tryit_test_post', 'uses' => 'website@tryit_test'));
	Route::post('deneyin-test', array('as' => 'website_tryit_test_post', 'uses' => 'website@tryit'));
	Route::get(__('route.website_landing_page_realty')->get($currentLanguage), array('as' => 'website_landing_page_realty_get', 'uses' => 'website@landing_page_realty'));
	Route::post(__('route.website_landing_page_realty')->get($currentLanguage), array('as' => 'website_landing_page_realty_post', 'uses' => 'website@landing_page_realty'));
	Route::get('namaz-vakitleri', array('as' => 'website_namaz-vakitleri_get', 'uses' => 'website@namaz'));
	Route::post('namaz-vakitleri?(:all)', array('as' => 'website_namaz-vakitleri_post', 'uses' => 'website@namaz'));


	Route::post(__('route.facebook_attempt')->get($currentLanguage), array('as' => 'website_facebook_attempt_post', 'uses' => 'common@facebookAttempt'));
	Route::get(__('route.website_captcha')->get($currentLanguage), array('as' => 'website_captcha_get', 'uses' => 'website@captcha_iframe'));
	// </editor-fold>

	Route::get(__('route.confirmemail')->get($currentLanguage), array('as' => 'common_confirmemail_get', 'uses' => 'common@confirmemail'));
	Route::get(__('appcreatewithface')->get($currentLanguage), array('as' => 'appcreatewithface', 'uses' => 'website@app_create_face'));

	Route::get(__('route.website_article_workflow')->get($currentLanguage), array('as' => 'website_article_workflow_get', 'uses' => 'website@article_workflow'));
	Route::get(__('route.website_article_brandvalue')->get($currentLanguage), array('as' => 'website_article_brandvalue_get', 'uses' => 'website@article_brandvalue'));
	Route::get(__('route.website_article_whymobile')->get($currentLanguage), array('as' => 'website_article_whymobile_get', 'uses' => 'website@article_whymobile'));
	Route::get(__('route.shop')->get($currentLanguage), array('as' => 'website_shop', 'before' => 'auth', 'uses' => 'payment@shop'));
	
	Route::get('payment-galepress', array('as' => 'website_payment_galepress_get', 'before' => 'auth', 'uses' => 'payment@payment_galepress'));
	Route::post('payment-galepress', array('as' => 'website_payment_galepress_post', 'before' => 'auth', 'uses' => 'payment@payment_galepress'));
	// Route::post('odeme', array('as' => 'website_odeme_get', 'uses' => 'website@odeme'));

	Route::post('odeme', array('as' => 'website_odeme_post', 'before' => 'auth', 'uses' => 'payment@odeme'));
	Route::post('odeme-onay', array('as' => 'website_payment_galepress_post', 'before' => 'auth', 'uses' => 'payment@payment_approval'));
	Route::get(__('route.website_payment_result')->get($currentLanguage), array('as' => 'website_payment_result_get', 'uses' => 'payment@odemeSonuc'));

	Route::get(__('route.login')->get($currentLanguage), array('as' => 'common_login_get', 'uses' => 'common@login'));
	Route::post(__('route.login')->get($currentLanguage), array('as' => 'common_login_post', 'uses' => 'common@login'));
	//Route::post(__('route.login')->get($currentLanguage), array('as' => 'common_login_post', 'before' => 'csrf', 'uses' => 'common@login'));

	Route::get(__('route.forgotmypassword')->get($currentLanguage), array('as' => 'common_forgotmypassword_get', 'uses' => 'common@forgotmypassword'));
	Route::post(__('route.forgotmypassword')->get($currentLanguage), array('as' => 'common_forgotmypassword_post', 'before' => 'csrf', 'uses' => 'common@forgotmypassword'));

	Route::get(__('route.resetmypassword')->get($currentLanguage), array('as' => 'common_resetmypassword_get', 'uses' => 'common@resetmypassword'));
	Route::post(__('route.resetmypassword')->get($currentLanguage), array('as' => 'common_resetmypassword_post', 'before' => 'csrf', 'uses' => 'common@resetmypassword'));

	Route::get(__('route.logout')->get($currentLanguage), array('as' => 'common_logout', 'uses' => 'common@logout'));

	Route::get(__('route.home')->get($currentLanguage), array('as' => 'common_home', 'before' => 'auth', 'uses' => 'common@home'));
	Route::get(__('route.dashboard')->get($currentLanguage), array('as' => 'common_dashboard', 'before' => 'auth', 'uses' => 'common@dashboard'));

	Route::get(__('route.mydetail')->get($currentLanguage), array('as' => 'common_mydetail_get', 'before' => 'auth', 'uses' => 'common@mydetail'));
	Route::post(__('route.mydetail')->get($currentLanguage), array('as' => 'common_mydetail_post', 'before' => 'auth|csrf', 'uses' => 'common@mydetail'));
	
	// <editor-fold defaultstate="collapsed" desc="Users">
	Route::get(__('route.users')->get($currentLanguage), array('as' => 'users', 'before' => 'auth', 'uses' => 'users@index'));
	Route::get(__('route.users_new')->get($currentLanguage), array('as' => 'users_new', 'before' => 'auth', 'uses' => 'users@new'));
	Route::get(__('route.users_show')->get($currentLanguage), array('as' => 'users_show', 'before' => 'auth', 'uses' => 'users@show'));
	Route::post(__('route.users_save')->get($currentLanguage), array('as' => 'users_save', 'before' => 'auth|csrf', 'uses' => 'users@save'));
	Route::post(__('route.users_send')->get($currentLanguage), array('as' => 'users_send', 'before' => 'auth|csrf', 'uses' => 'users@send'));
	Route::post(__('route.users_delete')->get($currentLanguage), array('as' => 'users_delete', 'before' => 'auth|csrf', 'uses' => 'users@delete'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Customers">
	Route::get(__('route.customers')->get($currentLanguage), array('as' => 'customers', 'before' => 'auth', 'uses' => 'customers@index'));
	Route::get(__('route.customers_new')->get($currentLanguage), array('as' => 'customers_new', 'before' => 'auth', 'uses' => 'customers@new'));
	Route::get(__('route.customers_show')->get($currentLanguage), array('as' => 'customers_show', 'before' => 'auth', 'uses' => 'customers@show'));
	Route::post(__('route.customers_save')->get($currentLanguage), array('as' => 'customers_save', 'before' => 'auth|csrf', 'uses' => 'customers@save'));
	Route::post(__('route.customers_delete')->get($currentLanguage), array('as' => 'customers_delete', 'before' => 'auth|csrf', 'uses' => 'customers@delete'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Applications">
	Route::get(__('route.applications')->get($currentLanguage), array('as' => 'applications', 'before' => 'auth', 'uses' => 'applications@index'));
	Route::get(__('route.applications_new')->get($currentLanguage), array('as' => 'applications_new', 'before' => 'auth', 'uses' => 'applications@new'));
	Route::get(__('route.applications_show')->get($currentLanguage), array('as' => 'applications_show', 'before' => 'auth', 'uses' => 'applications@show'));
	Route::post(__('route.applications_pushnotification')->get($currentLanguage), array('as' => 'applications_push', 'before' => 'auth', 'uses' => 'applications@push'));
	Route::post(__('route.applications_save')->get($currentLanguage), array('as' => 'applications_save', 'before' => 'auth|csrf', 'uses' => 'applications@save'));
	Route::post(__('route.applications_delete')->get($currentLanguage), array('as' => 'applications_delete', 'before' => 'auth|csrf', 'uses' => 'applications@delete'));
	Route::post(__('route.applications_uploadfile')->get($currentLanguage), array('as' => 'applications_uploadfile', 'before' => 'auth', 'uses' => 'applications@uploadfile'));
	Route::post(__('route.applications_uploadfile2')->get($currentLanguage), array('do' => function()
	{
		try
		{
			$rules = array(
				'Filedata' => 'mimes:pem'
			);
			$v = Validator::make(Input::all(), $rules);
			//TODO:duzelt
			if ($v->passes() || 1 == 1)
			{
				$file = Input::file('Filedata');
				$filePath = path('public').'files/temp';
				$fileName = File::name($file['name']);
				$fileExt = File::extension($file['name']);
				$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;
				
				if(!File::exists($filePath))
				{
					File::mkdir($filePath);	
				}
				
				$success = Input::upload('Filedata', $filePath, $tempFile);
				if($success)
				{
					return "success=".base64_encode("true")."&filename=".base64_encode($tempFile);
				}
				return "success=".base64_encode("false")."&errmsg=".base64_encode('');
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		catch(Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}));
	// </editor-fold>
	Route::get(__('route.applications_usersettings')->get($currentLanguage), array('as' => 'applications_usersettings', 'before' => 'auth', 'uses' => 'applications@userApplicationSettings'));

	// <editor-fold defaultstate="collapsed" desc="Contents">
	Route::post("contents/order/(:num)", array('as' => 'contents_order', 'before' => 'auth', 'uses' => 'contents@order'));
        Route::get("contents/remove_from_mobile/(:num)", array("as" => "content_remove_from_mobile", 'before' => 'auth', 'uses' => 'contents@remove_from_mobile'));
	Route::get(__('route.contents')->get($currentLanguage), array('as' => 'contents', 'before' => 'auth', 'uses' => 'contents@index'));
	Route::get(__('route.contents_request')->get($currentLanguage), array('as' => 'contents_request', 'uses' => 'contents@request'));
	Route::get(__('route.contents_new')->get($currentLanguage), array('as' => 'contents_new', 'before' => 'auth', 'uses' => 'contents@new'));
	Route::get(__('route.contents_show')->get($currentLanguage), array('as' => 'contents_show', 'before' => 'auth', 'uses' => 'contents@show'));
	Route::post(__('route.contents_save')->get($currentLanguage), array('as' => 'contents_save', 'before' => 'auth|csrf', 'uses' => 'contents@save'));
	Route::get('/copy/(:num)/(:all)', array('as' => 'copy', 'before' => 'auth', 'uses' => 'contents@copy'));
	Route::post(__('route.contents_delete')->get($currentLanguage), array('as' => 'contents_delete', 'before' => 'auth|csrf', 'uses' => 'contents@delete'));
	Route::post(__('route.contents_template_save')->get($currentLanguage), array('as' => 'contents_template_save', 'before' => 'auth', 'uses' => 'contents@template_save'));
	Route::post(__('route.contents_uploadfile')->get($currentLanguage), array('as' => 'contents_uploadfile', 'before' => 'auth', 'uses' => 'contents@uploadfile'));
	Route::post(__('route.contents_uploadfile2')->get($currentLanguage), array('do' => function()
	{
		try
		{
			$rules = array(
				'Filedata' => 'mimes:pdf'
				//'Filedata' => 'mimes:pdf,zip'
			);
			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				$rnd = Str::random(20);
				$file = Input::file('Filedata');
				$filePath = path('public').'files/temp';
				$fileName = File::name($file['name']);
				$fileExt = File::extension($file['name']);
				$tempFile = $fileName.'_'.$rnd.'.'.$fileExt;
				
				if(!File::exists($filePath))
				{
					File::mkdir($filePath);	
				}
				
				$success = Input::upload('Filedata', $filePath, $tempFile);
				if($success)
				{
					$ret = Uploader::ContentsUploadFile($tempFile);
					return "success=".base64_encode("true")."&filename=".base64_encode($ret['fileName'])."&coverimagefilename=".base64_encode($ret['imageFile']);
				}
				return "success=".base64_encode("false")."&errmsg=".base64_encode('');
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		catch(Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}));
	Route::post(__('route.contents_uploadcoverimage')->get($currentLanguage), array('as' => 'contents_uploadcoverimage', 'before' => 'auth', 'uses' => 'contents@uploadcoverimage'));
	Route::post(__('route.contents_uploadcoverimage2')->get($currentLanguage), array('do' => function()
	{
		try
		{
			$rules = array(
				'Filedata' => 'image'
				//'Filedata' => 'image|max:3000'
			);
			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				$file = Input::file('Filedata');
				$filePath = path('public').'files/temp';
				$fileName = File::name($file['name']);
				$fileExt = File::extension($file['name']);
				$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;
				
				if(!File::exists($filePath))
				{
					File::mkdir($filePath);	
				}
				
				$success = Input::upload('Filedata', $filePath, $tempFile);

				if($success) 
				{
					$ret = Uploader::UploadImage($tempFile);
					return "success=".base64_encode("true")."&filename=".base64_encode($ret['fileName']);
				}
				return "success=".base64_encode("false")."&errmsg=".base64_encode('');
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		catch(Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Password">
	Route::get(__('route.contents_passwords')->get($currentLanguage), array('as' => 'contents_passwords', 'before' => 'auth', 'uses' => 'contentpasswords@index'));
	Route::post(__('route.contents_passwords_save')->get($currentLanguage), array('as' => 'contents_passwords_save', 'before' => 'auth|csrf', 'uses' => 'contentpasswords@save'));
	Route::post(__('route.contents_passwords_delete')->get($currentLanguage), array('as' => 'contents_passwords_delete', 'before' => 'auth', 'uses' => 'contentpasswords@delete'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Orders">
	Route::get(__('route.application_form_create')->get($currentLanguage), array('as' => 'application_form_create', 'uses' => 'orders@appForm'));
	Route::get(__('route.orders')->get($currentLanguage), array('as' => 'orders', 'before' => 'auth', 'uses' => 'orders@index'));
	Route::get(__('route.orders_new')->get($currentLanguage), array('as' => 'orders_new', 'before' => 'auth', 'uses' => 'orders@new'));
	Route::get(__('route.orders_show')->get($currentLanguage), array('as' => 'orders_show', 'before' => 'auth', 'uses' => 'orders@show'));
	//Route::post(__('route.orders_save')->get($currentLanguage), array('as' => 'orders_save', 'before' => 'auth|csrf', 'uses' => 'orders@save'));
	Route::post(__('route.orders_save')->get($currentLanguage), array('as' => 'orders_save', 'uses' => 'orders@save'));
	Route::post(__('route.orders_delete')->get($currentLanguage), array('as' => 'orders_delete', 'before' => 'auth|csrf', 'uses' => 'orders@delete'));
	Route::post(__('route.orders_uploadfile')->get($currentLanguage), array('as' => 'orders_uploadfile', 'uses' => 'orders@uploadfile'));
	Route::post(__('route.orders_uploadfile2')->get($currentLanguage), array('do' => function()
	{
		try
		{
			$type = Input::get('type');

			$rules = array();
			if($type == 'uploadpdf')
			{
				$rules = array(
					'Filedata' => 'mimes:pdf'
				);
			}
			else if($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536')
			{
				$rules = array(
					'Filedata' => 'mimes:png,jpeg,gif,tiff'
				);
			}
			else {
				throw new Exception('Invalid file type!');
			}

			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				$file = Input::file('Filedata');
				$filePath = path('public').'files/temp';
				$fileName = File::name($file['name']);
				$fileExt = File::extension($file['name']);
				$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;
				
				if(!File::exists($filePath))
				{
					File::mkdir($filePath);	
				}
				
				$success = Input::upload('Filedata', $filePath, $tempFile);
				if($success)
				{
					Uploader::OrdersUploadFile($tempFile, $type);
					return "success=".base64_encode("true")."&filename=".base64_encode($tempFile);
				}
				return "success=".base64_encode("false")."&errmsg=".base64_encode('');
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		catch(Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Category">
	Route::get(__('route.categories')->get($currentLanguage), array('as' => 'categories', 'before' => 'auth', 'uses' => 'categories@index'));
	Route::post(__('route.categories_save')->get($currentLanguage), array('as' => 'categories_save', 'before' => 'auth|csrf', 'uses' => 'categories@save'));
	Route::post(__('route.categories_delete')->get($currentLanguage), array('as' => 'categories_delete', 'before' => 'auth', 'uses' => 'categories@delete'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Reports">
	Route::get(__('route.reports')->get($currentLanguage), array('as' => 'reports', 'before' => 'auth', 'uses' => 'reports@index'));
	Route::get(__('route.reports_show')->get($currentLanguage), array('as' => 'reports_show', 'before' => 'auth', 'uses' => 'reports@show'));
	Route::get(__('route.reports_location_country')->get($currentLanguage), array('as' => 'reports_location_country', 'before' => 'auth', 'uses' => 'reports@country'));
	Route::get(__('route.reports_location_city')->get($currentLanguage), array('as' => 'reports_location_city', 'before' => 'auth', 'uses' => 'reports@city'));
	Route::get(__('route.reports_location_district')->get($currentLanguage), array('as' => 'reports_location_district', 'before' => 'auth', 'uses' => 'reports@district'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Interactivity">
	Route::get(__('route.interactivity_preview')->get($currentLanguage), array('as' => 'interactivity_preview', 'before' => 'auth', 'uses' => 'interactivity@preview'));
	Route::get(__('route.interactivity_show')->get($currentLanguage), array('as' => 'interactivity_show', 'before' => 'auth', 'uses' => 'interactivity@show'));
	Route::get(__('route.interactivity_fb')->get($currentLanguage), array('as' => 'interactivity_fb', 'uses' => 'interactivity@fb'));
	Route::post(__('route.interactivity_check')->get($currentLanguage), array('as' => 'interactivity_check', 'before' => 'auth', 'uses' => 'interactivity@check'));
	Route::post(__('route.interactivity_save')->get($currentLanguage), array('as' => 'interactivity_save', 'before' => 'auth|csrf', 'uses' => 'interactivity@save'));
	Route::post(__('route.interactivity_transfer')->get($currentLanguage), array('as' => 'interactivity_transfer', 'before' => 'auth', 'uses' => 'interactivity@transfer'));
	Route::post(__('route.interactivity_refreshtree')->get($currentLanguage), array('as' => 'interactivity_refreshtree', 'before' => 'auth', 'uses' => 'interactivity@refreshtree'));
	Route::post(__('route.interactivity_upload')->get($currentLanguage), array('as' => 'interactivity_upload', 'before' => 'auth', 'uses' => 'interactivity@upload'));
	Route::post(__('route.interactivity_upload2')->get($currentLanguage), array('do' => function()
	{
		try
		{
			$type = Input::get('type');
			
			$rules = array();
			if($type == 'uploadvideofile')
			{
				$rules = array(
					'Filedata' => 'mimes:mp4'
				);
			}
			else if($type == 'uploadaudiofile')
			{
				$rules = array(
					'Filedata' => 'mimes:mp3'
				);
			}
			else
			{
				$rules = array(
					'Filedata' => 'image'
					//'Filedata' => 'image|max:3000'
				);
			}
			
			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				$file = Input::file('Filedata');
				$filePath = path('public').'files/temp';
				$fileName = File::name($file['name']);
				$fileExt = File::extension($file['name']);
				$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;
				
				if(!File::exists($filePath))
				{
					File::mkdir($filePath);	
				}
				
				$success = Input::upload('Filedata', $filePath, $tempFile);
				if($success)
				{
					return "success=".base64_encode("true")."&filename=".base64_encode($tempFile);
				}
				return "success=".base64_encode("false")."&errmsg=".base64_encode('');
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		catch(Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}));
	Route::post(__('route.interactivity_loadpage')->get($currentLanguage), array('as' => 'interactivity_loadpage', 'before' => 'auth', 'uses' => 'interactivity@loadpage'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="Crop">
	Route::get(__('route.crop_image')->get($currentLanguage), array('as' => 'crop_image', 'before' => 'auth', 'uses' => 'crop@image'));
	Route::post(__('route.crop_image')->get($currentLanguage), array('as' => 'crop_image', 'before' => 'auth', 'uses' => 'crop@image'));
	// </editor-fold>

	// <editor-fold defaultstate="collapsed" desc="maps">
	Route::get(__('route.maps')->get($currentLanguage), array('as' => 'maps_list', 'before'=>'auth', 'uses'=>'maps@index'));
	Route::get(__('route.maps_show')->get($currentLanguage), array('as' => 'maps_show', 'before'=>'auth', 'uses'=>'maps@show'));
	Route::get(__('route.maps_new')->get($currentLanguage), array('before'=>'auth', 'uses'=>'maps@new'));
	Route::post(__('route.maps_save')->get($currentLanguage), array('as' => 'maps_save', 'before'=>'crsf|auth', 'uses'=>'maps@save'));
	Route::get(__('route.maps_location')->get($currentLanguage) . "(:num)", array('as' => 'maps_location', 'before'=>'auth', 'uses'=>'maps@location'));
	// </editor-fold>
	
	// <editor-fold defaultstate="collapsed" desc="Banners">
	Route::get(__('route.banners')->get($currentLanguage), array('as' => 'banners_list', 'before'=>'auth', 'uses'=>'banners@index'));
	Route::get(__('route.banners_show')->get($currentLanguage), array('as' => 'banners_show', 'before'=>'auth', 'uses'=>'banners@show'));
	Route::get(__('route.banners_new')->get($currentLanguage), array('before'=>'auth', 'uses'=>'banners@new'));
	Route::post(__('route.banners_save')->get($currentLanguage), array('as' => 'banners_save', 'before'=>'crsf|auth', 'uses'=>'banners@save'));
	
	// </editor-fold>
	
	Route::post('/common/imageupload_ltie10', array('as' => 'banners_imageupload_ltie10', 'uses' => 'common@imageupload_ltie10'));
	Route::post('/common/imageupload', array('as' => 'banners_imageupload_ltie10', 'uses' => 'common@imageupload'));
}




Route::post('applications/userApplicationSettings', array('as' => 'save_applications_usersettings', 'before' => 'auth', 'uses' => 'applications@userApplicationSettings'));
Route::get("/template/(:num)", array('as' => 'template_index', 'before'=>'auth', 'uses'=>'template@index'));
Route::get("banners/delete", array('as' => 'banners_delete', 'before'=>'auth', 'uses'=>'banners@delete'));
Route::post("banners/order/(:num)", array('as' => 'banners_order', 'before'=>'auth', 'uses'=>'banners@order'));
Route::get("banners/service_view/(:num)", array('as' => 'banners_service_view', 'uses'=>'banners@service_view'));
Route::get('maps/webview/(:num)', array('as', 'uses'=>'maps@webview'));

Route::post('payment-response', array('as' => 'website_odeme_response_post', 'uses' => 'payment@odemeResponse'));
//Route::post('payment-response', array('as' => 'website_odeme_response_post', 'uses' => 'payment@odemeResponse'));

// WS
Route::get('ws/latest-version', array('uses' => 'ws.index@latestVersion'));

// <editor-fold defaultstate="collapsed" desc="WS v1.0.0">
// WS v1.0.0 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v100/applications/(:num)/version', array('uses' => 'ws.v100.applications@version'));
Route::get('ws/v100/applications/(:num)/detail', array('uses' => 'ws.v100.applications@detail'));
Route::get('ws/v100/applications/(:num)/categories', array('uses' => 'ws.v100.applications@categories'));
Route::get('ws/v100/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v100.applications@categoryDetail'));
Route::get('ws/v100/applications/(:num)/contents', array('uses' => 'ws.v100.applications@contents'));
// WS-Contents
Route::get('ws/v100/contents/(:num)/version', array('uses' => 'ws.v100.contents@version'));
Route::get('ws/v100/contents/(:num)/detail', array('uses' => 'ws.v100.contents@detail'));
Route::get('ws/v100/contents/(:num)/cover-image', array('uses' => 'ws.v100.contents@coverImage'));
Route::get('ws/v100/contents/(:num)/file', array('uses' => 'ws.v100.contents@file'));
// WS-Statistics
Route::post('ws/v100/statistics', array('uses' => 'ws.v100.statistics@create'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="WS v1.0.1">
// WS v1.0.1 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v101/applications/(:num)/version', array('uses' => 'ws.v101.applications@version'));
Route::get('ws/v101/applications/(:num)/detail', array('uses' => 'ws.v101.applications@detail'));
Route::get('ws/v101/applications/(:num)/categories', array('uses' => 'ws.v101.applications@categories'));
Route::get('ws/v101/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v101.applications@categoryDetail'));
Route::get('ws/v101/applications/(:num)/contents', array('uses' => 'ws.v101.applications@contents'));
// WS-Contents
Route::get('ws/v101/contents/(:num)/version', array('uses' => 'ws.v101.contents@version'));
Route::get('ws/v101/contents/(:num)/detail', array('uses' => 'ws.v101.contents@detail'));
Route::get('ws/v101/contents/(:num)/cover-image', array('uses' => 'ws.v101.contents@coverImage'));
Route::get('ws/v101/contents/(:num)/file', array('uses' => 'ws.v101.contents@file'));
// WS-Statistics
Route::post('ws/v101/statistics', array('uses' => 'ws.v101.statistics@create'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="WS v1.0.2">
// WS v1.0.2 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v102/applications/(:num)/version', array('uses' => 'ws.v102.applications@version'));
Route::get('ws/v102/applications/(:num)/detail', array('uses' => 'ws.v102.applications@detail'));
Route::get('ws/v102/applications/(:num)/categories', array('uses' => 'ws.v102.applications@categories'));
Route::get('ws/v102/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v102.applications@categoryDetail'));
Route::get('ws/v102/applications/(:num)/contents', array('uses' => 'ws.v102.applications@contents'));
// WS-Contents
Route::get('ws/v102/contents/(:num)/version', array('uses' => 'ws.v102.contents@version'));
Route::get('ws/v102/contents/(:num)/detail', array('uses' => 'ws.v102.contents@detail'));
Route::get('ws/v102/contents/(:num)/cover-image', array('uses' => 'ws.v102.contents@coverImage'));
Route::get('ws/v102/contents/(:num)/file', array('uses' => 'ws.v102.contents@file'));
// WS-Statistics
Route::post('ws/v102/statistics', array('uses' => 'ws.v102.statistics@create'));
Route::get('ws/v102/applications/authorized_application_list', array('uses' => 'ws.v102.applications@authorized_application_list'));
Route::post('ws/v102/applications/authorized_application_list', array('uses' => 'ws.v102.applications@authorized_application_list'));
// </editor-fold>

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to(__('route.login'));
});