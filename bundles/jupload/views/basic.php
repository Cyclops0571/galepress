<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>jQuery File Upload Example</title>
<style>
.bar {
    height: 18px;
    background: green;
}

</style>
</head>
<body>



<!--<input id="fileupload" type="file" name="files[]" data-url="/tr/jupload/upload/" multiple>-->


<input id="fileupload" type="file" name="files[]" multiple>

<input type="button" value="sec" onclick="$('#fileupload').click(); return false;">
                


<div id="progress">
    <div class="bar" style="width: 0%;"></div>
</div>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/bundles/jupload/js/vendor/jquery.ui.widget.js"></script>
<script src="/bundles/jupload/js/jquery.iframe-transport.js"></script>
<script src="/bundles/jupload/js/jquery.fileupload.js"></script>
<script>
$(function () {
		
		
/*
'fileTypeDesc': (componentName == "video" ? 'Video Files' : 'Audio Files'),
'fileTypeExt': (componentName == "video" ? '*.mp4' : '*.mp3'),
*/

	
	
	
    $('#fileupload').fileupload({
		//url: '/tr/jupload/upload/',
		url: '/tr/etkilesimli-pdf/yukle/',
        dataType: 'json',
		sequentialUploads: true,
		singleFileUploads:true, 
		/*
		formData: {
			sessionidaa: 'asdasd'	
		},
		*/
		add: function(e, data){
			
			var pass = true;
			$.each(data.files, function (index, file)
			{
				if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(file.name))
				{
					pass = false;
				}
			});
			
			pass = true;
			if(pass) 
			{
				data.submit();
			}
			/*
			$("#prop-" + id + " div.upload div.local").addClass("hide");
			$("#prop-" + id + " div.upload div.progress").removeClass("hide");
			$("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");
			*/
		},
		progressall: function(e, data){
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .bar').css(
				'width',
				progress + '%'
			);
			/*
			'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
				
				var percent = totalBytesUploaded * 100 / totalBytesTotal;
				
				$("#prop-" + id + " div.upload div.progress label").html(interactivity["video_uploading"] + ' ' + percent.toFixed(0) + '%');
				$("#prop-" + id + " div.upload div.progress div.scale").css('width', percent.toFixed(0) + '%');
			},
			*/
		},
        done: function(e, data){
			
			console.log("done - " + data);
			
            $.each(data.result.files, function (index, file) {
				console.log("done - " + file.name);
            });
			
			
			/*
			'onUploadSuccess': function (file, data, response) {
				
				if(data.getValue("success") == "true") {
					
					$("#prop-" + id + " div.upload").addClass("hide");
					
					$("#prop-" + id + " input#comp-" + id + "-filename").val(data.getValue("filename"));
					
					$("#prop-" + id + " div.upload div.progress").addClass("hide");
					$("#prop-" + id + " div.settings div.properties").removeClass("hide");
				}
				else {
					$("#prop-" + id + " div.upload span.error").removeClass("hide");
				}
			}
			*/
        },
		fail: function(e, data){
			
			console.log("fail");
        }
    });
	
	
	
	
});
</script>
<form enctype="multipart/form-data" method="POST" action="http://www.galepress.com/tr/icerikler/kaydet" accept-charset="UTF-8"> 
</form>
</body> 
</html>
