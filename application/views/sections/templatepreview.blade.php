<div class="form-row">
	<div class="col-md-3">{{__('common.banners_image')}}</div>
	<div class="col-md-8" style="position:relative;">
		<div class="col-md-6" style="width:46%; padding:0; margin-left:-9px;">
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
		<div class="col-md-6" style="position:absolute;bottom:0;right:0;padding:0;width:56%;">
			<div data-device="ipad" data-orientation="landscape" data-color="white" class="device-mockup">
				<div class="device">
					<div class="screen">
						<div class="templateScreen">
							<div class="header clearfix" style="height:21px !important;">
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
							<div class="footer text-center" style="height:19px !important; padding: 4px 7px;">
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
</div>