    <nav id="main-navigation" role="navigation" class="navbar navbar-fixed-top navbar-standard"><a href="javascript:void(0)" class="search_button"><i class="fa fa-search"></i></a>
      <form action="/{{ Session::get('language') }}" method="get" role="search" class="h_search_form" id="searchForm">
        <div class="container">
          <div class="h_search_form_wrapper">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
              </span>
            <input type="text" class="form-control" name="q" id="q" placeholder="{{__('website.search')}}" style="color:#909090"></div>
            <div class="h_search_close"><a href="#"><i class="fa fa-times"></i></a></div>
          </div>
        </div>
      </form>
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle"><i class="fa fa-align-justify fa-lg"></i></button><a href="/tr/" class="navbar-brand"><img src="/website/img/logo-white.png" alt="" class="logo-white"><img src="/website/img/logo-dark.png" alt="" class="logo-dark"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right service-nav">
            <li>
              <a href="/tr/deneyin">DENEYİN</a>
            </li>
            <li>
              <a href="/tr/giris"><i class="fa fa-mobile fa-lg"></i>&nbsp;<span class="badge">GİRİŞ</span></a>
            </li>
            <li class="dropdown"><a href="/tr" title="Language" data-toggle="dropdown" data-hover="dropdown" id="menu_item_Portfolio" data-ref="#" class="dropdown-toggle"><img src="/website/img/flags/trFlag.png" /><span class="caret"></span></a>
              <ul aria-labelledby="menu_item_Portfolio" class="dropdown-menu" style="min-width:52px !important;width:52px !important;">
                <li class="noTouch"><a href="#" title="English" data-ref="#"><img src="/website/img/flags/enFlagPassive.png" /></a></li>
                <li class="noTouch"><a href="#" title="Deutsch" data-ref="#"><img src="/website/img/flags/deFlagPassive.png" /></a></li>
              </ul>
            </li>
          </ul>
          <button type="button" class="navbar-toggle"><i class="fa fa-close fa-lg"></i></button>
          <ul class="nav yamm navbar-nav navbar-left main-nav">
              <li><a href="/tr/nasil-calisir" title="Nasıl çalışır?" id="menu_item_Home" data-ref="#">NASIL ÇALIŞIR?</a></li>

              <li><a href="/tr/cozumler" title="Çözümler" id="menu_item_Pages" data-ref="#">ÇÖZÜMLER</a></li>

              <li><a href="/tr/referanslar" title="Showcase" id="menu_item_features-grid" data-ref="features-grid">REFERANSLAR</a></li>

              <li><a href="/tr/iletisim" title="İLETİŞİM" id="menu_item_Contactus" data-ref="#">İLETİŞİM</a></li>

              <li><a href="/tr/blog" title="Blog" id="menu_item_Blog" data-ref="#">BLOG</a></li>

              <!-- <li><a href="http://shop.galepress.com/" target="_blank" title="Shop" id="menu_item_Shop" data-ref="#">SHOP</a></li> -->
          </ul>
        </div>
      </div>
    </nav>