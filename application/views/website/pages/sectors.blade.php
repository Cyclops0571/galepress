@layout('website.html')

@section('body-content')

      <section style="background-image: url(/website/img/sectors/background.jpg);" class="header-section parallax forceCovering">
        <div class="section-shade sep-top-3x sep-bottom-3x">
          <div class="container">
            <div class="row sep-top-md">
              <div class="col-md-12">
                <div class="row">
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_digitalpublishing')}}"><img src="/website/img/sectors/new/dijital.png" data-wow-delay="0.7s" class="wow fadeInUp"></a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_digitalpublishing')}}"><p data-wow-delay="0.7s" class="lead x2 wow fadeInLeft" style="max-height:30px;">{{__('website.home_sectors_digitalpublishing')}}</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_humanresources')}}"><img src="/website/img/sectors/new/ik.png" data-wow-delay="0.9s" class="wow fadeInUp"></a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_humanresources')}}"><p data-wow-delay="0.9s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_hr')}}</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_education')}}"><img src="/website/img/sectors/new/egitim.png" data-wow-delay="1.1s" class="wow fadeInUp"></a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_education')}}"><p data-wow-delay="1.1s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_education')}}</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_realty')}}"><img src="/website/img/sectors/new/gayrimenkul.png" data-wow-delay="1.3s" class="wow fadeInUp"></a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_realty')}}"><p data-wow-delay="1.3s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_realestate')}}</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                      <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_medicine')}}">
                          <img src="<?php echo __('website.medikalpnglocation'); ?>" data-wow-delay="1.5s"
                               class="wow fadeInUp">
                      </a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_medicine')}}"><p data-wow-delay="1.5s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_pharmaceutical')}}</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_retail')}}"><img src="/website/img/sectors/new/perakende.png" data-wow-delay="1.7s" class="wow fadeInUp"></a>
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_retail')}}"><p data-wow-delay="1.7s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_retail')}}</p></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Start Icons Section-->
      <section id="team" class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/dijital.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                          <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_digitalpublishing')}}"><img src="/website/img/sectors/new/dijital.png"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_digitalpublishing')}}"><h5>{{__('website.home_sectors_digitalpublishing')}}</h5></a>
                  </div>
                  <p>{{__('website.dp_clause1')}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/ik.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                          <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_humanresources')}}"><img src="/website/img/sectors/new/ik.png"></a></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_humanresources')}}"><h5>{{__('website.home_sectors_hr')}}</h5></a>
                  </div>
                  <p>{{__('website.hr_clause1')}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/egitim.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                          <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_education')}}"><img src="/website/img/sectors/new/egitim.png"></a></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_education')}}"><h5>{{__('website.home_sectors_education')}}</h5></a>
                  </div>
                  <p>{{__('website.education_clause1')}}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row sep-top-xs">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/gayrimenkul.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                          <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_realty')}}"><img src="/website/img/sectors/new/gayrimenkul.png"></a></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_realty')}}"><h5>{{__('website.home_sectors_realestate')}}</h5></a>
                  </div>
                  <p>{{__('website.realestate_clause1')}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/ilac.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                            <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_medicine')}}">
                                    <img src="<?php echo __('website.medikalpnglocation'); ?>">
                                </a>
                            </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_medicine')}}"><h5>{{__('website.home_sectors_pharmaceutical')}}</h5></a>
                  </div>
                  <p>{{__('website.realestate_clause1')}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="team-photo"><img src="/website/img/industries/perakende.jpg" class="img-responsive">
                    <div class="team-connection">
                      <div class="team-connection-list text-center">
                        <ul>
                          <li><a href="/{{ Session::get('language') }}/{{__('route.website_sectors_retail')}}"><img src="/website/img/sectors/new/perakende.png"></a></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 sep-top-xs">
                  <div class="team-name">
                    <a href="/{{ Session::get('language') }}/{{__('route.website_sectors_retail')}}"><h5>{{__('website.home_sectors_retail')}}</h5></a>
                  </div>
                  <p>{{__('website.retail_clause1')}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



      <section class="call-to-action bg-primary sep-top-md sep-bottom-md">
        <div class="container">
          <div class="row">
            <div class="col-md-9">
              <h5 class="action-title upper light"></h5>
            </div>
            <div class="col-md-3 text-right"><a href="/{{ Session::get('language') }}/{{__('route.website_tryit')}}" class="btn btn-light btn-bordered btn-lg">{{__('website.menu_tryit')}}</a></div>
          </div>
        </div>
      </section>



@endsection