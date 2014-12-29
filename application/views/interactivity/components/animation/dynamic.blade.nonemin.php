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
	$('#image').ready(function(){
	var bodyWidthFromTasarlayici={{$w}};
	var bodyHeightFromTasarlayici={{$h}};
	var x1={{ $x1 }};
	var y1={{ $y1 }};
	var x2={{ $x2 }};
	var y2={{ $y2 }};
	var rotate={{ $rotation }};
	var rotateSpeed={{ $rotationspeed }};
	var speed={{ $duration }};
	var effect = "{{ $effect }}";
	var effectsRotate = "{{ $rotationeffect }}";
	var fadeEffect=null;
	var animationDelay={{ $animedelay }};
	var animeinterval = {{ $animeinterval }};

	var image = new Image();
	image.src = $("#image").attr("src");
	image.onload = function() {
		var imgWidth=this.width;
		var calcWidth=(imgWidth/bodyWidthFromTasarlayici)*100;
		if(imgWidth>bodyWidthFromTasarlayici)
		{
			$('#image').css('width','100%');
		}
		else
		{
			$('#image').css('width',calcWidth+'%');
		}
		var imgHeight=this.height;
		var calcHeight=(imgHeight/bodyHeightFromTasarlayici)*100;
		$('#image').css('height',calcHeight+'%');
	};

	/*Başlangın Noktası Hesap*/
	//YATAY
	var bodyHeight=$(window).height();
	var calcX1=(x1/bodyHeightFromTasarlayici)*100;
	var finalX1=(calcX1*bodyHeight)/100;
	//DİKEY
	var bodyHeight=$(window).height();
	var calcY1=(y1/bodyHeightFromTasarlayici)*100;
	var finalY1=(calcY1*bodyHeight)/100;
	/*Başlangıç Noktası Hesap Son*/
	var bodyWidth=$(window).width();
	var calcX2=(x2/bodyWidthFromTasarlayici)*100;
	var finalX2=(calcX2*bodyWidth)/100;
	var bodyHeight=$(window).height();
	var calcY2=(y2/bodyHeightFromTasarlayici)*100;
	var finalY2=(calcY2*bodyHeight)/100;
	function aralikSuresi()
	{
		setTimeout(function()
		{imgAnimateLoop();},animeinterval);
	}
	function imgAnimate()
    {
		$("#image").animate({left:finalX2,top:finalY2},{queue:false,duration:parseInt(speed),
            complete: function() {
               	if( {{ (int)$reverse }} == 1 )
                {
                    imgAnimateReverse();
                }
                else if( {{ (int)$loop }} == 1 ) 
                {
                	if(animeinterval>0)
                	{
                		aralikSuresi();
                	}
                	else{
                		imgAnimateLoop();
                	}
                }
                else
                  return;
            }, easing:effect});
	}
	function imgAnimateReverse()
    {
        $("#image").animate({left:finalX1,top:finalY1},{queue:false,duration:parseInt(speed),
        complete: function() {
            if( {{ (int)$loop }} == 1 ) 
            {
            	if(animeinterval>0)
            	{
            		aralikSuresi();
            	}
            	else{
            		imgAnimate();
            	}
            }
        }, easing:effect});
    }
    function imgAnimateLoop()
    { 
        $("#image").css({"left":finalX1+"px","top":finalY1+"px"});
        imgAnimate();
    }
	if( {{ (int)$unvisibleStart }} == 1 )
		$("#image").css({"left":finalX1+"px","top":finalY1+"px","opacity":"0"});
	else
		$("#image").css({"left":finalX1+"px","top":finalY1+"px","opacity":"1"});
	setTimeout(function() {
		if(effect=="fade")
        {
          fadeEffect=effect;
          effect=null;
        }
		if(rotate!=0)
		{
			var rotateStatus=false;
      		var rotateVal=0;
      		var reverseCompleted=false;
			function AnimateRotate(d){
				var img = $("#image");
				if( {{ (int)$reverse }} == 1 ){
					if (!rotateStatus){
	                  	rotateVal=d;
	                  	d=0;
	                  	rotateStatus=true;  
	                }
	                else {
	                	rotateVal=0;
	                  	rotateStatus=false;
	                 	reverseCompleted=true; 
	                }
				}
				else
				{
					rotateVal=d;
					d=0;
				}
				$({deg: d}).animate({deg: rotateVal}, {
					duration: parseInt(rotateSpeed),
					easing: effectsRotate,
					step: function(now){
						img.css({
							transform: "rotate(" + now + "deg)"
						});
					},
	                complete: function(){
	                	if( {{ (int)$reverse }} == 1 && {{ (int)$loop }} == 0 ) 
                        {
                        	if(reverseCompleted)
                        		return;
                        	AnimateRotate(rotate);
                        }
                        else if( {{ (int)$reverse }} == 0 && {{ (int)$loop }} == 1 ) 
                        {
                        	if(animeinterval>0){
								setTimeout(function()
								{AnimateRotate(rotate);},animeinterval);
                        	}
                        	else{
                        		AnimateRotate(rotate);
                        	}
                        }
                        else if( {{ (int)$reverse }} == 1 && {{ (int)$loop }} == 1)
                        {    
                            if(animeinterval>0 && reverseCompleted==true)
	                        {
	                        	setTimeout(function() {
	                        		 AnimateRotate(rotate); 
	                        		 reverseCompleted=false;
	                        	},animeinterval);
	                        }
	                        else{
	                        	 AnimateRotate(rotate); 
	                        }                
                        }
                        else
                          return;
	                }
				});
			}
			AnimateRotate(rotate);
		}
		if(fadeEffect=="fade")
  		{
  			var fadeCount=0;
  			var aralikTamamlandi = 0;
			runEffect();
			function runEffect() {
				if( {{ (int)$reverse }} == 1 )
				{
					var imgOpacity = parseInt($('#image').css('opacity'));
					if(fadeCount==0 && {{ (int)$loop }} == 0){
						fadeCount++;
						$('#image').animate({
							queue:false,
							opacity: imgOpacity == 0 ? 1 : 0						        
						}, parseInt(speed), runEffect);
					}
					else if(fadeCount==1){
						fadeCount++;
						$('#image').animate({
							queue:false,
							opacity: imgOpacity == 0 ? 1 : 0						        
						}, parseInt(speed), runEffect);
					}
					else if({{ (int)$loop }} == 1){

						if(aralikTamamlandi==2 && animeinterval>0)
						{
							aralikTamamlandi=1;
							setTimeout(function() {
								$('#image').animate({
									queue:false,
									opacity: imgOpacity == 0 ? 1 : 0						        
								}, parseInt(speed), runEffect);

							},animeinterval);
						}
						else{
							$('#image').animate({
								queue:false,
								opacity: imgOpacity == 0 ? 1 : 0						        
							}, parseInt(speed), runEffect);
							aralikTamamlandi++;
						}
					}
					else
						return;
				}
				else if( {{ (int)$loop }} == 1 ) 
				{
					if( {{ (int)$unvisibleStart }} == 1 ){
						if(aralikTamamlandi==1 && animeinterval>0)
						{
							setTimeout(function() {
								$( "#image" ).css('opacity', '0');
								$('#image').animate({
									queue:false,
									opacity: "1"
								}, parseInt(speed), runEffect);
							},animeinterval);
						}
						else{
							$( "#image" ).css('opacity', '0');
							$('#image').animate({
								queue:false,
								opacity: "1"
							}, parseInt(speed), runEffect);
							aralikTamamlandi++;
						}
					}
					else{
						if(aralikTamamlandi==1 && animeinterval>0)
						{
							setTimeout(function() {
								$( "#image" ).css('opacity', '1');
								$('#image').animate({
									queue:false,
									opacity: "0"
								}, parseInt(speed), runEffect);
							},animeinterval);
						}
						else
						{
							$( "#image" ).css('opacity', '1');
							$('#image').animate({
								queue:false,
								opacity: "0"
							}, parseInt(speed), runEffect);
							aralikTamamlandi++;
						}
					}
				}
				else
				{
					$('#image').animate({queue:false,
						opacity: "0"
					}, parseInt(speed));
				}
        	}; 
  		}
  		imgAnimate();
	}, parseInt(animationDelay));
});
</script>
</body>
</html>