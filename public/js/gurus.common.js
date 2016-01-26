///////////////////////////////////////////////////////////////////////////////////////
// COMMON FUNCTIONS
    function roundIt(number) {
        var ret = number;
        ret = Math.round(ret * 100) / 100;
        ret = Math.round(ret * 10) / 10;
        ret = Math.round(ret);
        return ret;
    }

    function getQS(ji) {
        hu = window.location.search.substring(1);
        gy = hu.split("&");
        for (i = 0; i < gy.length; i++) {
            ft = gy[i].split("=");
            if (ft[0] == ji) {
                return ft[1];
            }
        }
        return "";
    }

    function validateAlphaNumeric(s) {

        for (var i = 0; i < s.length; i++) {
            var cc = s.charAt(i).charCodeAt(0);

            if ((cc > 47 && cc < 58) || (cc > 64 && cc < 91) || (cc > 96 && cc < 123)) {
                //return true;
            }
            else {
                //alert('Input is not alphanumeric');
                return false;
            }
        }
        return true;
    }

    function getParameterByName(name)
    {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(window.location.search);
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function checkURL(value) {
        /*
         var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
         if (urlregex.test(value)) {
         return (true);
         }
         return (false);
         */
        return true;
    }

    function isUrlReachable(url) {
        if (checkURL(url))
        {
            var d = "url=" + encodeURIComponent(url);
            //this request is send to galepress to check if the url is reacheable
            var ret = $.ajax({
                async: false,
                type: "POST",
                url: '/' + currentLanguage + '/' + route["interactivity_check"],
                data: d,
                error: function (ret) {
                    alert(ret);
                }
            }).responseText;
            if (ret)
            {
                return true;
            }

            /*
             $.ajax({
             url: url,
             type: 'GET',
             success: function(res) {
             
             },
             error: function() {
             
             }
             });
             
             var http = new XMLHttpRequest();
             http.open('HEAD', url, false);
             http.send();
             if(http.status != 200)
             {
             
             }				
             /*
             var http = new XMLHttpRequest();
             http.open('HEAD', url, false);
             try
             {
             http.send();
             if(http.status == 200)
             {
             $("#prop-" + id + " div.web span.success").removeClass("hide");
             }
             else
             {
             $("#prop-" + id + " div.web span.error").removeClass("hide");
             }
             }
             catch(e) { }
             
             */

        }
        return false;
    }

    function getTransform(e)
    {
        var t = e.css("transform");
        return t.substr(7, t.length - 8).split(', ');
    }

    function getScale()
    {
        var e = $("#page");
        var arr = getTransform(e);
        return parseFloat(arr[0]);
    }

    function getTransformTranslateX(e)
    {
        var arr = getTransform(e);
        return parseFloat(arr[4]);
    }

    function getTransformTranslateY(e)
    {
        var arr = getTransform(e);
        return parseFloat(arr[5]);
    }

    function getWidth(e)
    {
        var r = e.css("width").replace("px", "");
        return parseFloat(r);
    }

    function getHeight(e)
    {
        var r = e.css("height").replace("px", "");
        return parseFloat(r);
    }






    function fixWidth(e, w)
    {
        var arr = getTransform(e);
        if (false)
        {

        }


        return parseFloat(arr[5]);
    }

    function fixHeight(e, h)
    {

        var arr = getTransform(e);
        return parseFloat(arr[5]);
    }

    function fixLeft(e, x)
    {
        var eX = getTransformTranslateX(e);

        return parseFloat(arr[5]);
    }

    function fixTop(e, y)
    {
        var eY = getTransformTranslateY(e);

        return parseFloat(arr[5]);
    }




















