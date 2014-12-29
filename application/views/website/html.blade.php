<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <title>{{__('website.title')}}</title>
    <meta name="keywords" content="{{__('website.keywords')}}" />
    <meta name="description" content="{{__('website.description')}}">
    <meta name="author" content="galepress.com">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-itunes-app" content="app-id=647802727">
    <!-- Libs CSS -->
    <link rel="stylesheet" href="/website/css/bootstrap.css">
    <link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome.css">

    <link rel="stylesheet" href="/website/css/fonts/open-sans-condensed/css/open-sans-condensed.css">

    <link rel="stylesheet" href="/website/vendor/flexslider/flexslider.css" media="screen" />
    <link rel="stylesheet" href="/website/vendor/fancybox/jquery.fancybox.css" media="screen" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/website/css/theme.css">
    <link rel="stylesheet" href="/website/css/theme-elements.css">

    <!-- Current Page Styles -->
    <link rel="stylesheet" href="/website/vendor/revolution-slider/css/settings.css" media="screen" />
    <link rel="stylesheet" href="/website/vendor/revolution-slider/css/captions.css" media="screen" />
    <link rel="stylesheet" href="/website/vendor/circle-flip-slideshow/css/component.css" media="screen" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/website/css/custom.css">
    
    <!-- Skin -->
    <link rel="stylesheet" href="/website/css/skins/blue.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/website/css/bootstrap-responsive.css" />
    <link rel="stylesheet" href="/website/css/theme-responsive.css" />

    <!-- Favicons -->
    <link rel="shortcut icon" href="/website/img/favicon2.ico">


    <!-- Head Libs -->
    <script src="/website/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome-ie7.css">
    <link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome-ie7.min.css">
    <link rel="stylesheet" href="/website/css/fonts/font-awesome/css/font-awesome.min.css">

    <!--[if IE]>
    <link rel="stylesheet" href="/website/css/ie.css">
    <![endif]-->

    <!--[if lte IE 8]>
    <script src="/website/vendor/respond.js"></script>
    <![endif]-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/website/vendor/jquery.js"><\/script>')</script>
    <script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="/uploadify/jquery.uploadify-3.1.min.js"></script>
    <script src="/bundles/jupload/js/jquery.iframe-transport.js"></script>
    <script src="/bundles/jupload/js/jquery.fileupload.js"></script>
    <script src="/js/jquery.base64.decode.js"></script>
    <script src="/js/gurus.string.js"></script>

    <!-- Facebook OpenGraph Tags - Go to http://developers.facebook.com/ for more information.
    <meta property="og:title" content="GalePress - Dijital Yayıncılık Platformu"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://www.galepress.com"/>
    <meta property="og:image" content="http://www.galepress.com"/>
    <meta property="og:site_name" content="GalePress"/>
    <meta property="fb:app_id" content=""/>
    <meta property="og:description" content="GalePress - Dijital Yayıncılık Platformu"/>
    -->
    <style>
        .bubble {
            background-color: #000;
            border-radius: 5px;
            border:1px solid #fff;
            box-shadow: 0 0 6px #ccc;
            display: inline-block;
            padding: 7px 0px;
            position: relative;
            vertical-align:middle;
            text-align:center;
            float: left;   
            margin: 32px 0 -225px -255px;
            opacity:0.8;
            z-index:999;
            width:238px;
            height:auto;
            font-size:18px;
            filter:alpha(opacity=80); /* For IE8 and earlier */
        }

        .bubble::before {
            background-color: #000;
            opacity:0.85;
            filter:alpha(opacity=85); /* For IE8 and earlier */
            content: "\00a0";
            display: block;
            position: absolute;
            top: -2.5px;
            transform:             rotate( 120deg ) skew( -35deg );
            -moz-transform:    rotate( 120deg ) skew( -35deg );
            -ms-transform:     rotate( 120deg ) skew( -35deg );
            -o-transform:      rotate( 120deg ) skew( -35deg );
            -webkit-transform: rotate( 120deg ) skew( -35deg );
            width:  20px;
            height: 10px;
            box-shadow: -2px 2px 2px 0 rgba( 178, 178, 178, .4 );
            left: 205px;  
            z-index:-1;
        }
    </style>

    <?php 
    /*
    $a = include($_SERVER['DOCUMENT_ROOT']."/../application/language/".$_SESSION["benimdilim"]."/route.php");
    ?>
    <script type="text/javascript">
        <!--
        var route = new Array();
        route["orders_save"] = "<?php echo $a['orders_save']; ?>";
        route["orders_uploadfile"] = "<?php echo $a['orders_uploadfile']; ?>";
        route["orders_uploadfile2"] = "<?php echo $a['orders_uploadfile2']; ?>";
        // -->
    </script>
    */
    ?>
    @include('js.language')
</head>
<body>
	<input type="hidden" id="currentlanguage" value="{{ Session::get('language') }}" />

    <div class="body">
        @include('website.header')
        @yield('body-content')
        @include('website.footer')
    </div>

    <!-- Libs -->
    <script src="/website/vendor/jquery.easing.js"></script>
    <script src="/website/vendor/jquery.cookie.js"></script>
    <!-- <script src="master/style-switcher/style.switcher.js"></script> -->
    <script src="/website/vendor/bootstrap.js"></script>
    <script src="/website/vendor/selectnav.js"></script>
    <script src="/website/vendor/twitterjs/twitter.js"></script>
    <script src="/website/vendor/revolution-slider/js/jquery.themepunch.plugins.js"></script>
    <script src="/website/vendor/revolution-slider/js/jquery.themepunch.revolution.js"></script>
    <script src="/website/vendor/flexslider/jquery.flexslider.js"></script>
    <script src="/website/vendor/circle-flip-slideshow/js/jquery.flipshow.js"></script>
    <script src="/website/vendor/fancybox/jquery.fancybox.js"></script>
    <script src="/website/vendor/jquery.validate.js"></script>
    <script src="/website/js/plugins.js"></script>

    <!-- Current Page Scripts -->
    <script src="/website/js/views/view.home.js"></script>
    <script src="/website/js/views/view.contact.js"></script>

    <!-- Theme Initializer -->
    <script src="/website/js/theme.js"></script>

    <!-- Custom JS -->
    <script src="/website/js/custom.js"></script>
    <script src="/website/js/jquery.inputlimiter.1.3.1.min.js"></script>


    
    <?php if($_SERVER["REQUEST_URI"] == '/tr/calisma-yapisi' || $_SERVER["REQUEST_URI"] == '/en/work-flow' || $_SERVER["REQUEST_URI"] == '/de/arbeitsweise') { ?>
    <script type="text/javascript">
        swfobject.registerObject("FLVPlayer");
    </script>
    <?php } ?>


    <?php if($_SERVER["REQUEST_URI"] == '/tr/' || $_SERVER["REQUEST_URI"] == '/en/' || $_SERVER["REQUEST_URI"] == '/de/') { ?>
    <script type="text/javascript">
        $(function(){
            $('.bubble').removeClass('hidden');
        });
        setTimeout(function(){$('.bubble').fadeOut();}, 4000);
    </script>
    <?php } ?>

    <!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information. -->
    <!--
    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-XXXXX-X']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-42887832-1', 'galepress.com');
        ga('send', 'pageview');
    </script>
</body>
</html>