<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<!-- Set the viewport width to device width for mobile -->
<title>GalePress</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Content">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="shortcut icon" href="/website/img/favicon2.ico">
<!-- Included CSS Files -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=all' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="/css/app.css?v=10" type="text/css">
<link rel="stylesheet" href="/css/app-extra.css?v=10" type="text/css">
<link rel="stylesheet" href="/css/font-awesome.css" type="text/css">
<link rel="stylesheet" href="/css/redactor.css" type="text/css">
<link rel="stylesheet" href="/css/colorpicker.css" type="text/css">
<link rel="stylesheet" href="/uploadify/uploadify.css" type="text/css">
<!--[if lt IE 9]>
<link rel="stylesheet" href="/css/ie.css" type="text/css">
<![endif]-->
        
<!--[if IE 7]>
<link rel="stylesheet" href="/css/font-awesome-ie7.min.css">
<![endif]-->

<!--[if lt IE 7]>
<p class="chromeframe">Çok eski bir tarayıcı kullanıyorsunuz (IE6). Daha iyi bir deneyim için<a href="http://browsehappy.com/">tarayıcınızı güncelleyin </a> veya <a href="http://www.google.com/chromeframe/?redirect=true">Google Chrome yükleyin</a></p>
<![endif]-->

@include('js.language')
<script src="/js/modernizr.js" type="text/javascript"></script><!-- IE Fix for HTML5 Tags -->

<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
-->

<script src="/js/vendor/jquery.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/jquery.base64.decode.js" type="text/javascript"></script>
<script src="/js/gurus.common.js" type="text/javascript"></script>
<script src="/js/gurus.string.js" type="text/javascript"></script>
<script src="/js/gurus.date.js" type="text/javascript"></script>
<script src="/js/vendor/jquery-ui.js"></script>
<script src="/uploadify/jquery.uploadify-3.1.min.js" type="text/javascript"></script>
<script src="/js/fullscreen.js" type="text/javascript"></script>
<script src="/js/SCF.ui.js" type="text/javascript"></script>
<script src="/js/vendor/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/vendor/jquery.placeholder.js" type="text/javascript"></script>
<script src="/js/SCF.ui/Equalizer.js" type="text/javascript"></script>
<script src="/js/SCF.ui/appreciate.js" type="text/javascript"></script>
<script src="/js/SCF.ui/commutator.js" type="text/javascript"></script>
<script src="/js/SCF.ui/datepicker.js" type="text/javascript"></script>
<script src="/js/SCF.ui/pagination.js" type="text/javascript"></script>
<script src="/js/SCF.ui/scrollbox.js" type="text/javascript"></script>
<script src="/js/SCF.ui/slideshow.js" type="text/javascript"></script>
<script src="/js/SCF.ui/tabbox.js" type="text/javascript"></script>
<script src="/js/SCF.ui/starbar.js" type="text/javascript"></script>
<script src="/js/SCF.ui/checkbox.js" type="text/javascript"></script>
<script src="/js/SCF.ui/radio.js" type="text/javascript"></script>
<script src="/js/SCF.ui/player.js" type="text/javascript"></script>
<script src="/js/SCF.ui/currentlyPlaying.js" type="text/javascript"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/zoom_assets/jquery.smoothZoom.js?v=10"></script>
<script src="/js/jquery.gselectable.js?v=10" type="text/javascript"></script>
<script src="/js/jquery.component.js?v=10" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<input type="hidden" id="currentlanguage" value="{{ Session::get('language') }}" />
@yield('body-content')
<script src="/js/jquery.collapse.js" type="text/javascript"></script>
<script src="/js/jquery.easytabs.js" type="text/javascript"></script>
<script src="/js/redactor.min.js" type="text/javascript"></script>
<script src="/js/jquery.colorPicker.js" type="text/javascript"></script>
<script src="/js/respond.min.js" type="text/javascript"></script>
<script src="/bundles/jupload/js/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="/bundles/jupload/js/jquery.fileupload.js" type="text/javascript"></script>

<?php
$components = DB::table('Component')
	->where('StatusID', '=', eStatus::Active)
	->order_by('DisplayOrder', 'ASC')
	->get();
?>
@foreach($components as $component)
<script id="tool-{{ $component->Class }}" type="text/html">{{ View::make('interactivity.components.'.$component->Class.'.tool') }}</script>
<script id="prop-{{ $component->Class }}" type="text/html">{{ View::make('interactivity.components.'.$component->Class.'.property', array('ComponentID' => $component->ComponentID, 'PageComponentID' => 0, 'Process' => 'new', 'PageCount' => count($pages))) }}</script>
@endforeach

<script src="/js/gurus.projectcore.js?v=9" type="text/javascript"></script>
<script src="/js/session-check.js" type="text/javascript"></script>
<script src="/js/lib.interactivity.js?v=9" type="text/javascript"></script>
</body>
</html>