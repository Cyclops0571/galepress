	
@if(Auth::User()->UserTypeID != eUserTypes::Manager)
<div class="modal in" id="modalTemplateChooser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; overflow:hidden;">
	<div class="modal-dialog" style="width:40%; margin-top:0 !important; padding-top:0 !important;">
		<div class="modal-content">
			<div class="modal-body clearfix">
				<div class="controls">
					<div class="content controls">
						<div class="form-row">                       
							<div class="col-md-12">
								<div data-device="ipad" data-orientation="portrait" data-color="white" class="device-mockup">
								  <div class="device">
									<div class="screen">
										<div class="templateSplashScreen hide" style="opacity:0; height:100%;">
											<?php $fileSplash=path('public').dirname($templateResults[0]->FilePath)."/splash.jpg";?>
											@if(!file_exists($fileSplash))
											<img src="/img/template-chooser/content-pages/empty-splash.jpg" width="100%">
											@else
											<img src=<?php echo "/".dirname($templateResults[0]->FilePath)."/splash.jpg";?> width="100%">
											@endif
										</div>
										<div class="templateScreen hide" style="opacity:0;">
											<div class="header clearfix">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left">
													<div class="header-categories"></div>
												</div>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
													<div class="header-extras" style="cursor:pointer;"></div>
												</div>
											</div>
											<div class="container">
												<div class="form-row">
												<?php for($i = 0; $i < 9; $i++): ?>
													<?php
													$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
													$name = "";
													$detail = "";
													if(isset($templateResults[$i])) {
														$imageSrcTmp = $templateResults[$i]->FilePath.'/'.$templateResults[$i]->FileName;
														if(is_file(path("public") . $imageSrcTmp)) {
															$imageSrc = "/" . $imageSrcTmp;
														}
														$name = $templateResults[$i]->Name;
														$detail = $templateResults[$i]->Detail;
													}
													?>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
														<img src="{{$imageSrc}}" width="95%">


														<div class="content-bar">
															<div class="col-md-12">{{$detail}}</div>
															<div class="col-md-12">{{$name}}</div>
														</div>
													</div>
												<?php endfor; ?>
												</div>
											</div>
											<div class="footer text-center">
												<div class="footer-buttons">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
												</div>
											</div>
										</div>
										<div class="templateExtrasScreen hide" style="opacity:0;">
											<img src="/img/template-chooser/extras-panel.jpg" width="100%" height="100%">
											<div class="container">
												<div class="form-row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 social-icons"></div>
												</div>
											</div>
										</div>
										@if(count($templateResults)>0 && $templateResults[0]->ContentID!=null)
										<div class="templateReadScreen hide" style="opacity:0;">
											<div class="loading"></div>
											<div id="loading-text">95%</div>
											<div class="container">
												<div class="form-row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<p style="overflow:hidden;">{{$templateResults[0]->Detail}}</p>
														<p style="overflow:hidden;">{{$templateResults[0]->Name}}</p>
														<p style="overflow:hidden; width:90%;">{{$templateResults[0]->MonthlyName}}</p>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="form-row">
															<div class="col-lg-offset-6 col-md-offset-6 col-sm-offset-6 col-xs-offset-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 content-buttons">
																<input type="button" class="btn" id="templateBtnUpdate" value="Güncelle" style="cursor:default;">
															</div>
														</div>
														<div class="form-row">
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 content-buttons">
																<input type="button" class="btn" id="templateBtnRead" value="Oku" style="margin-left:-10px;">
															</div>
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 content-buttons">
																<input type="button" class="btn" id="templateBtnDelete" value="Sil" style="cursor:default;">
															</div>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-12">
														<img src="" width="100%"> 
													</div>
												</div>
											</div>
										</div>

										<div class="templateContentScreen hide" style="opacity:0;">
											<div class="header clearfix">
												<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
													<div class="col-md-2"><i class="app-buttons icon-reorder"></i></div>
												</div>
											</div>
											<div class="content-page">
												<img src="/img/template-chooser/content-pages/file_1.jpg" width="100%">
											</div>
											<div class="thumbnails">
												<div class="triangle"><span>283</span></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_1.jpg"></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_2.jpg"></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_3.jpg"></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_4.jpg"></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_5.jpg"></div>
												<div class="col-md-2"><img src="/img/template-chooser/content-pages/file_6.jpg"></div>
											</div>
											<div class="footer text-center">
												<div class="footer-buttons">
													<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
												</div>
											</div>
										</div>
										@endif
									</div>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="block block-drop-shadow bg-light-rtl" id="templateChooserBox" style="position:fixed; z-index:9999; display:none;">
	<!-- Tema seçici için sayfanın sağında çıkan filtrelemeyle ilgili açılır kapanır bölüm. -->
	<div class="site-settings" style="display:block;">
		<!-- <div class="site-settings-button"><span class="icon-tablet" style="font-size:30px; line-height:39px;"></span></div> -->
		<div class="site-settings-content">
			<div class="block block-transparent nm filterBlock">                
				<div class="header" style="height:35px; line-height:35px; border-bottom:1px solid black;">
					<h2>Uygulama Teması Değiştir</h2>
				</div>
				<div class="content controls reportSubtitle">
					<form id="templateForm" method="get">
						<input type="hidden" name="applicationID" value="<?php echo Input::get("applicationID", 0)?>" />
						<div class="form-row">
							<div class="col-md-12">Arkaplan:</div>
							<!-- <div class="col-md-12">
								<div class="input-group">
									<div class="input-group-addon"><span class="icon-dropbox"></span></div>
									<select style="width: 100%;" tabindex="-1" id="templateBackgroundChange" class="form-control select2">
										<option value="0">Light</option>
										<option value="1">Dark</option>
									</select>
								</div>
							</div> -->
							<div class="form-row">
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label>
											<div class="radio"><input type="radio" class="templateBackgroundChange" name="templateBackground" value="1"></div>
											Krem Havası<img src="/img/template-chooser/color-picker-light.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label>
											<div class="radio"><input type="radio" class="templateBackgroundChange" name="templateBackground" value="2"></div>
											Koyu Kahve<img src="/img/template-chooser/color-picker-dark.png" width="15" style="margin-left:10px;"></label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row" style="border-bottom:1px solid black; padding-bottom:10px;">
							<div class="col-md-12">Fontlar, Butonlar:</div>
							<!-- <div class="col-md-12">
								<div class="input-group">
									<div class="input-group-addon"><span class="icon-cloud"></span></div>
									<select style="width: 100%;" tabindex="-1" id="templateForegroundChange" class="form-control select2">
										<option value="0" style="color:#2185C5">Blue</option>
										<option value="1" style="color:#6D6D6D">Gray</option>
										<option value="2" style="color:#049604">Green</option>
										<option value="3" style="color:#FF5500" selected>Orange</option>
										<option value="4" style="color:#B9121B">Red</option>
										<option value="5" style="color:#FFCE00">Yellow</option>
									</select>
								</div>
							</div> -->
							<div class="form-row">
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#2185C5;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="1"></div>
											Gece Mavisi<img src="/img/template-chooser/color-picker-blue.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#6D6D6D;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="2"></div>
											Bataklık Grisi<img src="/img/template-chooser/color-picker-gray.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#049604;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="3"></div>
											Çimen Yeşili<img src="/img/template-chooser/color-picker-green.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#FF5500;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="4"></div>
											Portakal Turuncusu<img src="/img/template-chooser/color-picker-orange.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#B9121B;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="5"></div>
											Kiraz Kırmızısı<img src="/img/template-chooser/color-picker-red.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="radiobox-inline">
										<label style="color:#FFCE00;">
											<div class="radio"><input type="radio" class="templateForegroundChange" name="templateForeground" value="6"></div>
											Güneş Sarısı<img src="/img/template-chooser/color-picker-yellow.png" width="15" style="margin-left:10px;">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">  
								<input id="templateChooserClose" class="btn btn-mini" value="Kapat">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">  
								<input class="btn my-btn-success" type="button" onclick="cTemplate.save();" value="Temayı Kullan">
							</div> 
						</div>
					</form>
				</div>                 
			</div>
		</div>
	</div>                  
</div>
<script type="text/javascript">
		var background = <?php echo $templateResults[0]->ThemeBackground; ?>;
		var foreground = <?php echo $templateResults[0]->ThemeForeground; ?>;
		cTemplate.initialize(background, foreground);
</script>
@endif   