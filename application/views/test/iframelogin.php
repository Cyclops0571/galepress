<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <title>Document</title>
    <style type="text/css">
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        #content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
        }
    </style>
</head>
<body>
<div id="content">
    <iframe id="galepressIframe" width="100%" height="100%" frameborder="0"
            src="http://www.galepress.com/en/login"></iframe>
</div>
<script type="text/javascript">
    $('#galepressIframe').load(function () {
        var loginUrl = ['/login', '/anmelden', '/login'];
        var redirectToIframeUrl = true;
        for (var i = 0; i < loginUrl.length; i++) {
            if (window.frames[0].location.href.indexOf(loginUrl[i]) != -1) {
                redirectToIframeUrl = false;
            }
        }
        if (redirectToIframeUrl) {
            window.location.href = window.frames[0].location.href;
        }

    });
</script>


</body>
</html>