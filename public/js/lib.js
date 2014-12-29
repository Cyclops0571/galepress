
$(function(){


	$("#CategoryID").chosen({
		placeholder_text_single: "Seçiniz...",
		placeholder_text_multiple: "Seçiniz...",
		no_results_text: "Sonuç bulunamadı."
	});


	/*
	$('#CategoryID').on('change', function(e) {
	    $('#CategoryID').trigger('chosen:updated');
	});
	*/

	//var w = $(document).width() - parseInt($("#main").css("padding-left").replace("px", "")) - 10;
	/*
	alert(
	
		$(document).innerWidth() + " " + $(document).width() + " "  +
		
		
		$("#sidebar").width()
	);
	
	alert(
	
		$("#main").css("padding-left").replace("px", "")
	);
	
	*/
	
	/*
	var w = 0;
	w = w + $(document).innerWidth();
	w = w - parseInt($("#main").css("padding-left").replace("px", ""));
	w = w - parseInt($("#main").css("padding-right").replace("px", ""));
	w = w - 10;
	
	//w = w - $("#sidebar").width();
	$("#main").width(w);
	*/
	$.datepicker.regional['tr'] = {
        closeText: 'kapat',
        prevText: '&#x3c;geri',
        nextText: 'ileri&#x3e',
        currentText: 'bug\u00fcn',
        monthNames: ['Ocak', '\u015eubat', 'Mart', 'Nisan', 'May\u0131s', 'Haziran', 'Temmuz', 'A\u011fustos', 'Eylül', 'Ekim', 'Kas\u0131m', 'Aral\u0131k'],
        monthNamesShort: ['Oca', '\u015eub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'A\u011fu', 'Eyl', 'Eki', 'Kas', 'Ara'],
        dayNames: ['Pazar', 'Pazartesi', 'Sal\u0131', '\u00c7arşamba', 'Per\u015fembe', 'Cuma', 'Cumartesi'],
        dayNamesShort: ['Pz', 'Pt', 'Sa', '\u00c7a', 'Pe', 'Cu', 'Ct'],
        dayNamesMin: ['Pz', 'Pt', 'Sa', '\u00c7a', 'Pe', 'Cu', 'Ct'],
        weekHeader: 'Hf',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['tr']);

	$(".date, .datepicker").datepicker();

	jQuery('#start-date').datepicker({
        dateFormat: 'dd.mm.yy',
		onSelect: function(selectedDate) {
			jQuery('#end-date').datepicker( "option", "minDate", selectedDate );
			cReport.OnChange();
		}
	});
	
	jQuery('#end-date').datepicker({
	    dateFormat: 'dd.mm.yy',
		onSelect: function(selectedDate) {
			jQuery('#start-date').datepicker( "option", "maxDate", selectedDate );
			cReport.OnChange();
		}
	});

	$("#UserTypeID").change(function(){
		
		if($(this).val() == "111"){
			$("#CustomerID").addClass("required");
			$("label[for='CustomerID']").html('Müşteri: <span class="error">*</span>');
		}
		else {
			$("#CustomerID").removeClass("required");
			$("label[for='CustomerID']").html('Müşteri:');
		}
	});
	
	$("#IsProtected").click(function(){
		if($(this).is(':checked')){
			$("#Password").addClass("required");
			$("label[for='Password']").html('Parola: <span class="error">*</span>');
		}
		else {
			$("#Password").removeClass("required");
			$("label[for='Password']").html('Parola:');
		}
	});
	
	$("#IsBuyable").click(function(){
		if($(this).is(':checked')){
			$("#Price").addClass("required");
			$("#CurrencyID").addClass("required");
			$("label[for='Price']").html('Fiyat: <span class="error">*</span>');
			$("label[for='CurrencyID']").html('Para Birimi: <span class="error">*</span>');
		}
		else {
			$("#Price").removeClass("required");
			$("#CurrencyID").removeClass("required");
			$("label[for='Price']").html('Fiyat:');
			$("label[for='CurrencyID']").html('Para Birimi:');
		}
	});
	
	/*
	$("#dialog-category-form").dialog({
		autoOpen: false,
		height: 350,
		width: 350,
		modal: true,
		buttons: {
			"Kapat": function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			$("#dialog-category-form").addClass("hidden");
			//cContent.loadCategoryOptionList();
		}
	});
	$('#dialog-category-form').on('hidden.bs.modal', function (e) {
	  //console.log('asd');
	});
	*/

	$(".tooltip").qtip({style: { classes: 'ui-tooltip-rounded'}});
});

function toogleFullscreen()
{
	console.log('toogleFullscreen');
	/*
	if(!getFullscreenStatus())
	{
		$('.fullTrigger').click();	
	}
	else
	{
		exitFullscreen();
	}
	*/
}

function getFullscreenStatus()
{
	console.log('getFullscreenStatus');
	//return screenfull.isFullscreen;
}

function exitFullscreen()
{
	console.log('exitFullscreen');
	//screenfull.exit();
}

function closeInteractiveIDE()
{
	console.log('closeInteractiveIDE');
	//cContent.closeInteractiveIDE();
}

//***************************************************
// NEW DESIGN
//***************************************************
$(document).ready(function(){

	if($("input[type=checkbox]").length > 0 || $("input[type=radio]").length > 0) {
		$("input[type=checkbox], input[type=radio]").uniform();
	}
	
	$(".select2").chosen({
		placeholder_text_single: "Seçiniz...",
		placeholder_text_multiple: "Seçiniz...",
		no_results_text: "Sonuç bulunamadı."
	});

	//if($(".select2").length > 0) $(".select2").select2();

	$(".tip").tooltip({placement: 'top'});    
    $(".tipb").tooltip({placement: 'bottom'});    
    $(".tipl").tooltip({placement: 'left'});        
	$(".tipr").tooltip({placement: 'right'});

	$(".site-settings-button").click(function() {
        if($(this).parent('.site-settings').hasClass('active'))
            $(this).parent('.site-settings').removeClass('active');
        else{
            $(this).parent('.site-settings').addClass('active');           
            
        $(this).parent('.site-settings').find('input:checkbox, input:radio').uniform();

        if($(".container").hasClass("container-fixed"))
            $(".ss_layout[value=fixed]").attr("checked",true).parent("span").addClass("checked");
        else
            $(".ss_layout[value=liquid]").attr("checked",true).parent("span").addClass("checked");
        }
    });

	if($("table.sortable_simple").length > 0)
        $("table.sortable_simple").dataTable({"iDisplayLength": 5,"bLengthChange": false,"bFilter": false,"bInfo": false,"bPaginate": true});
    
    if($("table.sortable_default").length > 0)
        $("table.sortable_default").dataTable({"iDisplayLength": 5, "sPaginationType": "full_numbers","bLengthChange": false,"bFilter": false,"bInfo": false,"bPaginate": true, "aoColumns": [ { "bSortable": false }, null, null, null, null]});
    
    if($("table.sortable").length > 0)
        $("table.sortable").dataTable({"iDisplayLength": 5, "aLengthMenu": [5,10,25,50,100], "sPaginationType": "full_numbers", "aoColumns": [ { "bSortable": false }, null, null, null, null]});

    if($(".knob").length > 0) $(".knob input").knob();

    if($(".sparkline").length > 0)
       $('.sparkline span').sparkline('html', { enableTagOptions: true });


	$("#monthHideBtn").click(function(){

	    if(!$('.list-item').hasClass('closed')){
	        $(".list-item").fadeOut();
	        $(".list-item").addClass('closed');
	        $("#monthHideIcon").removeClass('icon-chevron-up');
	        $("#monthHideIcon").addClass('icon-chevron-down');
	    }
	    else{
	        $(".list-item").fadeIn();
	        $(".list-item").removeClass('closed');
	        $("#monthHideIcon").removeClass('icon-chevron-down');
	        $("#monthHideIcon").addClass('icon-chevron-up');
	    }
	});

	$(".psn-control").click(function(){       
	   if($('.page-container').hasClass('page-sidebar-narrow')){
	        $('.page-container').removeClass('page-sidebar-narrow');
	        $(this).parent('.control').removeClass('active');
		   //$("#my-info-block").fadeIn();
	   }else{
	        $('.page-container').addClass('page-sidebar-narrow');        
	        $(this).parent('.control').addClass('active');
			//$("#my-info-block").hide();
	   }
		return false;
	});

	$(".page-navigation li a").click(function(){       
	    var ul = $(this).parent('li').children('ul');
	    
	    if(ul.length == 1){            
	        if(ul.is(':visible'))
	            ul.slideUp('fast');                
	        else
	            ul.slideDown('fast');
	        return false;
	    }
	});

	$(".file .btn,.file input:text").click(function(){                
	    var block = $(this).parents('.file');
	    block.find('input:file').click();
	    block.find('input:file').change(function(){
	        block.find('input:text').val(block.find('input:file').val());
	    });
	});

	$('#logout').hover(
	     function () {
	       $('#header-background').css("background", "url(/../img/headerRed.png) repeat-x");
	     }, 
	     function () {
	       $('#header-background').css("background", "url(/../img/headerBlue.png) repeat-x");
	     }
	);
    
	$(window).bind("load", function() {
	    //gallery(); HAKANHAKANHAKAN
	    //thumbs(); HAKANHAKANHAKAN
	   //lists();  HAKANHAKANHAKAN
	    page();
	});

	$(window).resize(function(){
	    
	    /* vertical tabs */
	    $(".nav-tabs-vertical").each(function(){
	        var h = $(this).find('.nav-tabs').height();
	        $(this).find('.tabs').css('min-height',h);
	    });
	    /* eof vertical tabs */        

	    //gallery();   HAKANHAKANHAKAN
	    //thumbs(); HAKANHAKANHAKAN
	    //lists(); HAKANHAKANHAKAN
	    page();
	});

	function page(){        
	    if($("body").width() < 768){
	        $(".page-container").addClass("page-sidebar-narrow");
	        $(".page-navigation li ul").removeAttr('style');
			//$("#my-info-block").hide();
	    }    
	}

});

//dashboard
$(document).ready(function() {
    //İndirilme Sayısı
    function labelFormatter(label, series) {
        return "<div style='text-shadow: 1px 2px 1px rgba(0,0,0,0.2); font-size: 11px; text-align:center; padding:2px; color: #FFF; line-height: 13px;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }
    
    function showTooltip(x, y, contents) {
        $('<div class="ftooltip">' + contents + '</div>').css({
            position: 'absolute',
            'z-index': '10',
            display: 'none',
            top: y - 20,
            left: x,            
            padding: '3px',
            'background-color': 'rgba(0,0,0,0.5)',
            'font-size': '11px',
            'border-radius': '3px',
            color: '#FFF'            
        }).appendTo("body").fadeIn(200);
    }    

    if($("#dashboard").length > 0) {

    	var previousPoint = null;
 
	    $("#dash_chart_1").bind("plothover", function (event, pos, item) {
	        
	        $("#x").text(pos.x.toFixed(2));
	        $("#y").text(pos.y.toFixed(2));

	        if (item) {
	            if (previousPoint != item.dataIndex) {
	                previousPoint = item.dataIndex;

	                $(".ftooltip").remove();
	                var x = item.datapoint[0].toFixed(2),
	                    y = item.datapoint[1].toFixed(2);

	                showTooltip(item.pageX, item.pageY,
	                            item.series.label + ": " + y);
	            }
	        }else {
	            $(".ftooltip").remove();
	            previousPoint = null;            
	        }

	    });

	    $({numberValue: $('#myKnob').val()}).animate({numberValue: parseInt($('#myKnob').attr("data-value"))}, {
	        duration: 4000,
	        easing: 'swing',
	        step: function() {  
	            $('#myKnob').val(Math.ceil(this.numberValue)).trigger('change');
	        }
	    });
	    
	    var attrData = $("#dash_chart_1").attr("data").split('-');
	    var attrColumns = $("#dash_chart_1").attr("columns").split('-');
	    var attrMaxData = parseInt($("#dash_chart_1").attr("maxdata"));
	    //var data  = [ [1, 25], [2, 28], [3, 22], [4, 18], [5, 30], [6, 18], [7,14] ];
	    var data  = [ [1, parseInt(attrData[0])], [2, parseInt(attrData[1])], [3, parseInt(attrData[2])], [4, parseInt(attrData[3])], [5, parseInt(attrData[4])], [6, parseInt(attrData[5])], [7, parseInt(attrData[6])] ];
	    var plot1 = $.plotAnimator($("#dash_chart_1"), [{ data: data, animator: {steps: 50}, lines: { show: true, fill: false }, label: "İndirilme" }],{ 
	                                      series: {lines: { show: true }, points: { show: false }},
	                                      grid: { hoverable: true, clickable: true, margin: {left: 110}},
	                                      xaxis: {ticks: [[1, attrColumns[6]],[2, attrColumns[5]],[3, attrColumns[4]],[4, attrColumns[3]],[5, attrColumns[2]],[6, attrColumns[1]],[7,attrColumns[0]]]},
	                                      yaxis: { min: 0, max: (attrMaxData>0 ? attrMaxData : 100), tickDecimals:0},
	                                      legend: {show: false}});

	    //İndirilme Sayısı istatistiğindeki animasyonun sonunda çalışacak olan kod bloğu. Çizgideki noktaları getirir.
	    $("#dash_chart_1").on("animatorComplete", function() {
	      plot2 = $.plot($("#dash_chart_1"), [{ data: data, label: "İndirilme"}],{ 
	                                      series: {lines: { show: true }, points: { show: true }},
	                                      grid: { hoverable: true, clickable: true, margin: {left: 110}},
	                                      xaxis: {ticks: [[1, attrColumns[6]],[2, attrColumns[5]],[3, attrColumns[4]],[4, attrColumns[3]],[5, attrColumns[2]],[6, attrColumns[1]],[7,attrColumns[0]]]},
	                                      yaxis: {min: 0, max: (attrMaxData>0 ? attrMaxData : 100), tickDecimals:0 },
	                                      legend: {show: false}});
	    });

	    //UYGULAMA DETAYI
		var arrStart = $("#startDate").text().split('.');
		var arrEnd = $("#endDate").text().split('.');
	    var start = new Date(parseInt(arrStart[2]), parseInt(arrStart[1]) - 1, parseInt(arrStart[0]));
	    var end = new Date(parseInt(arrEnd[2]), parseInt(arrEnd[1]) - 1, parseInt(arrEnd[0]));
	    var today = new Date();
	    var status = Math.round(100 - (end - today) / (end - start) * 100 ) + '%';
	    var statusControl = Math.round(100 - (end - today) / (end - start) * 100 );
	    if(statusControl>=100)
	    	status = 100 + '%';
	    else if(statusControl<0)
	    	status = 100 + '%';
	    if($("#startDate").text()==$("#endDate").text())
	    	status = 100 + '%';
	    $("#appProgress").width(status);
	    $("#datePerValue").text(status);

	    //Onceki aylar
	    var timeoutStart = 500;
	    $(".previous-month").each(function(){
	        var e = $(this);
	        setTimeout(function() {
	            e.width(e.attr("aria-value") + '%');
	        }, timeoutStart);
	        timeoutStart = timeoutStart + 500;
	    })
	    
	    /*

	    //CİHAZ RAPORU
	                      
	    var tablet = [170, 60, 100, 180, 150, 100 , 250];
	    var mobil = [70, 90, 110, 160, 105, 85 , 45];
	    var ticks = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma'];
	     
	    plot2 = $.jqplot('dash_chart_2', [tablet, mobil], {
	        animate: true,
	        seriesColors: [ "#4bb2c5", "#eaa228"],
	        seriesDefaults: {
	            renderer:$.jqplot.BarRenderer
	        },
	    axes: {
	            xaxis: {
	                renderer: $.jqplot.CategoryAxisRenderer,
	                ticks: ticks
	            },
	        },
	    grid: {
	    drawGridLines: true,        // wether to draw lines across the grid or not.
	    gridLineColor: '#8f9090',
	    gridLineWidth: 0.2,    
	    background: 'transparent',      // CSS color spec for background color of grid.
	    borderColor: '#737373',     // CSS color spec for border around grid.
	    borderWidth: 0.3,           // pixel width of border around grid.
	    renderer: $.jqplot.CanvasGridRenderer,  // renderer to use to draw the grid.
	    rendererOptions: {}         // options to pass to the renderer.  Note, the default
	                                // CanvasGridRenderer takes no additional options.
	    },
	      highlighter: {
	        show: true,
	        formatString:'<span style="display:none;">%s</span><span>%s</span>'
	        },
	      cursor: {
	        show: true
	      }
	        });
	    var barChart;
	    $("#chartType").click(function(){
	        if(!barChart)
	        {
	            plot2 = $.jqplot('dash_chart_2', [tablet, mobil], {
	                animate: true,
	                seriesColors: [ "#4bb2c5", "#eaa228"],
	                seriesDefaults: {
	                    renderer:$.jqplot.LineRenderer,
	                    pointLabels: { show: true }
	                },

	            axes: {
	                    xaxis: {
	                        renderer: $.jqplot.CategoryAxisRenderer,
	                        ticks: ticks
	                    },
	             
	                },
	            grid: {
	            drawGridLines: true,        // wether to draw lines across the grid or not.
	            gridLineColor: '#8f9090',
	            gridLineWidth: 0.2,    
	            background: 'transparent',      // CSS color spec for background color of grid.
	            borderColor: '#737373',     // CSS color spec for border around grid.
	            borderWidth: 0.5,           // pixel width of border around grid.
	            renderer: $.jqplot.CanvasGridRenderer,  // renderer to use to draw the grid.
	            rendererOptions: {}         // options to pass to the renderer.  Note, the default
	                                        // CanvasGridRenderer takes no additional options.
	            },
	            highlighter: {
	            show: true,
	            formatString:'<span style="display:none;">%s</span><span>%s</span>'
	            },
	            });

	            plot2.replot();
	            barChart=true;
	        }
	        else
	        {
	                plot2 = $.jqplot('dash_chart_2', [tablet, mobil], {
	                animate: true,
	                seriesColors: [ "#4bb2c5", "#eaa228"],
	                seriesDefaults: {
	                    renderer:$.jqplot.BarRenderer,
	                    pointLabels: { show: true }
	                },

	                axes: {
	                        xaxis: {
	                            renderer: $.jqplot.CategoryAxisRenderer,
	                            ticks: ticks
	                        },
	                    },
	                grid: {
	                drawGridLines: true,        // wether to draw lines across the grid or not.
	                gridLineColor: '#8f9090',
	                gridLineWidth: 0.2,   
	                background: 'transparent',      // CSS color spec for background color of grid.
	                borderColor: '#737373',     // CSS color spec for border around grid.
	                borderWidth: 0.5,           // pixel width of border around grid.

	                renderer: $.jqplot.CanvasGridRenderer,  // renderer to use to draw the grid.
	                rendererOptions: {}         // options to pass to the renderer.  Note, the default
	                                            // CanvasGridRenderer takes no additional options.
	                },
	                highlighter: {
	                show: true,
	                formatString:'<span style="display:none;">%s</span><span>%s</span>'
	                },
	            });
	        plot2.replot();
	        barChart=false;
	        } 
	    });
	    $(".psn-control").click(function(){       
	        plot2.replot();
	    });
	    */
    }   
});

/* DİL DEĞİŞTİRME KODLARI - BAŞLANGIÇ */

	function modalOpen()
    {
        $("#modalChangeLanguage").css("display","block");
        
        if($(location).attr('pathname').substring(0,3)=="/tr"){

            $("#radio_tr").attr("class","checked");
	        $("#radio_en").attr("class","none");
	        $("#radio_de").attr("class","none"); 
        }
        else if($(location).attr('pathname').substring(0,3)=="/en"){

            $("#radio_tr").attr("class","none");
        	$("#radio_en").attr("class","checked");
        	$("#radio_de").attr("class","none");
        }
        else if($(location).attr('pathname').substring(0,3)=="/de"){

            $("#radio_tr").attr("class","none");
       	 	$("#radio_en").attr("class","none");
        	$("#radio_de").attr("class","checked");
        }
    }
   function modalClose()
    {
        $("#modalChangeLanguage").css("display","none");
    }
    function trActive()
    {
        document.location.href = '/tr';
        $("#radio_tr").attr("class","checked");
        $("#radio_en").attr("class","none");
        $("#radio_de").attr("class","none");
    }
    function enActive()
    {
        document.location.href = '/en';
        $("#radio_tr").attr("class","none");
        $("#radio_en").attr("class","checked");
        $("#radio_de").attr("class","none");
    }
    function deActive()
    {

        document.location.href = '/de';
        $("#radio_tr").attr("class","none");
        $("#radio_en").attr("class","none");
        $("#radio_de").attr("class","checked");
    }

/* DİL DEĞİŞTİRME KODLARI - SON */