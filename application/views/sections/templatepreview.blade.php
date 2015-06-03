<?php
$defaultSliderImage = '/img/bannerSlider/defaultPreview.jpg';
?>
<style>			
	#ms-gallery-1{
		margin:0 auto;
	}
	.ms-gallery-template .ms-bullets.ms-dir-h,.ms-bullets.ms-dir-h .ms-bullets-count {
		right: 3% !important;
	}
	.ms-gallery-template .ms-gallery-botcont{
		position: absolute !important;
		bottom:0 !important;
		width: 100% !important;
		opacity: 0.7;
		height: 25% !important;
	}
	.ms-gallery-template .ms-slide-info{
		padding: 0px 20px !important;
		font-size: 0.8em !important;
	}
	.ms-info{
		display: table-cell !important;
		vertical-align: middle !important;
	}
	.ms-bullets-count{
		display: table-cell !important;
		vertical-align: middle !important;
	}
	.ms-gallery-template .ms-gal-playbtn{
		display: none !important;
	}
	.ms-gallery-template .ms-gal-thumbtoggle{
		display: none !important;
	}
	.ms-timerbar{
		display: none !important;
	}
	.ms-slide-info.ms-dir-h,.ms-bullets.ms-dir-h{
		height: 100% !important;
		display: table !important;
		top:0 !important;
	}
	.tabletLandscape{
	    -ms-transform: rotate(90deg); /* IE 9 */
	    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
	    transform: rotate(90deg);
	    position: absolute;
	    bottom: 0;
	    margin-left: 10px;
	}
	.tabletIcons{
		font-size: 25px;
		margin-left: 5%;
		position: relative;
		height: 26px;
	}
	.tabletIcons span{
		cursor: pointer;
		opacity: 0.5;
	}
	.tabletIcons span:hover{
		opacity: 1;
	}
	.tabletIcons .tabletActive{
		opacity: 1;
	}
	.device-mockup[data-device="ipad"][data-orientation="portrait"] > .device > .screen .ms-inner-controls-cont{
		max-width: 100% !important;
	}
	.device-mockup[data-device="ipad"][data-orientation="portrait"] > .device > .screen .ms-inner-controls-cont .ms-view{
		width: 100% !important;
		left: 0 !important;
	}
	.device-mockup[data-device="ipad"][data-orientation="portrait"] > .device > .screen .ms-inner-controls-cont .ms-view .ms-slide{
		width: 100% !important;
	}
	.device-mockup[data-device="ipad"][data-orientation="portrait"] > .device > .screen .ms-inner-controls-cont .ms-view .ms-slide{
		width: 100% !important;
	}
</style>

<div class="tabletIcons">
	<span class="icon-tablet tabletActive"></span>
	<span class="icon-tablet tabletLandscape"></span>
