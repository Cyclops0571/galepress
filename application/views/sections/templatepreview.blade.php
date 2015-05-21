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
		margin-left: 16px;
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
</style>
<div class="tabletIcons">
	<span class="icon-tablet tabletActive"></span>
	<span class="icon-tablet tabletLandscape"></span>
</div>
<div class="form-row" style="margin-top:0;">
	<div id="portraitTablet" class="col-md-12" style="width:65%; padding:0;">
		<div data-device="ipad" data-orientation="portrait" data-color="white" class="device-mockup">
			<div class="device">
				<div class="screen">
					<div class="templateScreen">
						<div class="header clearfix">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
								<div class="header-categories"></div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="ms-gallery-template" id="ms-gallery-1">
										<!-- masterslider -->
										<div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
											<?php foreach ($bannerSet as $savedBanner): ?>
												<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
													<?php $imgPath = $savedBanner->getImagePath($application); ?>
													<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" /> 
													<div class="ms-info">{{$savedBanner->Description}}</div>
													<a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a>
												</div>
											<?php endforeach; ?>
											<?php if (empty($bannerSet)): ?>
												<?php for ($i = 0; $i < 4; $i++): ?>
													<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
														<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}"/> 
														<div class="ms-info"></div>
														<a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a>
													</div>
												<?php endfor; ?>
											<?php endif; ?>
										</div>
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
				</div>
			</div>
		</div>
	</div>
	<div id="landscapeTablet" class="col-md-6 hide" style="width:100%; padding:0;">
		<div data-device="ipad" data-orientation="landscape" data-color="white" class="device-mockup">
			<div class="device">
				<div class="screen">
					<div class="templateScreen">
						<div class="header clearfix">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left" style="padding:0;">
								<div class="header-categories"></div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center app-name">{{$templateResults[0]->ApplicationName}}</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="ms-gallery-template" id="ms-gallery-2">
										<!-- masterslider -->
										<div class="master-slider ms-skin-black-2 round-skin" id="masterslider2">
											<?php foreach ($bannerSet as $savedBanner): ?>
												<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
													<?php $imgPath = $savedBanner->getImagePath($application); ?>
													<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" /> 
													<div class="ms-info">{{$savedBanner->Description}}</div>
													<a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a>
												</div>
											<?php endforeach; ?>
											<?php if (empty($bannerSet)): ?>
												<?php for ($i = 0; $i < 4; $i++): ?>
													<div class="ms-slide" data-delay="{{$application->BannerIntervalTime}}">
														<img src="/img/bannerSlider/blank.gif" data-src="{{$defaultSliderImage}}"/> 
														<div class="ms-info"></div>
														<a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a>
													</div>
												<?php endfor; ?>
											<?php endif; ?>
										</div>
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
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('.tabletIcons span:eq(0)').click(function(){
	$('.tabletIcons span').removeClass('tabletActive');
	$(this).addClass('tabletActive');
	$('#portraitTablet').removeClass('hide');
	$('#landscapeTablet').addClass('hide');
})
$('.tabletIcons span:eq(1)').click(function(){
	$('.tabletIcons span').removeClass('tabletActive');
	$(this).addClass('tabletActive');
	$('#portraitTablet').addClass('hide');
	$('#landscapeTablet').removeClass('hide');
})
</script>