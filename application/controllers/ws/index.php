<?php

class Ws_Index_Controller extends Base_Controller
{
	public $restful = true;

	public function get_test()
	{
		/*
		$basePath = path('app').'controllers/ws';
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath."/"), RecursiveIteratorIterator::SELF_FIRST);
		foreach ($files as $file)
		{
			$file = str_replace('\\', '/', $file);

			//Ignore "." and ".." folders
			if(in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
				continue;

			$realFile = realpath($file);
			$relativeFile = str_replace($basePath.'/', '', $realFile);

			if(is_dir($realFile) === true)
			{
				//var_dump($relativeFile);
			}
			else if(is_file($realFile) === true)
			{
				//var_dump($relativeFile);
			}
		}
		*/
		return Response::json(array(
			'status' => 0,
			'error' => "",
			'Version' => ""
		));
	}

	public function get_latestVersion()
	{
		$versions = array();
		$basePath = path('app').'controllers/ws';
		$files = scandir($basePath);
		foreach ($files as $file)
		{
			//if file starts with 'v'
			if(strpos($file, 'v') === 0) {
				//var_dump($file);
				$realFile = $basePath.'/'.$file;

				if(is_dir($realFile) === true)
				{
					$v = str_replace("v","", $file);
					$v = str_replace(".","", $v);
					array_push($versions, (int)$v);
				}
			}
		}
		return Response::json(array(
			'status' => 0,
			'error' => "",
			'Version' => max($versions)
		));
	}
}