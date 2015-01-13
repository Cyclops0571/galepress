<?php

class Interactivity_Controller extends Base_Controller
{
	public $restful = true;
	
	public function get_preview()
	{
		$componentID = Input::get('componentid');
		$componentName = Input::get('componentname');
		$clientPageComponentID = 0;
		$c = Component::where('Class', '=', $componentName)->where('StatusID', '=', eStatus::Active)->count();
		if($c > 0)
		{
			$ids = Input::get('compid');
			if($ids !== null)
			{
				/*
				$data = array(
					'preview' => true,
					'baseDirectory' => 'http://www.galepress.com/files/components/'.$componentName.'/',
					'id' => ''
				);
				*/
				$data = array(
					'preview' => true,
					'baseDirectory' => 'http://'.$_SERVER['HTTP_HOST'].'/files/components/'.$componentName.'/',
					'id' => ''
				);
				
				foreach($ids as $id)
				{
					if((int)$componentID == (int)$id)
					{
						$clientComponentID = (int)Input::get('comp-'.$id.'-id', '0');
						$clientPageComponentID = (int)Input::get('comp-'.$id.'-pcid', '0');
						$clientProcess = Input::get('comp-'.$id.'-process', '');
						
						//if($clientProcess == 'new' || $clientProcess == 'loaded')
						$postedData = Input::get();
						
						//var_dump($postedData);
						//return;
						
						foreach($postedData as $name => $value)
						{
							if(Common::startsWith($name, 'comp-'.$id))
							{
								$name = str_replace('comp-'.$id.'-', "", $name);
								
								if($name !== "id" && $name !== "process" && $name !== "fileselected" && $name !== "posterimageselected" && $name !== "modaliconselected")
								{
									if(($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value))
									{
										//var_dump($value);
										//return;
										
										$files = array();
										
										foreach($value as $v)
										{
											//var_dump($v);
											
											$pcp = DB::table('PageComponentProperty')
												->where('PageComponentID', '=', $clientPageComponentID)
												->where('Name', '=', $name)
												->where('Value', 'LIKE', '%'.$v.'%')
												->where('StatusID', '=', 1)
												->first();
											
											if($pcp)
											{
												//$files = array_merge($files, array($name => $pcp->Value));
												array_push($files, $pcp->Value);
											}
											else
											{
												$val = 'files/temp/'.$v;
												
												//$files = array_merge($files, array($name => $val));
												array_push($files, $val);
											}
										}
										
										//var_dump($files);
										//return;
										
										$data = array_merge($data, array('files' => $files));
									}
									elseif($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname')
									{
										$pcp = DB::table('PageComponentProperty')
											->where('PageComponentID', '=', $clientPageComponentID)
											->where('Name', '=', $name)
											->where('StatusID', '=', 1)
											->first();
										if($pcp)
										{
											if(Common::endsWith($pcp->Value, $value))
											{
												$data = array_merge($data, array($name => $pcp->Value));
											}
											else
											{
												$val = 'files/temp/'.$value;
												$data = array_merge($data, array($name => $val));
											}	
										}
										else
										{
											$val = 'files/temp/'.$value;
											$data = array_merge($data, array($name => $val));
										}
									}
									elseif($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://'))
									{
										$value = 'http://'.$value;

										$data = array_merge($data, array($name => $value));
									}
									else {
										$data = array_merge($data, array($name => $value));	
									}
								}
							}
						}
						break;
					}
				}
				
				
				//var_dump($data);
				//return;
				
				if(isset($data['modal']))
				{
					if((int)$data['modal'] == 1)
					{
						$image_url = path('public').$data["modaliconname"];
        				if(File::exists($image_url) && is_file($image_url)) {
        					$image_url = "/".$data["modaliconname"];
    					}
    					else {
    						$image_url = "/files/components/".$componentName."/icon.png";
    					}
    					// height="52"
						return '<html><head></head><body style="margin:0px; padding:0px;"><img src="'.$image_url.'" width="100%"></body></html>';
						//return '<html><head></head><body style="margin:0px; padding:0px;"><img src="/files/components/'.$componentName.'/icon.png"></body></html>';
					}
				}

				if($componentName == 'video' || $componentName == 'audio' || $componentName == 'animation' || $componentName == 'tooltip' || $componentName == 'scroll' || $componentName == 'slideshow' || $componentName == 'gal360')
				{
					/*
					if($componentName == 'gal360'){

						var_dump($data);
						return;
					}
					*/
					$url = '';
					if(isset($data['url'])) {
						$url = $data['url'];
					}
					if(!(strpos($url, 'www.youtube.com/embed') === false)) {
						return Redirect::to($data['url']);
					}
					return View::make('interactivity.components.'.$componentName.'.dynamic', $data);
				}
				elseif($componentName == 'map')
				{
					$type = 'roadmap';
					if((int)$data['type'] == 2)
					{
						//hybrid
						$type = 'satellite';
					}
					elseif((int)$data['type'] == 3)
					{
						//satellite
						$type = 'satellite';
					}
					/*
					--------------------------------------------------------------------
					http://stackoverflow.com/questions/9356724/google-map-api-zoom-range
					--------------------------------------------------------------------
					Google Maps basics
					Zoom Level - zoom
					0 - 19
					0 lowest zoom (whole world)
					19 highest zoom (individual buildings, if available) Retrieve current zoom level using mapObject.getZoom()
					--------------------------------------------------------------------
					0.01 = 10
					0.02 = 20
					.
					.
					--------------------------------------------------------------------
					*/
					$zoom = 1000 * (float)$data['zoom'];
					$z = (19 * $zoom / 100);
					//$z = $data['zoom'];
					//return Redirect::to('http://maps.google.com/?ie=UTF8&ll='.$data['lat'].','.$data['lon'].'&spn=0.029332,0.061455&t='.$type.'&z='.$z.'&output=embed');
					return Redirect::to('https://www.google.com/maps/embed/v1/view?maptype='.$type.'&zoom='.$z.'&center='.$data['lat'].','.$data['lon'].'&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4');
					//return Redirect::to('https://www.google.com/maps/embed/v1/view?maptype='.$type.'&zoom='.$z.'&center='.$data['lat'].','.$data['lon'].'&key=AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY');
				}
				elseif($componentName == 'link')
				{
					return '';
				}
				elseif($componentName == 'webcontent')
				{
					//https://www.google.com/maps/preview?ll=40.995374,29.108083&z=15&t=m&hl=tr-TR&gl=US&mapclient=embed&cid=9770296505447935381
					//https://www.google.com/maps/preview?ll=40.995374,29.108083&z=15&t=m&hl=tr-TR&gl=US&mapclient=embed&cid=9770296505447935381
					//return $data['url'];
					//return Redirect::to('https://www.google.com/maps/place/Teknik+Yap%C4%B1+Holding/@40.995374,29.108083,17z/data=!3m1!4b1!4m2!3m1!1s0x0:0x879710e80d76ed95?hl=en-US&key=AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY');
					//return Redirect::to('https://www.google.com/maps/embed/v1/view?maptype=satellite&zoom=1&center=59,-123&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4');
					//return Response::make('<iframe src="'.$data['url'].'&output=embed'.'"></iframe>', 200);
					//return Response::make('<script type="text/javascript">setTimeout(function () { alert("emre"); document.location.href = "'.$data['url'].'"; }, 500);</script>', 200);
					//return Response::make('<script type="text/javascript">setTimeout(function() { alert("emre"); document.location.href = "'.$data['url'].'&output=embed&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4'.'"; }, 500);</script><script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>', 200);
					//return Response::make('<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>', 200);
					//return Redirect::to('https://www.google.com/maps/embed/v1/view?maptype=satellite&center=40.995374,29.108083&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4');
					//return Response::make('<a href="'.$data['url'].'" rel="noreferrer" id="autoclick">go</a><script1>document.getElementById("autoclick").click();</script1>', 200);
					//return Response::make('<html><head><meta http-equiv="refresh" content="3;url='.$data['url'].'"/></head><body>Please wait, while redirecting...<script type="text/javascript"></body></html>', 200);
					return Redirect::to($data['url']);
				}
				elseif($componentName == 'bookmark')
				{
					return '';
				}
			}
		}
		return 'error';
	}
	
	public function get_show($contentFileID)
    {
		$currentUser = Auth::User();
		
		$ContentID = (int)ContentFile::find($contentFileID)->ContentID;
		$ApplicationID = (int)Content::find($ContentID)->ApplicationID;

		if(!Common::CheckContentOwnership($ContentID))
		{
			$data = array(
				'errmsg' => __('error.unauthorized_user_attempt')
			);
			return View::make('interactivity.error', $data);
		}

		if(!Common::AuthInteractivity($ApplicationID))
		{
			$data = array(
				'errmsg' => __('error.auth_interactivity')
			);
			return View::make('interactivity.error', $data);
		}
		
		$cf = ContentFile::find($contentFileID);
		
		$oldContentFileID = 0;

		if((int)$cf->Transferred == 1)
		{
			$oldContentFileID = (int)DB::table('ContentFile')
				->where('ContentFileID', '<', $contentFileID)
				->where('ContentID', '=', $cf->ContentID)
				->where('Interactivity', '=', 1)
				->where('StatusID', '=', eStatus::Active)
				->order_by('ContentFileID', 'DESC')
				->take(1)
				->only('ContentFileID');
		}

		$cfp = DB::table('ContentFilePage')
				->where('ContentFileID', '=', $cf->ContentFileID)
				->where('StatusID', '=', eStatus::Active);
		
		//ilk kez aciliyor!
		if($cfp->count() == 0)
		{
			$interactivityState = (int)DB::table('ContentFile')
				->where('ContentFileID', '=', $contentFileID)
				->where('StatusID', '=', eStatus::Active)
				->only('Interactivity');

			if($interactivityState == 2) {

				//return Redirect::to('/'.Session::get('language').'/'.__('route.contents').'/'.$ContentID.'?error='.__('error.interactivity_conflict'));
				return Redirect::to('/'.__('route.contents').'/'.$ContentID.'?error='.__('error.interactivity_conflict'));
			}
			else if($interactivityState !== 1) { 
				$cf = ContentFile::find($contentFileID);
				$cf->Interactivity = 2;
				$cf->ProcessUserID = $currentUser->UserID;
				$cf->ProcessDate = new DateTime();
				$cf->ProcessTypeID = eProcessTypes::Update;
				$cf->save();
			}

			$targetFileName = $cf->FileName;
			$targetFilePath = $cf->FilePath;
			$targetRealPath = path('public').$targetFilePath;
			$targetFileNameFull = $targetRealPath.'/'.$targetFileName;
			
			//create folder if doesnt exist
			$pdfFile = '';
			$pdfPath = $targetFilePath.'/file_'.$contentFileID;
			$pdfRealPath = path('public').$pdfPath;
			
			if(!File::exists($pdfRealPath))
			{
				File::mkdir($pdfRealPath);	
			}
			
			try
			{
				DB::transaction(function() use ($currentUser, $contentFileID, $oldContentFileID, $targetFileNameFull, $pdfFile, $pdfPath, $pdfRealPath)
				{
					$cf = ContentFile::find($contentFileID);
					$cf->Interactivity = 1;
					$cf->ProcessUserID = $currentUser->UserID;
					$cf->ProcessDate = new DateTime();
					$cf->ProcessTypeID = eProcessTypes::Update;
					$cf->save();

					//extract zip file
					$zip = new ZipArchive();
					$res = $zip->open($targetFileNameFull);
					if ($res === true)
					{
						$zip->extractTo($pdfRealPath);
						$zip->close();
					}
					
					//find pdf file
					$files = scandir($pdfRealPath);
					
					foreach($files as $file)
					{
						if(is_file($pdfRealPath.'/'.$file) && Common::endsWith($file, '.pdf'))
						{
							$pdfFile = $file;
							break;
						}
					}
					
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
					$bookmarksAdded = false;
					for($i = 0; $i < $pageCount; $i++)
					{
						$width = (float)$p->pcos_get_number($doc, "pages[".$i."]/width");
						$height = (float)$p->pcos_get_number($doc, "pages[".$i."]/height");
						
						$imageFile = File::name($pdfFileNameFull).'_'.($i + 1).'.jpg';
						
						//Create page snapshots
						//echo getenv('PATH'); // /usr/local/bin:/usr/bin:/bin
						//putenv(getenv('PATH').':/usr/bin');
						
						
						/*
						$im = new imagick($filePath.'/'.$tempFile.'[0]');
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
						$im->writeImages($filePath.'/'.$imageFile, true);
						*/
						$im = new imagick();
						//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
						$im->setOption('pdf:use-cropbox', 'true');
						//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
						//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
						//$im->setResourceLimit(6, 2);
						$im->setResolution(150, 150);
						$im->readImage($pdfFileNameFull."[".$i."]");
						$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
						//$im->setImageColorspace(255);
						$im->setCompression(Imagick::COMPRESSION_JPEG);
						$im->setCompressionQuality(80);
						//$im->setImageFormat('jpeg');
						$im->setImageFormat('jpg');
						$im->writeImage($pdfRealPath.'/'.$imageFile);
						$im->clear();
						$im->destroy();
						unset($im);
						
						//generate pages
						$cfp = new ContentFilePage();
						$cfp->ContentFileID = $contentFileID;
						$cfp->No = $i + 1;
						$cfp->Width = $width;
						$cfp->Height = $height;
						$cfp->FilePath = $pdfPath;
						$cfp->FileName = $imageFile;
						//$cfp->FileName2 = '';
						$cfp->FileSize = File::size($pdfRealPath.'/'.$imageFile);
						$cfp->StatusID = eStatus::Active;
						$cfp->CreatorUserID = $currentUser->UserID;
						$cfp->DateCreated = new DateTime();
						$cfp->ProcessUserID = $currentUser->UserID;
						$cfp->ProcessDate = new DateTime();
						$cfp->ProcessTypeID = eProcessTypes::Insert;
						$cfp->save();


						//if($currentUser->UserID==65)
						//{
							try
							{
								//added by hknsrr, weblink, pagelink ve bookmark annotation içeren pdf'lerin sisteme yüklendikleri zaman bu annotationların sisteme kaydedilerek int. tasarlayıcıda gösterilmesi.
								$annotations_path = "pages[".$i."]/annots";
						        $anncount = (int) $p->pcos_get_number($doc, "length:".$annotations_path);
						        $bookmarkCount = (int)$p->pcos_get_number($doc, "length:bookmarks");

						        if($bookmarkCount > 0 && (int)$cf->Transferred != 1 && !$bookmarksAdded)
						        {
						        	for ($bookmarkIndex = 0; $bookmarkIndex < $bookmarkCount; $bookmarkIndex++)
							        {
							        	//$bookmarkLevel = (int)$p->pcos_get_number($doc, "bookmarks[" .$bookmarkIndex. "]/level");
							        	$bookmarkDestpage = (int)$p->pcos_get_number($doc, "bookmarks[" .$bookmarkIndex. "]/destpage");
							        	$bookmarkTitle = $p->pcos_get_string($doc, "bookmarks[" .$bookmarkIndex. "]/Title");
							        	//Log::info($bookmarkDestpage.". sayfada ".$bookmarkCount." adet bookmark bulundu");
							        	//Log::info("bookmark title: ".$bookmarkTitle);
							        	//Log::info("bookmark level: ".$bookmarkLevel);

							        	$lastComponentNo = DB::table('PageComponent')
																->where('ContentFilePageID', '=', $cfp->ContentFilePageID+$bookmarkDestpage-1)
																->where('StatusID', '=', eStatus::Active)
																->order_by('No', 'DESC')
																->take(1)
																->only('No');

										//Log::info("lastcomponent no: ".$lastComponentNo);

										if($lastComponentNo==null)
											$lastComponentNo=0;

						                $linkAnnotPageComponent = new PageComponent();
										$linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID+$bookmarkDestpage-1;
										$linkAnnotPageComponent->ComponentID = 10;
										$linkAnnotPageComponent->No = $lastComponentNo+1;
										$linkAnnotPageComponent->StatusID = eStatus::Active;
										$linkAnnotPageComponent->CreatorUserID = $currentUser->UserID;
										$linkAnnotPageComponent->DateCreated = new DateTime();
										$linkAnnotPageComponent->ProcessUserID = $currentUser->UserID;
										$linkAnnotPageComponent->ProcessDate = new DateTime();
										$linkAnnotPageComponent->ProcessTypeID = eProcessTypes::Insert;
										$linkAnnotPageComponent->save();

										//Bookmark Component
										for($j = 0; $j < 4; $j++)
										{
											$pcp = new PageComponentProperty();
											$pcp->PageComponentID = $linkAnnotPageComponent->PageComponentID;
											if($j==0)
											{
												$pcp->Name = "pcid";
												$pcp->Value = "0";
											}
											elseif($j==1)
											{
												$pcp->Name = "text";
												$pcp->Value = $bookmarkTitle;
											}
											elseif($j==2)
											{
												$pcp->Name = "trigger-x";
												$pcp->Value = 10;
											}
											elseif($j==3)
											{
												$pcp->Name = "trigger-y";
												$pcp->Value = 10;
											}


											$pcp->StatusID = eStatus::Active;
											$pcp->CreatorUserID = $currentUser->UserID;
											$pcp->DateCreated = new DateTime();
											$pcp->ProcessUserID = $currentUser->UserID;
											$pcp->ProcessDate = new DateTime();
											$pcp->ProcessTypeID = eProcessTypes::Insert;
											$pcp->save();
										}
							        }
							        $bookmarksAdded=true;
						        }

						        if($anncount > 0 && (int)$cf->Transferred != 1)
						        {
						        	//Log::info("annotation count: ".$anncount);
					        		$docInfo = $p->pcos_get_stream($doc, "","/Root/Metadata");
					          		//$posStart = strpos($docInfo, '<xmp:CreatorTool>');
					          		//$posEnd = strpos($docInfo, '</xmp:CreatorTool>');
					          		//$docInfoFind = substr($docInfo, $posStart, $posEnd);
					            	//$indesignFind = strpos($docInfo,"InDesign");
					            	preg_match("/indesign/i", $docInfo, $indesignFind);

						            for ($ann = 0; $ann < $anncount; $ann++)
						            {
						            	if($ann>25)
						            		break;

						            	$annotation_path = $annotations_path."[".$ann."]";
						            	$linkDest = (int)$p->pcos_get_number($doc, $annotation_path."/destpage");
						            	$pcosmode = $p->pcos_get_string($doc, "pcosmode");
						            	//Log::info("link dest: ".$linkDest);
						            	
						            	//Web Link
						        		if($pcosmode=="URI" || $pcosmode==">>")
						        		{
						        			//Log::info("girdi");
						        			//Print the type of the annotation
									        $subtype = $p->pcos_get_string($doc, $annotation_path."/Subtype");
									        
									        //Log::info("Type: ".$p->get_buffer()." Count: ". $anncount);
								        	$uri_path = $annotation_path."/A/URI";
							        		$uri = $p->pcos_get_string($doc, $uri_path);

									        //Print the rectangle for the annotation.
									        if($subtype=="Link" && $subtype!="null" && substr($uri, 0, 2)!="yl")
									        {
									        	$rect_path = $annotation_path."/Rect";

										       	$pageHeight=$height;

								            	//Log::info("x: ".$p->pcos_get_number($doc, $rect_path."[0]"));

								            	$rectY=$pageHeight-(int)$p->pcos_get_number($doc, $rect_path."[3]");
								                //Log::info("y: ".$rectY);
								            
								            	$rectHeight=$pageHeight-(int)$p->pcos_get_number($doc, $rect_path."[1]")-$rectY;

								            	if($rectHeight<0)
								            		$rectHeight*=-1;
								            	//Log::info("rectHeight: ".$rectHeight);
										         
								            	$rectX=$p->pcos_get_number($doc, $rect_path."[0]");
								            	$rectWidth=$p->pcos_get_number($doc, $rect_path."[2]")-$rectX;
								            	//Log::info("rectWidth: ".$rectWidth);

								                //Log::info("Page No: ".$cfp->No);

								                $lastComponentNo = DB::table('PageComponent')
																->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
																->where('StatusID', '=', eStatus::Active)
																->order_by('No', 'DESC')
																->take(1)
																->only('No');

												if($lastComponentNo==null)
													$lastComponentNo=0;

								                $linkAnnotPageComponent = new PageComponent();
												$linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
												$linkAnnotPageComponent->ComponentID = 4;
												$linkAnnotPageComponent->No = $lastComponentNo+1;
												$linkAnnotPageComponent->StatusID = eStatus::Active;
												$linkAnnotPageComponent->CreatorUserID = $currentUser->UserID;
												$linkAnnotPageComponent->DateCreated = new DateTime();
												$linkAnnotPageComponent->ProcessUserID = $currentUser->UserID;
												$linkAnnotPageComponent->ProcessDate = new DateTime();
												$linkAnnotPageComponent->ProcessTypeID = eProcessTypes::Insert;
												$linkAnnotPageComponent->save();

												//Log::info("x: ".$rectX);
												//Log::info("y: ".$rectY);
												//Log::info("width: ".$rectWidth);
												//Log::info("height: ".$rectHeight);

												//Weblink Component
												for($j = 0; $j < 8; $j++)
												{
													$pcp = new PageComponentProperty();
													$pcp->PageComponentID = $linkAnnotPageComponent->PageComponentID;
													if($j==0)
													{
														$pcp->Name = "pcid";
														$pcp->Value = "0";
													}
													elseif($j==1)
													{
														$pcp->Name = "type";
														$pcp->Value = "2";
													}
													elseif($j==2)
													{
														$pcp->Name = "page";
														$pcp->Value = $cfp->No;
													}
													elseif($j==3)
													{
														$pcp->Name = "url";
														$pcp->Value = $uri;
													}
													elseif($j==4)
													{
														$pcp->Name = "x";
														$pcp->Value = $rectX;
													}
													elseif($j==5)
													{
														$pcp->Name = "y";
														if(isset($indesignFind[0]))
															$pcp->Value = $rectY-$rectHeight; //indesign
														else
															$pcp->Value = $rectY; //not indesign
													}
													elseif($j==6)
													{
														$pcp->Name = "w";
														$pcp->Value = $rectWidth;
													}
													elseif($j==7)
													{
														$pcp->Name = "h";
														$pcp->Value = $rectHeight;
													}

													$pcp->StatusID = eStatus::Active;
													$pcp->CreatorUserID = $currentUser->UserID;
													$pcp->DateCreated = new DateTime();
													$pcp->ProcessUserID = $currentUser->UserID;
													$pcp->ProcessDate = new DateTime();
													$pcp->ProcessTypeID = eProcessTypes::Insert;
													$pcp->save();
												}
									        }

						        		}
						        		//Page Link
						        		else
						        		{
						        			//Log::info("ikinciye girdi");
						        			
						        			//Print the type of the annotation
									        $subtype = $p->pcos_get_string($doc, $annotation_path."/Subtype");
									        
									        //Log::info("Type: ".$p->get_buffer()." Count: ". $anncount);
								        	//$uri_path = $annotation_path."/A/URI";
							        		//$uri = $p->pcos_get_string($doc, $uri_path);

									        //Print the rectangle for the annotation.
									        if($subtype=="Link" && $subtype!="null")
									        {
									        	$rect_path = $annotation_path."/Rect";

										       	$pageHeight=$height;

										       	//Log::info("pageHeight: ".$pageHeight);
								            	//Log::info("x: ".$p->pcos_get_number($doc, $rect_path."[0]"));
								            	//Log::info("1: ".$p->pcos_get_number($doc, $rect_path."[1]"));
								            	//Log::info("2: ".$p->pcos_get_number($doc, $rect_path."[2]"));
								            	//Log::info("y: ".$p->pcos_get_number($doc, $rect_path."[3]"));

								            	$rectY=$pageHeight-(int)$p->pcos_get_number($doc, $rect_path."[3]");
								                //Log::info("y: ".$rectY);
								            
								            	$rectHeight=$pageHeight-(int)$p->pcos_get_number($doc, $rect_path."[1]")-$rectY;
								            	if($rectHeight<0)
								            		$rectHeight*=-1;
								            	//Log::info("rectHeight: ".$rectHeight);
										         
								            	$rectX=$p->pcos_get_number($doc, $rect_path."[0]");
								            	$rectWidth=$p->pcos_get_number($doc, $rect_path."[2]")-$rectX;
								            	//Log::info("rectWidth: ".$rectWidth);

								                //Log::info("Page No: ".$cfp->No);

								                $lastComponentNo = DB::table('PageComponent')
																->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
																->where('StatusID', '=', eStatus::Active)
																->order_by('No', 'DESC')
																->take(1)
																->only('No');

												if($lastComponentNo==null)
													$lastComponentNo=0;

								                $linkAnnotPageComponent = new PageComponent();
												$linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
												$linkAnnotPageComponent->ComponentID = 4;
												$linkAnnotPageComponent->No = $lastComponentNo+1;
												$linkAnnotPageComponent->StatusID = eStatus::Active;
												$linkAnnotPageComponent->CreatorUserID = $currentUser->UserID;
												$linkAnnotPageComponent->DateCreated = new DateTime();
												$linkAnnotPageComponent->ProcessUserID = $currentUser->UserID;
												$linkAnnotPageComponent->ProcessDate = new DateTime();
												$linkAnnotPageComponent->ProcessTypeID = eProcessTypes::Insert;
												$linkAnnotPageComponent->save();

												//Weblink Component
												for($j = 0; $j < 8; $j++)
												{
													$pcp = new PageComponentProperty();
													$pcp->PageComponentID = $linkAnnotPageComponent->PageComponentID;
													if($j==0)
													{
														$pcp->Name = "pcid";
														$pcp->Value = "0";
													}
													elseif($j==1)
													{
														$pcp->Name = "type";
														$pcp->Value = "1";
													}
													elseif($j==2)
													{
														$pcp->Name = "page";
														$pcp->Value = $linkDest;
													}
													elseif($j==3)
													{
														$pcp->Name = "url";
														$pcp->Value = "http://";
													}
													elseif($j==4)
													{
														$pcp->Name = "x";
														$pcp->Value = $rectX;
													}
													elseif($j==5)
													{
														$pcp->Name = "y";
														if(isset($indesignFind[0]))
															$pcp->Value = $rectY-$rectHeight; //indesign
														else
															$pcp->Value = $rectY; //not indesign
													}
													elseif($j==6)
													{
														$pcp->Name = "w";
														$pcp->Value = $rectWidth;
													}
													elseif($j==7)
													{
														$pcp->Name = "h";
														$pcp->Value = $rectHeight;
													}

													$pcp->StatusID = eStatus::Active;
													$pcp->CreatorUserID = $currentUser->UserID;
													$pcp->DateCreated = new DateTime();
													$pcp->ProcessUserID = $currentUser->UserID;
													$pcp->ProcessDate = new DateTime();
													$pcp->ProcessTypeID = eProcessTypes::Insert;
													$pcp->save();
												}
									        }
						        		}

						            }
						        }
						    }
						    catch(Exception $e) {
								//echo $e->getMessage();
								//Log::info($oc->No.'-sm:0');
								Log::info($e->getMessage());
								//array_push($oldPagesSimilarity, 0);
							}

						//}

						if($oldContentFileID > 0) {

							$oldPagesSimilarity = array();

							//Log::info('Sayfa '.($i + 1));

							$newPage = new imagick($pdfRealPath.'/'.$imageFile);

							$ocfp = DB::table('ContentFilePage')
								->where('ContentFileID', '=', $oldContentFileID)
								->where('StatusID', '=', eStatus::Active)
								->get();

							foreach($ocfp as $oc)
							{
								try
								{
									$oldPage = new imagick(path('public').$oc->FilePath.'/'.$oc->FileName);
									$result = $newPage->compareImages($oldPage, Imagick::METRIC_MEANSQUAREERROR);

									//Log::info($oc->No.'-sm:'.(1 - (float)$result[1]));

									array_push($oldPagesSimilarity, (1 - (float)$result[1]));

									$oldPage->clear();
									$oldPage->destroy();
									unset($oldPage);
								}
								catch(Exception $e) {
									//echo $e->getMessage();
									//Log::info($oc->No.'-sm:0');
									//Log::info($e->getMessage());
									array_push($oldPagesSimilarity, 0);
								}
							}

							$newPage->clear();
							$newPage->destroy();
							unset($newPage);

							$maxSimilarity = max($oldPagesSimilarity);
							
							if($maxSimilarity > 0.7)
							{
								$oldPageIndex = array_search($maxSimilarity, $oldPagesSimilarity);
								$oldPageNo = $oldPageIndex + 1;
								$oldContentFilePageID = (int)DB::table('ContentFilePage')
									->where('ContentFileID', '=', $oldContentFileID)
									->where('No', '=', $oldPageNo)
									->where('StatusID', '=', eStatus::Active)
									->take(1)
									->only('ContentFilePageID');

								$oldComponents = DB::table('PageComponent')
									->where('ContentFilePageID', '=', $oldContentFilePageID)
									->where('StatusID', '=', eStatus::Active)
									->get();

								$lastComponentNo = DB::table('PageComponent')
									->where('ContentFilePageID', '=', $oldContentFilePageID)
									->where('StatusID', '=', eStatus::Active)
									->order_by('No', 'DESC')
									->take(1)
									->only('No');

								foreach($oldComponents as $oldComponent)
								{
									//insert
									$newPageComponent = new PageComponent();
									$newPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
									$newPageComponent->ComponentID = $oldComponent->ComponentID;
									$newPageComponent->No = $oldPageNo; //modified by hknsrr, no değerler, aynı oldğu zaman sayfadaki kompenentler sayfaya yapışıyordu...
									$newPageComponent->StatusID = eStatus::Active;
									$newPageComponent->CreatorUserID = $currentUser->UserID;
									$newPageComponent->DateCreated = new DateTime();
									$newPageComponent->ProcessUserID = $currentUser->UserID;
									$newPageComponent->ProcessDate = new DateTime();
									$newPageComponent->ProcessTypeID = eProcessTypes::Insert;
									$newPageComponent->save();

									$oldComponentProperties = DB::table('PageComponentProperty')
										->where('PageComponentID', '=', $oldComponent->PageComponentID)
										->where('StatusID', '=', eStatus::Active)
										->get();

									foreach($oldComponentProperties as $oldComponentProperty)
									{
										//insert
										$newPageComponentProperty = new PageComponentProperty();
										$newPageComponentProperty->PageComponentID = $newPageComponent->PageComponentID;
										$newPageComponentProperty->Name = $oldComponentProperty->Name;
										$newPageComponentProperty->Value = $oldComponentProperty->Value;
										$newPageComponentProperty->StatusID = eStatus::Active;
										$newPageComponentProperty->CreatorUserID = $currentUser->UserID;
										$newPageComponentProperty->DateCreated = new DateTime();
										$newPageComponentProperty->ProcessUserID = $currentUser->UserID;
										$newPageComponentProperty->ProcessDate = new DateTime();
										$newPageComponentProperty->ProcessTypeID = eProcessTypes::Insert;
										$newPageComponentProperty->save();
									}

									$oldPageNo++;
								}
							}
						}
					}
					$p->close_pdi_document($doc);
				});
			}
			catch (PDFlibException $e)
			{
				$data = array(
					'errmsg' => "PDFlib exception occurred in starter_pcos sample:<br/>[".$e->get_errnum()."] ".$e->get_apiname().": ".$e->get_errmsg()
				);
				return View::make('interactivity.error', $data);
			}
			catch (Exception $e)
			{
				$data = array(
					'errmsg' => $e->getMessage()
				);
				return View::make('interactivity.error', $data);
			}
		}
		
		$cfp = DB::table('ContentFilePage')
				->where('ContentFileID', '=', $cf->ContentFileID)
				->where('StatusID', '=', eStatus::Active)
				->get();
		
		$data = array(
			'ContentID' => $cf->ContentID,
			'ContentFileID' => $cf->ContentFileID,
			'included' => (int)$cf->Included,
			'filename' => $cf->FileName,
			'pages' => $cfp
		);
		return View::make('interactivity.master', $data)
				->nest('header', 'interactivity.header', $data)
				->nest('sidebar', 'interactivity.sidebar', $data)
				->nest('footer', 'interactivity.footer', $data);
    }
	
	public function get_fb($applicationID)
    {
    	//return $applicationID;
    	$search = Input::get('search', '');
    	$cats = Input::get('cat', '');
    	$where = '';

    	if(is_array($cats)) {
	    	$arrCategory = array();
	    	foreach($cats as $cat){
	    		array_push($arrCategory, (int)$cat);
	    	}
	    	$where .= ' AND o.`ContentID` IN (SELECT ContentID FROM ContentCategory WHERE CategoryID IN ('.implode(',', $arrCategory).'))';
    	}
    	
    	if(Str::length($search) > 0) {
    		$search = str_replace("'", "", $search);
    		$where .= ' AND o.`Name` LIKE \'%'.$search.'%\'';
    	}
    	$contentFileSQL = 'SELECT ContentFileID FROM ContentFile WHERE ContentID=o.ContentID AND StatusID=1';
    	$sql = ''.
				'SELECT '.
					'c.CustomerID, '.
					'c.CustomerName, '.
					'a.ApplicationID, '.
					'a.Name AS ApplicationName, '.
					'o.Name, '.
					'o.Detail, '.
					'(SELECT CONCAT(FilePath, \'/\', FileName) FROM ContentCoverImageFile WHERE ContentFileID IN ('.$contentFileSQL.') AND StatusID=1 ORDER BY ContentCoverImageFileID DESC LIMIT 1) AS CoverImageFile, '.
					'o.ContentID '.
				'FROM `Customer` AS c '.
					'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.ApplicationID='.(int)$applicationID.' AND a.StatusID=1 '.
					'INNER JOIN `Content` AS o ON o.ApplicationID=a.ApplicationID'.$where.' AND IFNULL(o.Blocked, 0)=0 AND o.Status=1 AND IsProtected=0 AND (SELECT COUNT(*) FROM ContentFilePage WHERE ContentFileID IN ('.$contentFileSQL.') AND StatusID=1) > 0 AND o.StatusID=1 '.
				'WHERE c.StatusID=1';
		//var_dump($sql);		
		$contents = DB::table(DB::raw('('.$sql.') t'))->get();

		$sql = ''.
				'SELECT * '.
				'FROM Category '.
				'WHERE CategoryID IN (SELECT CategoryID FROM `ContentCategory` WHERE ContentID IN (SELECT ContentID FROM ('.$sql.') t)) AND StatusID=1 '.
				'ORDER BY `Name` ASC';
		$categories = DB::table(DB::raw('('.$sql.') t'))->get();
		//$categories = Category::where('ApplicationID', '=', (int)$applicationID)->where('StatusID', '=', eStatus::Active)->order_by('Name', 'ASC')->get();

    	$data = array(
    		'filterSearch' => $search,
    		'filterCat' => $cats,
    		'cat' => $categories,
    		'contents' => $contents
		);
		return View::make('flipbook.index', $data);
    }

	//POST
	public function post_check()
    {
		try
		{
			$url = Input::get('url');
			
			$connectable = false;
			$handle   = curl_init($url);
			if ($handle !== false)
			{
				curl_setopt($handle, CURLOPT_HEADER, true);
				curl_setopt($handle, CURLOPT_FAILONERROR, true);
				curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				curl_setopt($handle, CURLOPT_NOBODY, false);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
				//curl_setopt($handle, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				$connectable = curl_exec($handle);
				curl_close($handle);
			}
			if($connectable)
			{
				return "success=".base64_encode("true");
			}
			return "success=".base64_encode("false");
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
	}
	
	public function post_save()
    {
		//return "success=".base64_encode("false");
		try
		{
			$currentUser = Auth::User();
			
			$included = (int)Input::get('included');
			$contentFileID = (int)Input::get('contentfileid');
			$contentID = (int)ContentFile::find($contentFileID)->ContentID;
			$applicationID = (int)Content::find($contentID)->ApplicationID;
			$customerID = (int)Application::find($applicationID)->CustomerID;
			
			if(!Common::CheckContentOwnership($contentID))
			{
				throw new Exception(__('error.unauthorized_user_attempt'));
			}

			if(!Common::AuthInteractivity($applicationID))
			{
				throw new Exception(__('error.auth_interactivity'));
			}
			
			DB::transaction(function() use ($currentUser, $customerID, $applicationID, $contentID, $contentFileID, $included)
			{
				$closing = Input::get('closing');
				$pageNo = (int)Input::get('pageno');
				$ids = Input::get('compid');
				
				//find current page id
				$ContentFilePageID = 0;
				
				$cfp = DB::table('ContentFilePage')
					->where('ContentFileID', '=', $contentFileID)
					->where('No', '=', $pageNo)
					->where('StatusID', '=', eStatus::Active)
					->first();
				if($cfp)
				{
					$ContentFilePageID = (int)$cfp->ContentFilePageID;
				}
				
				if($closing == "true")
				{
					$cf = ContentFile::find($contentFileID);
					$cf->Interactivity = 1;
					$cf->HasCreated = 0;
					$cf->ErrorCount = 0;
					$cf->InteractiveFilePath = '';
					$cf->InteractiveFileName = '';
					$cf->InteractiveFileName2 = '';
					$cf->InteractiveFileSize = 0;
					$cf->Included = ($included == 1 ? 1 : 0);
					$cf->ProcessUserID = $currentUser->UserID;
					$cf->ProcessDate = new DateTime();
					$cf->ProcessTypeID = eProcessTypes::Update;
					$cf->save();
				}
				else
				{
					$cf = ContentFile::find($contentFileID);
					$cf->Included = ($included == 1 ? 1 : 0);
					$cf->ProcessUserID = $currentUser->UserID;
					$cf->ProcessDate = new DateTime();
					$cf->ProcessTypeID = eProcessTypes::Update;
					$cf->save();
				}
				
				if($ids !== null)
				{
					foreach($ids as $id)
					{
						$clientComponentID = (int)Input::get('comp-'.$id.'-id', '0');
						$clientPageComponentID = (int)Input::get('comp-'.$id.'-pcid', '0');
						$clientProcess = Input::get('comp-'.$id.'-process', '');
						
						if($clientProcess == 'new' || $clientProcess == 'loaded')
						{
							$tPageComponentExists = false;
							$tPageComponentID = 0;
							
							if($clientProcess == 'loaded' && $clientPageComponentID > 0)
							{
								$tPageComponentExists = true;
								$tPageComponentID = $clientPageComponentID;
							}
							else
							{
								$current = DB::table('PageComponent')
											->where('ContentFilePageID', '=', $ContentFilePageID)
											->where('No', '=', $id)
											->where('StatusID', '=', eStatus::Active)
											->first();
								if($current)
								{
									$tPageComponentExists = true;
									$tPageComponentID = $current->PageComponentID;
								}
							}
							
							if(!$tPageComponentExists)
							{
								$pc = new PageComponent();	
							}
							else
							{
								$pc = PageComponent::find($tPageComponentID);
								
								if($ContentFilePageID != (int)$pc->ContentFilePageID)
								{
									throw new Exception("Unauthorized user attempt");
								}
							}
							$pc->ContentFilePageID = $ContentFilePageID;
							$pc->ComponentID = $clientComponentID;
							$pc->No = $id;
							$pc->StatusID = eStatus::Active;
							if(!$tPageComponentExists)
							{
								$pc->CreatorUserID = $currentUser->UserID;
								$pc->DateCreated = new DateTime();	
							}
							$pc->ProcessUserID = $currentUser->UserID;
							$pc->ProcessDate = new DateTime();
							if(!$tPageComponentExists)
							{
								$pc->ProcessTypeID = eProcessTypes::Insert;
							}
							else
							{
								$pc->ProcessTypeID = eProcessTypes::Update;	
							}
							$pc->save();
							
							$pageComponentID = $pc->PageComponentID;
							
							if($tPageComponentExists)
							{
								DB::table('PageComponentProperty')
									->where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`='.$pageComponentID.' AND `ContentFilePageID`='.$ContentFilePageID.' AND `StatusID`=1)'))
									->where('StatusID', '=', eStatus::Active)
									->update(
										array(
											'StatusID' => eStatus::Deleted,
											'ProcessUserID' => $currentUser->UserID,
											'ProcessDate' => new DateTime(),
											'ProcessTypeID' => eProcessTypes::Update
										)
									);	
							}
							
							$postedData = Input::get();
							foreach($postedData as $name => $value)
							{
								if(Common::startsWith($name, 'comp-'.$id))
								{
									//Log::info('name:'.$name.' value:'.$value);
									
									$name = str_replace('comp-'.$id.'-', "", $name);
									
									if($name !== "id" && $name !== "process" && $name !== "fileselected" && $name !== "posterimageselected" && $name !== "modaliconselected")
									{
										//slideshow || gallery360
										if(($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value))
										{
											$index = 1;
											
											foreach($value as $v)
											{
												if(Str::length($v) > 0)
												{
													$sourcePath = 'files/temp';
													$sourcePathFull = path('public').$sourcePath;
													$sourceFile = $v;
													$sourceFileNameFull = $sourcePathFull.'/'.$sourceFile;
													
													$targetPath = 'files/customer_'.$customerID.'/application_'.$applicationID.'/content_'.$contentID.'/file_'.$contentFileID.'/output/comp_'.$pageComponentID;
													$targetPathFull = path('public').$targetPath;
													$targetFile = $currentUser->UserID.'_'.date("YmdHis").'_'.$v;
													//360
													if($clientComponentID == 9)
													{
														$targetFile = ($index < 10 ? '0'.$index : ''.$index).'.jpg';
													}
													$targetFileNameFull = $targetPathFull.'/'.$targetFile;
													
													if(!File::exists($targetPathFull))
													{
														File::mkdir($targetPathFull);
													}
												
													if(File::exists($sourceFileNameFull))
													{
														File::move($sourceFileNameFull, $targetFileNameFull);
														$v = $targetPath.'/'.$targetFile;
													}
													else
													{
														$oldValue = DB::table('PageComponentProperty')
																->where('PageComponentID', '=', $pc->PageComponentID)
																->where('Name', '=', $name)
																->where('Value', 'LIKE', '%'.$v)
																->where('StatusID', '=', eStatus::Deleted)
																->order_by('PageComponentPropertyID', 'DESC')
																->first(array('Value'));
														if($oldValue) {
															$v = $oldValue->Value;
														}
														else {
															$v = $targetPath.'/'.$v;
														}
														//TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
														//$v = $targetPath.'/'.$v;
													}
													
													$pcp = new PageComponentProperty();
													$pcp->PageComponentID = $pc->PageComponentID;
													$pcp->Name = $name;
													$pcp->Value = $v;
													$pcp->StatusID = eStatus::Active;
													$pcp->CreatorUserID = $currentUser->UserID;
													$pcp->DateCreated = new DateTime();
													$pcp->ProcessUserID = $currentUser->UserID;
													$pcp->ProcessDate = new DateTime();
													$pcp->ProcessTypeID = eProcessTypes::Insert;
													$pcp->save();
													
													$index = $index + 1;	
												}
											}
										}
										else
										{
											if(($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname') && Str::length($value) > 0)
											{
												$sourcePath = 'files/temp';
												$sourcePathFull = path('public').$sourcePath;
												$sourceFile = $value;
												$sourceFileNameFull = $sourcePathFull.'/'.$sourceFile;
												
												$targetPath = 'files/customer_'.$customerID.'/application_'.$applicationID.'/content_'.$contentID.'/file_'.$contentFileID.'/output/comp_'.$pageComponentID;
												$targetPathFull = path('public').$targetPath;
												$targetFile = $currentUser->UserID.'_'.date("YmdHis").'_'.$value;
												$targetFileNameFull = $targetPathFull.'/'.$targetFile;
												
												if(!File::exists($targetPathFull))
												{
													File::mkdir($targetPathFull);
												}
											
												if(File::exists($sourceFileNameFull))
												{
													File::move($sourceFileNameFull, $targetFileNameFull);
													$value = $targetPath.'/'.$targetFile;
												}
												else
												{
													$oldValue = DB::table('PageComponentProperty')
															->where('PageComponentID', '=', $pc->PageComponentID)
															->where('Name', '=', $name)
															->where('StatusID', '=', eStatus::Deleted)
															->order_by('PageComponentPropertyID', 'DESC')
															->first(array('Value'));

													if($oldValue) {
														$value = $oldValue->Value;
													}
													else {
														$value = $targetPath.'/'.$value;
													}
													//TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
													//$value = $targetPath.'/'.$value;
												}
											}
											
											if($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://'))
											{
												 $value = 'http://'.$value;
											}
											
											$pcp = new PageComponentProperty();
											$pcp->PageComponentID = $pc->PageComponentID;
											$pcp->Name = $name;
											$pcp->Value = $value;
											$pcp->StatusID = eStatus::Active;
											$pcp->CreatorUserID = $currentUser->UserID;
											$pcp->DateCreated = new DateTime();
											$pcp->ProcessUserID = $currentUser->UserID;
											$pcp->ProcessDate = new DateTime();
											$pcp->ProcessTypeID = eProcessTypes::Insert;
											$pcp->save();
										}
									}
								}
							}
						}
						elseif($clientProcess == 'removed' && $clientPageComponentID > 0)
						{
							DB::table('PageComponentProperty')
								->where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`='.$clientPageComponentID.' AND `ContentFilePageID`='.$ContentFilePageID.' AND `StatusID`=1)'))
								->where('StatusID', '=', eStatus::Active)
								->update(
									array(
										'StatusID' => eStatus::Deleted,
										'ProcessUserID' => $currentUser->UserID,
										'ProcessDate' => new DateTime(),
										'ProcessTypeID' => eProcessTypes::Update
									)
								);
							
							DB::table('PageComponent')
								->where('PageComponentID', '=', $clientPageComponentID)
								->where('ContentFilePageID', '=', $ContentFilePageID)
								->where('StatusID', '=', eStatus::Active)
								->update(
									array(
										'StatusID' => eStatus::Deleted,
										'ProcessUserID' => $currentUser->UserID,
										'ProcessDate' => new DateTime(),
										'ProcessTypeID' => eProcessTypes::Update
									)
								);
							
							//TODO:Delete current file
						}
					}	
				}
			});
			return "success=".base64_encode("true");
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
    }

	public function post_transfer()
    {
		//return "success=".base64_encode("false");
		try
		{
			$currentUser = Auth::User();
			
			$pageFrom = (int)Input::get('from', '0');
			$pageTo = (int)Input::get('to', '0');
			$componentID = (int)Input::get('componentid', '0');
			$contentFileID = (int)Input::get('contentfileid', '0');
			$contentID = (int)ContentFile::find($contentFileID)->ContentID;
			$applicationID = (int)Content::find($contentID)->ApplicationID;
			$customerID = (int)Application::find($applicationID)->CustomerID;
			
			if(!Common::CheckContentOwnership($contentID))
			{
				throw new Exception(__('error.unauthorized_user_attempt'));
			}

			if(!Common::AuthInteractivity($applicationID))
			{
				throw new Exception(__('error.auth_interactivity'));
			}
			
			DB::transaction(function() use ($currentUser, $customerID, $applicationID, $contentID, $contentFileID, $componentID, $pageFrom, $pageTo)
			{
				$contentFilePageIDFrom = 0;
				$cfp = DB::table('ContentFilePage')
					->where('ContentFileID', '=', $contentFileID)
					->where('No', '=', $pageFrom)
					->where('StatusID', '=', eStatus::Active)
					->first();
				if($cfp)
				{
					$contentFilePageIDFrom = (int)$cfp->ContentFilePageID;
				}

				$contentFilePageIDTo = 0;
				$cfp = DB::table('ContentFilePage')
					->where('ContentFileID', '=', $contentFileID)
					->where('No', '=', $pageTo)
					->where('StatusID', '=', eStatus::Active)
					->first();
				if($cfp)
				{
					$contentFilePageIDTo = (int)$cfp->ContentFilePageID;
				}

				$cnt = (int)DB::table('PageComponent')->where('ContentFilePageID', '=', $contentFilePageIDFrom)->where('StatusID', '=', eStatus::Active)->count();
				if($cnt == 0) {
					throw new Exception(__('interactivity.transfer_error_insufficient'));
				}

				if($componentID > 0) {
					DB::table('PageComponent')
						->where('ContentFilePageID', '=', $contentFilePageIDFrom)
						->where('No', '=', $componentID)
						->where('StatusID', '=', eStatus::Active)
						->update(array(
							'ContentFilePageID' => $contentFilePageIDTo,
							'ProcessUserID' => $currentUser->UserID,
							'ProcessDate' => new DateTime(),
							'ProcessTypeID' => eProcessTypes::Update
						)
					);
				}
				else {
					DB::table('PageComponent')
						->where('ContentFilePageID', '=', $contentFilePageIDFrom)
						->where('StatusID', '=', eStatus::Active)
						->update(array(
							'ContentFilePageID' => $contentFilePageIDTo,
							'ProcessUserID' => $currentUser->UserID,
							'ProcessDate' => new DateTime(),
							'ProcessTypeID' => eProcessTypes::Update
						)
					);	
				}
				
				//From
				$componentNo = 1;
				$pageComponents = DB::table('PageComponent')
					->where('ContentFilePageID', '=', $contentFilePageIDFrom)
					->where('StatusID', '=', eStatus::Active)
					->order_by('PageComponentID', 'ASC')
					->get();
				foreach($pageComponents as $component)
				{
					DB::table('PageComponent')
						->where('PageComponentID', '=', $component->PageComponentID)
						->update(array(
							'No' => $componentNo,
							'ProcessUserID' => $currentUser->UserID,
							'ProcessDate' => new DateTime(),
							'ProcessTypeID' => eProcessTypes::Update
						)
					);
					$componentNo +=1;
				}

				//To
				$componentNo = 1;
				$pageComponents = DB::table('PageComponent')
					->where('ContentFilePageID', '=', $contentFilePageIDTo)
					->where('StatusID', '=', eStatus::Active)
					->order_by('PageComponentID', 'ASC')
					->get();
				foreach($pageComponents as $component)
				{
					DB::table('PageComponent')
						->where('PageComponentID', '=', $component->PageComponentID)
						->update(array(
							'No' => $componentNo,
							'ProcessUserID' => $currentUser->UserID,
							'ProcessDate' => new DateTime(),
							'ProcessTypeID' => eProcessTypes::Update
						)
					);
					$componentNo +=1;
				}
			});
			return "success=".base64_encode("true");
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
    }
	
	public function post_refreshtree()
    {
    	//return "success=".base64_encode("false");
		try
		{
			$currentUser = Auth::User();
			
			$contentFileID = (int)Input::get('contentfileid', '0');
			$contentID = (int)ContentFile::find($contentFileID)->ContentID;
			$applicationID = (int)Content::find($contentID)->ApplicationID;
			$customerID = (int)Application::find($applicationID)->CustomerID;
			
			if(!Common::CheckContentOwnership($contentID))
			{
				throw new Exception(__('error.unauthorized_user_attempt'));
			}

			if(!Common::AuthInteractivity($applicationID))
			{
				throw new Exception(__('error.auth_interactivity'));
			}
			$data = array(
	    		'ContentFileID' => $contentFileID
			);
			$html = View::make('interactivity.tree', $data)->render();
			return "success=".base64_encode("true")."&html=".base64_encode($html);
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
    }

	public function post_upload()
    {
		//$file = Input::file('Filedata');
		//$filePath = path('public').'files/temp';
		//$fileName = File::name($file['name']);
		//$fileExt = File::extension($file['name']);
		//$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;
		
		$type = Input::get('type');
		$element = Input::get('element');
		
		$options = array();
		if($type == 'uploadvideofile')
		{
			$options = array(
				//'script_url' => URL::to_route('contents_uploadcoverimage'),
				'upload_dir' => path('public').'files/temp/',
				'upload_url' => URL::base().'/files/temp/',
				'param_name' => $element,
				'accept_file_types' => '/\.(mp4)$/i'
			);	
		}
		else if($type == 'uploadaudiofile')
		{
			$options = array(
				//'script_url' => URL::to_route('contents_uploadcoverimage'),
				'upload_dir' => path('public').'files/temp/',
				'upload_url' => URL::base().'/files/temp/',
				'param_name' => $element,
				'accept_file_types' => '/\.(mp3)$/i'
			);
		}
		else if($type == 'uploadimage')
		{
			$options = array(
				//'script_url' => URL::to_route('contents_uploadcoverimage'),
				'upload_dir' => path('public').'files/temp/',
				'upload_url' => URL::base().'/files/temp/',
				'param_name' => $element,
				'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
			);
		}
		$upload_handler = new UploadHandler($options);
		
		if (!Request::ajax())
			return;
		
		$upload_handler->post("");
    }
	
	public function post_loadpage()
    {
		try
		{
			$currentUser = Auth::User();
			
			$contentFileID = (int)Input::get('contentfileid');
			$pageNo = (int)Input::get('pageno');
			
			$contentID = (int)ContentFile::find($contentFileID)->ContentID;
			$applicationID = (int)Content::find($contentID)->ApplicationID;
			$customerID = (int)Application::find($applicationID)->CustomerID;
			
			if(!Common::CheckContentOwnership($contentID))
			{
				throw new Exception(__('error.unauthorized_user_attempt'));
			}

			if(!Common::AuthInteractivity($applicationID))
			{
				throw new Exception(__('error.auth_interactivity'));
			}

			$ContentFilePageID = 0;
			
			$cfp = DB::table('ContentFilePage')
				->where('ContentFileID', '=', $contentFileID)
				->where('No', '=', $pageNo)
				->where('StatusID', '=', eStatus::Active)
				->first();
			if($cfp)
			{
				$ContentFilePageID = (int)$cfp->ContentFilePageID;
			}
			
			$pageCount = DB::table('ContentFilePage')
				->where('ContentFileID', '=', $contentFileID)
				->where('StatusID', '=', eStatus::Active)
				->count();
					
			$toolC = '';
			$propC = '';
			
			$pc = DB::table('PageComponent')
				->where('ContentFilePageID', '=', $ContentFilePageID)
				->where('StatusID', '=', eStatus::Active)
				->get();
			foreach($pc as $c)
			{
				$componentClass = PageComponent::find($c->PageComponentID)->Component()->Class;
				
				$cp = DB::table('PageComponentProperty')
					->where('PageComponentID', '=', $c->PageComponentID)
					->where('StatusID', '=', eStatus::Active)
					->get();
					
				$cpX = DB::table('PageComponentProperty')
					->where('PageComponentID', '=', $c->PageComponentID)
					->where('Name', '=', 'x')
					->where('StatusID', '=', eStatus::Active)
					->first();
					
				$cpY = DB::table('PageComponentProperty')
					->where('PageComponentID', '=', $c->PageComponentID)
					->where('Name', '=', 'y')
					->where('StatusID', '=', eStatus::Active)
					->first();
				
				$cpTriggerX = DB::table('PageComponentProperty')
					->where('PageComponentID', '=', $c->PageComponentID)
					->where('Name', '=', 'trigger-x')
					->where('StatusID', '=', eStatus::Active)
					->first();
					
				$cpTriggerY = DB::table('PageComponentProperty')
					->where('PageComponentID', '=', $c->PageComponentID)
					->where('Name', '=', 'trigger-y')
					->where('StatusID', '=', eStatus::Active)
					->first();
				
				$x = 0;
				$y = 0;
				$trigger_x = 0;
				$trigger_y = 0;
				if($cpX) $x = (int)$cpX->Value;
				if($cpY) $y = (int)$cpY->Value;
				if($cpTriggerX) $trigger_x = (int)$cpTriggerX->Value;
				if($cpTriggerY) $trigger_y = (int)$cpTriggerY->Value;
				
				if($componentClass == "audio" || $componentClass == "bookmark")
				{
					$x = $trigger_x;
					$y = $trigger_y;
				}
					
				$data = array(
					'ComponentID' => $c->ComponentID,
					'PageComponentID' => $c->PageComponentID,
					'Process' => 'loaded',
					'PageCount' => $pageCount,
					'Properties' => $cp
				);
				$tool = View::make('interactivity.components.'.$componentClass.'.tool', $data)->render();
				//$tool = str_replace("{id}", $c->PageComponentID, $tool);
				$tool = str_replace("{id}", $c->No, $tool);
				$tool = str_replace("{name}", $componentClass, $tool);
				$tool = str_replace("{x}", $x, $tool);
				$tool = str_replace("{y}", $y, $tool);
				$tool = str_replace("{trigger-x}", $trigger_x, $tool);
				$tool = str_replace("{trigger-y}", $trigger_y, $tool);
				$toolC .= $tool;
				
				$prop = View::make('interactivity.components.'.$componentClass.'.property', $data)->render();
				//$prop = str_replace("{id}", $c->PageComponentID, $prop);
				$prop = str_replace("{id}", $c->No, $prop);
				$propC .= $prop;
			}
			return "success=".base64_encode("true")."&tool=".base64_encode($toolC)."&prop=".base64_encode($propC);
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
    }
	
	
}