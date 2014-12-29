<?php

class Website_Controller extends Base_Controller
{
	public $restful = true;
	
	public function get_home()
	{
		return View::make('website.pages.home');
	}

	public function get_aboutus()
	{
		return View::make('website.pages.aboutus');
	}

	public function get_galepress()
	{
		return View::make('website.pages.galepress');
	}

	public function get_products()
	{
		return View::make('website.pages.products');
	}

	public function get_advantages()
	{
		return View::make('website.pages.advantages');
	}

	public function get_customers()
	{
		return View::make('website.pages.customers');
	}

	public function get_tutorials()
	{
		return View::make('website.pages.tutorials');
	}

	public function get_contact()
	{
		return View::make('website.pages.contact');
	}

	public function get_sitemap()
	{
		return View::make('website.pages.sitemap');
	}

	public function get_search()
	{
		return View::make('website.pages.search');
	}

	public function get_blog()
	{
		return View::make('website.pages.blog');
	}
}