<?php
/*
<div id="content_control_inner">
    <div id="page_info">
        <h2>{{ $caption }}</h2>
        <p class="breadcrumbs">
            {{ HTML::link(__('route.home'), __('common.home')) }} &gt;
            @if(isset($detailcaption))
                {{ HTML::link($route, $caption) }} &gt; 
                <span>{{ $detailcaption }}</span>
            @else 
                <span>{{ $caption }}</span>
            @endif
        </p>
    </div>
    <!-- end page_info-->
    
    @if(!isset($detailcaption))
        <div class="select-filter"></div>
        <!--<a href="#" class="page_options">Sayfa Seçenekleri</a>-->
    @endif
</div>
<!-- end content_control_inner-->
*/
?>
<ul class="breadcrumbFilter">
	<li>{{ HTML::link(__('route.home'), __('common.home')) }}</li>
    @if(isset($detailcaption))
    <li>{{ HTML::link($route, $caption) }}</li> 
    <li class="active">{{ $detailcaption }}</li>
    @else 
    <li class="active">{{ $caption }}</li>
    @endif
</ul>