</div>
<div class="form-row" style="margin-top:0;">
	<div class="col-md-12" style="width:100%; padding:0; max-width:655px !important;">
		<div data-device="ipad" data-orientation="portrait" data-color="white" class="device-mockup">
			<div class="device">
				<div class="screen">
					<div class="templateSplashScreen" style="opacity:0; height:100%;">
						<?php $fileSplash=path('public').dirname($templateResults[0]->FilePath)."/splash.jpg";?>
						@if(!file_exists($fileSplash))
						<img src="/img/template-chooser/content-pages/empty-splash.jpg" width="100%">
						@else
						<img src=<?php echo "/".dirname($templateResults[0]->FilePath)."/splash.jpg";?> width="100%">
						@endif
					</div>
					<div class="templateScreen hide">
						<div class="header clearfix">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
								<div class="header-categories"></div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
						</div>
						<div class="container">
							<div class="form-row" style="padding-left:0.5%; padding-right:1%;">
								<div class="ms-gallery-template" id="ms-gallery-1">
									<!-- masterslider -->
									<div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
										<?php foreach ($bannerSet as $savedBanner): ?>
											<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
												<?php $imgPath = $savedBanner->getImagePath($application); ?>
												<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" class="sliderImages"/> 
												<div class="ms-info">{{$savedBanner->Description}}</div>
												<!-- <a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a> -->
											</div>
										<?php endforeach; ?>
										<?php if (empty($bannerSet)): ?>
											<?php for ($i = 0; $i < 4; $i++): ?>
												<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
													<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}" class="sliderImages"/> 
													<div class="ms-info"></div>
												</div>
											<?php endfor; ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="ms-gallery-template hide" id="ms-gallery-2">
									<!-- masterslider -->
									<div class="master-slider ms-skin-black-2 round-skin" id="masterslider2">
										<?php foreach ($bannerSet as $savedBanner): ?>
											<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
												<?php $imgPath = $savedBanner->getImagePath($application); ?>
												<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" class="sliderImages"/> 
												<div class="ms-info">{{$savedBanner->Description}}</div>
												<!-- <a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a> -->
											</div>
										<?php endforeach; ?>
										<?php if (empty($bannerSet)): ?>
											<?php for ($i = 0; $i < 4; $i++): ?>
												<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
													<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}" class="sliderImages"/> 
													<div class="ms-info"></div>
												</div>
											<?php endfor; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="form-row">
								<?php for ($i = 0; $i < 9; $i++): ?>
									<?php
									$imageSrc = "/img/template-chooser/defaultCover-" . ($i + 1) . IMAGE_EXTENSION;
									$name = "";
									$detail = "";
									if (isset($templateResults[$i])) {
										$imageSrcTmp = $templateResults[$i]->FilePath . '/' . $templateResults[$i]->FileName;
										if (is_file(path("public") . $imageSrcTmp)) {
											$imageSrc = "/" . $imageSrcTmp;
										}
										$name = $templateResults[$i]->Name;
										$detail = $templateResults[$i]->Detail;
										$Sayi = $templateResults[$i]->MonthlyName;
									}
									if ($i == 0 || $i == 3 || $i == 6) {
										echo "<div class=form-row>";
									}
									?>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<img src="{{$imageSrc}}" width="95%">
										<div class="content-bar noTouch">
											<div class="col-md-12">{{$detail}}</div>
											<div class="col-md-12">{{$name}}</div>
											<div class="col-md-12">{{$Sayi}}</div>
										</div>
									</div>
									<?php
									if ($i == 2 || $i == 5 || $i == 8) {
										echo "</div>";
									}
									?>
								<?php endfor; ?>
							</div>
						</div>
						<div class="footer text-center">
							<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
						</div>
					</div>
					<div class="templateExtrasScreen hide" style="opacity:0; overflow:hidden;">
						<div class="container">
							<div class="form-row">
                                <div class="col-md-12"><img src="/img/template-chooser/logo.png" width="100%"></div>
                            </div>
                            <div class="form-row" style="margin-top:17px;">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-search"></span></div>
                                        <input type="text" class="form-control" placeholder="Ara...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row extrasBar categories" style="margin-top:10px;">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="extra-bar-icon"></div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 title">
                                    Kategoriler
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="title-drop"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <ul style="list-style:none;">
										<?php if(empty($categorySet)): ?>
											<li><span class="category-active"></span><span> Genel</span></li>
										<?php else: ?>
											<?php $categoryClass = "category-active"; ?>
											<?php foreach($categorySet as $category): ?>
											<li><span class="<?php echo $categoryClass; ?>"></span><span>{{$category->Name;}}</span></li>
											<?php $categoryClass = "category-disable"; ?>
											<?php endforeach; ?>
										<?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-row extrasBar barLinks">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="extra-bar-icon"></div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 title">
                                    Bağlantılar
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="title-drop"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <ul style="list-style:none;">
                                        <li><span class="links links-web"></span> Web</li>
                                        <li><span class="links links-face"></span> Facebook</li>
                                        <li><span class="links links-twitter"></span> Twitter</li>
                                        <li><span class="links links-instagram"></span> Instagram</li>
                                        <li><span class="links links-linkedin"></span> Linkedin</li>
                                        <li><span class="links links-mail"></span> Mail</li>
                                    </ul>
                                </div>
							</div>
						</div>
					</div>
                    <div class="templateReadScreen hide" style="opacity:0;">
						<div class="loading"></div>
                            <div id="loading-text"><i class="icon-remove"></i> %82</div>
						<div class="container">
                                <div class="form-row" style="height:55px;">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:-8px;">
                                        <p style="overflow:hidden; height:13px;">{{$templateResults[0]->Detail}}</p>
                                        <p style="overflow:hidden; margin-bottom:7px; font-family: Avenir Medium !important;">{{$templateResults[0]->Name}}</p>
                                        <p style="overflow:hidden; width:90%; height:13px;">{{$templateResults[0]->MonthlyName}}</p>
								</div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="form-row">
										<div class="col-lg-offset-6 col-md-offset-6 col-sm-offset-6 col-xs-offset-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 content-buttons">
                                                <input type="button" class="btn" id="templateBtnUpdate" value="Güncelle" style="cursor:default; margin-top:-15px;">
										</div>
									</div>
									<div class="form-row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 content-buttons">
                                                <input type="button" class="btn" id="templateBtnRead" value="Oku" style="margin-left:-6px;">
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
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                                <div class="header-table-of-contents"></div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                              	<div class="header-share"></div>
							</div>
						</div>
						<div class="content-page">
							<img src="/img/template-chooser/content-pages/file_1.jpg" width="100%">
						</div>
						<div class="thumbnails">
							<div class="triangle"><span>283</span></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_1.jpg"></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_2.jpg"></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_3.jpg"></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_4.jpg"></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_5.jpg"></div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="/img/template-chooser/content-pages/file_6.jpg"></div>
						</div>
						<div class="footer text-center">
							<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-home footerBtnHome"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-library"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-download"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 footer-info"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var background = <?php echo $templateResults[0]->ThemeBackground; ?>;
var foreground = <?php echo $templateResults[0]->ThemeForeground; ?>;
cTemplate.initialize(background, foreground);
$('.tabletIcons span:eq(0)').click(function(){
	$('.tabletIcons span').removeClass('tabletActive');
	$(this).addClass('tabletActive');
	$('.device-mockup').attr('data-orientation','portrait');
	$('.ms-gallery-template:eq(0)').removeClass('hide');
	$('.ms-gallery-template:eq(1)').addClass('hide');
});
$('.tabletIcons span:eq(1)').click(function(){
	$('.tabletIcons span').removeClass('tabletActive');
	$(this).addClass('tabletActive');
	$('.device-mockup').attr('data-orientation','landscape');
	$('.ms-gallery-template:eq(0)').addClass('hide');
	$('.ms-gallery-template:eq(1)').removeClass('hide');
})
</script>