    <footer id="footer">
      <div class="inner sep-bottom-sm">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="widget sep-top-md">
                <div class="row">
                  <div class="col-md-12">
                    <div class="team-name" style="border-bottom: 1px solid #545454;">
                      <a href="http://www.detaysoft.com/" target="_blank"><img class="desaturate" src="/website/img/logo-footer.png"></a>
                    </div>
                    <p><small>{{__('website.footer_detaysoft_text')}}</small></p>
                    <!--<p><small>Kurulduğu 1999 yılından itibaren başarılı projeler üreten Detaysoft, zamanla sektörünün en deneyimli teknoloji firmaları arasına girdi.</small></p>-->
                    <p class="pull-right"><small><a href="http://www.detaysoft.com/Content/Text/9/Genel_Tanitim" target="_blank"><u><i>{{__('website.footer_detaysoft_more')}}</i></u></a></small></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-md-offset-1">
              <div class="widget sep-top-md">
                <h6 class="upper widget-title">{{__('website.footer_socialmedia')}}</h6>
                <ul class="social-icon sep-top-xs">
                  <li><a href="https://www.linkedin.com/company/galepress" class="fa fa-linkedin fa-lg"></a></li>
                  <li><a href="https://twitter.com/GalePress" class="fa fa-twitter fa-lg"></a></li>
                  <li><a href="https://www.facebook.com/pages/Galepress/267455253374597?fref=ts" class="fa fa-facebook fa-lg"></a></li>
                </ul>
                <ul class="social-icon sep-top-xs">
                  <li>
                    <small class="sep-top-xs sep-bottom-md">{{__('website.get_in_touch_desc')}}<br />
                    <small class="alert alert-success hidden" id="newsletterSuccess">{{__('website.newsletter_success')}}</small>
                    <small class="alert alert-error hidden" id="newsletterError"></small>

                      <form class="form-inline" id="newsletterForm" action="/website/php/newsletter-subscribe.php" method="POST">
                        <div class="input-group input-group-sm" style="margin-top:8px;">
                          <span class="input-group-addon newsletter"><i class="fa fa-envelope-o"></i></span>
                          <input type="text" name="email" id="email" class="form-control newsletter-text-input" aria-label="email registration">
                          <span class="input-group-btn">
                            <button class="btn btn-default newsletter" type="submit">{{__('website.newsletter_subscription')}}</button>
                          </span>
                        </div>
                      </form>
                    </small>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-3 col-md-offset-1">
              <div class="widget sep-top-md">
                <h6 class="upper widget-title">{{__('website.contact')}}</h6>
                <ul class="widget-address sep-top-xs">
                  <li><i class="fa fa-map-marker fa-lg"></i><small>{{__('website.address_istanbul')}}</small></li>
                  <li><i class="fa fa-phone fa-lg"></i><small>+90 (216) 443 13 29</small></li>
                  <li><i class="fa fa-fax fa-lg"></i><small>+90 (216) 443 08 27</small></li>
                  <li><i class="fa fa-envelope fa-lg"></i><small><a href="mailto:info@galepress.com">info@galepress.com</a></li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="copyright sep-top-xs sep-bottom-xs">
        <div class="container">
          <div class="row">
            <div class="col-md-12"><small>{{__('website.footer_copyright')}}</small></div>
          </div>
        </div>
      </div>
    </footer>