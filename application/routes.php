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




Route::get('/', function()
{
	return View::make('website.pages.home');
	/*
	if(Auth::check())
	{
		return Redirect::to(__('route.home'));
	}
	else
	{
		return Redirect::to(__('route.login'));
	}
	*/
});

$languages = Config::get('application.languages', array());

foreach($languages as $currentLanguage) {

	Route::get(__('route.website_aboutus')->get($currentLanguage), array('as' => 'website_aboutus_get', 'uses' => 'website@aboutus'));
	Route::get(__('route.website_galepress')->get($currentLanguage), array('as' => 'website_galepress_get', 'uses' => 'website@galepress'));
	Route::get(__('route.website_products')->get($currentLanguage), array('as' => 'website_products_get', 'uses' => 'website@products'));
	Route::get(__('route.website_advantages')->get($currentLanguage), array('as' => 'website_advantages_get', 'uses' => 'website@advantages'));
	Route::get(__('route.website_customers')->get($currentLanguage), array('as' => 'website_customers_get', 'uses' => 'website@customers'));
	Route::get(__('route.website_tutorials')->get($currentLanguage), array('as' => 'website_tutorials_get', 'uses' => 'website@tutorials'));
	Route::get(__('route.website_contact')->get($currentLanguage), array('as' => 'website_contact_get', 'uses' => 'website@contact'));
	Route::get(__('route.website_sitemap')->get($currentLanguage), array('as' => 'website_sitemap_get', 'uses' => 'website@sitemap'));
	Route::get(__('route.website_search')->get($currentLanguage), array('as' => 'website_search_get', 'uses' => 'website@search'));
	Route::get(__('route.website_blog')->get($currentLanguage), array('as' => 'website_blog_get', 'uses' => 'website@blog'));

	Route::get(__('route.website_article_workflow')->get($currentLanguage), array('as' => 'website_article_workflow_get', 'uses' => 'website@article_workflow'));
	Route::get(__('route.website_article_brandvalue')->get($currentLanguage), array('as' => 'website_article_brandvalue_get', 'uses' => 'website@article_brandvalue'));
	Route::get(__('route.website_article_whymobile')->get($currentLanguage), array('as' => 'website_article_whymobile_get', 'uses' => 'website@article_whymobile'));

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
	
	//Users
	Route::get(__('route.users')->get($currentLanguage), array('as' => 'users', 'before' => 'auth', 'uses' => 'users@index'));
	Route::get(__('route.users_new')->get($currentLanguage), array('as' => 'users_new', 'before' => 'auth', 'uses' => 'users@new'));
	Route::get(__('route.users_show')->get($currentLanguage), array('as' => 'users_show', 'before' => 'auth', 'uses' => 'users@show'));
	Route::post(__('route.users_save')->get($currentLanguage), array('as' => 'users_save', 'before' => 'auth|csrf', 'uses' => 'users@save'));
	Route::post(__('route.users_send')->get($currentLanguage), array('as' => 'users_send', 'before' => 'auth|csrf', 'uses' => 'users@send'));
	Route::post(__('route.users_delete')->get($currentLanguage), array('as' => 'users_delete', 'before' => 'auth|csrf', 'uses' => 'users@delete'));

	//Customers
	Route::get(__('route.customers')->get($currentLanguage), array('as' => 'customers', 'before' => 'auth', 'uses' => 'customers@index'));
	Route::get(__('route.customers_new')->get($currentLanguage), array('as' => 'customers_new', 'before' => 'auth', 'uses' => 'customers@new'));
	Route::get(__('route.customers_show')->get($currentLanguage), array('as' => 'customers_show', 'before' => 'auth', 'uses' => 'customers@show'));
	Route::post(__('route.customers_save')->get($currentLanguage), array('as' => 'customers_save', 'before' => 'auth|csrf', 'uses' => 'customers@save'));
	Route::post(__('route.customers_delete')->get($currentLanguage), array('as' => 'customers_delete', 'before' => 'auth|csrf', 'uses' => 'customers@delete'));

	//Applications
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

	//Contents
	Route::get(__('route.contents')->get($currentLanguage), array('as' => 'contents', 'before' => 'auth', 'uses' => 'contents@index'));
	Route::get(__('route.contents_request')->get($currentLanguage), array('as' => 'contents_request', 'uses' => 'contents@request'));
	Route::get(__('route.contents_new')->get($currentLanguage), array('as' => 'contents_new', 'before' => 'auth', 'uses' => 'contents@new'));
	Route::get(__('route.contents_show')->get($currentLanguage), array('as' => 'contents_show', 'before' => 'auth', 'uses' => 'contents@show'));
	Route::post(__('route.contents_save')->get($currentLanguage), array('as' => 'contents_save', 'before' => 'auth|csrf', 'uses' => 'contents@save'));
	Route::post(__('route.contents_delete')->get($currentLanguage), array('as' => 'contents_delete', 'before' => 'auth|csrf', 'uses' => 'contents@delete'));
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
					$ret = Uploader::ContentsUploadCoverImage($tempFile);
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

	//Password
	Route::get(__('route.contents_passwords')->get($currentLanguage), array('as' => 'contents_passwords', 'before' => 'auth', 'uses' => 'contentpasswords@index'));
	Route::post(__('route.contents_passwords_save')->get($currentLanguage), array('as' => 'contents_passwords_save', 'before' => 'auth|csrf', 'uses' => 'contentpasswords@save'));
	Route::post(__('route.contents_passwords_delete')->get($currentLanguage), array('as' => 'contents_passwords_delete', 'before' => 'auth', 'uses' => 'contentpasswords@delete'));

	//Orders
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

	//Category
	Route::get(__('route.categories')->get($currentLanguage), array('as' => 'categories', 'before' => 'auth', 'uses' => 'categories@index'));
	Route::post(__('route.categories_save')->get($currentLanguage), array('as' => 'categories_save', 'before' => 'auth|csrf', 'uses' => 'categories@save'));
	Route::post(__('route.categories_delete')->get($currentLanguage), array('as' => 'categories_delete', 'before' => 'auth', 'uses' => 'categories@delete'));

	//Reports
	Route::get(__('route.reports')->get($currentLanguage), array('as' => 'reports', 'before' => 'auth', 'uses' => 'reports@index'));
	Route::get(__('route.reports_show')->get($currentLanguage), array('as' => 'reports_show', 'before' => 'auth', 'uses' => 'reports@show'));
	Route::get(__('route.reports_location_country')->get($currentLanguage), array('as' => 'reports_location_country', 'before' => 'auth', 'uses' => 'reports@country'));
	Route::get(__('route.reports_location_city')->get($currentLanguage), array('as' => 'reports_location_city', 'before' => 'auth', 'uses' => 'reports@city'));
	Route::get(__('route.reports_location_district')->get($currentLanguage), array('as' => 'reports_location_district', 'before' => 'auth', 'uses' => 'reports@district'));

	//Interactivity
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
}

