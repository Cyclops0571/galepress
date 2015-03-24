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
        {{ HTML::style('css/print.css', array('media' => 'print')); }}
        {{ HTML::style('css/newdesign.css', array('media' => 'screen')); }}
        {{ HTML::style('css/general.css', array('media' => 'screen')); }}
        {{ HTML::style('css/fonts/open-sans-condensed/css/open-sans-condensed.css', array('media' => 'screen')); }}
        {{ HTML::style('css/myApp.css?v=9', array('media' => 'screen')); }}
        {{ HTML::style('uploadify/uploadify.css', array('media' => 'screen')); }}
        {{ HTML::style('js/chosen_v1.0.0/chosen.css',array('media' => 'screen'));}}
        {{ HTML::style('css/btn_interactive.css',array('media' => 'screen'));}}

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
        {{ HTML::script('js/jquery.cookie.js'); }}
        {{ HTML::script('js/gurus.common.js'); }}
        {{ HTML::script('js/gurus.string.js'); }}
        {{ HTML::script('js/gurus.date.js'); }}
        {{ HTML::script('js/gurus.projectcore.js'); }}
        {{ HTML::script('js/session-check.js'); }}
        {{ HTML::script('js/lib.js'); }}

        {{ HTML::script('js/jqplot/jquery.jqplot.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.barRenderer.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.highlighter.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.dateAxisRenderer.min.js'); }}
        {{ HTML::script('js/jqplot/jqplot.categoryAxisRenderer.min.js'); }}
        <!--
        @if(URI::current() != __("route.reports")->get()."/101" && URI::current() != __("route.reports")->get()."/201" && URI::current() != __("route.reports")->get()."/301" && URI::current() != __("route.reports")->get()."/302" && URI::current() != __("route.reports")->get()."/1101" && URI::current() != __("route.reports")->get()."/1201" && URI::current() != __("route.reports")->get()."/1301" && URI::current() != __("route.reports")->get()."/1302")
        <script type="text/javascript" src="https://galepress.atlassian.net/s/d41d8cd98f00b204e9800998ecf8427e/en_US-x8m41o-1988229788/6210/8/1.4.3/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=488f7392"></script>
        @endif
        -->
        <!-- Begin pngfix-->
        <!--[if lt IE 7]>
        {{ HTML::script('js/DD_belatedPNG_0.0.8a.js'); }}
        <script>
        DD_belatedPNG.fix('.modify, .arrow, a.extend, li.add a, li.remove a, #site_info a');
        </script>
        <![endif]-->
    @yield_section
</head>
@_yield('body')
</html>