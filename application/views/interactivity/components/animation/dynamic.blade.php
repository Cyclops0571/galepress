<?php
$vFile = path('public').$filename;
if(File::exists($vFile) && is_file($vFile)) {
	$fname = File::name($vFile);
	$fext = File::extension($vFile);
	$vFile = $fname.'.'.$fext;
}
else {
	$vFile = '';
}

if(!$preview)
{
	$vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
}
else
{
	$vFile = '/'.$filename;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name="viewport" content="user-scalable=no" />
	<title>GalePress</title>
	<style type='text/css'>
		*{margin:0;padding:0;overflow:hidden;}
		html,body{width:100%;height:100%;}
	</style>
</head>
<body>
	<img src="{{ ((int)$option == 1 ? $vFile : $url) }}" id="image" style="position:relative !important;top:0;left:0;">
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$("#image").ready(function() {function r() {setTimeout(function() {s() }, c) } function n() {$("#image").animate({left: u, top: v }, {queue: !1, duration: parseInt(a), complete: function() {1 == {{ (int)$reverse }} ? w() : 1 == {{ (int)$loop }} && (0 < c ? r() : s()) }, easing: l }) } function w() {$("#image").animate({left: g, top: e }, {queue: !1, duration: parseInt(a), complete: function() {1 == {{ (int)$loop }} && (0 < c ? r() : n()) }, easing: l }) } function s() {$("#image").css({left: g + "px", top: e + "px"}); n() } var p = {{$w}}, f = {{$h}}, q = {{ $x1 }}, x = {{ $y1 }}, y = {{ $x2 }}, z = {{ $y2 }}, h = {{ $rotation }}, A = {{ $rotationspeed }}, a = {{ $duration }}, l = "{{ $effect }}", B = "{{ $rotationeffect }}", t = null, C = {{ $animedelay }}, c = {{ $animeinterval }}, b = new Image; b.src = $("#image").attr("src"); b.onload = function() {var c = this.width, a = c / p * 100; c > p ? $("#image").css("width", "100%") : $("#image").css("width", a + "%"); c = this.height / f * 100; $("#image").css("height", c + "%") }; var b = $(window).height(), g = q / f * 100 * b / 100, b = $(window).height(), e = x / f * 100 * b / 100, q = $(window).width(), u = y / p * 100 * q / 100, b = $(window).height(), v = z / f * 100 * b / 100; 1 == {{ (int)$unvisibleStart }} ? $("#image").css({left: g + "px", top: e + "px", opacity: "0"}) : $("#image").css({left: g + "px", top: e + "px", opacity: "1"}); setTimeout(function() {"fade" == l && (t = l, l = null); if(0 != h) {var b = function(a) {var d = $("#image"); 1 == {{ (int)$reverse }} ? g ? (e = 0, g = !1, f = !0) : (e = a, a = 0, g = !0) : (e = a, a = 0); $({deg: a }).animate({deg: e }, {duration: parseInt(A), easing: B, step: function(a) {d.css({transform: "rotate(" + a + "deg)"}) }, complete: function() {1 == {{ (int)$reverse }} && 0 == {{ (int)$loop }} ? f || b(h) : 0 == {{ (int)$reverse }} && 1 == {{ (int)$loop }} ? 0 < c ? setTimeout(function() {b(h) }, c) : b(h) : 1 == {{ (int)$reverse }} && 1 == {{ (int)$loop }} && (0 < c && 1 == f ? setTimeout(function() {b(h); f = !1 }, c) : b(h)) } }) }, g = !1, e = 0, f = !1; b(h) } if("fade" == t) {var d = function() {if(1 == {{ (int)$reverse }}) {var b = parseInt($("#image").css("opacity")); 0 == m && 0 == {{ (int)$loop }} ? (m++, $("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d)) : 1 == m ? (m++, $("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d)) : 1 == {{ (int)$loop }} && (2 == k && 0 < c ? (k = 1, setTimeout(function() {$("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d) }, c)) : ($("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d), k++)) } else 1 == {{ (int)$loop }} ? 1 == {{ (int)$unvisibleStart }} ? 1 == k && 0 < c ? setTimeout(function() {$("#image").css("opacity", "0"); $("#image").animate({queue: !1, opacity: "1"}, parseInt(a), d) }, c) : ($("#image").css("opacity", "0"), $("#image").animate({queue: !1, opacity: "1"}, parseInt(a), d), k++) : 1 == k && 0 < c ? setTimeout(function() {$("#image").css("opacity", "1"); $("#image").animate({queue: !1, opacity: "0"}, parseInt(a), d) }, c) : ($("#image").css("opacity", "1"), $("#image").animate({queue: !1, opacity: "0"}, parseInt(a), d), k++) : $("#image").animate({queue: !1, opacity: "0"}, parseInt(a)) }, m = 0, k = 0; d() } n() }, parseInt(C)) });
	</script>
</body>
</html>