// WS
Route::get('ws/latest-version', array('uses' => 'ws.index@latestVersion'));

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



Route::get('test', array('do' => function()
{

	// test algoritma calisma
	$fibonacci = array();

	$itemCount = 10;

	for ($i=0; $i <= $itemCount ; $i++) { 

		if($i<2)
			array_push($fibonacci,$i);
		else
		{
			$fibonacci[$i] = $fibonacci[$i-2] + $fibonacci[$i-1];
		}

	}

	print_r($fibonacci);


}));

Route::get('test2', array('do' => function()
{
	return 5;
	
	$arr = array();
	array_push($arr, 20);
	array_push($arr, 21);
	array_push($arr, 12);
	array_push($arr, 13);
	array_push($arr, 14);
	array_push($arr, 15);

	echo array_search(max($arr), $arr);
	/*
	$arr[0] = 20;
	$arr[1] = 11;
	$arr[2] = 12;
	$arr[3] = 13;
	$arr[4] = 14;
	*/

	return;
	$path = path('public').'files';
	$f1 = $path."/1.jpg";
	$f2 = $path."/5.jpg";
	
	try {
		$image1 = new imagick($f1);
		$image2 = new imagick($f2);
		$result = $image1->compareImages($image2, Imagick::METRIC_MEANSQUAREERROR);
		echo $result[1];
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}

	return;
	/*
	//return $_SERVER["DOCUMENT_ROOT"]."/../imagesComparison.php";



	//ImagesComparison Class Example
	require $_SERVER["DOCUMENT_ROOT"]."/../application/libraries/imagesComparison.php";

	//two images with exactly same width and height
	$compare = new ImagesComparison($path."/1.png", $path."/2.png");

	//compare two images(can skip)
	echo $compare->compare();

	//give each part of contiguous difference a number(can skip)
	//$compare->index();

	//check the consistency of two images
	//var_dump($compare->consistency());	//(it will send a header, so skip it because of printImage)

	//fill in the difference with certain color: array(red, green, blue), else, random color for each contiguous part
	//$compare->fillDiff();

	//circle the difference with certain color: array(red, green, blue), else, red; offset => make the circle bigger
	//$compare->circleDiff();

	//print the image to the browser or a file
	//$compare->printImage();
	return;
	*/




	// init the image objects
	$image1 = new imagick();
	$image2 = new imagick();

	// set the fuzz factor (must be done BEFORE reading in the images)
	$image1->SetOption('fuzz', '2%');

	// read in the images
	$image1->readImage($path."/1.png");
	$image2->readImage($path."/2.png");

	// compare the images using METRIC=1 (Absolute Error)
	$result = $image1->compareImages($image2, 1);
	var_dump($result);
	// print out the result
	echo "The image comparison 2% Fuzz factor is: " . $result[1];


	/*
	$image1 = new imagick($path."/1.png");
	$image2 = new imagick($path."/3.png");

	$result = $image1->compareImages($image2, Imagick::METRIC_MEANSQUAREERROR);
	$result[0]->setImageFormat("png");

	header("Content-Type: image/png");
	echo $result[0];
	*/

	return;





	$oldContentFileID = DB::table('ContentFile')
		->where('ContentFileID', '<', '1405')
		->where('ContentID', '=', '895')
		->where('Interactivity', '=', '1')
		->where('StatusID', '=', eStatus::Active)
		->order_by('ContentFileID', 'DESC')
		->take(1)
		->only('ContentFileID');

	if($oldContentFileID) {

		$ContentFilePages = DB::table('ContentFilePage')->where('ContentFileID', '=', $oldContentFileID)->where('StatusID', '=', eStatus::Active)->get();
		foreach($ContentFilePages as $ContentFilePage) {


			$f = new ContentFilePage();
			$f->ContentFileID = $ContentFilePage->asdasdasdasd;
			$f->No = $ContentFilePage->asdasdasdasd;
			//$f->Width = $ContentFilePage->asdasdasdasd;
			//$f->Height = $ContentFilePage->asdasdasdasd;
			//$f->FilePath = $ContentFilePage->asdasdasdasd;
			//$f->FileName = $ContentFilePage->asdasdasdasd;
			//$f->FileName2 = $ContentFilePage->asdasdasdasd;
			//$f->FileSize = $ContentFilePage->asdasdasdasd;
			$f->StatusID = eStatus::Active;
			$f->CreatorUserID = $currentUser->UserID;
			$f->DateCreated = new DateTime();
			$f->ProcessUserID = $currentUser->UserID;
			$f->ProcessDate = new DateTime();
			$f->ProcessTypeID = eProcessTypes::Insert;
			$f->save();
			
			$contentFileID = $f->ContentFileID;


			/*
			ContentFilePage				
			ContentFilePageID	int		P	
			ContentFileID	int		FIN	ContentFile
			No	int		N	
			Width	float		N	
			Height	float		N	
			FilePath	nvarchar	255	N	
			FileName	nvarchar	255	N	
			FileName2	nvarchar	255	N	
			FileSize	int		N	
			StatusID	int		FIN	GroupCode
			CreatorUserID	int		FIN	User
			DateCreated	datetime		N	
			ProcessUserID	int		FIN	User
			ProcessDate	datetime		N	
			ProcessTypeID	int		FIN	GroupCode
			*/


			var_dump($ContentFilePage->ContentFilePageID);
		}
		//ContentFilePage-ContentFileID
		//PageComponent-ContentFilePageID
		//PageComponentProperty-PageComponentID	
	}
	return '';
	
	//create snapshot
	$filePath = path('public').'files/temp';
	$imageFile = 'NISAN.jpg';

	$im = new imagick();
	//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
	$im->setOption('pdf:use-cropbox', 'true');
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
	//$im->setResourceLimit(6, 2);
	$im->setResolution(150, 150);
	$im->readImage($filePath."/NISAN.pdf[0]");
	$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
	//$im->setImageColorspace(255);
	$im->setCompression(Imagick::COMPRESSION_JPEG);
	$im->setCompressionQuality(80);
	//$im->setImageFormat('jpeg');
	$im->setImageFormat('jpg');

	$width = 400;
	$height = 524;
	$geo = $im->getImageGeometry();
	
	if(($geo['width'] / $width) < ($geo['height'] / $height))
	{
		$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
	}
	else
	{
		$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
	}
	$im->ThumbnailImage($width, $height, true);
	$im->writeImage($filePath.'/'.$imageFile);
	$im->clear();
	$im->destroy();
	unset($im);
	return 'ok';



	$apps = DB::table('Application')
		->where(function($query)
		{
			$query->where('ExpirationDate', '=', DB::raw('CURDATE()+15'));
			$query->or_where('ExpirationDate', '=', DB::raw('CURDATE()+7'));
			$query->or_where('ExpirationDate', '=', DB::raw('CURDATE()'));
		})
		->where('StatusID', '=', 1)
		->get();
	var_dump($apps);
	return;


	$date = '14.07.2009 05:35:10';
	echo $date."<br><br>";

	$date = Common::dateWrite($date);
	echo $date."<br><br>";

	$date = Common::dateRead($date, 'dd.MM.yyyy HH:mm:ss');
	echo $date."<br><br>";

	return;
	
	$time_start = microtime(true);


	//create snapshot
	$filePath = path('public').'files/temp';
	$imageFile = 'z.jpg';
	$zipFile = 'z.zip';
	
	$zip = new ZipArchive();
	$res = $zip->open($filePath.'/'.$zipFile, ZIPARCHIVE::CREATE);
	if ($res === true)
	{
		$zip->addFile($filePath.'/z.pdf', 'file.pdf');
		$zip->close();
	}

	$im = new imagick();
	//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
	$im->setOption('pdf:use-cropbox', 'true');
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
	//$im->setResourceLimit(6, 2);
	$im->setResolution(150, 150);
	$im->readImage($filePath."/z.pdf[0]");
	$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
	//$im->setImageColorspace(255);
	$im->setCompression(Imagick::COMPRESSION_JPEG);
	$im->setCompressionQuality(80);
	//$im->setImageFormat('jpeg');
	$im->setImageFormat('jpg');

	$width = 400;
	$height = 524;
	$geo = $im->getImageGeometry();
	
	if(($geo['width'] / $width) < ($geo['height'] / $height))
	{
		$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
	}
	else
	{
		$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
	}
	$im->ThumbnailImage($width, $height, true);
	$im->writeImage($filePath.'/'.$imageFile);
	$im->clear();
	$im->destroy();
	unset($im);
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "Did nothing in $time seconds\n";
	return;


	//var_dump(			intval(9500/1000) 			);
	//return;
	//var_dump(Hash::make('123'));
	//var_dump(Hash::check('123', '$2a$08$YGPpVsyurJ3aqtAZ9U/.Aer8s/Csqz6qdD4ImUTUmqpoGTqEf4YLq'));
	//return;

	//return $_SERVER['SERVER_NAME'];
	return $_SERVER['HTTP_HOST'];


	$user = DB::table('Statistic')->distinct()->only('Country');
	//$user = DB::table('Statistic')->only('Country')->get();
	//$user = DB::table('Statistic')->distinct()->order_by('Country', 'ASC')->get("Country");
	//var_dump($user);
	return;
	$time_start = microtime(true);




	//create folder if doesnt exist
	$pdfFile = 'large_pdf.pdf';
	$pdfRealPath = path('public').'files/temp';

	$pdfFileNameFull = $pdfRealPath.'/'.$pdfFile;
					
	$p = new pdflib();
	//$p->set_option("license=0");
	$p->set_option("license=".Config::get('custom.pdflib_license'));
	$p->set_option("errorpolicy=return");
	$doc = $p->open_pdi_document($pdfFileNameFull, "");
	if ($doc == 0)
	{
		throw new Exception($p->get_errmsg());
	}

	$pageCount = (int)$p->pcos_get_number($doc, "length:pages");
	
	//for($i = 0; $i < $pageCount; $i++)
	for($i = 0; $i < 5; $i++)
	{
		$width = (float)$p->pcos_get_number($doc, "pages[".$i."]/width");
		$height = (float)$p->pcos_get_number($doc, "pages[".$i."]/height");
		
		$imageFile = File::name($pdfFileNameFull).'_'.($i + 1).'.jpg';
		
		$im = new imagick();
		//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
		$im->setOption('pdf:use-cropbox', 'true');
		//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
		//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
		//$im->setResourceLimit(6, 2);
		$im->setResolution(150, 150);
		$im->readImage($pdfFileNameFull."[".$i."]");
		//$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
		//$im->setImageColorspace(255);
		$im->setCompression(Imagick::COMPRESSION_JPEG);
		$im->setCompressionQuality(80);
		//$im->setImageFormat('jpeg');
		$im->setImageFormat('jpg');
		$im->writeImage($pdfRealPath.'/'.$imageFile);
		$im->clear();
		$im->destroy();
		unset($im);
	}
	$p->close_pdi_document($doc);

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "Did nothing in $time seconds\n";
	return;






	$filePath = path('public').'files/temp';

	$im = new imagick();
	//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
	$im->setOption('pdf:use-cropbox', 'true');
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
	//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
	//$im->setResourceLimit(6, 2);
	$im->setResolution(150, 150);
	$im->readImage($filePath."/19.pdf[0]");
	$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
	//$im->setImageColorspace(255);
	$im->setCompression(Imagick::COMPRESSION_JPEG);
	$im->setCompressionQuality(80);
	//$im->setImageFormat('jpeg');
	$im->setImageFormat('jpg');


	$width = 400;
	$height = 524;
	$geo = $im->getImageGeometry();
	
	if(($geo['width'] / $width) < ($geo['height'] / $height))
	{
		$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
	}
	else
	{
		$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
	}
	$im->ThumbnailImage($width, $height, true);

	$im->writeImage($filePath.'/19-3.jpg');
	$im->clear();
	$im->destroy();
	unset($im);

	
	return;
	//create snapshot
	$im = new imagick($filePath.'/19.pdf[0]');
	$im->setOption('pdf:use-cropbox', 'true');
	$im->setImageFormat('jpg');
	$width = 400;
	$height = 524;
	$geo = $im->getImageGeometry();
	
	if(($geo['width'] / $width) < ($geo['height'] / $height))
	{
		$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
	}
	else
	{
		$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
	}
	$im->ThumbnailImage($width, $height, true);
	$im->writeImages($filePath.'/19-2.jpg', true);
	return;



	$searchpath = dirname(dirname(dirname(__FILE__)))."/input";
	$outfile = "";
	$title = "Spot Color";

	$font;
	$spot;
	$y = 500; 
	$x = 30;

	try {
	    $p = new pdflib();

	    $p->set_option("searchpath={" . $searchpath . "}");
	    $p->set_option("stringformat=utf8");

	    $p->set_option("errorpolicy=return");

	    if ($p->begin_document($outfile, "") == 0)
		throw new Exception("Error: " . $p->get_errmsg());

	    $p->set_info("Creator", "PDFlib Cookbook");
	    $p->set_info("Title", $title . ' $Revision: 1.8 $');
	    
	    $font = $p->load_font("Helvetica-Bold", "unicode", "");

	    if ($font == 0)
		throw new Exception("Error: " . $p->get_errmsg());
	    
	    $p->begin_page_ext(0, 0, "width=a4.height height=a4.width");
	    
	    
	    $spot = $p->makespotcolor("PANTONE 281 U");
	    
	    $p->setcolor("fill", "spot", $spot, 1.0, 0.0, 0.0);
	   
	    $p->fit_textline("PANTONE 281 U spot color with a tint value of 100%",
		$x, $y -= 30, "font=" . $font . " fontsize=16");
	    
	    $p->setcolor("fill", "spot", $spot, 0.5, 0.0, 0.0);
	    
	    $p->fit_textline("PANTONE 281 U spot color with a tint value of 50%",
		$x, $y -= 30, "font=" . $font . " fontsize=16");
	    
	    
	    $spot = $p->makespotcolor("HKS 39 E");
	    
	    $p->setcolor("fill", "spot", $spot, 1.0, 0, 0);
	    
	    $p->fit_textline("HKS 39 E spot color with a tint value of 100%",
		$x, $y -= 50, "font=" . $font . " fontsize=16");
	    
	    $p->setcolor("fill", "spot", $spot, 0.7, 0, 0);
	    
	    $p->fit_textline("HKS 39 E spot color with a tint value of 70%",
		$x, $y -= 30, "font=" . $font . " fontsize=16");
	    
	  
	    $p->setcolor("fill", "cmyk", 0, 0.2, 0.9, 0);
	    
	    $spot = $p->makespotcolor("CompanyLogo");
	    
	    $p->setcolor("fill", "spot", $spot, 1, 0, 0);
	    $p->fit_textline("CompanyLogo custom spot color with a tint value of " .
		"100%", $x, $y -= 50, "font=" . $font . " fontsize=16");

	    $p->end_page_ext("");
	    $p->end_document("");

	    $buf = $p->get_buffer();
	    $len = strlen($buf);

	    header("Content-type: application/pdf");
	    header("Content-Length: $len");
	    header("Content-Disposition: inline; filename=spot_color.pdf");
	    print $buf;

	} catch (PDFlibException $e) {
	die("PDFlib exception occurred:\n".
	    "[" . $e->get_errnum() . "] " . $e->get_apiname() .
	    ": " . $e->get_errmsg() . "\n");
	} catch (Exception $e) {
	die($e->getMessage());
	}

	$p = 0;









	//var_dump('1');
	
	
	
	
	//$data = array_merge($data, array('files' => get_object_vars($files)));
	//$data = array_merge($data, array('files' => $files));
								
								
	//asd;
}));

Route::post('test2', array('do' => function()
{
	var_dump(Input::all());
}));






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