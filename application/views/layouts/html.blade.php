<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
<head>
    @section('head')
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ Config::get('custom.companyname') }}</title>
        <!-- Meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="google-site-verification" content="" />
        <meta http-equiv="content-Language" content="tr" />
        <meta http-equiv="imagetoolbar" content="false" />
        <meta name="MSSmartTagsPreventParsing" content="true" />
        <meta name="revisit-after" content="3 days" />
        <meta name="keywords" content="" />
        <meta name="author" content="Designed and built by GURUS Technology" />
        <meta name="copyright" content="GURUS Technology" />
        <meta name="company" content="GURUS" />
        <meta name="description" content="" />
        <meta name="verify-v1" content="" />
        <meta name="robots" content="all" />
        <link rel="shortcut icon" href="/website/img/favicon2.ico">
        
        <!-- Begin CSS-->
        {{ HTML::style('css/print.css?v=' . APP_VER, array('media' => 'print')); }}
        {{ HTML::style('css/newdesign.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/general.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/fonts/open-sans-condensed/css/open-sans-condensed.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/myApp.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('uploadify/uploadify.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('js/chosen_v1.0.0/chosen.css?v=' . APP_VER,array('media' => 'screen'));}}
        {{ HTML::style('css/btn_interactive.css?v=' . APP_VER,array('media' => 'screen'));}}

        <link rel="stylesheet" href="/css/template-chooser/master.css?v=<?php echo APP_VER; ?>">
        <link rel="stylesheet" href="/website/styles/device-mockups2.css?v=<?php echo APP_VER; ?>">

        <!-- Begin JavaScript -->
        @include('js.language')

        {{ HTML::script('js/jquery-1.7.2.min.js'); }}
        {{ HTML::script('js/jquery-ui-1.10.4.custom.min.js'); }}
        {{ HTML::script('js/bootstrap.min.js'); }}
        {{ HTML::script('js/jquery.uniform.min.js'); }}
        {{ HTML::script('js/jquery.knob.js'); }}
        {{ HTML::script('js/flot/jquery.flot.js'); }}
        {{ HTML::script('js/flot/jquery.flot.animator.js'); }}
        {{ HTML::script('js/flot/jquery.flot.resize.js'); }}
        {{ HTML::script('js/flot/jquery.flot.grow.js'); }}

        {{ HTML::script('uploadify/jquery.uploadify-3.1.min.js'); }}
        {{ HTML::script('bundles/jupload/js/jquery.iframe-transport.js'); }}
        {{ HTML::script('bundles/jupload/js/jquery.fileupload.js'); }}

        {{ HTML::script('js/chosen_v1.0.0/chosen.jquery.min.js'); }}
        {{ HTML::script('js/jquery.base64.decode.js'); }}
        {{ HTML::script('js/jquery.qtip.js'); }}
        {{ HTML::script('js/jquery.cookie.js?v=' . APP_VER); }}
        {{ HTML::script('js/gurus.common.js?v=' . APP_VER); }}
        {{ HTML::script('js/gurus.string.js?v=' . APP_VER); }}
        {{ HTML::script('js/gurus.date.js?v=' . APP_VER); }}
        {{ HTML::script('js/gurus.projectcore.js?v=' . APP_VER); }}
        {{ HTML::script('js/session-check.js?v=' . APP_VER); }}
        {{ HTML::script('js/lib.js?v=' . APP_VER); }}

        {{ HTML::script('js/jqplot/jquery.jqplot.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.barRenderer.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.highlighter.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.dateAxisRenderer.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.categoryAxisRenderer.min.js'); }}

        <!-- Begin pngfix-->
        <!--[if lt IE 7]>
        {{ HTML::script('js/DD_belatedPNG_0.0.8a.js'); }}
        <script>
        DD_belatedPNG.fix('.modify, .arrow, a.extend, li.add a, li.remove a, #site_info a');
        </script>
        <![endif]-->


        <script type="text/javascript">
        $(function(){

            $( ".templateScreen" ).click(function( event ) {
              $(".templateReadScreen img").attr('src',event.target.src);
            });

            $('.templateBackgroundChange').on('change', function (e) {
                $('.app-background-templates').remove();
                if(this.value==0){
                    $('head').append('<link rel="stylesheet" class="app-background-templates" href="/css/template-chooser/background-template-light.css" type="text/css" />');        
                }
                else{
                    $('head').append('<link rel="stylesheet" class="app-background-templates" href="/css/template-chooser/background-template-dark.css" type="text/css" />');        
                }
            });

            $('.templateForegroundChange').on('change', function (e) {
                $('.app-foreground-templates').remove();
                if(this.value==0){
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-blue.css" type="text/css" />');        
                }
                else if(this.value==1){
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-gray.css" type="text/css" />');        
                }
                else if(this.value==2){
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-green.css" type="text/css" />');        
                }
                else if(this.value==3){
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-orange.css" type="text/css" />');        
                }
                else if(this.value==4){
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-red.css" type="text/css" />');        
                }
                else{
                    $('head').append('<link rel="stylesheet" class="app-foreground-templates" href="/css/template-chooser/foreground-template-yellow.css" type="text/css" />');        
                }
            });

            $('#modalTemplateChooser').on('shown.bs.modal', function () {
                $('.container.content-list').addClass('blurred');
                $('#templateChooserBox').show(500);
                $('#templateChooserBox .site-settings').addClass('active');
                $('.templateSplashScreen').removeClass('hide').fadeTo( "slow" , 1, function() {
                    setTimeout(function(){
                        $('.templateSplashScreen').fadeTo( "slow" , 0, function() {
                            $('.templateSplashScreen').addClass("hide");
                            $('.templateScreen').removeClass('hide').fadeTo( "slow" , 1);
                        });
                    },1000);
                });

                $(".templateScreen .container [class*='col-']").click(function(){
                    $('.templateScreen').fadeTo( "slow" , 0.5, function() {
                        $('.templateReadScreen').removeClass('hide').fadeTo( "slow" , 1);
                    });
                })

                $("#templateBtnRead").click(function(){
                    $('.templateScreen, .templateReadScreen').fadeTo( "slow" , 0, function() {
                        $('.templateContentScreen').removeClass('hide').fadeTo( "slow" , 1);
                    });
                })

                $(".footerBtnHome").click(function(){
                    $('.templateContentScreen, .templateScreen, .templateReadScreen').fadeTo( "slow" , 0, function() {
                        $('.templateScreen, .templateReadScreen, .templateContentScreen').addClass('hide');
                        $('.templateScreen').removeClass('hide').fadeTo( "slow" , 1);
                    });
                })
            });

            $('#modalTemplateChooser').on('hidden.bs.modal', function (e) {
                $('.templateSplashScreen, .templateScreen, .templateReadScreen, .templateContentScreen').addClass('hide');
                $('.container.content-list').removeClass('blurred');
                $('#templateChooserBox').hide(500);
                $('#templateChooserBox .site-settings').removeClass('active');
                $('.templateExtrasScreen').addClass('hide').fadeTo( "fast" , 0);
                $('.templateScreen').css('margin-left','0');
                $('.templateScreen .footer').css('right','0')
            });

            $('#templateChooserClose').click(function(){
                $('#modalTemplateChooser').modal('hide');
            });

            $('.header-extras').click(function(){
                if($('.templateExtrasScreen').hasClass('hide')){
                    $('.templateExtrasScreen').removeClass('hide').fadeTo( "fast" , 1);
                    $('.templateScreen').css('margin-left','-20%'); 
                    $('.templateScreen .footer').css('right','20%');
                }
                else{
                    $('.templateExtrasScreen').addClass('hide').fadeTo( "fast" , 0);
                    $('.templateScreen').css('margin-left','0');
                    $('.templateScreen .footer').css('right','0');
                }
            });

        })
        </script>

        
    @yield_section
</head>
@_yield('body')
</html>