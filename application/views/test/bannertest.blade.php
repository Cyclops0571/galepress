<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <title>GALERPESS BANNER SLIDER</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/js/Swiper-master/dist/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <style>
        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
            border: 0;
        }

        iframe {
            margin: 0;
            padding: 0;
            border: 0;
        }
    </style>
</head>
<body style="background: red;">
{{--<iframe style="background: green; border: none" width="100%" height="200px" src="http://localhost/banners/service_view/58"/>--}}
<script type="text/javascript">
    var myObject = [11,22]
//    myObject.a = "|"
//    myObject.b = "|"

//    Object.defineProperty( myObject, Symbol.iterator, {
//        enumerable: false,
//        writable: false,
//        configurable: true,
//        value: function() {
//            var o = this;
//            var idx = 0;
//            var ks = Object.keys( o );
//            console.log(ks)
//            return {
//                next: function() {
//                    return {
//                        value: o[ks[idx++]],
//                        done: (idx > ks.length)
//                    };
//                }
//            };
//        }
//    } );
//
//    // iterate `myObject` manually
//    var it = myObject[Symbol.iterator]();
//    it.next(); // { value:2, done:false }
//    it.next(); // { value:3, done:false }
//    it.next(); // { value:undefined, done:true }

    // iterate `myObject` with `for..of`
    it = myObject[Symbol.iterator]()
    for (var i = 0; i < 10; i++) {
        console.log( it.next() );
    }
</script>
</body>
</html>