<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <title>GALERPESS BANNER SLIDER</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="/deneme/Swiper-master/dist/css/swiper.min.css">

    <script src="/js/masterslider/jquery-1.10.2.min.js"></script>
    <script src="/deneme/Swiper-master/dist/js/swiper.min.js"></script>

    <style>
        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper-container {
            width: 100%;
            height: 300px;
            margin: 20px auto;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            width: 90%;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>
</head>

<?php
//opacity 0.7 idi 0 a cektim
if (false) {
    $savedBanner = new Banner();
    $application = new Application();
}
$Autoplay = $application->BannerAutoplay;
$IntervalTime = $application->BannerIntervalTime;
$TransitionRate = $application->BannerTransitionRate;
?>
<body>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php foreach ($bannerSet as $savedBanner): ?>
            <div class="swiper-slide">
                <img src="<?php echo $savedBanner->getImagePath() ?>"/>
            </div>
        <?php endforeach; ?>
        <!-- Add Pagination -->
    </div>
    <div class="swiper-pagination"></div>
</div>
<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 'auto',
        centeredSlides: true,
        paginationClickable: true,
        spaceBetween: 30
    });
</script>
</body>
</html>
