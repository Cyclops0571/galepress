@layout('website.html')

@section('body-content')

      <section id="home" class="demo-1">
        <!-- Start slider-wrapper-->
        <div id="slider" style="display:none;" class="sl-slider-wrapper">
          <div class="fluid-width-video-wrapper" style="z-index:98;">
            <video id="home-video" autoplay="autoplay" loop="loop" muted="muted" style="width:100% !important;" poster="/website/img/video/poster.jpg">
              <source src="/website/video/galepressVideo.mp4" type="video/mp4">
            </video>
          </div>
          <div class="sl-slider" style="z-index:99;">
            <!-- start slide-->
            <div data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2" class="sl-slide">
              <div style="background-image: url(/website/img/intro-home9.jpg);" class="sl-slide-inner"></div>
            </div>
            <div data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5" class="sl-slide" style="z-index:99;">

              <div style="background: none;" class="sl-slide-inner">

                <div class="slide-container">
                  <div class="slide-content text-center" id="videoSlide" style="display:none;">
                    <h2 class="main-title" style="font-weight:200; margin-bottom:40px;">Mobil Dünya Parmaklarınızın Ucunda!</h2>
                    <blockquote class="sep-top-xs">
                      <a href="/tr/deneyin" class="btn btn-light btn-bordered btn-lg">Deneyin</a><a href="/tr/nasil-calisir" class="btn btn-primary btn-lg">Keşfedin</a>
                    </blockquote>
                  </div>
                  <!-- <iframe src="//player.vimeo.com/video/121023414?title=0&amp;byline=0&amp;badge=0&amp;portrait=0&amp;color=59a1de&amp;autoplay=1&amp;loop=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
                  <!-- <iframe src="http://galetest.com/website/video/galepress.mp4" frameborder="0" style="position:absolute; top:0; left:0; width:100%; height:100%;"></iframe> -->
                  <!-- <video autoplay loop poster="/website/img/video/poster.jpg">
                    <source src="/website/video/galepress.mp4" type="video/mp4">
                  </video> -->
                </div>
              </div>
            </div>
            <!-- end slide-->
          </div>
        </div>
        <!-- End slider-wrapper-->
      </section>
      <!-- Start Parallax section-->
      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="section-title text-center wow bounceInDown">
                <h3 class="small-space" style="font-size:3.7em; color:#777; font-weight:lighter;">Bütün Çözümler İçin Tek Platform</h3>
                <p class="lead lighter" style="font-size:1.7em; color:black; font-weight:lighter;">Şirketinizin ihtiyacı olan çözüm müşteri etkileşimini arttırmak, satış etkinliğini yükseltmek, daha iyi elemanlar işe almak veya baskı maliyetlerini düşürmek olabilir. Bu çözümlerin hepsini ve daha fazlasını Galepress'in çevik yapısı sayesinde çok kısa bir sürede hayata geçirebileceksiniz. Kiralama modeli sayesinde mobil çözümler departmanınız için personel, daha geniş bir ofis ve danışmanlık gibi masraflarınız da olmayacak. Mobil dünya artık parmaklarınızın ucunda.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="parallax4" style="background-image: url(/website/img/sectors/background.jpg);" class="parallax">
        <div id="charts-wrapper" class="section-shade sep-top-3x sep-bottom-3x">
          <div class="container">
            <div data-wow-delay="1s" class="section-title sep-bottom-md text-center wow bounceInDown">
              <h1 class="light" style="letter-spacing:5px; font-weight:200;">İstediğiniz Her Alanda</h1>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-dijital-yayincilik"><img src="/website/img/sectors/new/dijital.png" data-wow-delay="0.7s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-dijital-yayincilik"><p data-wow-delay="0.7s" class="lead x2 wow fadeInLeft" style="max-height:30px;">Dijital Yayıncılık</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-insan-kaynaklari"><img src="/website/img/sectors/new/ik.png" data-wow-delay="0.9s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-insan-kaynaklari"><p data-wow-delay="0.9s" class="lead x2 wow fadeInLeft">İK</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-egitim"><img src="/website/img/sectors/new/egitim.png" data-wow-delay="1.1s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-egitim"><p data-wow-delay="1.1s" class="lead x2 wow fadeInLeft">Eğitim</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-gayrimenkul"><img src="/website/img/sectors/new/gayrimenkul.png" data-wow-delay="1.3s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-gayrimenkul"><p data-wow-delay="1.3s" class="lead x2 wow fadeInLeft">Gayrimenkul</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-ilac"><img src="/website/img/sectors/new/medikal.png" data-wow-delay="1.5s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-ilac"><p data-wow-delay="1.5s" class="lead x2 wow fadeInLeft">İlaç</p></a>
                  </div>
                  <div data-wow-delay="0.5s" class="sectors col-md-2 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                    <a href="/tr/cozumler-perakende"><img src="/website/img/sectors/new/perakende.png" data-wow-delay="1.7s" class="wow fadeInUp"></a>
                    <a href="/tr/cozumler-perakende"><p data-wow-delay="1.7s" class="lead x2 wow fadeInLeft">Perakende</p></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Parallax section-->
      <!-- Start About section-->
      <!-- Start Clients section-->
      <section class="sep-top-md sep-bottom-2x">
        <div class="container">
          <div data-auto-play="true" data-items="4" data-auto-height="false" class="home-showcase owl-carousel owl-theme">
            <div class="item">
              <div class="col-md-12">
                <div class="sep-top-xs sep-bottom-sm item-ipad">
                  <div class="team-photo">
                    <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait" data-color="white">
                      <div class="device">
                          <div class="screen">
                              <div data-auto-play="true" data-items="3" data-single-item="true" class="owl-carousel owl-theme">
                                  <div class="item"><img src="/website/img/clients/carrefoursa/1.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/carrefoursa/2.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/carrefoursa/3.jpg" alt="" class="img-responsive"></div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="team-name">
                  <h5 class="upper">CarrefourSA</h5><span>Yönetim</span>
                </div>
                <em>Galepress bizim için bir maliyet değil gelir kalemi oldu. Baskı maliyetlerinden ettiğimiz tasarruf kiralama modeli ile edindiğimiz bu platformun maliyetlerini çoktan dengeledi.</em>
              </div>
            </div>
            <div class="item">
              <div class="col-md-12">
                <div class="sep-top-xs sep-bottom-sm item-ipad">
                  <div class="team-photo">
                    <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait" data-color="white">
                      <div class="device">
                          <div class="screen">
                              <div data-auto-play="true" data-items="3" data-single-item="true" data-auto-height="true" class="owl-carousel owl-theme">
                                  <div class="item"><img src="/website/img/clients/zendiamond/1.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/zendiamond/2.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/zendiamond/3.jpg" alt="" class="img-responsive"></div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="team-name">
                  <h5 class="upper">Zen Diamond</h5><span>Yönetim</span>
                </div>
                <em>Bütün markalar için ulaşması zor olan VIP kitleye erişimimiz Galepress sayesinde farklı bir rotaya girdi. Galepress bizim gözümüzle "dijital dünyanın pırlantası"</em>
              </div>
            </div><div class="item">
              <div class="col-md-12">
                <div class="sep-top-xs sep-bottom-sm item-ipad">
                  <div class="team-photo">
                    <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait" data-color="white">
                      <div class="device">
                          <div class="screen">
                              <div data-auto-play="true" data-items="3" data-single-item="true" data-auto-height="true" class="owl-carousel owl-theme">
                                  <div class="item"><img src="/website/img/clients/renovia/1.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/renovia/2.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/renovia/3.jpg" alt="" class="img-responsive"></div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="team-name">
                  <h5 class="upper">Renovia</h5><span>Yönetim</span>
                </div>
                <em>Rakiplerimiz uygulama geliştiriclerle ardı arkası gelmeyen toplantılar yapıp zaman kaybederken Galepress ile 2 hafta içerisinde mobil dünyaya girip müşterilerimize aplikasyonumuzu yükletmeye başladık.</em>
              </div>
            </div><div class="item">
              <div class="col-md-12">
                <div class="sep-top-xs sep-bottom-sm item-ipad">
                  <div class="team-photo">
                    <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait" data-color="white">
                      <div class="device">
                          <div class="screen">
                              <div data-auto-play="true" data-items="3" data-single-item="true" data-auto-height="true" class="owl-carousel owl-theme">
                                  <div class="item"><img src="/website/img/clients/pleon/1.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/pleon/2.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/pleon/3.jpg" alt="" class="img-responsive"></div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="team-name">
                  <h5 class="upper">Pleon Sportivo</h5><span>Yönetim</span>
                </div>
                <em>Aradığı bilgileri mobil aplikasyonumuzda bulabilen müşterilerimiz bizi telefonla arayıp bilgi almaktan vazgeçti. Galepress ile kaybedildikten sonra yerine konulamayan tek kaynaktan tasarruf ettik: Zaman.</em>
              </div>
            </div><div class="item">
              <div class="col-md-12">
                <div class="sep-top-xs sep-bottom-sm item-ipad">
                  <div class="team-photo">
                    <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait" data-color="white">
                      <div class="device">
                          <div class="screen">
                              <div data-auto-play="true" data-items="3" data-single-item="true" data-auto-height="true" class="owl-carousel owl-theme">
                                  <div class="item"><img src="/website/img/clients/mopas/1.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/mopas/2.jpg" alt="" class="img-responsive"></div>
                                  <div class="item"><img src="/website/img/clients/mopas/3.jpg" alt="" class="img-responsive"></div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="team-name">
                  <h5 class="upper">Mopaş</h5><span>Yönetim</span>
                </div>
                <em>Müşterilerimize her zaman en iyi kaliteyi en uygun fiyata tedarik etme prensibimizi paylaşan bir platform ile çalıştığımız için çok memnunuz. Müşterilerimizi kampanyalarımızdan daha kolay haberdar Galepress sayesinde bir kazan-kazan modeli oluşturabildik.</em>
              </div>
            </div>         
 
          </div>
        </div>
      </section>
      <!-- End Clients section-->
      <section id="about" class="sep-top-md sep-bottom-md bg-primary">
        <div class="container">
          <div class="row">
            <div class="col-md-4 text-right">
              <div class="sep-top-md sep-bottom-md">
                <div class="bordered-right section-title">
                  <h2 class="upper"><span class="light" style="color:white;">İNTERAKTİF</span> TASARLAYICI</h2>
                </div>
                <p class="lead">Dokümanınızın içeriğini hareketli ve sesli görsellerle zenginleştirin.</p>
                <div class="sep-top-xs"><a href="/tr/deneyin" data-wow-delay=".5s" class="btn btn-light btn-bordered btn-lg wow bounceInLeft animated" style="visibility: visible; -webkit-animation-delay: 0.5s;">DENEYİN</a></div>
              </div>
            </div>
            <div class="col-md-8 col-xs-12 intAnimeFrame">
              <div class="col-md-1 col-lg-offset-1 col-xs-1 compLeftCol" style="margin-right:-50px; z-index:99;">
                <img src="/website/img/icons/light/new/video.png" class="compenents">
                <img src="/website/img/icons/light/new/ses.png" class="compenents">
                <img src="/website/img/icons/light/new/harita.png" class="compenents">
                <img src="/website/img/icons/light/new/link.png" class="compenents">
                <img src="/website/img/icons/light/new/web.png" class="compenents">
              </div>
              <div class="col-md-10 col-xs-10 compMiddleCol">
                <div data-device="macbook" data-orientation="landscape" data-color="black" class="device-mockup">
                  <div class="device">
                    <div class="screen">
                      <iframe scrolling="no" src="/website/animating/web/animasyon2.html" style="width:100% !important; height:100% !important;max-width:100% !important; max-height:100% !important;"></iframe>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1 col-xs-1 compRightCol" style="margin-left:-50px;">
                <img src="/website/img/icons/light/new/tooltip.png" class="compenents">
                <img src="/website/img/icons/light/new/scroller.png" class="compenents" style="margin-top:21px;">
                <img src="/website/img/icons/light/new/slide.png" class="compenents" style="margin-top:21px;">
                <img src="/website/img/icons/light/new/360.png" class="compenents" style="margin-top:21px;">
                <img src="/website/img/icons/light/new/bookmark.png" class="compenents" style="margin-top:21px;">
                <img src="/website/img/icons/light/new/animasyon.png" class="compenents" style="margin-top:21px;">
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
<!--           <div class="row">
            <div class="col-md-12">
              <div class="section-title">
                <h2 class="upper"><span>NEDEN GALEPRESS?</span></h2>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-3 icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/1.png">
                <div class="icon-box-content">
                  <h5 class="upper">İNTERAKTİF TASARLAYICI</h5>
                  <p>Dökümanlarınıza interaktif öğeler eklemek hiç bu kadar kolay olmamıştı. İstediğiniz özelliği sürükle bırak metoduyla dökümanınıza taşıyın, dökümanlarınız yeni bir boyut kazansın.</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/2.png">
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">İNTERAKTİF ÖGELER</h5>
                  <p>Yazılı içeriğinizi fotoğraf galerileri, ses dosyaları, videolar ve animasyonlar ile süsleyerek müşterilerinizin dikkat eğrisinin düşmesini engelleyin, dökümanlarınız dijital gürültüden sıyrılarak öne çıksın.</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/3.png">
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">PUSH NOTIFICATION</h5>
                  <p>Yeni kampanyalarınızı ve gelişmeleri müşterilerinize anlatırken sesinizi duyuramamaktan şikayetçiyseniz  çözüm Galepress'in "push notification" özelliğinde. Mesajlarınızın farkedilmeme riskini ortadan kaldırın, müşterilerinize doğrudan ulaşın ve kampanyalarınız daha başarılı olsun.</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/6.png"></i>
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">RAPORLAMA</h5>
                  <p>Dijital iletişiminizin sonuçlarını analiz edememekten mi şikayetçisiniz? Galepress'in gelişmiş raporlama arayüzü sayesinde lokasyon, sayfada geçirilen zaman ve daha bir çok kritik veri ile pazarlama hamlenize doping yapabileceksiniz.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 sep-top-lg icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/4.png">
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">GÜVENLİK</h5>
                  <p>Mobil aplikasyonunuz ile hassas verilerin aktarımını mı yapacaksınız? Artık güvenlik konusunda kaygılanmanıza gerek yok. Bulut sunucuları ve şifreleme özelliği ile istediğiniz  hassas bilgileri iş ortaklarınıza aktarabileceksiniz.</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 sep-top-lg icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/7.png">
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">HIZ</h5>
                  <p>İçeriğinizi güncellemek hızınızı kesmesin. Stratejik güncellemeleriniz Galepress'in hız odaklı sistemi sayesinde dijital çağın güncelleme hızına ayak uydursun</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 sep-top-lg icon-gradient">
              <div class="icon-box icon-horizontal icon-lg">
                <img src="/website/img/infographic/gray/5.png">
                <div class="icon-box-content">
                  <h5 class="upper" style="color:#0986c2;">BÜTÜN DÜNYAYA ERİŞİM</h5>
                  <p>Galepress sayesinde giriş yapacağınız aplikasyon pazarları ile rekabet ortamınızın sınırlarını kaldırın. Yeni pazarlar sayesinde yeni fırsatlar ve satışlar elde edin.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection