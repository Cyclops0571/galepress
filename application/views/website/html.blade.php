<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{__('website.title')}}</title>
    <meta name="keywords" content="{{__('website.keywords')}}" />
    <meta name="description" content="{{__('website.description')}}">
    <meta name="author" content="galepress.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory-->
    <link rel="shortcut icon" href="/website/img/favicon2.ico">
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,200italic,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/website/styles/font-awesome.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/owl.carousel.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/owl.theme.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/slit-slider-style.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/slit-slider-custom.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/idangerous.swiper.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/yamm.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/animate.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/prettyPhoto.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/bootstrap-slider.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/device-mockups2.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/bootstrap.min.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/main.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/main-responsive.css?v=<?php echo APP_VER; ?>">
    <link id="primary_color_scheme" rel="stylesheet" href="/website/styles/theme_royalblue.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" href="/website/styles/myStyles.css?v=<?php echo APP_VER; ?>">
    <script src="/website/scripts/vendor/modernizr.js"></script>
    <noscript>
      <link rel="stylesheet" href="/website/styles/styleNoJs.css?v=<?php echo APP_VER; ?>">
    </noscript>
  </head>
  <body>
    <div id="load"></div>
    <div class="page">
      @include('website.header')
      @_yield('body-content')
      @include('website.footer')
      <div id="back_to_top"><a href="#" class="fa fa-arrow-up fa-lg"></a></div>
    </div>
    <script src="/website/scripts/vendor/jquery.js"></script>
    <script src="/website/scripts/vendor/queryloader2.min.js"></script>
    <script src="/website/scripts/vendor/owl.carousel.js"></script>
    <script src="/website/scripts/vendor/jquery.ba-cond.min.js"></script>
    <script src="/website/scripts/vendor/jquery.slitslider.js"></script>
    <script src="/website/scripts/vendor/idangerous.swiper.js"></script>
    <script src="/website/scripts/vendor/jquery.fitvids.js"></script>
    <script src="/website/scripts/vendor/jquery.countTo.js"></script>
    <script src="/website/scripts/vendor/TweenMax.min.js"></script>
    <script src="/website/scripts/vendor/ScrollToPlugin.min.js"></script>
    <script src="/website/scripts/vendor/jquery.scrollmagic.min.js"></script>
    <script src="/website/scripts/vendor/jquery.easypiechart.js"></script>
    <script src="/website/scripts/vendor/jquery.validate.js"></script>
    <script src="/website/scripts/vendor/wow.min.js"></script>
    <script src="/website/scripts/vendor/jquery.placeholder.js"></script>
    <script src="/website/scripts/vendor/jquery.easing.1.3.min.js"></script>
    <script src="/website/scripts/vendor/jquery.waitforimages.min.js"></script>
    <script src="/website/scripts/vendor/jquery.prettyPhoto.js"></script>
    <script src="/website/scripts/vendor/imagesloaded.pkgd.min.js"></script>
    <script src="/website/scripts/vendor/isotope.pkgd.min.js"></script>
    <script src="/website/scripts/vendor/jquery.fillparent.min.js"></script>
    <script src="/website/scripts/vendor/raphael-min.js"></script>
    <script src="/website/scripts/vendor/bootstrap.js"></script>
    <script src="/website/scripts/vendor/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/website/scripts/vendor/bootstrap-slider.js"></script>
    <script src="/website/scripts/vendor/bootstrap-rating-input.js"></script>
    <script src="/website/scripts/vendor/bootstrap-hover-dropdown.min.js"></script>
    <script src="/website/scripts/jquery.gmap.min.js"></script>
    <script src="/website/scripts/circle_diagram.js"></script>
    <script src="/website/scripts/main.js?v=<?php echo APP_VER; ?>"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-42887832-1', 'galepress.com');
      ga('send', 'pageview');
    </script>
    <div class="search-result" style="position:absolute; top:-100px; left:0">
        <script>
        (function() {
            var cx = '003558081527571790912:iohyqlcsz2m';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
            '//www.google.com/cse/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
        })();
        </script>
        <gcse:search></gcse:search>
    </div>


    <script type="text/javascript">
    $(function(){

        if("{{ Session::get('language') }}"=="tr"){

            $('.dropdown.languageChange > a').attr('href','/tr');
            $('.dropdown.languageChange > a img').attr('src','/website/img/flags/trFlag.png');

            $('.dropdown.languageChange ul li:first-child a').attr('href','/en');
            $('.dropdown.languageChange ul li:first-child a img').attr('src','/website/img/flags/enFlag.png');


        } else {

            $('.dropdown.languageChange > a').attr('href','/en');
            $('.dropdown.languageChange > a img').attr('src','/website/img/flags/enFlag.png');

            $('.dropdown.languageChange ul li:first-child a').attr('href','/tr');
            $('.dropdown.languageChange ul li:first-child a img').attr('src','/website/img/flags/trFlag.png');
        }

        $('.dropdown.languageChange ul li').click(function(event){
            var target = $( event.target );
            if(target.is('a')){
                $('.dropdown.languageChange > a img').attr('src',$(event.target).find('img').attr('src'));
                if("{{ Session::get('language') }}"=="tr"){
                    $('.dropdown.languageChange ul li:first-child a img').attr('src','/website/img/flags/trFlag.png');
                }
                else{
                    $('.dropdown.languageChange ul li:first-child a img').attr('src','/website/img/flags/enFlag.png');
                }
            }
        });

        if($('#blogIframe').length>0 || $('#blogIframeNews').length>0 || $('#blogIframeTutorials').length>0)
        {
            var waitForFinalEvent = (function () {
                var timers = {};
                return function (callback, ms, uniqueId) {
                if (!uniqueId) {
                  uniqueId = "Don't call this twice without a uniqueId";
                }
                if (timers[uniqueId]) {
                  clearTimeout (timers[uniqueId]);
                }
                timers[uniqueId] = setTimeout(callback, ms);
                };
            })();

            if($('#blogIframe').length>0){
                $('#blogIframe').load(function(){
                    $('#blogIframe').css('min-height',$('#blogIframe').contents().find('body').height()+50);
                }); 
            }
            if($('#blogIframeNews').length>0){
                $('#blogIframeNews').load(function(){
                    $('#blogIframeNews').css('min-height',$('#blogIframeNews').contents().find('body').height()+50);
                });
            }
            if($('#blogIframeTutorials').length>0){
                $('#blogIframeTutorials').load(function(){
                    $('#blogIframeTutorials').css('min-height',$('#blogIframeTutorials').contents().find('body').height()+50);
                });
            }

            $(window).resize(function(){
                waitForFinalEvent(function(){
                    if($('#blogIframe').length>0){$('#blogIframe').css('min-height',$('#blogIframe').contents().find('body').height()+50);}
                    if($('#blogIframeNews').length>0){$('#blogIframeNews').css('min-height',$('#blogIframeNews').contents().find('body').height()+50);}
                    if($('#blogIframeTutorials').length>0){$('#blogIframeTutorials').css('min-height',$('#blogIframeTutorials').contents().find('body').height()+50);}
                }, 500, "resizeMyIframe");
            });
        }
    })
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6022106543310&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
  </body>
</html>